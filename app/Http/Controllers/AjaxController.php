<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use database\Models\Employee;
use Illuminate\Support\Carbon;
use Models\planning;
use Illuminate\Support\Facades\Crypt;

class AjaxController extends Controller
{
    public function getAllEmployee(Request $request){
        $employee = Employee::getResourceEmployee();
        foreach($employee as &$employe){
            list($hours, $week) = self::getSumHourDay($employe->id, $request->start, $request->end);
            $week ? list($hourWeek, $week) = self::getSumHourDay($employe->id, $request->start, $request->end, $week) : $hourWeek = false;
            $employe['title'] = Crypt::decrypt($employe->title) . ' ' . $hours . 'h ' . ($hourWeek ? $hourWeek . 'h' : '');
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

    public static function getSumHourDay($fkEmployee, $stDate, $ndDate, bool $week = false){
        $carbonStDate = new Carbon($stDate);
        $carbonNdDate = new Carbon($ndDate);
        $timeAdded    = new Carbon();
        $currentTime  = new Carbon();

        if($carbonNdDate->diffInDays($carbonStDate) > 1 || $week){
            $allEventDayEmployee = Planning::getSumDayEmployeeWeek($fkEmployee, $week ? $carbonStDate->startOfWeek()->format('Ymd') : $stDate, $week ? $carbonStDate->endOfWeek()->format('Ymd') : $ndDate);
        }else{
            $week = true;
            $allEventDayEmployee = Planning::getSumDayEmployee($fkEmployee, $stDate);
        }

        foreach($allEventDayEmployee as $item){
            $startDate = new Carbon($item->eventStart);
            $endDate   = new Carbon($item->eventEnd);
            $timeAdded->add($endDate->diff($startDate));
        }

        return array($timeAdded->diff($currentTime)->format('%H:%I'), $week);
    }
}
