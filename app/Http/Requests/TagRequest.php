<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules()
    {
        if($this->id){
            $rules = [
                'name' => 'required|unique:tags,name,'.$this->id,

            ];
        }else{
            $rules = [
                'name' => 'required|unique:tags,name',
            ];
        }
        return $rules;
    }
}
