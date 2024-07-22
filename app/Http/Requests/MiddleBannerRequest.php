<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiddleBannerRequest extends FormRequest
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
            'tag' => 'required',
        ];

        if($this->id){
            $rules += [
                'image' => 'mimes:jpeg,png,jpg,gif,svg',
            ];
        }else{
            $rules += [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ];
        }
        return $rules;
    }
}
