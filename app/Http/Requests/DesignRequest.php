<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignRequest extends FormRequest
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
            'category_id' => 'required',
            'gender_id' => 'required',
            'metal_id' => 'required',
        ];

        if($this->id){
            $rules += [
                'code'=> 'required|unique:designs,code,'.decrypt($this->id),
            ];
        }else{
            $rules += [
                'code'=> 'required|unique:designs,code',
            ];
        }
        return $rules;
    }
}
