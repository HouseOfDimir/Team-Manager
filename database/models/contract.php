<?php

namespace Models;

use Illuminate\Database\Eloquent\{Model, Collection,SoftDeletes};
use Illuminate\Support\Carbon;

    class contract extends Model
    {
        use SoftDeletes;
        const CREATED_AT = null;
        const UPDATED_AT = null;
        const DELETED_AT = 'endDate';

        protected $dateFormat    = 'Ymd';
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

        public static function getContractById(int $fkContract):contract
        {
            return self::find($fkContract);
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
            self::find($fkContract)->delete();
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
