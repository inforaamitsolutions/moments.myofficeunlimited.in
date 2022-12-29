<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientsController extends Controller
{
    public function clientsAdd(Request $request)
    {
        $id = $_POST['editId'];
        $data = $_POST;

        if ($id == '')
        {
            if($last = Client::create($data))
            {
                $lastId = $last->id;
                $allClients = Client::where('deleted_at',NULL)->get();

                if($request->file('photo')!=null)
                {
                    $path = 'public/clients/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Client::where('id',$lastId)->update($imgParr);
                }

                return redirect('/clientsList')->with('allClients',$allClients);
            }
        }
        else
        {
            unset($data['editId']);
            unset($data['_token']);
            

            if(Client::where('id',$id)->update($data))
            {
                $allClients = Client::where('deleted_at',NULL)->get();

                if($request->file('photo')!=null)
                {
                    $path = 'public/clients/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Client::where('id',$id)->update($imgParr);
                }
                
                return redirect('/clientsList')->with('allClients', $allClients);
            }
        }

    }

    public function editClient($id)
    {
        $data = Client::where('id',$id)->first();
        return $data;
    }

    public function deleteClient($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Client::where('id',$id)->update($data))
        {
            echo "done";
        }
    }

    public function checkClient($name)
    {
        $company = Client::where('deleted_at',NULL)->where('companyName', $name)->get();

        // echo json_encode($company);exit;
        if(count($company) > 0)
        {
            echo "1";
        }else {
            echo "0";
        }

    }
}
