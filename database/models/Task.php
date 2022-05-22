<?php

namespace Models;

use Illuminate\Database\Eloquent\{Model, Collection, SoftDeletes};
use Illuminate\Http\Request;

    class Task extends Model
    {
        use SoftDeletes;
        const CREATED_AT = null;
        const UPDATED_AT = null;
        const DELETED_AT = 'endDate';

        protected $dateFormat = 'Ymd';
        protected $table         = 'task';
        protected $primaryKey    = 'id';

        public static function getAllTasks():Collection
        {
            return self::leftJoin('letterColor', 'letterColor.id', '=', 'task.fkLetterColor')
                        ->whereNull('Task.endDate')
                        ->select('task.id AS id', 'libelle', 'color', 'letterColor', 'fkLetterColor')->get();
        }

        public static function insertTask(Request $request):void
        {
            if($request->filled('fkTask')){
                self::where('id', $request->fkTask)
                    ->update(['color' => $request->color, 'libelle' => $request->libelle, 'fkLetterColor' => $request->fkLetterColor]);
            }else{
                $insert                = new self();
                $insert->color         = $request->color;
                $insert->fkLetterColor = $request->fkLetterColor;
                $insert->libelle       = $request->libelle;
                $insert->startDate     = Date('Ymd');
                $insert->save();
            }
        }

        public static function deleteTask(int $fkTask):void
        {
            self::find($fkTask)->delete();
        }

        public static function getTaskById(int $fkTask):Task
        {
            return self::find($fkTask);
        }

        public function colorLetter(){
            return $this->hasOne(letterColor::class, 'fkLetterColor');
        }
    }

?>
