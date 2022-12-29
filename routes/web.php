<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmpController;
use App\Http\Middleware\admin;
use Illuminate\Support\Facades\Auth;

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

// Route::group(['middleware' => ['admin']], function () {
// Route::withoutMiddleware([admin::class])->group(function () {
// Route::middleware([admin::class])->group(function () {

Route::get('/', [WebsiteController::class, 'login'])->name('login');
Route::get('/forgot-password', [WebsiteController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/profile', [WebsiteController::class, 'aprofile'])->name('aprofile');
Route::get('/register', [WebsiteController::class, 'register'])->name('register');
Route::get('/home', [WebsiteController::class, 'index'])->name('index');
Route::get('/clientsList', [WebsiteController::class, 'clients'])->name('clients');
Route::get('/vendorsList', [WebsiteController::class, 'vendors'])->name('vendors');
Route::get('/projects', [WebsiteController::class, 'projects'])->name('projects');
Route::get('/tasks', [WebsiteController::class, 'tasks'])->name('tasks');
Route::get('/task-reports', [WebsiteController::class, 'reports'])->name('reports');
Route::get('/employees', [WebsiteController::class, 'employees'])->name('employees');

Route::get('/checkEmail/{email}', [WebsiteController::class, 'checkEmail'])->name('checkEmail');
Route::get('/adminLogout', [WebsiteController::class, 'adminLogout'])->name('adminLogout');
Route::get('/empLogout', [EmpController::class, 'empLogout'])->name('empLogout');
Route::post('/updateProfileAdmin', [WebsiteController::class, 'updateProfileAdmin'])->name('updateProfileAdmin');
Route::post('/verificationMail', [WebsiteController::class, 'verificationMail'])->name('verificationMail');
Route::post('/updatePassword', [WebsiteController::class, 'updatePassword'])->name('updatePassword');
Route::post('/reset-password', [WebsiteController::class, 'passwordReset'])->name('passwordReset');
Route::get('/verify-otp/{otp}/{user}/{id}', [WebsiteController::class, 'verifyOtp'])->name('verifyOtp');


Route::get('/employee-home', [EmpController::class, 'eindex'])->name('eindex');
Route::get('/employee-profile', [EmpController::class, 'profile'])->name('profile');
Route::get('/employee-tasks', [EmpController::class, 'taskboard'])->name('taskboard');
Route::post('/updateProfile', [EmpController::class, 'updateProfile'])->name('updateProfile');
Route::post('/changePassword', [EmpController::class, 'changePassword'])->name('changePassword');

Route::post('/loginCheck', [WebsiteController::class, 'loginCheck'])->name('loginCheck');
Route::post('/registerCheck', [WebsiteController::class, 'registerCheck'])->name('registerCheck');

Route::post('/clientsAdd', [ClientsController::class, 'clientsAdd'])->name('clientsAdd');
Route::get('/editClient/{id}', [ClientsController::class, 'editClient'])->name('editClient');
Route::get('/deleteClient/{id}', [ClientsController::class, 'deleteClient'])->name('deleteClient');
Route::get('/checkClient/{name}', [ClientsController::class, 'checkClient'])->name('checkClient');

Route::post('/clientsAdd', [ClientsController::class, 'clientsAdd'])->name('clientsAdd');
Route::get('/editClient/{id}', [ClientsController::class, 'editClient'])->name('editClient');
Route::get('/deleteClient/{id}', [ClientsController::class, 'deleteClient'])->name('deleteClient');

Route::post('/vendorsAdd', [VendorsController::class, 'vendorsAdd'])->name('vendorsAdd');
Route::get('/editVendor/{id}', [VendorsController::class, 'editVendor'])->name('editVendor');
Route::get('/deleteVendor/{id}', [VendorsController::class, 'deleteVendor'])->name('deleteVendor');
Route::get('/checkClientName/{name}', [VendorsController::class, 'checkClientName'])->name('checkClientName');

Route::post('/projectAdd', [ProjectsController::class, 'projectAdd'])->name('projectAdd');
Route::get('/editProject/{id}', [ProjectsController::class, 'editProject'])->name('editProject');
Route::get('/deleteProject/{id}', [ProjectsController::class, 'deleteProject'])->name('deleteProject');

Route::post('/tasklistAdd', [TaskController::class, 'tasklistAdd'])->name('tasklistAdd');
Route::get('/editTasklist/{id}', [TaskController::class, 'editTasklist'])->name('editTasklist');
Route::get('/deleteTasklist/{id}', [TaskController::class, 'deleteTasklist'])->name('deleteTasklist');

Route::post('/taskAdd', [TaskController::class, 'taskAdd'])->name('taskAdd');
Route::get('/editTask/{id}', [TaskController::class, 'editTask'])->name('editTask');
Route::get('/deleteTask/{id}', [TaskController::class, 'deleteTask'])->name('deleteTask');

Route::post('/employeeAdd', [EmployeeController::class, 'employeeAdd'])->name('employeeAdd');
Route::get('/editEmployeee/{id}', [EmployeeController::class, 'editEmployeee'])->name('editEmployeee');
Route::get('/deleteEmployeee/{id}', [EmployeeController::class, 'deleteEmployeee'])->name('deleteEmployeee');
Route::get('/checkEmailAddress/{email}', [EmployeeController::class, 'checkEmail'])->name('checkEmail');


Route::post('/reassignTask', [EmployeeController::class, 'reassignTask'])->name('reassignTask');
Route::post('/applyFilter', [WebsiteController::class, 'applyFilter'])->name('applyFilter');


Route::get('crop-image', 'App\Http\Controllers\Controller@indexCrop');
Route::post('crop-image', ['as' => 'croppie.upload-image', 'uses' => 'App\Http\Controllers\Controller@uploadCropImage']);
