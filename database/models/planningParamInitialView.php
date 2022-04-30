<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class paramAdminInitialView extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'planningParamInitialView';
        protected $primaryKey    = 'id';

        public static function getAllInitialView():Collection
        {
            return self::whereNull('endDate')->get();
        }

        public static function getInitialViewById($fkView){
            return self::where('id', $fkView)->value('code');
        }
    }
?>
