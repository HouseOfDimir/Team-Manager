<?php

namespace Models;

use Illuminate\Database\Eloquent\{Model, Collection};

    class planningType extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'planningType';
        protected $primaryKey    = 'id';

        public static function getAllPlanning()
        {
            return self::whereNull('endDate')->get();
        }

        public static function getGlobalById($fkPlanningType){
            return self::where('id', $fkPlanningType)->value('global');
        }
    }
?>
