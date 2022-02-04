<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use database\Models\Employee;
use Illuminate\Support\Carbon;
use Models\planning;
use Illuminate\Support\Facades\Crypt;

class AjaxController extends Controller
{
    public function getAllEmployee(){
        $employee = Employee::getResourceEmployee();
        foreach($employee as &$employe){
            $employe['title'] = Crypt::decrypt($employe->title);
        }
        return response()->json($employee);
    }

    public function getEmployeeById($fkEmployee){
        $employee = Employee::getEmployeeWithId($fkEmployee);
        foreach($employee as &$employe){
            $employe['title'] = Crypt::decrypt($employe->title);
        }
        return response()->json($employee);
    }

    public function getOneEmployeeById($fkEmployee){
        $employee = Employee::getResourceEmployeeById($fkEmployee);
        $employee->title = Crypt::decrypt($employee->title);
        return response()->json($employee);
    }

    public function getAllEvents(Request $request){
        return response()->json(planning::getAllEventsByDate($request->start, $request->end));
    }

    public function getAllEventsById(Request $request){
        return response()->json(planning::getAllEventsByDateAndFkEmployee($request->fkEmployee, $request->start, $request->end));
    }
}
