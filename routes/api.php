<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Auth\Api\ClientsController;
use App\Http\Controllers\Auth\Api\VendorsController;
use App\Http\Controllers\Auth\Api\EmployeeController;
use App\Http\Controllers\Auth\Api\TasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 *  Admin And Employee Login;
 */
Route::post('authenticate', [LoginController::class, 'authenticate']);
Route::get('adminDashboard', [LoginController::class, 'adminDashboardDetail'])->middleware('auth:emp_api');
Route::get('employeeDashboard', [LoginController::class, 'employeeDashboardDetail'])->middleware('auth:emp_api');

/**
 * Admin Upadate Profile
 */
Route::get('adminProfile', [LoginController::class, 'adminProfile'])->middleware('auth:emp_api');
Route::post('updateAdminProfile', [LoginController::class, 'updateAdminProfile'])->middleware('auth:emp_api');
Route::get('employeeProfile', [LoginController::class, 'employeeProfile'])->middleware('auth:emp_api');
Route::post('updateEmployeeProfile', [LoginController::class, 'updateEmployeeProfile'])->middleware('auth:emp_api');
Route::post('employeeChangePassword', [LoginController::class, 'employeeChangePassword'])->middleware('auth:emp_api');


/**
 *  Clientd Add-Edit-Update-Delete;
 */
Route::get('clientsList', [ClientsController::class, 'clientsList'])->middleware('auth:emp_api');
Route::post('addClient', [ClientsController::class, 'addClient'])->middleware('auth:emp_api');
Route::get('editClient/{id}', [ClientsController::class, 'editClient'])->middleware('auth:emp_api');
Route::delete('deleteClient/{id}', [ClientsController::class, 'deleteClient'])->middleware('auth:emp_api');

/**
 *  Vendors Add-Edit-Update-Delete;
 */
Route::get('vendorsList', [VendorsController::class, 'vendorsList'])->middleware('auth:emp_api');
Route::post('addVendor', [VendorsController::class, 'addVendor'])->middleware('auth:emp_api');
Route::get('editVendor/{id}', [VendorsController::class, 'editVendor'])->middleware('auth:emp_api');
Route::delete('deleteVendor/{id}', [VendorsController::class, 'deleteVendor'])->middleware('auth:emp_api');

/**
 * Employees Add-Edit-Update-Delete;
 */
Route::get('employeeList', [EmployeeController::class, 'employeeList'])->middleware('auth:emp_api');
Route::post('addEmployee', [EmployeeController::class, 'addEmployee'])->middleware('auth:emp_api');
Route::get('editEmployee/{id}', [EmployeeController::class, 'editEmployee'])->middleware('auth:emp_api');
Route::delete('deleteEmployee/{id}', [EmployeeController::class, 'deleteEmployee'])->middleware('auth:emp_api');

/**
 *  Tasks Board Add-Edit-Update-Delete;
 */
Route::get('tasks', [TasksController::class, 'tasks'])->middleware('auth:emp_api');
Route::post('addTasksBoard', [TasksController::class, 'addTasksBoard'])->middleware('auth:emp_api');
Route::get('editTasksBoard/{id}', [TasksController::class, 'editTasksBoard'])->middleware('auth:emp_api');
Route::delete('deleteTasksBoard/{id}', [TasksController::class, 'deleteTasksBoard'])->middleware('auth:emp_api');

/**
 * Tasks Add-Edit-Update-Delete;
 */ 
Route::post('addTasks', [TasksController::class, 'addTasks'])->middleware('auth:emp_api');
Route::get('editTasks/{id}', [TasksController::class, 'editTasks'])->middleware('auth:emp_api');
Route::delete('deleteTasks/{id}', [TasksController::class, 'deleteTasks'])->middleware('auth:emp_api');

/**
 * Tasks Report
 */
Route::get('taskReports', [TasksController::class, 'taskReports'])->middleware('auth:emp_api');

/**
 * Employee Tasks Board
 */
Route::get('employeeTasks', [TasksController::class, 'employeeTasks'])->middleware('auth:emp_api');