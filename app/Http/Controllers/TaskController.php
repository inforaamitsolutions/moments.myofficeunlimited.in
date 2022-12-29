<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use App\Models\Task;

class TaskController extends Controller
{
    public function tasklistAdd(Request $request)
    {
        $id = $_POST['editId'];
        $data = $_POST;

        if ($id == '')
        {
            if($last = TaskList::create($data))
            {
                return redirect('/tasks');
            }
        }
        else
        {
            unset($data['editId']);
            unset($data['_token']);
            

            if(TaskList::where('id',$id)->update($data))
            {                
                return redirect('/tasks');
            }
        }

    }

    public function editTasklist($id)
    {
        $data = TaskList::where('id',$id)->first();
        return $data;
    }

    public function deleteTasklist($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(TaskList::where('id',$id)->update($data))
        {
            echo "done";
        }
    }

    public function taskAdd(Request $request)
    {
        $id = $_POST['editIdTask'];
        $data = $_POST;

        // $data['assignTo'] = implode(",",$data['assignTo']);
        $data['status'] = '1';
        if (isset($data['descDiv']))
        {
            $data['desc'] = $data['descDiv'];
        }
        

        // echo "<pre>";
        // print_r($_POST);exit;
        
        if ($id == '')
        {
            if($last = Task::create($data))
            {
                $lastId = $last->id;

                if($request->file('photo')!=null)
                {
                    $path = 'public/tasks/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Task::where('id',$lastId)->update($imgParr);
                }

                return redirect('/tasks');
            }
        }
        else
        {
            unset($data['editIdTask']);
            unset($data['_token']);
            

            if(Task::where('id',$id)->update($data))
            {
                if($request->file('photo')!=null)
                {
                    $path = 'public/tasks/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Task::where('id',$id)->update($imgParr);
                }
                
                return redirect('/tasks');
            }
        }

    }

    public function editTask($id)
    {
        $data = Task::where('id',$id)->first();
        return $data;
    }

    public function deleteTask($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Task::where('id',$id)->update($data))
        {
            echo "done";
        }
    }
}
