<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\Employee;
use App\Models\Loginuser;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class EmpController extends Controller
{
    public function eindex()
    {
        $email = Session::get('user');
        $user = Employee::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uid = $user->id;
            $uimg = $user->photo;

            $allemps = Task::where('deleted_at',NULL)->where('assignTo',$user->id)
            ->where('status','!=','2')->count();
            
            return view('pages.emp-dashboard',compact('uname','allemps','uid','uimg'));
        }
    }

    public function profile()
    {
        $email = Session::get('user');
        $user = Employee::where('email',$email)->first();
        if ($user == '')
        {
            return redirect('/');
        }else {
            $uname = $user->name;
            $uid = $user->id;
            $uimg = $user->photo;
            return view('pages.emp-profile',compact('uname','user','uimg'));
        }
    }

    public function empLogout()
    {
        Session::forget('user');
        Session::flush();
        return redirect()->route('login');
    }

    public function taskboard()
    {

        $email = Session::get('user');
        $user = Employee::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }
        else {
            $uname = $user->name;
            $uid = $user->id;
            $uimg = $user->photo;

// echo $user->id;exit;
            $tasklist = TaskList::where('deleted_at',NULL)->get();
            $tasks = Task::where('tasks.deleted_at',NULL)
            ->where('assignTo',$user->id)
            ->where('status','!=','2') 
            ->orderBy('tasks.id','DESC')
            ->get();

            foreach($tasks as $p)
            {
                $arr = explode(",",$p->assignTo);
                $employees  =  Employee::where('deleted_at',NULL)->whereIn('id', $arr)->select('name')->get();

                $arrName = array();
                foreach($employees as $employees)
                {
                    array_push($arrName, $employees->name);
                }
                $p->eName = implode(" , ",$arrName);
                
                
            }
            
            $allClients = Client::where('deleted_at',NULL)->get();
            $allVendors = Vendor::where('deleted_at',NULL)->get();
            $employee = Employee::where('deleted_at',NULL)->get();
            $projects = Project::where('projects.deleted_at',NULL)->get();

            return view('pages.emp-tasks',compact('tasks','tasklist','allClients','allVendors','employee','projects','uname','user','uimg','uid'));
        }
        
    }

    public function updateProfile(Request $request)
    {

        $id = $_POST['id'];
        $data = $_POST;

        unset($data['id']);
        unset($data['_token']);
            

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

            Session::forget('user');
            Session::flush();

            Session::put('user', $data['email']);
            
            return redirect('/employee-profile');
        }

    }

    public function changePassword()
    {
        // echo json_encode($_POST);
        $emp = Employee::where('id',$_POST['id'])->first();
        $newPassword = Hash::make($_POST['new']);
        if (Hash::check($_POST['password'], $emp->password))
        {
            $arr = array(
                'password' => $newPassword,
                'confirmPassword' => $newPassword
            );

            if(Employee::where('id',$_POST['id'])->update($arr))
            {
                return back()->with("success", "Password changed!");
            }
        }else{
            return redirect('/employee-profile')->with("error", "Old Password Is Not Metch!");
        }
    }
}
