<?php

namespace App\Http\Controllers\auth\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\client;
use App\Models\Loginuser;
use App\Http\Requests\ClientsAddRequest;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    public function clientsList(Request $request): JsonResponse
    {
        $result['allClients'] = Client::where('deleted_at', NULL)->get();
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

    public function addClient(ClientsAddRequest $request): JsonResponse
    {
        $request_data = $request->validated();

        if ($request_data['id'] == '') {
            if ($last = Client::create($request_data)) {
                $lastId = $last->id;
                // $allClients = Client::where('deleted_at', NULL)->get();

                if ($request->file('photo') != null) {
                    $path = 'clients/';
                    $photo_name = $request->file('photo')->getClientOriginalName();

                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('photo')->move(public_path($path), $file_name);

                    $imgParr["photo"] = 'public/clients/' . date('dmY') . $photo_name;
                    Client::where('id', $lastId)->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Clients Add successfully.',
                ], 200);
            }
        } else {
            // unset($data['editId']);
            // unset($data['_token']);
            if (Client::where('id', $request_data['id'])->update($request_data)) {
                // $allClients = Client::where('deleted_at',NULL)->get();
                if ($request->file('photo') != null) {
                    $path = 'clients/';
                    $photo_name = $request->file('photo')->getClientOriginalName();

                    $file_name = $path . date('dmY') . $photo_name;
                    $request->file('photo')->move(public_path($path), $file_name);

                    $imgParr["photo"] = 'public/clients/' . date('dmY') . $photo_name;
                    Client::where('id', $request_data['id'])->update($imgParr);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'Clients Update successfully.',
                ], 200);
            }
        }
    }
    public function editClient($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:clients,id',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'error'      => $validation->errors()
            ], 422);
        }
        $result = Client::where('id', $id)->first();
        return response()->json([
            'success'   => true,
            'data' => $result,
            'message'   => 'Clients Get successfully.',
        ], 200);
    }

    public function deleteClient($id): JsonResponse
    {
        $request_data = [
            'id' => $id
        ];

        $validation  = Validator::make($request_data, [
            'id' => 'exists:clients,id',
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
        if (Client::where('id', $id)->update($result)) {
            return response()->json([
                'success'   => true,
                'data' => $result,
                'message'   => 'Clients Delete successfully.',
            ], 200);
        }
    }
}
