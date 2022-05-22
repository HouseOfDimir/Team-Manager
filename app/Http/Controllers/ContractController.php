<?php

namespace App\Http\Controllers;

use App\Lib\Files;
use database\Models\{Employee, contractType};
use Illuminate\Http\Request;
use Models\fileEmployee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Models\contract;

class ContractController extends Controller
{
    const DRIVER          = 'template';
    const DRIVER_CONTRACT = 'contract';
    const TITLE_BASE      = 'Création de contrat';
    const TITLE_EDIT      = 'Edition de contrat';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function execute(contract $fkContract = null)
    {
        $allEmployee = Employee::getAllEmployee();
        foreach($allEmployee as &$employee){
            $employee->firstName = Crypt::decrypt($employee->firstName);
            $employee->name      = Crypt::decrypt($employee->name);
        }

        $allContract = contract::getAllContract();
        foreach($allContract as &$item){
            $this->employeeDecryptor($item);
        }

        $array = ['allEmployee'         => $allEmployee,
                  'route'               => route('contract.createContract'),
                  'allContractType'     => contractType::getAllContractType(),
                  'allEmployeeContract' => $allContract,
                  'title'               => self::TITLE_BASE];

        if($fkContract){
                $fkContract->startPeriod = Carbon::createFromFormat('Ymd', $fkContract->startPeriod)->format('d/m/Y');
                $fkContract->endPeriod   = Carbon::createFromFormat('Ymd', $fkContract->endPeriod)->format('d/m/Y');
                $array['contract']     = $fkContract;
                $array['title']        = self::TITLE_EDIT;
        }

        return view('contract.index')->with($array);
    }

    public function addContract(Request $request){
        $this->validate($request, ['fkEmployee'     => 'required|int|exists:database\Models\Employee,id',
                                   'fkContractType' => 'required|int|exists:database\Models\contractType,id',
                                   'fkContract'     => 'nullable|int|exists:database\Models\contract,id',
                                   'dureeHebdo'     => 'required|string|regex:/[0-9]+/|max:2',
                                   'startPeriod'    => 'required|string|max:10',
                                   'endPeriod'      => 'required|string|max:10',
                                   'dureeAnnuelle'  => 'required|string|regex:/[0-9]+/|max:4']);
        contract::insertContract($request);
        return redirect()->back()->with('success', 'Contrat enregistré avec succès !');
    }

    public function deleteContract(contract $fkContract){
        $fkContract->delete();
        return $fkContract->delete() ? redirect()->route('contract.index')->with('success', 'Contrat supprimé avec succès !') : redirect()->back()->with('error', 'Une erreur est survenue, veuillez contacter votre administrateur !');
    }

    public function employeeDecryptor($employee){
        $employee->firstName    = Crypt::decrypt($employee->firstName);
        $employee->eName        = Crypt::decrypt($employee->eName);
        return $employee;
    }
}
