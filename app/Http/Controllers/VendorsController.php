<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorsController extends Controller
{
    public function vendorsAdd(Request $request)
    {
        $id = $_POST['editId'];
        $data = $_POST;

        if ($id == '')
        {
            if($last = Vendor::create($data))
            {
                $lastId = $last->id;

                if($request->file('photo')!=null)
                {
                    $path = 'public/vendors/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Vendor::where('id',$lastId)->update($imgParr);
                }

                return redirect('/vendorsList');
            }
        }
        else
        {
            unset($data['editId']);
            unset($data['_token']);
            

            if(Vendor::where('id',$id)->update($data))
            {
                if($request->file('photo')!=null)
                {
                    $path = 'public/vendors/';
                    $imgArray = array();
                    foreach($request->file('photo') as $p)
                    {
                        $image_name = $path.date('dmY').$p->getClientOriginalName();
                        $p->move($path,$image_name);
                        array_push($imgArray, $image_name);
                    }
                    
                    $imgParr["photo"] = end($imgArray);
                    Vendor::where('id',$id)->update($imgParr);
                }
                
                return redirect('/vendorsList');
            }
        }

    }

    public function editVendor($id)
    {
        $data = Vendor::where('id',$id)->first();
        return $data;
    }

    public function deleteVendor($id)
    {
        $data = array(
            'deleted_at' => date('Y-m-d H:i:s')
        );
        if(Vendor::where('id',$id)->update($data))
        {
            echo "done";
        }
    }

    public function checkClientName($name)
    {
        $company = Vendor::where('deleted_at',NULL)->where('companyName', $name)->get();

        // echo json_encode($company);exit;
        if(count($company) > 0)
        {
            echo "1";
        }else {
            echo "0";
        }

    }
}
