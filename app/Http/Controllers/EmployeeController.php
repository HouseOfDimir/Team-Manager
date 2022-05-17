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
use Models\planningType;
use Symfony\Component\Process\Process;

class EmployeeController extends Controller
{
    const TITLE_BASE      = 'Création employé';
    const H1_CREATION     = 'Création fiche employé';
    const H1_RECAP        = 'Récapitulatif ';
    const CONTRAT         = 'CTT';
    const PLANNING        = 'Planning semaine ';
    const PLANNING_TITLE  = 'Planning_Semaine';
    const DRIVER_PLN      = 'PLN';
    const IMAGE_EXTENSION = '.png';
    const PLANNING_EQUIPE = 'équipe';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){$this->middleware('auth');}

    public function execute(){
        $allEmployee = Employee::getAllEmployee();
        foreach($allEmployee as &$employee){
            $employee['fileEmployee'] = fileEmployee::getAllFileByEmployee($employee->salt);
            $this->employeeDecryptor($employee);
        }

        return view('employee.index')->with(['allEmployee'     => $allEmployee,
                                             'allPlanningType' => planningType::getAllPlanning(),
                                             'inputEmployee'   => inputEmployee::getAllInputEmployee()]);
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
            'name'        => 'required|string|regex:/[a-zA-Z]+/',
            'firstName'   => 'required|string|regex:/[a-zA-Z]+/',
            'city'        => 'required|string|regex:/[a-zA-Z]+/',
            'birthPlace'  => 'required|string|regex:/[a-zA-Z]+/',
            'birthDate'   => 'required|string',
            'adress'      => 'required|string',
            'mail'        => 'required|string',
            'greenNumber' => 'required|string|max:15|regex:/[0-9]{15}/',
            'phone'       => 'required|string|regex:/(0)[0-9]{9}/',
            'fkEmployee'  => 'nullable|string|exists:\database\Models\Employee,salt',
            'zipCode'     => 'required|string|regex:/[0-9]{5}/'
        ]);

        if($request->filled('fkEmployee')){
            if(Employee::countByMailAndPhoneById($request->phone, $request->mail, $request->fkEmployee)){return redirect()->back()->with('error', 'Une erreur est survenue, le numéro de téléphone ou le mail existent déjà !');}
            $message = ['success' => 'Informations employé modifiées avec succcès !'];
            $request->fkEmployee = Crypt::decrypt($request->fkEmployee);
        }else{
            $request->flash();
            if(Employee::countByMailAndPhone($request->phone, $request->mail)){ return redirect()->back()->with('error', 'Une erreur est survenue, le numéro de téléphone ou le mail existent déjà !');}
            $message = ['success' => 'Employé ajouté avec succcès !'];
        }
        $fkEmployee = Employee::insertEmployee($request);

        if(filled($request->file())){
            foreach($request->file() as $key => $file){
                FileController::insertFileEmployee($request, $fkEmployee, $key, $file);
            }

            return redirect()->route('employee.toModifyEmployee', ['fkEmployee' => $fkEmployee])->with($message);

        }else{
            return redirect()->route('employee.toModifyEmployee', ['fkEmployee' => $fkEmployee])->with($message);
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

        $request->startDate = Carbon::createFromFormat('d/m/Y', $request->startDate)->format('Ymd');
        $request->endDate   = Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Ymd');
        if($request->endDate - $request->startDate !== 4){return redirect()->back()->with('error', 'Veuillez des dates correctes ! Un lundi et un vendredi doivent être saisis !');}
        $pathToSave = Files::getStoragePath(self::DRIVER_PLN);

        if(planningType::getGlobalById($request->planningType)){
            $fullPath   = $pathToSave.self::PLANNING_TITLE.'-'.$request->startDate.'-'.$request->endDate.'-'.self::PLANNING_EQUIPE.self::IMAGE_EXTENSION;
            //$cmd = '"C://Program Files/Google/Chrome/Application/chrome.exe" --disable-gpu --headless --run-all-compositor-stages-before-draw --window-size=1200,825 --force-device-scale-factor=1 --screenshot="'.$fullPath.'" --virtual-time-budget=400 '.route('planning.getPlanningGlobal',['startDate' => $request->startDate, 'endDate' => $request->endDate]);
            $cmd = '"C://Program Files/Google/Chrome/Application/chrome.exe" --disable-gpu --headless --run-all-compositor-stages-before-draw --enable-logging --window-size=1200,825 --screenshot="'.$fullPath.'" '.route('planning.getPlanningGlobal',['startDate' => $request->startDate, 'endDate' => $request->endDate]).' --virtual-time-budget=10000';

            //dd($cmd);
            exec($cmd, $output, $code);

            foreach($request->fkEmployee as $item){
                if($code == 0){
                    $mail = new EmailController();
                    $mail->sendCalendarToEmployee($item, $fullPath, Carbon::createFromFormat('Ymd', $request->startDate)->format('d/m/Y'), Carbon::createFromFormat('Ymd', $request->endDate)->format('d/m/Y'));
                }
            }
            //unlink($fullPath);

        }else{
            foreach($request->fkEmployee as $item){
                $fullPath   = $pathToSave.self::PLANNING_TITLE.'-'.$request->startDate.'-'.$request->endDate.'-'.$item.self::IMAGE_EXTENSION;
                $cmd = '"C://Program Files/Google/Chrome/Application/chrome.exe" --disable-gpu --headless --run-all-compositor-stages-before-draw --enable-logging --window-size=1200,825 --screenshot="'.$fullPath.'" '.route('planning.getPlanningOneEmployee',['fkEmployee' => $item, 'startDate' => $request->startDate, 'endDate' => $request->endDate]).' --virtual-time-budget=10000';
                //dd($cmd);
                exec($cmd, $output, $code);

                if($code == 0){
                    $mail = new EmailController();
                    $mail->sendCalendarToEmployee($item, $fullPath, Carbon::createFromFormat('Ymd', $request->startDate)->format('d/m/Y'), Carbon::createFromFormat('Ymd', $request->endDate)->format('d/m/Y'));
                    //unlink($fullPath);
                }
            }
        }

        return redirect()->route('employee.index')->with('success', 'Les plannings ont été envoyés aux employés avec succès !');
    }
//auto trier sur la colonne donnée, la premiere etant prio, en asc ou en desc² et gére rle type de donnée
}
