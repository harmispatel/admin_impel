<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    //
    public function userlogin(Request $request)
    {

        try {
            $find_user = User::where('email',$request->email)->first();
            if(isset($find_user)){
                if($find_user->status == 1){
                    if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){

                        $user = new CustomerResource(Auth::guard('web')->user());

                        $token =  $user->createToken('MyApp')-> accessToken;

                        $data = ['user' => $user, 'token' => $token];
                        return $this->sendResponse(true, 'User Logged In Successfully...', $data);
                    }
                    else{

                        return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
                    }
                }
                else{
                    return $this->sendApiResponse(false, 0,'You Account has been Blocked!', (object)[]);
                }
            }else{
                return $this->sendApiResponse(false, 0,'Please Enter a Valid Email', (object)[]);
            }

        } catch (\Throwable $th) {
            dd($th);

            return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
        }
    }

    public function login(Request $request)
    {
        try {
            $customer = User::where('phone',$request->phone)->first();

            if (!isset($customer->id) && empty($customer->id)) {
                $new_customer = new User;
                $new_customer->phone = $request->phone;
                $new_customer->user_type = 2;
                $new_customer->status = 1;
                $new_customer->verification = 1;
                $new_customer->save();

                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Customer has been Registerd SuccessFully.',
                        'status' => 1,
                        'user_type' => $new_customer->user_type,
                        'user_id' => $new_customer->id,
                        'verification' => $new_customer->verification,
                        'mobile' => $customer->phone,
                    ], Response::HTTP_OK);
            }else{
                if($customer->status == 1){
                    return response()->json(
                    [
                        'success' => true,
                        'message' => 'Customer has already Registerd.',
                        'status' => 1,
                        'user_type' => $customer->user_type,
                        'user_id' => $customer->id,
                        'verification' => $customer->verification,
                        'mobile' => $customer->phone,
                    ], Response::HTTP_OK);
                }else{
                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Your Account has been Blocked By ADMIN!',
                            'status' => 0,
                            'user_type' => $customer->user_type,
                            'user_id' => $customer->id,
                            'verification' => $customer->verification,
                            'mobile' => $request->phone,
                        ], Response::HTTP_OK);
                }
            }
        } catch (\Throwable $th) {

            return $this->sendApiResponse(false, 0,'Failed to Login!', (object)[]);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $email = (isset($request->email)) ? $request->email : '';
            $reset_url = (isset($request->reset_url)) ? $request->reset_url : '';

            if(empty($email)){
                return $this->sendApiResponse(false, 0,'The email field is Required!', (object)[]);
            }

            if(!empty($reset_url)){

                $dealer = User::where('email', $email)->where('user_type', 1)->first();

                if(isset($dealer->id)){
                    $token = Str::random(20);
                    $reset_url = $reset_url."/".$token;

                    DB::table('password_resets')->insert([
                        'email' => $email,
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]);

                    Mail::send(
                        'auth.admin.dealer_reset_password_mail',
                        ['reset_url' => $reset_url],
                        function ($message) use ($email) {
                            $message->from(env('MAIL_USERNAME'));
                            $message->to($email);
                            $message->subject('Reset Password');
                        }
                    );

                   User::where('email', $email)->update(['remember_token' => $token]);

                   return $this->sendResponse(true, 'We have e-mailed your password reset link!', (object)[]);
                }else{
                    return $this->sendApiResponse(false, 0,'Please Enter Valid Email!', (object)[]);
                }
            }else{
                return $this->sendApiResponse(false, 0,'Oops, Something went wrong!', (object)[]);
            }

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Oops, Something went wrong!', (object)[]);
        }
    }

    public function resetPassword(Request $request){
        try {
            $remember_token = (isset($request->remember_token)) ? $request->remember_token : '';
            $password = (isset($request->password)) ? $request->password : '';
            $confirm_password = (isset($request->confirm_password)) ? $request->confirm_password : '';

            if(empty($remember_token)){
                return $this->sendApiResponse(false, 0,'Invalid Token!', (object)[]);
            }elseif(empty($password)){
                return $this->sendApiResponse(false, 0,'The password field is Required!', (object)[]);
            }elseif(empty($confirm_password)){
                return $this->sendApiResponse(false, 0,'The comfirm password field is Required!', (object)[]);
            }

            if($password == $confirm_password){
                $isValidToken = DB::table('password_resets')->where(['token' => $remember_token])->first();
                if (!$isValidToken) {
                    return $this->sendApiResponse(false, 0,'Invalid Token!', (object)[]);
                }

                // User Update Password
                $user = User::where('remember_token', $remember_token)->first();
                if(isset($user->id)){
                    User::where('remember_token', $remember_token)->update(['password' => bcrypt($password), 'remember_token' => null]);
                    DB::table('password_resets')->where('token',$remember_token)->delete();
                    return $this->sendResponse(true, 'Your Password has been Changed.', (object)[]);
                }else{
                    return $this->sendApiResponse(false, 0,'Invalid Token!', (object)[]);
                }
            }else{
                return $this->sendApiResponse(false, 0,'password & confirm password doesn\'t Match!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Oops, Something went wrong!', (object)[]);
        }
    }
}
