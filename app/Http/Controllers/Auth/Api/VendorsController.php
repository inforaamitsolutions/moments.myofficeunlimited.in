<?php

namespace App\Http\Controllers\auth\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Vendor;
use App\Models\Loginuser;
use App\Http\Requests\VendorsAddRequest;
use Illuminate\Support\Facades\Validator;


class VendorsController extends Controller
{
    public function vendorsList(Request $request): JsonResponse
    {
        $result['allVendors'] = Vendor::where('deleted_at', NULL)->get();
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

    public function addVendor(VendorsAddRequest $request): JsonResponse
    {
        $request_data = $request->validated();
        if($request_data['id'] == ''){
            if ($last = Vendor::create($request_data)) {
                $lastId = $last->id;
                // $allvendors = vendors::where('deleted_at', NULL)->get();
    
                if ($request->file('photo') != null) {
                    $path = 'vendors/';
                    $photo_name = $request->file('photo')->getClientOriginalName();
    
                    $file_name =  date('dmY') . $photo_name;
                    
                    $request->file('photo')->move(public_path($path), $file_name);    
                    
                    $imgParr["photo"] = 'public/vendors/' . date('dmY') . $photo_name;
                    
                    Vendor::where('id', $lastId)->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Vendors Add successfully.',
                ], 200);
            }
        }else{
            // unset($data['editId']);
            // unset($data['_token']);
            if(Vendor::where('id',$request_data['id'])->update($request_data))
            {
                // $allvendors = vendors::where('deleted_at',NULL)->get();
                if ($request->file('photo') != null) {
                    $path = 'endors/';
                    $photo_name = $request->file('photo')->getClientOriginalName();
    
                    $file_name =  date('dmY') . $photo_name;
                    $request->file('photo')->move(public_path($path), $file_name);
                        
                    $imgParr["photo"] = 'public/vendors/' . date('dmY') . $photo_name;
                    Vendor::where('id', $request_data['id'])->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Vendors Update successfully.',
                ], 200);
            }
            
        }
        
    }

    public function editVendor($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];
        
        $validation  = Validator::make($request_data, [
            'id' => 'exists:vendors,id',    
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = Vendor::where('id',$id)->first();
        return response()->json([
            'success'   => true,
            'data' => $result,
            'message'   => 'Vendors Get successfully.',
        ], 200);
    }

    public function deleteVendor($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];
        
        $validation  = Validator::make($request_data, [
            'id' => 'exists:vendors,id',    
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
        if(Vendor::where('id',$id)->update($result))
        {
            return response()->json([
                'success'   => true,
                'data' => $result,
                'message'   => 'Vendors Delete successfully.',
            ], 200);
        }
    }
}
