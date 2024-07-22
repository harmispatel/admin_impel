<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'gst_no' => 'nullable|min:15',
            'pan_no' => 'nullable|min:10',
            'profile_picture' => 'mimes:png,jpg,svg,gif'
        ];

        if($this->customer_id) {
            $rules += [
                'email' => 'required|email|unique:users,email,'.decrypt($this->customer_id),
                'phone' => 'required|unique:users,phone,'.decrypt($this->customer_id),
            ];
        }else{
            $rules += [
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
            ];
        }
        return $rules;
    }
}
