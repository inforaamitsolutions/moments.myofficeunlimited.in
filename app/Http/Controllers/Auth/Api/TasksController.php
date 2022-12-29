<?php

namespace App\Http\Controllers\auth\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Loginuser;
use App\Models\TaskList;
use App\Models\Task;
use App\Models\Vendor;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AddTasksBoardRequest;
use App\Http\Requests\AddTasksRequest;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function tasks()
    {
        $result['tasklist'] = TaskList::where('deleted_at', NULL)->orderBy('id', 'DESC')->get();
        $result['tasks'] = Task::where('tasks.deleted_at', NULL)
            ->where('employees.deleted_at', NULL)
            ->join('employees', 'employees.id', 'tasks.assignTo')
            ->select('tasks.*', 'employees.*', 'tasks.name as tName', 'tasks.id as tId')
            ->where('tasks.status', '!=', '2')
            ->orderBy('tasks.id', 'DESC')->get();
        $result['allClients'] = Client::where('deleted_at', NULL)->get();
        $result['allVendors'] = Vendor::where('deleted_at', NULL)->get();
        $result['employee'] = Employee::where('deleted_at', NULL)->get();
        $result['projects'] = Project::where('deleted_at', NULL)->get();

        // $email = Session::get('user');
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
            $result['priority'] = array(
                "Normal", "High", "Low"
            );

            foreach ($result['tasks'] as $p) {
                $assign = Employee::where('deleted_at', NULL)->where('id', $p->assignTo)->first();
                $p->assignTo = $assign->name;
            }

            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function addTasksBoard(AddTasksBoardRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        if ($request_data['id'] == '') {
            if ($last = TaskList::create($request_data)) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'TasksBoard Add successfully.',
                ], 200);
            }
        } else {
            if (TaskList::where('id', $request_data['id'])->update($request_data)) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'TasksBoard Update successfully.',
                ], 200);
            }
        }
    }

    public function editTasksBoard($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:task_lists,id',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = TaskList::where('id', $id)->first();
        return response()->json([
            'success'   => true,
            'data' => $result,
            'message'   => 'TasksBoard Get successfully.',
        ], 200);
    }

    public function deleteTasksBoard($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:task_lists,id',
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
        if (TaskList::where('id', $id)->update($result)) {
            return response()->json([
                'success'   => true,
                'data' => $result,
                'message'   => 'TasksBoard Delete successfully.',
            ], 200);
        }
    }

    public function addTasks(AddTasksRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        $request_data['status'] = '1';

        if ($request_data['id'] == '') {

            if ($last = Task::create($request_data)) {
                $lastId = $last->id;

                if ($request->file('images') != null) {
                    $path = 'tasks/';
                    $photo_name = $request->file('images')->getClientOriginalName();
                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('images')->move(public_path($path), $file_name);
                    $imgParr["images"] = 'public/tasks/' . date('dmY') . $photo_name;
                    Task::where('id', $lastId)->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Task Add successfully.',
                ], 200);
            }
        } else {
            if (Task::where('id', $request_data['id'])->update($request_data)) {

                if ($request->file('images') != null) {
                    $path = 'tasks/';
                    $photo_name = $request->file('images')->getClientOriginalName();
                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('images')->move(public_path($path), $file_name);
                    $imgParr["images"] = 'public/tasks/' . date('dmY') . $photo_name;
                    Task::where('id', $request_data['id'])->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Task Update successfully.',
                ], 200);
            }
        }
    }

    public function editTasks($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:tasks,id',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = Task::where('id', $id)->first();
        return response()->json([
            'success'   => true,
            'data' => $result,
            'message'   => 'Tasks Get successfully.',
        ], 200);
    }

    public function deleteTasks($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:tasks,id',
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
        if (Task::where('id', $id)->update($result)) {
            return response()->json([
                'success'   => true,
                'data' => $result,
                'message'   => 'Tasks Delete successfully.',
            ], 200);
        }
    }

    public function taskReports()
    {
        // $result['tasklist'] = TaskList::where('deleted_at', NULL)->get();
        $result['tasks'] = Task::where('tasks.deleted_at', NULL)
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

        // $result['allemps'] = Employee::where('deleted_at', NULL)->get();

        $login['user'] = auth('api')->user();
        $user = Loginuser::where('email', $login['user']->email)->first();

        if ($user == '') {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        } else {

            foreach ($result['tasks'] as $p) {
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

                    $data = array(
                        'status' => 3
                    );
                    Task::where('id', $p->tId)->update($data);
                }
            }

            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }

    public function employeeTasks()
    {
        $login['user'] = auth('emp_api')->user();
        $user = Employee::where('email', $login['user']->email)->first();

        if ($user == '') {
            $response = [
                'success' => false,
                'message' => 'Unauthorised Email And Password'
            ];
            return response()->json($response);
        } else {
            // $uname = $user->name;
            // $uid = $user->id;
            // $uimg = $user->photo;


            $result['tasklist'] = TaskList::where('deleted_at', NULL)->get();
            $result['tasks'] = Task::where('tasks.deleted_at', NULL)
                ->where('assignTo', $user->id)
                ->where('status', '!=', '2')
                ->orderBy('tasks.id', 'DESC')
                ->get();

            // foreach ($result['tasks'] as $p) {
            //     $arr = explode(",", $p->assignTo);
            //     $employees  =  Employee::where('deleted_at', NULL)->whereIn('id', $arr)->select('name')->get();

            //     $arrName = array();
            //     foreach ($employees as $employees) {
            //         array_push($arrName, $employees->name);
            //     }
            //     $p->eName = implode(" , ", $arrName);
            // }

            // $result['allClients'] = Client::where('deleted_at', NULL)->get();
            // $result['allVendors'] = Vendor::where('deleted_at', NULL)->get();
            // $result['employee'] = Employee::where('deleted_at', NULL)->get();
            // $result['projects'] = Project::where('projects.deleted_at', NULL)->get();

            $response = [
                'success' => true,
                'data' => $result,
                'message' => ' Sucessfully'
            ];
            return response()->json($response, 200);
        }
    }
}
