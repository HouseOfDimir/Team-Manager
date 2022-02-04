<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Http\Request;

    class fileEmployee extends Model
    {
        const CREATED_AT = null;
        const UPDATED_AT = null;

        protected $table         = 'fileEmployee';
        protected $primaryKey    = 'id';

        public static function getAllFileByEmployeeExceptContract(string $fkEmployee, string $code):Collection
        {
            return self::rightJoin('fileType', 'fileType.id', '=', 'fileEmployee.fkFileType')
                        ->whereNull('fileEmployee.endDate')->where('fkEmployee', $fkEmployee)->where('code', '<>', $code)
                        ->select('code', 'fileEmployee.id AS id', 'name', 'libelle')
                        ->get();
        }

        public static function getAllFileByEmployee(int $fkEmployee):Collection
        {
            return self::leftJoin('fileType', 'fileType.id', '=', 'fileEmployee.fkFileType')
                        ->whereNull('endDate')->where('fkEmployee', $fkEmployee)
                        ->select('code', 'fileEmployee.id AS id', 'name', 'libelle', 'fkFileType')
                        ->get();
        }

        public static function getAllFileByEmployeeToArray(string $fkEmployee):array
        {
            return self::leftJoin('fileType', 'fileType.id', '=', 'fileEmployee.fkFileType')
                        ->whereNull('endDate')->where('fkEmployee', $fkEmployee)
                        ->select('code', 'fileEmployee.id AS id', 'name', 'libelle', 'fkFileType')
                        ->get()->keyBy('fkFileType')->toArray();
        }

        public static function deleteFileEmployee(int $fkFile)
        {
            $file = self::where('id',$fkFile);
            $fileBack = $file;
            $file->update(['endDate' => Date('Ymd')]);
            return $fileBack;
        }

        public static function insertFileEmployee($fkEmployee, $fkFileType, $name, $hashName):void
        {
            $insert             = new self();
            $insert->startDate  = Date('Ymd');
            $insert->name       = $name;
            $insert->hashName   = $hashName;
            $insert->fkFileType = $fkFileType;
            $insert->fkEmployee = $fkEmployee;
            $insert->save();
        }

        public static function getFileByCodeAndEmployee(string $fkEmployee, string $code)
        {
            return self::rightJoin('fileType', 'fileType.id', '=', 'fileEmployee.fkFileType')
                        ->where([['fkEmployee', $fkEmployee],['fileType.code', $code], ['fileEmployee.endDate', null]])
                        ->select('code', 'fileEmployee.id AS id', 'name', 'libelle')
                        ->first();
        }

        public static function getFileInfoById(int $fkFile):fileEmployee
        {
            return self::rightJoin('fileType', 'fileType.id', '=', 'fileEmployee.fkFileType')
                        ->where('fileEmployee.id', $fkFile)
                        ->select('fileEmployee.id', 'name', 'hashName', 'code')
                        ->first();
        }
    }

?>
