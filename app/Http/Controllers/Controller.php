<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Request;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexCrop()
    {
      return view('pages.croppie');
    }
   
    public function uploadCropImage(Request $request)
    {
        // $image = $request->image;

        // list($type, $image) = explode(';', $image);
        // list(, $image)      = explode(',', $image);
        // $image = base64_decode($image);
        // $image_name= time().'.png';
        // $path = public_path('upload/'.$image_name);


        // $image_name = $path.date('dmY').$image->getClientOriginalName();
        // $image->move($path,$image_name);

        // file_put_contents($path, $image);

        if($request->file('image')!=null)
        {
            $path = 'public/uploads/';
            $imgArray = array();
            foreach($request->file('image') as $p)
            {
                $image_name = $path.date('dmY').$p->getClientOriginalName();
                $p->move($path,$image_name);
                array_push($imgArray, $image_name);
            }
            
        }

        return response()->json(['status'=>true]);
    }
}
