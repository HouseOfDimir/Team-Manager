<?php

namespace App\Http\Controllers;

use database\Models\letterColor;
use database\Models\paramAdmin;
use database\Models\paramAdminInitialView;
use Illuminate\Http\Request;
use Models\Task;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){$this->middleware('auth');}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function execute(Task $fkTask = null)
    {
        $array = ['allTask'     => Task::getAllTasks(),
                  'letterColor' => letterColor::getAllLetterColor(),
                  'route'       => route('task.createTask')];
        isset($fkTask) && $array['task'] = $fkTask;

        return view('task.index')->with($array);
    }

    public function administration(){
        $paramAdmin         = paramAdmin::getAllParamAdmin();
        $paramAdminOther    = [];
        $paramAdminPlanning = [];

        foreach($paramAdmin as $item){
            if($item->planning){
                $paramAdminPlanning[] = $item;
            }else{
                $paramAdminOther[] = $item;
            }
        }

        return view('task.administration')->with(['paramAdmin'         => $paramAdminOther,
                                                  'paramAdminPlanning' => $paramAdminPlanning,
                                                  'initialView'        => paramAdminInitialView::getAllInitialView(),
                                                  'route'              => route('task.editParamAdmin')]);
    }

    public function editParamAdmin(Request $request){
        $this->validate($request, [
            'weekends'     => 'required|bool',
            'initialView'  => 'required|int|exists:planningParamInitialView,id',
            'slotMinTime'  => 'required|date_format:H:i:s',
            'slotMaxTime'  => 'required|date_format:H:i:s',
            'slotDuration' => 'required|date_format:H:i:s'
        ]);

        foreach($request->except('_token') as $key => $value){
            paramAdmin::insertBulkAdmin($key, $value);
        }
        return redirect()->back()->with('success', 'Param??tres administration modifi??s avec succ??s');
    }

    public function createTask(Request $request){
        $this->validate($request, [
            'fkTask'      => 'nullable|int|exists:\Models\Task,id',
            'color'       => 'required|string|max:7',
            'libelle'     => 'required|string|max:50',
            'fkLetterColor' => 'required|string|max:5',
        ]);

        Task::insertTask($request);
        if($request->filled('fkTask')){
            return redirect()->route('task.index')->with('success', 'T??che modifi??e avec succ??s !');

        }else{
            return redirect()->route('task.index')->with('success', 'T??che cr????e avec succ??s !');
        }
    }

    public function deleteTask(Task $fkTask){
        return $fkTask->delete() ? redirect()->route('task.index')->with('success', 'T??che supprim??e avec succ??s !') : redirect()->back()->with('error', 'Une erreur est survenue, veuillez contacter votre administrateur !');
    }

    /* public function toModifyTask($fkTask){
        $this->validateFkTask($fkTask);

    }

    public function validateFkTask($fkTask){
        $request = new \Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->request->add(['fkTask' => $fkTask]);
        $this->validate($request, ['fkTask' => 'required|int|exists:\Models\Task,id']);
        return $request;
    } */
}
