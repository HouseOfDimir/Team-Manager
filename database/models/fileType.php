<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class fileType extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'fileType';
        protected $primaryKey    = 'id';

        public static function getAllFileType():Collection
        {
            return self::whereNull('datefin')->get();
        }

        public static function getAllIdFileType():array
        {
            return self::whereNull('datefin')->get()->keyBy('id')->toArray();
        }

        public static function getCodeFileTypeById(int $fkFileType):string
        {
            return self::where('id', $fkFileType)->value('code');
        }
    }
// FILES COULD BE FACTURES ENERGIE, TELEPHONE, INTERNET, RIB, IBAN, CONTRAT (CEE CDD CDI)
?>
