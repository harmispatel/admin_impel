<?php

namespace App\Http\Requests\APIRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WomansClubsRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email',
            'mobile' => 'required',
            'city' => 'required',
            'how_you_know' => 'required',
            'message' => 'nullable|min:50',
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
