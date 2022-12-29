<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddEmployeeRequest extends FormRequest
{

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $validator->errors()->first(),
            'error'      => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => [
                // 'numeric',
            ],
            'name' => [
                'required'
            ],
            'email' => [
                'email:rfc,dns'
            ],
            'phone' => [
                'numeric',
                'required',
                'digits:10'
            ],
            'photo' => [],
            'designation' => [
                'required'
            ],
            'gender' => [
                'required'
            ],
            'address' => [
                'required',
            ],
            'state' => [
                'required',
            ],
            'country' => [
                'required',
            ],
            'pincode' => [
                'required',
            ],
            'password' => [],
            'confirmPassword' => [],
            'image' => [],
            'status' => []
        ];
    }
}
