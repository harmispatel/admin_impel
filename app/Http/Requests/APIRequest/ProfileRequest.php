<?php

namespace App\Http\Requests\APIRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
            'comapany_name' => 'required',
            'gst_no' => 'required',
            'confirm_password' => 'same:password',
            'pincode' => 'required',
            // 'document.*' => 'mimes:pdf,png,jpg,jpeg',
        ];
        return $rules;
    }

    // Get the error messages for the defined validation rules.
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
        [
            'errors' => $validator->errors(),
            'status' => true
        ], 422));
    }
}
