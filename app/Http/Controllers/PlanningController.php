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

        return view('planning.index')->with(['alltask'       => Task::getAllTasks(),
                                             'allEmployee'   => Employee::getAllEmployee(),
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
        switch($request->type){
            case config('app.switch.add'):
                $event = planning::insertEvent($request);
                    return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement ajouté avec succès !', 'event' => $event])
                    : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;

            case config('app.switch.update'):
                $event = planning::updateEvent($request);
                return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement modifié avec succès !', 'event' => $event])
                : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;

            case config('app.switch.delete'):
                $event = planning::deleteEvent($request);
                return $event !== null ? response()->json(['style' => 'success', 'feedback' => 'Evènement supprimé avec succès !', 'event' => $event])
                : response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
            break;
        }
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
}
