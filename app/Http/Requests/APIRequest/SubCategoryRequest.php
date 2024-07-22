<?php

namespace App\Http\Requests\APIRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubCategoryRequest extends FormRequest
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
        $rules = 
        [
            'parent_category' => 'required',
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
