<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Lib\Files;
use App\Lib\Mailer;
use \database\Models\{Employee, inputEmployee, fileType, fileEmployee};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    const TITLE_BASE  = 'Création employé';
    const H1_CREATION = 'Création fiche employé';
    const H1_RECAP    = 'Récapitulatif ';
    const CONTRAT     = 'CTT';
    const PLANNING    = 'Planning semaine ';
    const DRIVER_PLN  = 'PLN';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){$this->middleware('auth');}

    public function execute(){
        $allEmployee = Employee::getAllEmployee();
        foreach($allEmployee as &$employee){
            $this->employeeDecryptor($employee);
        }

        return view('employee.index')->with(['allEmployee'   => $allEmployee,
                                             'inputEmployee' => inputEmployee::getAllInputEmployee()]);
    }

    public function creationEmployee(){
        return view('employee.ficheEmployee')->with(['fileType'      => fileType::getAllFileType(),
                                                     'inputEmployee' => inputEmployee::getAllInputEMployee(),
                                                     'h1'            => self::H1_CREATION,
                                                     'title'         => self::TITLE_BASE,
                                                     'route'         => route('employee.createEmployee')]);
    }

    public function toModifyEmployee($fkEmployee){
        $employee = Employee::getEmployeeById($fkEmployee);

        return view('employee.ficheEmployee')->with(['employee'      => $this->employeeDecryptor($employee),
                                                     'fileType'      => fileType::getAllFileType(),
                                                     'inputEmployee' => inputEmployee::getAllInputEMployee(),
                                                     'fileEmployee'  => fileEmployee::getAllFileByEmployeeToArray($employee->salt),
                                                     'h1'            => self::H1_RECAP . $employee->firstName . ' ' . $employee->name,
                                                     'title'         => $employee->firstName . ' ' . $employee->name,
                                                     'route'         => route('employee.createEmployee')]);
    }

    public function createEmployee(Request $request){
        $this->validate($request, [
            'name'        => 'required|string',
            'firstName'   => 'required|string',
            'city'        => 'required|string',
            'birthPlace'  => 'required|string',
            'birthDate'   => 'required|string',
            'adress'      => 'required|string',
            'mail'        => 'required|string',
            'greenNumber' => 'required|string|max:15|regex:/[0-9]{15}/',
            'phone'       => 'required|string|regex:/(0)[0-9]{9}/',
            'fkEmployee'  => 'nullable|int|exists:\database\Models\Employee,salt',
            'zipCode'     => 'required|string|regex:/[0-9]{5}/'
        ]);

        if($request->filled('fkEmployee')){
            if(Employee::countByMailAndPhoneById($request->phone, $request->mail, $request->fkEmployee)){return redirect()->back()->with('error', 'Une erreur est survenue, le numéro de téléphone ou le mail existent déjà !');}
        }else{
            $request->flash();
            if(Employee::countByMailAndPhone($request->phone, $request->mail)){ return redirect()->back()->with('error', 'Une erreur est survenue, le numéro de téléphone ou le mail existent déjà !');}
        }

        $fkEmployee = Employee::insertEmployee($request);

        if(filled($request->file())){
            foreach($request->file() as $key => $file){
                FileController::insertFileEmployee($request, $fkEmployee, $key, $file);
            }

            return redirect()->route('employee.toModifyEmployee', ['fkEmployee' => $fkEmployee])->with('success', 'Informations employé modifiées avec succcès !');

        }else{
            return redirect()->route('employee.toModifyEmployee', ['fkEmployee' => $fkEmployee])->with('success', 'Informations employé modifiées avec succcès !');
        }
    }

    public function deleteEmployee($fkEmployee){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkEmployee' => $fkEmployee]);
        $this->validate($request, ['fkEmployee' => 'required|string|exists:\database\Models\Employee,salt']);
        Employee::deleteEmployee($fkEmployee);
        return redirect()->back()->with('success', 'Employé supprimé avec succès !');
    }

    public function sendEmployeeInfoToN1($fkEmployee){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkEmployee' => $fkEmployee]);
        $this->validate($request, ['fkEmployee' => 'required|string|exists:\database\Models\Employee,salt']);
        $mail = new Mailer(Employee::getEmployeeById($request->fkEmployee));
        $mail->buildMailForN1();
    }

    public function employeeDecryptor($employee){
        $employee->birthDate    = Carbon::createFromFormat('Ymd', $employee->birthDate)->format('d/m/Y');
        $employee->firstName    = Crypt::decrypt($employee->firstName);
        $employee->name         = Crypt::decrypt($employee->name);
        $employee->greenNumber  = Crypt::decrypt($employee->greenNumber);
        $employee->mail         = Crypt::decrypt($employee->mail);
        $employee->phone        = Crypt::decrypt($employee->phone);
        $employee->adress       = Crypt::decrypt($employee->adress);
        $employee->zipCode      = Crypt::decrypt($employee->zipCode);
        $employee->city         = Crypt::decrypt($employee->city);
        return $employee;
    }

    public function createPDFandSendToMail(Request $request){
        $allEmployee        = Employee::getAllEmployee();
        $request->startDate = Carbon::createFromFormat('d/m/Y', $request->startDate)->format('Ymd');
        $request->endDate   = Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Ymd');
        if($request->endDate - $request->startDate !== 4){return redirect()->back()->with('error', 'Veuillez des dates correctes ! Un lundi et un vendredi doivent être saisis !');}
        $pathToSave = Files::getStoragePath(self::DRIVER_PLN);
        foreach($allEmployee as $item){
            $cmd = "'C://Program Files/Google/Chrome/Application/chrome.exe' --headless --disable-gpu --run-all-compositor-stages-before-draw --print-to-pdf=".$pathToSave."Planning du ".$request->startDate." au ".$request->endDate." ".route('planning.getPlanningOneEmployee',['fkEmployee' => $item->id, 'startDate' => $request->startDate, 'endDate' => $request->endDate]);dd($cmd);
            exec($cmd, $output, $code);
            dd($output, $code);
            /* $browserFactory = new BrowserFactory();
            $browser = $browserFactory->createBrowser();

            try{
                $page = $browser->createPage();
                $page->navigate(route('planning.getPlanningOneEmployee',
                    ['fkEmployee' => $item->id, 'startDate' => $request->startDate, 'endDate' => $request->endDate]))
                    ->waitForNavigation();dd($page);
                $page->pdf(['printBackground' => false])->saveToFile('/foo/bar.pdf');
                $browser->close();
            }catch(OperationTimedOut $e){
                dd($e);
                // too long to load
            }catch(NavigationExpired $e){
                dd($e);
                // An other page was loaded
            } */
            //Storage::put('public/pdf/invoice.pdf', $pdf->output());

            //$dompdf->save(Files::getStoragePath(self::DRIVER_PLN) . self::PLANNING . $request->startDate . '_' . $request->endDate);
        }
    }
//auto trier sur la colonne donnée, la premiere etant prio, en asc ou en desc² et gére rle type de donnée
}
