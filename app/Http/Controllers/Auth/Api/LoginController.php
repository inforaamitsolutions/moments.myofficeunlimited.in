<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Loginuser;
use App\Models\Task;
use App\Models\Client;
use App\Models\TaskList;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Employee;
use App\Http\Requests\AddAdminRequest;
use App\Http\Requests\AddEmployeeRequest;
use Illuminate\Auth\Events\Failed;

// use Auth;

class LoginController extends Controller
{
    /**
     * Check authentication
     */
    public function authenticate(Request $request): JsonResponse
    {
        $request_data = $request->all();
        $validation  = Validator::make($request_data, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        if ($request['type'] == "admin") {
            $email_pass = Auth::guard('web_loginusers')->attempt(['email' => $request->email, 'password' => $request->password]);
            $user = Auth::guard('web_loginusers')->user();
        } else {
            $email_pass = Auth::guard('web_employee')->attempt(['email' => $request->email, 'password' => $request->password]);
            // $email_pass = Auth::guard('web_employee')->check(['email' => $request->email, 'password' => Hash::make($request->password)]);
            $user = Auth::guard('web_employee')->user();
        }
        if ($email_pass) {
            // $test = $user->access_token = $user->createToken('User-authenticate-'.$user->id)->plainTextToken; //accessToken->token
            $user->access_token = $user->createToken('xNYTB8jHkIjMXbeyQaGdDiPrIZ2XatnQUNy016y7')->accessToken; //->plainTextToken
            // $success['token'] = $user->createToken('MyApp')-> accessToken;
            $success['token'] = $user;
            // dd($success['token']);
            if (!isset($success['token'])) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Unauthenticate User',
                ], 200);
            }
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Uaser Login Sucessfully'
            ];

            Session::put('user', $user->name);

            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        }
    }

    public function adminDashboardDetail(Request $request): JsonResponse
    {
        // dd(auth('api')->user());
        // $alluser = Loginuser::all();
        // $response = [
        //     'success' => true,
        //     'data' => $alluser,
        //     'message' => ' Sucessfully'
        // ];
        // return response()->json($response, 200);
        $active = array();
        $pending = array();
        $completed = array();

        $t1 = Task::where('tasks.deleted_at', NULL)
            ->where('employees.deleted_at', NULL)
            ->join('employees', 'employees.id', 'tasks.assignTo')
            ->select(
                'tasks.*',
                'employees.*',
                'tasks.name as tName',
                'tasks.id as tId',
                'tasks.status as tStatus',
                'tasks.created_at as sDate'
            )
            ->orderBy('tasks.id', 'DESC')->get();
        foreach ($t1 as $p) {
            $employees  =  Employee::where('deleted_at', NULL)->where('id', $p->assignTo)->select('name')->get();
            $arrName = array();
            foreach ($employees as $employees) {
                array_push($arrName, $employees->name);
            }
            $p->eName = implode(" , ", $arrName);

            $t = date("d-m-Y");
            $today = strtotime($t);

            $old = $p->dueDate;
            $str = str_replace("/", "-", $old);
            $due = strtotime($str);

            if ($today > $due) {
                $p->tStatus = 3;
                array_push($pending, $p->id);
            } elseif ($p->tStatus == 1) {
                array_push($active, $p->id);
            } elseif ($p->tStatus == 2) {
                array_push($completed, $p->id);
            }
        }

        $result['activeTasks'] = count($active);
        $result['completeTasks'] = count($completed);
        $result['pendingTasks'] = count($pending);
        $result['tasks'] = count($t1);

        $result['projects'] = Tasklist::where('deleted_at', NULL)->count();
        $result['employee'] = Employee::where('deleted_at', NULL)->count();
        $result['allClients'] = Client::where('deleted_at', NULL)->count();
        $result['allVendors'] = Vendor::where('deleted_at', NULL)->count();


        $login['user'] = auth('api')->user();

        if ($login['user'] == '') {
            $response = [
                'success' => false,
                'data' => '',
                'message' => 'Please Login With Your Credentials.'
            ];
            return response()->json($response, 200);
        } else {
            $result['uname'] = $login['user']->name;
            $result['uimg'] = $login['user']->photo;

            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function employeeDashboardDetail(Request $request): JsonResponse
    {
        $email = auth('emp_api')->user();
        // dd($email->email);
        $user = Employee::where('email', $email->email)->first();

        if ($user->email == '') {
            $response = [
                'success' => false,
                'data' => '',
                'message' => 'Please Login With Your Credentials.'
            ];
            return response()->json($response, 200);
        } else {

            $result['uname'] = $user->name;
            $result['uid'] = $user->id;
            $result['uimg'] = $user->photo;
            $result['allemps'] = Task::where('deleted_at', NULL)->where('assignTo', $user->id)
                ->where('status', '!=', '2')->count();

            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function adminProfile()
    {

        $login['user'] = auth('api')->user();
        $result['user'] = Loginuser::where('email', $login['user']->email)->first();

        if ($result['user'] == '') {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        } else {
            // $result['uname'] = $result['user']->name;
            // $result['uimg'] = $result['user']->photo;
            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function updateAdminProfile(AddAdminRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        if (Loginuser::where('id', $request_data['id'])->update($request_data)) {
            if ($request->file('photo') != null) {
                $path = 'admin/';
                $photo_name = $request->file('photo')->getClientOriginalName();
                $file_name = $path . date('dmY') . $photo_name;
                $request->file('photo')->move(public_path($path), $file_name);
                $imgParr["photo"] = 'public/admin/' . date('dmY') . $photo_name;
                Loginuser::where('id', $request_data['id'])->update($imgParr);
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Prifile Update successfully.',
            ], 200);
        } else {
            echo "no update";
        }
    }

    public function employeeProfile()
    {
        $login['user'] = auth('emp_api')->user();
        $result['user'] = Employee::where('email', $login['user']->email)->first();

        if ($result['user'] == '') {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        } else {
            // $result['uname'] = $result['user']->name;
            // $result['uimg'] = $result['user']->photo;
            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function updateEmployeeProfile(AddEmployeeRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        if (Employee::where('id', $request_data['id'])->update($request_data)) {
            if ($request->file('photo') != null) {
                $path = 'employee/';
                $photo_name = $request->file('photo')->getClientOriginalName();
                $file_name = $path . date('dmY') . $photo_name;
                $request->file('photo')->move(public_path($path), $file_name);
                $imgParr["photo"] = 'public/employee/' . date('dmY') . $photo_name;
                Employee::where('id', $request_data['id'])->update($imgParr);
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Prifile Update successfully.',
            ], 200);
        } else {
            echo "no update";
        }
    }

    public function employeeChangePassword(request $request)
    {
        $emp = Employee::where('id', $request->id)->first();
        $newPassword = Hash::make($request->newpassword);
        if (Hash::check($request->password, $emp->password)) {
            $arr = array(
                'password' => $newPassword,
                'confirmPassword' => $newPassword
            );

            if (Employee::where('id', $request->id)->update($arr)) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Password Update successfully.',
                ], 200);
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Old Password Is Not Metch! '
            ];
            return response()->json($response);
        }
    }
}
