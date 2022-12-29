<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function projectAdd(Request $request)
    {
        $id = $_POST['editId'];
        $data = $_POST;

        if ($id == '')
        {
            if($last = Project::create($data))
            {
                $lastId = $last->id;

                if($request->file('photo')!=null)
                {
                    $path = 'public/projects/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Project::where('id',$lastId)->update($imgParr);
                }

                return redirect('/projects');
            }
        }
        else
        {
            unset($data['editId']);
            unset($data['_token']);
            

            if(Project::where('id',$id)->update($data))
            {
                if($request->file('photo')!=null)
                {
                    $path = 'public/projects/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Project::where('id',$id)->update($imgParr);
                }
                
                return redirect('/projects');
            }
        }

    }

    public function editProject($id)
    {
        $data = Project::where('id',$id)->first();
        return $data;
    }

    public function deleteProject($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Project::where('id',$id)->update($data))
        {
            echo "done";
        }
    }
}
