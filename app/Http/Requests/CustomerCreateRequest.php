<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation Error(s).',
            'data'      => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname'                 => 'required|string|max:50|min:2',
            'lastname'                  => 'required|string|max:50|min:2',
            'insertion'                 => 'required|string|max:20|min:2',
            'mobile'                    => 'required|string|max:30|min:2',
            'driving_license_category'  => 'required|string|max:4|min:1',
            'drivers_license_number'    => 'required|string|max:30|min:2',
            'username'                  => 'required|string|unique:customers|max:50|min:2',
            'email'                     => 'required|email|unique:customers',
            'password'                  => 'required|confirmed'
        ];
    }
}
