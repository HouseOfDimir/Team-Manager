<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class inputEmployee extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'inputEmployee';
        protected $primaryKey    = 'id';

        public static function getAllInputEMployee():Collection
        {
            return self::whereNull('endDate')->orderby('formOrder', 'ASC')->get();
        }
    }

?>
