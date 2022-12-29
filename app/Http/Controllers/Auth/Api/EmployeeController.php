<?php

namespace App\Http\Controllers\auth\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Employee;
use App\Models\Loginuser;
use App\Http\Requests\EmployeeAddRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function employeeList(Request $request): JsonResponse
    {
        $result['allEmployee'] = Employee::where('deleted_at', NULL)->get();
        // $email = Session::get('user');
        $login['user'] = auth('api')->user();

        $user = Loginuser::where('email', $login['user']->email)->first();

        if ($user == '') {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        } else {

            $result['uname'] = $user->name;
            $result['uimg'] = $user->photo;
            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function addEmployee(EmployeeAddRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        if ($request_data['id'] == '') {
            $request_data['password'] = Hash::make($request_data['password']);
            $request_data['confirmPassword'] = Hash::make($request_data['confirmPassword']);
            if ($last = Employee::create($request_data)) {
                $lastId = $last->id;

                if ($request->file('photo') != null) {
                    $path = 'employee/';
                    $photo_name = $request->file('photo')->getClientOriginalName();
                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('photo')->move(public_path($path), $file_name);
                    $imgParr["photo"] = 'public/employee/' . date('dmY') . $photo_name;
                    Employee::where('id', $lastId)->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Employee Add successfully.',
                ], 200);
            }
        } else {
            if (Employee::where('id', $request_data['id'])->update($request_data)) {
                if ($request->file('photo') != null) {
                    $path = 'employee/';
                    $photo_name = $request->file('photo')->getClientOriginalName();
                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('photo')->move(public_path($path), $file_name);
                    $imgParr["photo"] ='public/employee/' . date('dmY') . $photo_name;
                    Employee::where('id', $request_data['id'])->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Employee Update successfully.',
                ], 200);
            }
        }
    }

    public function editEmployee($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:employees,id',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = Employee::where('id', $id)->first();
        return response()->json([
            'success'   => true,
            'data' => $result,
            'message'   => 'Employee Get successfully.',
        ], 200);
    }

    public function deleteEmployee($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];
        
        $validation  = Validator::make($request_data, [
            'id' => 'exists:employees,id',    
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Employee::where('id',$id)->update($result))
        {
            return response()->json([
                'success'   => true,
                'data' => $result,
                'message'   => 'Employess Delete successfully.',
            ], 200);
        }
    }
}
