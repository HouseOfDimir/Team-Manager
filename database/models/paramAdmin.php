<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class paramAdmin extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'paramAdmin';
        protected $primaryKey    = 'id';

        public static function getAllParamAdmin():Collection
        {
            return self::whereNull('endDate')->get();
        }

        public static function insertBulkAdmin($key, $value):void
        {
            self::where('code', $key)->update(['valeur' => $value]);
        }

        public static function getParamValueByCode(string $code):string
        {
            return self::where('code', $code)->value('valeur');
        }

        public static function getParamPlanning($paramPlanning){
            return self::whereNull('endDate')
                        ->where('planning', $paramPlanning)
                        ->select('code', 'valeur')
                        ->get()->keyBy('code')
                        ->toArray();
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
