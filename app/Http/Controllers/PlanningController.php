<?php

namespace App\Http\Controllers;

use database\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Models\planning;
use Models\Task;
use Illuminate\Support\Carbon;

class PlanningController extends Controller
{
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
        return view('planning.index')->with(['alltask'     => Task::getAllTasks(),
                                             'allEmployee' => Employee::getAllEmployee(),
                                             'fullScreen'  => 1]);
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
        switch ($request->type) {
            case config('app.switch.add'):
                if(planning::insertEvent($request)){
                    return response()->json(['style' => 'success', 'feedback' => 'Evènement ajouté avec succès !']);
                }else{
                    return response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
                }
            break;

            case config('app.switch.update'):
                if(planning::updateEvent($request)){
                    return response()->json(['style' => 'info', 'feedback' => 'Evènement modifié avec succès !']);
                }else{
                    return response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
                }
            break;

            case config('app.switch.delete'):
                if(planning::deleteEvent($request)){
                    return response()->json(['style' => 'info', 'feedback' => 'Evènement supprimé avec succès !']);
                }else{
                    return response()->json(['style' => 'error', 'feedback' => 'Un erreur est survenue, veuillez contacter votre administrateur !']);
                }
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
}
