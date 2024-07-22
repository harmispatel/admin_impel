<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class DealerRequest extends FormRequest

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

            'name' => 'required',

            'city' => 'required',

            'state' => 'required',

            // 'gst_no' => 'required',

            'address' => 'required',

            'pincode' => 'required',

            // 'comapany_name' => 'required',

            'discount_value' => 'required',

            'commission_value' => 'required',

            'commission_days' => 'required',

            'company_logo' => 'mimes:png,jpg,gif,svg',

            'profile_picture' => 'mimes:png,jpg,gif,svg',

            'documents.*' => 'mimes:jpg,png,pdf,doc,docx',

        ];



        if($this->id){

            $rules += [

                'email' => 'required|email|unique:users,email,'.decrypt($this->id),

                'phone' => 'required|numeric|digits:10|unique:users,phone,'.decrypt($this->id),

                'confirm_password' => 'same:password',

                'dealer_code' => 'required|unique:users,dealer_code,'.decrypt($this->id),

            ];



        }else{

            $rules += [

                'email' => 'required|email|unique:users,email',

                'phone' => 'required|numeric|digits:10|unique:users,phone',

                'password' =>'required|min:6',

                'confirm_password' => 'required|same:password|min:6',

                'dealer_code' => 'required|unique:users,dealer_code',

            ];

        }

        return $rules;

    }

}

