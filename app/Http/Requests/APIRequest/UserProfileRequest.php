<?php

namespace App\Http\Requests\APIRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserProfileRequest extends FormRequest
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
            // 'phone' => 'required|numeric|digits:12|unique:users,phone,'.$this->id,
            'address' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'city' => 'required',
        ];

        if($this->address_same_as_company == 0){
            $rules += [
                'shipping_address' => 'required',
                'shipping_pincode' => 'required',
                'shipping_state' => 'required',
                'shipping_city' => 'required',
            ];
        }

        return $rules;
    }

    // Get the error messages for the defined validation rules.
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
        [
            'errors' => $validator->errors(),
            'status' => false
        ], 422));
    }
}
