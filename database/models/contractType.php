<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class contractType extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'contractType';
        protected $primaryKey    = 'id';

        public static function getAllContractType():Collection
        {
            return self::whereNull('endDate')->get();
        }

        public static function getContractById(int $fkContract):contractType
        {
            return self::find($fkContract);
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
