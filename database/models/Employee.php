<?php

namespace database\Models;

use Illuminate\Database\Eloquent\{Model, Collection};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
    {
        use SoftDeletes;
        const CREATED_AT = null;
        const UPDATED_AT = null;
        const DELETED_AT = 'endDate';

        protected $table         = 'employee';
        protected $primaryKey    = 'id';

        public static function getAllEmployee():Collection
        {
            return self::whereNull('endDate')->get();
        }

        public static function getEmployeeWithId($fkEmployee):Employee
        {
            return self::find($fkEmployee);
        }

        public static function insertEmployee(Request $request):string
        {
            if($request->has('fkEmployee')){
                $update              = self::find($request->fkEmployee);
                $update->name        = Crypt::encrypt($request->name);
                $update->firstName   = Crypt::encrypt($request->firstName);
                $update->birthDate   = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('Ymd');
                $update->birthPlace  = $request->birthPlace;
                $update->zipCode     = Crypt::encrypt($request->zipCode);
                $update->greenNumber = Crypt::encrypt($request->greenNumber);
                $update->city        = Crypt::encrypt($request->city);
                $update->adress      = Crypt::encrypt($request->adress);
                $update->mail        = Crypt::encrypt($request->mail);
                $update->phone       = Crypt::encrypt($request->phone);
                $update->save();

                return $update->salt;

            }else{
                $insert              = new self();
                $insert->name        = Crypt::encrypt($request->name);
                $insert->firstName   = Crypt::encrypt($request->firstName);
                $insert->birthDate   = Carbon::createFromFormat('d/m/Y', $request->birthDate)->format('Ymd');
                $insert->birthPlace  = $request->birthPlace;
                $insert->zipCode     = Crypt::encrypt($request->zipCode);
                $insert->city        = Crypt::encrypt($request->city);
                $insert->greenNumber = Crypt::encrypt($request->greenNumber);
                $insert->adress      = Crypt::encrypt($request->adress);
                $insert->mail        = Crypt::encrypt($request->mail);
                $insert->phone       = Crypt::encrypt($request->phone);
                $insert->startDate   = Date('Ymd');
                $insert->save();

                $salt = Crypt::encrypt($insert->id);
                self::where('id', $insert->id)->update(['salt' => $salt]);
                return $salt;
            }
        }

        public static function deleteEmployee(string $fkEmployee):void
        {
            self::where('salt', $fkEmployee)->update(['endDate' => Date('Ymd')]);
        }

        public static function getEmployeeById(string $fkEmployee):Employee
        {
            return self::where('salt', $fkEmployee)->first();
        }

        public static function countByMailAndPhone(string $phone, string $mail):int
        {
            return self::whereNull('endDate')->where(function($query) use ($phone, $mail){
                $query->where('phone', $phone)->orWhere('mail', $mail);
            })->count();
        }

        public static function countByMailAndPhoneById(string $phone, string $mail, string $fkEmployee):int
        {
            return self::whereNull('endDate')
                        ->where('id', '<>', $fkEmployee)->where(function($query) use ($phone, $mail){
                            $query->where([['phone', $phone], ['endDate', null]])->orWhere([['mail', $mail], ['endDate', null]]);
                        })->count();
        }

        public static function getMailEmployeeById(string $fkEmployee):string
        {
            return self::where('salt',$fkEmployee)->value('mail');
        }

        public static function getResourceEmployee(){
            return self::whereNull('endDate')->select('id', 'firstName AS title')->get();
        }

        public static function getResourceEmployeeById($fkEmployee){
            return self::where('id', $fkEmployee)->select('id', 'firstName AS title')->first();
        }

        public function getContrat(){
            return $this->hasOne('contract')->select('contract.id AS id', 'dureeHebdo', 'dureeAnnuelle', 'contractType.name AS libelleContrat');
        }
    }

?>
