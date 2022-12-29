<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employeeAdd(Request $request)
    {
        $id = $_POST['editId'];
        $data = $_POST;

        // echo json_encode($data);exit;
        
        
        if ($id == '')
        {
            $data['password'] = Hash::make($data['password']);
            $data['confirmPassword'] = Hash::make($data['confirmPassword']);

            if($last = Employee::create($data))
            {
                $lastId = $last->id;

                if($request->file('photo')!=null)
                {
                    $path = 'public/employee/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Employee::where('id',$lastId)->update($imgParr);
                }

                return redirect('/employees');
            }
        }
        else
        {
            unset($data['editId']);
            unset($data['_token']);
            

            $data['password'] = Hash::make($data['password']);
            $data['confirmPassword'] = Hash::make($data['confirmPassword']);
            
            if(Employee::where('id',$id)->update($data))
            {
                if($request->file('photo')!=null)
                {
                    $path = 'public/employee/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Employee::where('id',$id)->update($imgParr);
                }
                
                return redirect('/employees');
            }
        }

    }

    public function editEmployeee($id)
    {
        $data = Employee::where('id',$id)->first();
        return $data;
    }

    public function deleteEmployeee($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Employee::where('id',$id)->update($data))
        {
            echo "done";
        }
    }

    public function reassignTask()
    {
        // echo json_encode($_POST); exit;
        $id = $_POST['taskIdRe'];
        // $forArr = implode(" , ",$_POST['forwardedTo']);
        $data = array(
            'status' => '2',
        );
        if(Task::where('id',$id)->update($data))
        {
            // echo "done";
            return redirect('/employee-tasks');
        }
    }

    public function checkEmail($email)
    {
        $user = Employee::where('deleted_at',NULL)->where('email', $email)->get();

        // echo json_encode($user);exit;
        if(count($user) > 0)
        {
            echo "1";
        }else {
            echo "0";
        }

    }
}
