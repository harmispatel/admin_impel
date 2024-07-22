<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'image' => 'mimes:jpeg,png,jpg, svg, gif',
        ];

        if($this->id)
        {
            $rules += [
                'email' => 'required|email|unique:users,email,'.decrypt($this->id),
                'confirm_password' =>'same:password',
            ];

            if(decrypt($this->id) != 1){
                $rules += [
                    'role' => 'required',
                ];
            }

        }else{
            $rules += [
                'email' =>   'required|email|unique:users,email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
                'role' => 'required',
            ];
        }

        return $rules;
    }
}
