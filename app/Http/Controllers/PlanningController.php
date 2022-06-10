<?php

namespace App\Http\Controllers;

use database\Models\Employee;
use database\Models\paramAdmin;
use database\Models\paramAdminInitialView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Models\planning;
use Models\Task;
use Illuminate\Support\Carbon;

class PlanningController extends Controller
{
    const PLANNING_OPTION = 1;
    const INITIAL_VIEW    = 'initialView';
    const WEEKENDS        = 'weekends';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function execute()
    {
        $paramPlanning = paramAdmin::getParamPlanning(self::PLANNING_OPTION);
        foreach($paramPlanning as $key => &$value){
            if($key == self::INITIAL_VIEW){
                $value['valeur'] = paramAdminInitialView::getInitialViewById($value['valeur']);
            }elseif($key == self::WEEKENDS){
                $value['valeur'] = $value['valeur'] == 0 ? false : true;
            }
        }

        $allEmployee = Employee::getAllEmployee();
        foreach($allEmployee as &$item){
            self::employeeDecryptor($item);
        }

        return view('planning.index')->with(['alltask'       => Task::getAllTasks(),
                                             'allEmployee'   => $allEmployee,
                                             'paramPlanning' => $paramPlanning,
                                             'fullScreen'    => 1]);
    }

    public function getWeekIndex(Request $request)
    {
        if($request->ajax()){
            return response()->json(planning::getEvents($request));
        }else{
            abort(404);
        }
    }

    public function ajaxTourbi(Request $request)
    {
        // ajouter la récup du total de la journée : datas => fkEmployee, eventDate
        switch($request->type){
            case config('app.switch.add'):
                $event        = planning::insertEvent($request);
                list($totalHourDay, $totalHourWeek) = $this->getSumHourDay($request->fkEmployee, $request->eventDate);
                    return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement ajouté avec succès !', 'event' => $event, 'totalPerDay' => $totalHourDay, 'totalPerWeek' => $totalHourWeek])
                    : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;

            case config('app.switch.update'):
                $event        = planning::updateEvent($request);
                list($totalHourDay, $totalHourWeek) = $this->getSumHourDay($request->fkEmployee, $request->eventDate);
                return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement modifié avec succès !', 'event' => $event, 'totalPerDay' => $totalHourDay, 'totalPerWeek' => $totalHourWeek])
                : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;

            case config('app.switch.delete'):
                $event        = planning::deleteEvent($request);
                list($totalHourDay, $totalHourWeek) = $this->getSumHourDay($request->fkEmployee, $request->eventDate);
                return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement supprimé avec succès !', 'event' => $event, 'totalPerDay' => $totalHourDay, 'totalPerWeek' => $totalHourWeek])
                : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;
        }
    }

    public function getSumHourDay($fkEmployee, $eventDate){
        $carbonStDate         = new Carbon($eventDate);
        $allEventDayEmployee  = Planning::getSumDayEmployee($fkEmployee, $eventDate);
        $allEventWeekEmployee = Planning::getSumDayEmployeeWeek($fkEmployee, $carbonStDate->startOfWeek()->format('Ymd'), $carbonStDate->endOfWeek()->format('Ymd'));

        $timeAdded     = new Carbon();
        $timeAddedWeek = new Carbon();
        $currentTime   = new Carbon();

        foreach($allEventDayEmployee as $item){
            $startDate = new Carbon($item->eventStart);
            $endDate   = new Carbon($item->eventEnd);
            $timeAdded->add($endDate->diff($startDate));
        }

        foreach($allEventWeekEmployee as $item){
            $startDate   = new Carbon($item->eventStart);
            $endDate     = new Carbon($item->eventEnd);
            $timeAddedWeek->add($endDate->diff($startDate));
        }

        return array($timeAdded->diff($currentTime)->format('%H:%I'), $timeAddedWeek->diff($currentTime)->format('%H:%I'));
    }

    public function getAllEmployee(Request $request){
        if($request->ajax()){
            $employee = Employee::getResourceEmployee();
            foreach($employee as &$employe){
                $employee['title'] = Crypt::decrypt($employe->title);
            }
            return response()->json($employee);

        }else{
            abort(404);
        }
    }

    public function getPlanningOneEmployee($fkEmployee, $startDate, $endDate){
        return view('planning.personalPlanning')->with(
            [
                'id'              => $fkEmployee,
                'startDate'       => $startDate,
                'endDate'         => $endDate,
                'formatedStDate'  => \Carbon\Carbon::createFromFormat('Ymd', $startDate)->format('d/m/Y'),
                'formatedEndDate' => \Carbon\Carbon::createFromFormat('Ymd', $endDate)->format('d/m/Y')
            ]
        );
    }

    public function getPlanningGlobal($startDate, $endDate){
        return view('planning.globalPlanning')->with(
            [
                'startDate'       => $startDate,
                'endDate'         => $endDate,
                'formatedStDate'  => \Carbon\Carbon::createFromFormat('Ymd', $startDate)->format('d/m/Y'),
                'formatedEndDate' => \Carbon\Carbon::createFromFormat('Ymd', $endDate)->format('d/m/Y')
            ]
        );
    }

    public function employeeDecryptor($employee){
        $employee->birthDate    = Carbon::createFromFormat('Ymd', $employee->birthDate)->format('d/m/Y');
        $employee->firstName    = Crypt::decrypt($employee->firstName);
        $employee->name         = Crypt::decrypt($employee->name);
        $employee->greenNumber  = Crypt::decrypt($employee->greenNumber);
        $employee->mail         = Crypt::decrypt($employee->mail);
        $employee->phone        = Crypt::decrypt($employee->phone);
        $employee->adress       = Crypt::decrypt($employee->adress);
        $employee->zipCode      = Crypt::decrypt($employee->zipCode);
        $employee->city         = Crypt::decrypt($employee->city);
        return $employee;
    }
}
