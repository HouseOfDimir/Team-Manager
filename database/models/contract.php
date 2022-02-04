<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Support\Carbon;

    class contract extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'contract';
        protected $primaryKey    = 'id';

        public static function getAllContract():Collection
        {
            return self::leftJoin('contractType', 'contractType.id', '=', 'contract.fkContractType')
                        ->leftJoin('employee', 'employee.id', '=', 'contract.fkEmployee')
                        ->whereNull('contract.endDate')
                        ->select('contract.id AS id', 'dureeHebdo', 'dureeAnnuelle', 'contractType.name AS libelleContrat',
                                 'firstName', 'employee.name AS eName')->get();
        }

        public static function getContractById(int $fkContract)
        {
            return self::where('id', $fkContract)->whereNull('endDate')->first();
        }

        public static function getContractByFkEmployee(int $fkEmployee):contract
        {
            return self::where('fkEmployee', $fkEmployee);
        }

        public static function insertContract($request){
            $insert                 = new contract();
            $insert->fkEmployee     = $request->fkEmployee;
            $insert->fkContractType = $request->fkContractType;
            $insert->dureeHebdo     = $request->dureeHebdo;
            $insert->dureeAnnuelle  = $request->dureeAnnuelle;
            $insert->startPeriod    = Carbon::createFromFormat('d/m/Y', $request->startPeriod)->format('Ymd');
            $insert->endPeriod      = Carbon::createFromFormat('d/m/Y', $request->endPeriod)->format('Ymd');;
            $insert->startDate      = Date('Ymd');
            $insert->save();
        }

        public static function deleteContract($fkContract){
            self::where('id', $fkContract)->update(['endDate' => Date('Ymd')]);
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
