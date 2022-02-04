<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class letterColor extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'letterColor';
        protected $primaryKey    = 'id';

        public static function getAllLetterColor():Collection
        {
            return self::whereNull('endDate')->get();
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
