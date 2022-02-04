<?php

namespace App\Http\Controllers;

use App\Lib\Files;
use database\Models\{contract, Employee, contractType};
use Illuminate\Http\Request;
use Models\fileEmployee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

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

    public function execute($fkContrat = null)
    {
        $allEmployee = Employee::getAllEmployee();
        foreach($allEmployee as &$employee){
            $employee->firstName = Crypt::decrypt($employee->firstName);
            $employee->name      = Crypt::decrypt($employee->name);
        }

        $array = ['allEmployee'         => $allEmployee,
                  'route'               => route('contract.createContract'),
                  'allContractType'     => contractType::getAllContractType(),
                  'allEmployeeContract' => contract::getAllContract(),
                  'title'               => self::TITLE_BASE];
        if($fkContrat){
            $request = new \Illuminate\Http\Request();
            $request->setMethod('POST');
            $request->request->add(['fkContract' => $fkContrat]);
            $this->validate($request, ['fkContract' => 'required|int|exists:\database\Models\contract,id']);
            if($contract = contract::getContractById($fkContrat)){
                $contract->startPeriod = Carbon::createFromFormat('Ymd', $contract->startPeriod)->format('d/m/Y');
                $contract->endPeriod   = Carbon::createFromFormat('Ymd', $contract->endPeriod)->format('d/m/Y');
                $array['contract']     = $contract;
                $array['title']        = self::TITLE_EDIT;
            }else{
                abort(404);
            }
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

    public function deleteContract($fkContrat){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkContract' => $fkContrat]);
        $this->validate($request, ['fkContract' => 'required|int|exists:\database\Models\contract,id']);
        contract::deleteContract($fkContrat);
        return redirect()->back()->with('success', 'Contrat supprimé avec succès !');
    }
}
