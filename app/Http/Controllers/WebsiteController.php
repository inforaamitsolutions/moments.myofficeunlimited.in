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
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class WebsiteController extends Controller
{
    public function checkEmail($email)
    {
        // echo $email;exit;

        $user = Loginuser::where('email',$email)->get();
        // $emp = Employee::where('email',$email)->get();
        $emp = Employee::where('email',$email)->where('deleted_at',NULL)->get();

        if (count($user) > 0)
        {
            if ($user[0]->status == 'Admin')
            {
                echo "1";

            }
        }elseif (count($emp) > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function registerCheck()
    {
        $_POST['password'] = Hash::make($_POST['password']);
        $_POST['confirmPassword'] = Hash::make($_POST['confirmPassword']);
        $_POST['status'] = 'Admin';
        if($last = Loginuser::create($_POST))
        {
            Session::put('user', $_POST['email']);
            return redirect('/home');
        }

    }

    public function loginCheck()
    {
        // echo json_encode($_POST);exit;
        $email = $_POST['email'];

        $user = Loginuser::where('email',$email)->get();
        // dd($user);
        $emp = Employee::where('email',$email)->where('deleted_at',NULL)->get();

        if (count($user) > 0)
        {
            if ($user[0]->status == 'Admin')
            {
                if(Hash::check($_POST['password'],$user[0]->password))
                {
                    Session::put('user', $_POST['email']);
                    return redirect('/home');
                }else {
                    return back()->with("error", "Password you entered is incorrect!");
                }

            }
        }elseif (count($emp) > 0) {
            if(Hash::check($_POST['password'],$emp[0]->password))
            {
                Session::put('user', $_POST['email']);
                return redirect('/employee-home');
            }else {
                return back()->with("error", "Password you entered is incorrect!");
            }
        } else {
            return back()->with("error", "Email address doesn't exist!");
        }
        
    }

    public function adminLogout()
    {
        Session::forget('user');
        Session::flush();
        return redirect()->route('login');
    }

    public function login()
    {
        return view('pages.login');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function forgotPassword()
    {
        return view('pages.forgot-password');
    }

    public function verificationMail()
    {
        // echo json_encode($_POST);exit;
        // $userIs = $_POST['user'];

        $user = Loginuser::where('email',$_POST['email'])->get();
        $emps = Employee::where('email',$_POST['email'])->get();

        if (count($user) > 0)
        {
            $userID = $user[0]->id;
            $userIs = 'Admin';

            $randomid = mt_rand(100000,999999); 
            $data = 
            "Use OTP $randomid to proceed further in your password reset process.\n
            From,
            Team MyOffice Unlimited
            ";

            Mail::raw($data, function ($message) {
                $message->to($_POST['email'])
                ->subject('Password reset OTP');
            });

            if(count(Mail::failures()) > 0){
                echo "Email not send";
            } else {
                // echo "done";
                return redirect("/verify-otp/$randomid/$userIs/$userID");
            }

        }
        else if (count($emps) > 0)
        {

            $userID = $emps[0]->id;
            $userIs = 'Employee';
            $randomid = mt_rand(100000,999999); 
            $data = 
            "Use OTP $randomid to proceed further in your password reset process.\n
            From,
            Team MyOffice Unlimited
            ";

            Mail::raw($data, function ($message) {
                $message->to($_POST['email'])
                ->subject('Password reset OTP');
            });

            if(count(Mail::failures()) > 0){
                echo "Email not send";
            } else {
                // echo "done";
                return redirect("/verify-otp/$randomid/$userIs/$userID");
            }
        }else {
            return back()->with("error", "Email address doesn't exist!");
        }
    }

    public function verifyOtp($otp,$user,$id)
    {
        return view('pages.verify-otp',compact('otp','user','id'));
    }

    public function passwordReset()
    {
        // echo json_encode($_POST);exit;
        $user = $_POST['user'];
        $userId = $_POST['userId'];
        $otpCheck = $_POST['otpCheck'];
        $otp = $_POST['otp'];
        if ($otp == $otpCheck)
        {
            return view('pages.password-reset',compact('user','userId'));
        }else {
            return back()->with("error", "OTP you entered is incorrect!");
        }
    }

    public function updatePassword()
    {
        // echo json_encode($_POST);

        $_POST['password'] = Hash::make($_POST['password']);
        $_POST['confirmPassword'] = Hash::make($_POST['confirmPassword']);

        if ($_POST['user'] == 'Admin')
        {
            $data = array(
                'password' => $_POST['password'],
                'confirmPassword' => $_POST['confirmPassword'],
            );
            if(Loginuser::where('id',$_POST['userId'])->update($data))
            {
                return redirect('/');
            }
        } else {
            $data = array(
                'password' => $_POST['password'],
                'confirmPassword' => $_POST['confirmPassword'],
            );
            if(Employee::where('id',$_POST['userId'])->update($data))
            {
                return redirect('/');
            }
        }
    }

    public function aprofile()
    {
        
        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;
            return view('pages.admin-profile',compact('uname','user','uimg'));
        }
    }

    public function updateProfileAdmin(Request $request)
    {
        $id = $_POST['id'];
        $data = $_POST;

        unset($data['id']);
        unset($data['_token']);
            

        if(Loginuser::where('id',$id)->update($data))
        {
            if($request->file('photo')!=null)
            {
                // echo "photo";exit;
                $path = 'public/admin/';
                $imgArray = array();
                foreach($request->file('photo') as $p)
                {
                    // echo "photo";exit;
                    $image_name = $path.date('dmY').$p->getClientOriginalName();
                    $p->move($path,$image_name);
                    
                    array_push($imgArray, $image_name);
                    // echo json_encode($imgArray);exit;
                }
                
                $imgParr["photo"] = end($imgArray);
                Loginuser::where('id',$id)->update($imgParr);
            }

            Session::forget('user');
            Session::flush();

            Session::put('user', $data['email']);
            
            return redirect('/profile');
        }else {
            echo "no update";
        }
    }

    public function reports()
    {
        // task status - 1 - active
        // task status - 2 - complete
        // task status - 3 - pending

        $tasklist = TaskList::where('deleted_at',NULL)->get();
        $tasks = Task::where('tasks.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->join('employees','employees.id','tasks.assignTo')
                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId',
                'tasks.status as tStatus','tasks.created_at as sDate')
                ->orderBy('tasks.id','DESC')->get();

        $allemps = Employee::where('deleted_at',NULL)->get();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;

            foreach($tasks as $p)
            {
                $employees  =  Employee::where('deleted_at',NULL)->where('id', $p->assignTo)->select('name')->get();
                $arrName = array();
                foreach($employees as $employees)
                {
                    array_push($arrName, $employees->name);
                }
                $p->eName = implode(" , ",$arrName);

                $t = date("d-m-Y");
                $today = strtotime($t);

                $old = $p->dueDate;
                $str = str_replace("/", "-", $old);
                $due = strtotime($str);

                if ($today > $due)
                {
                    $p->tStatus = 3;

                    $data = array(
                        'status' => 3
                    );
                    Task::where('id',$p->tId)->update($data);
                }                

            }

            return view('pages.task-report',compact('tasks','tasklist','allemps','user','uname','uimg'));
        }
    }

    public function index()
    {
        // $tasks = Task::where('deleted_at',NULL)->count();
        // $tasks = Task::where('tasks.deleted_at',NULL)
        //         ->where('employees.deleted_at',NULL)
        //         ->join('employees','employees.id','tasks.assignTo')->count();

        $active = array();
        $pending = array();
        $completed = array();

        $t1 = Task::where('tasks.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->join('employees','employees.id','tasks.assignTo')
                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId',
                'tasks.status as tStatus','tasks.created_at as sDate')
                ->orderBy('tasks.id','DESC')->get();

            foreach($t1 as $p)
            {
                $employees  =  Employee::where('deleted_at',NULL)->where('id', $p->assignTo)->select('name')->get();
                $arrName = array();
                foreach($employees as $employees)
                {
                    array_push($arrName, $employees->name);
                }
                $p->eName = implode(" , ",$arrName);

                $t = date("d-m-Y");
                $today = strtotime($t);

                $old = $p->dueDate;
                $str = str_replace("/", "-", $old);
                $due = strtotime($str);

                if ($today > $due)
                {
                    $p->tStatus = 3;
                    array_push($pending,$p->id);
                }
                elseif ($p->tStatus == 1){
                    array_push($active,$p->id);
                }  elseif ($p->tStatus == 2){
                    array_push($completed,$p->id);
                }           

            }

        // echo "<pre>";
        // print_r($tasks);exit;


        // echo json_encode($active);exit;
        $activeTasks = count($active);
        $completeTasks = count($completed);
        $pendingTasks = count($pending);
        $tasks = count($t1);
        
        $employee = Employee::where('deleted_at',NULL)->count();
        $allClients = Client::where('deleted_at',NULL)->count();
        $projects = Tasklist::where('deleted_at',NULL)->count();
        $allVendors = Vendor::where('deleted_at',NULL)->count();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;

            return view('pages.admin-dashboard', compact('tasks','employee','allClients','projects',
            'allVendors','activeTasks','completeTasks','pendingTasks','user','uname','uimg'));
        }
    }

    public function clients()
    {
        $allClients = Client::where('deleted_at',NULL)->get();
        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;

            return view('pages.clients',compact('allClients','user','uname','uimg'));
        }
    }

    public function vendors()
    {
        $allVendors = Vendor::where('deleted_at',NULL)->get();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;

            return view('pages.vendors',compact('allVendors','user','uname','uimg'));
        }
    }

    public function projects()
    {

        $allClients = Client::where('deleted_at',NULL)->get();
        $projects = Project::where('projects.deleted_at',NULL)
                    ->join('clients','clients.id','projects.client')
                    ->select('clients.*','projects.*','clients.name as cName')
                    ->get();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {
            $uname = $user->name;
            $uimg = $user->photo;

            return view('pages.projects',['allClients'=> $allClients, 'projects'=>$projects,'user'=>$user,'uname'=>$uname,'uimg'=>$uimg]);
        }
    }

    public function tasks()
    {
        $tasklist = TaskList::where('deleted_at',NULL)->orderBy('id','DESC')->get();
        $tasks = Task::where('tasks.deleted_at',NULL)
                ->where('employees.deleted_at',NULL)
                ->join('employees','employees.id','tasks.assignTo')
                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId')
                ->where('tasks.status','!=','2')
                ->orderBy('tasks.id','DESC')->get();
        $allClients = Client::where('deleted_at',NULL)->get();
        $allVendors = Vendor::where('deleted_at',NULL)->get();
        $employee = Employee::where('deleted_at',NULL)->get();
        $projects = Project::where('deleted_at',NULL)->get();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;

            $priority = array
            (
                "Normal","High","Low"
            );

            foreach($tasks as $p)
            {
                $assign = Employee::where('deleted_at',NULL)->where('id', $p->assignTo)->first();
                $p->assignTo = $assign->name;

            } 
            // echo json_encode($tasks);exit;
            return view('pages.task-board',compact('tasks','tasklist','allClients','allVendors','employee','projects','priority','user','uname','uimg'));
        }
    }

    public function employees()
    {
        $employee = Employee::where('deleted_at',NULL)->get();

        $email = Session::get('user');
        $user = Loginuser::where('email',$email)->first();

        if ($user == '')
        {
            return redirect('/');
        }else {

            $uname = $user->name;
            $uimg = $user->photo;
            
            return view('pages.employee',compact('employee','user','uname','uimg'));
        }
    }

    public function applyFilter()
    {
        $emp = $_POST['employee'];
        $status = $_POST['status'];
        $fromDate = date("Y-m-d", strtotime($_POST['fromDate']));
        $toDate = date("Y-m-d", strtotime($_POST['toDate']));

        if ($emp != '' )
        {
            if ($status != '')
            {
                if ($fromDate != '1970-01-01')
                {
                    if ($toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.status',$status)
                                ->where('tasks.created_at', '>', ["$fromDate 00:00:00"])
                                ->where('tasks.created_at', '<', ["$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->orderBy('tasks.id','DESC')->get();
                    }
                    else {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.status',$status)
                                ->where('tasks.created_at', '>', ["$fromDate 00:00:00"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
                else {
                    if ($toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.status',$status)
                                ->where('tasks.created_at', '<', ["$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.status',$status)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
            }
            else {
                if ($fromDate != '1970-01-01')
                {
                    if ($toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->whereBetween('tasks.created_at',  ["$fromDate 00:00:00", "$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.created_at', '>', ["$fromDate 00:00:00"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
                else {
                    if ($toDate != '1970-01-01')
                    {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.assignTo',$emp)
                                ->where('tasks.created_at', '<', ["$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->where('assignTo',$emp)
                                ->get();
                    }
                }
            }
        }
        else {

            if ($status != '')
            {
                if ($fromDate != '1970-01-01')
                {
                    if ($toDate != '1970-01-01')
                    {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.status',$status)
                                ->whereBetween('tasks.created_at',  ["$fromDate 00:00:00", "$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {
                        
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.status',$status)
                                ->where('tasks.created_at', '>', ["$fromDate 00:00:00"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
                else {
                    if ($toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.status',$status)
                                ->where('tasks.created_at', '<', ["$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.status',$status)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
            }
            else {
                if ($fromDate != '1970-01-01')
                {
                    if ( $toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->whereBetween('created_at',  ["$fromDate 00:00:00", "$toDate 23:59:59"])
                                ->get();
                    }
                    else {

                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->where('created_at', '>', ["$fromDate 00:00:00"])
                                ->get();
                    }
                }
                else {
                    if ($toDate != '1970-01-01')
                    {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->where('tasks.created_at', '<', ["$toDate 23:59:59"])
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                    else {
                        $task = Task::where('tasks.deleted_at',NULL)
                                ->where('employees.deleted_at',NULL)
                                ->join('employees','employees.id','tasks.assignTo')
                                ->select('tasks.*','employees.*','tasks.name as tName','tasks.id as tId','tasks.status as tStatus')
                                ->get();
                    }
                }
            }
        }

        foreach($task as $p)
        {
            $employees  =  Employee::where('deleted_at',NULL)->where('id', $p->assignTo)->select('name')->get();
            $arrName = array();
            foreach($employees as $employees)
            {
                array_push($arrName, $employees->name);
            }
            $p->eName = implode(" , ",$arrName);

            $t = date("d-m-Y");
            $today = strtotime($t);

            $old = $p->dueDate;
            $str = str_replace("/", "-", $old);
            $due = strtotime($str);

            if ($today > $due)
            {
                $p->tStatus = 3;
            }                

        }

        // echo json_encode($task);exit;

        $data = "<table class='table table-striped custom-table mb-0 datatable'>";
        $data .= "<thead>";
        $data .= "<tr>";
        $data .= "<th>#</th>";
        $data .= "<th>Task Name</th>";
        $data .= "<th>Status</th>";
        $data .= "<th>Assigned To</th>";
        $data .= "</tr>";
        $data .= "</thead>";
        $data .= "<tbody>";
        foreach($task as $task)
        {
            
            $data .= "<tr>";
            $data .= "<td>$task->tId</td>";
            $data .= "<td>$task->tName</td>";
            $data .= "<td>";
            $data .= "<div class='dropdown action-label'>";
            $data .= "<span class='btn btn-white btn-sm btn-rounded' style='cursor: inherit !important;'>";
            if ($task->tStatus == 1)
            {
                $data .=  "<i class='fa fa-dot-circle-o text-warning'></i> Active";
            }else if ($task->tStatus == 2)
            {
                $data .= "<i class='fa fa-dot-circle-o text-success'></i> Completed";
            } else if ($task->tStatus == 3)
            {
                $data .= "<i class='fa fa-dot-circle-o text-danger'></i> Pending";
            }
            $data .= "</span>";
            $data .= "</div>";
            $data .= "</td>";
            $data .= "<td>$task->eName</td>";
            $data .= "</tr>";
        }
        $data .= "</tbody>";
        $data .= "</table>";

        return $data;

    }

}
