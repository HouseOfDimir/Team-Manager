<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->withoutMiddleware(['auth']);


Route::group(['prefix' => 'employee'], function(){
    Route::get('/view', 'EmployeeController@execute')->name('employee.index');
    Route::get('/creation', 'EmployeeController@creationEmployee')->name('employee.creationEmployee');
    Route::post('/create', 'EmployeeController@createEmployee')->name('employee.createEmployee');
    Route::get('/delete/{fkEmployee}', 'EmployeeController@deleteEmployee')->name('employee.deleteEmployee');
    Route::get('/modify/{fkEmployee}', 'EmployeeController@toModifyEmployee')->name('employee.toModifyEmployee');
    Route::post('/edit', 'EmployeeController@editEmployee')->name('employee.editEmployee');
    Route::post('/planningAndMail', 'EmployeeController@createPDFandSendToMail')->name('employee.planningAndMail');
});

Route::group(['prefix' => 'contract'], function(){
    Route::get('/view/{fkContract?}', 'ContractController@execute')->name('contract.index');
    Route::post('/create', 'ContractController@addContract')->name('contract.createContract');
    Route::get('/delete/{fkContract}', 'ContractController@deleteContract')->name('contract.deleteContract');
});

Route::group(['prefix' => 'task'], function(){
    Route::get('/view/{fkTask?}', 'TaskController@execute')->name('task.index');
    Route::get('/administration', 'TaskController@administration')->name('task.administration');
    Route::post('/createTask', 'TaskController@createTask')->name('task.createTask');
    Route::get('/deleteTask', 'TaskController@deleteTask')->name('task.deleteTask');
    Route::post('/editParamAdmin', 'TaskController@editParamAdmin')->name('task.editParamAdmin');
});

Route::group(['prefix' => 'file'], function(){
    Route::get('/view/{fkFile}', 'FileController@viewFile')->name('file.view');
    Route::get('/download/{fkFile}', 'FileController@downloadFile')->name('file.download');
    Route::get('/delete/{fkFile}', 'FileController@deleteFile')->name('file.delete');
    Route::get('/display/{fkFile}', 'FileController@displayFile')->name('file.display');
});

Route::group(['prefix' => 'planning'], function(){
    Route::get('/view', 'PlanningController@execute')->name('planning.index');
    Route::post('/create','PlanningController@ajaxTourbi')->name('planning.create');
    Route::post('/update','PlanningController@ajaxTourbi')->name('planning.update');
    Route::post('/delete','PlanningController@ajaxTourbi')->name('planning.delete');
    Route::post('/getAllEmployee', 'PlanningController@getAllEmployee')->name('planning.getAllEmployee');
    Route::get('/getPlanningOneEmployee/{fkEmployee}/{startDate}/{endDate}', 'PlanningController@getPlanningOneEmployee')->name('planning.getPlanningOneEmployee')->withoutMiddleware(['auth']);
    Route::get('/getPlanningGlobal/{startDate}/{endDate}', 'PlanningController@getPlanningGlobal')->name('planning.getPlanningGlobal')->withoutMiddleware(['auth']);
    //Route::post('/getAllEvents', 'PlanningController@getAllEvents')->name('planning.getAllEvents');
});

Route::group(['prefix' => 'ajax'], function(){
    Route::get('/getAllEmployee', 'AjaxController@getAllEmployee')->name('ajax.getAllEmployee');
    Route::get('/getEmployeeById/{fkEmployee}', 'AjaxController@getEmployeeById')->name('ajax.getEmployeeById');
    Route::get('/getOneEmployeeById/{fkEmployee}', 'AjaxController@getOneEmployeeById')->name('ajax.getOneEmployeeById');
    Route::get('/getAllEvents/{end?}/{start?}', 'AjaxController@getAllEvents')->name('ajax.getAllEvents');
    Route::get('/getAllEventsById/{fkEmployee?}/{end?}/{start?}', [AjaxController::class, 'getAllEventsById'])->name('ajax.getAllEventsById');
});

Route::get("send-email/{fkEmployee}", "EmailController@sendEmailToN1")->name('sendMail');
