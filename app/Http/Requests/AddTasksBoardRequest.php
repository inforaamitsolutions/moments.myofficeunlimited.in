<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddTasksBoardRequest extends FormRequest
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
            'color' => [
                'required'
            ],
            'status' => [
                
            ],            
        ];
    }
}
