<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeAddRequest extends FormRequest
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
                // 'required'
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
                'digits:12'
            ],
            'photo' => [
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2048'
            ],
            'designation' => [
                'required'
            ],
            'gender' => ['required','in:Male,Female'],
            'address' => [
                'required'
            ], 
            'state' => [
                'required'
            ],
            'country' => [
                'required'
            ],
            'pincode' => [
                'required',
                // 'size:5',
                'integer'
            ],
            'password' => [
                'required',
                'min:5'
            ],
            'confirmPassword' => [
                'required',
                'min:5',
                'same:password'                
            ],
            'image'=>[

            ],
            'status'=>[

            ],
            
        ];
    }
}
