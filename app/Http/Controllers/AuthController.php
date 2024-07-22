<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    // Show Admin Login Form
    public function showAdminLogin()
    {
        return view('auth.admin.login');
    }

    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        $input = $request->except('_token');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt($input)){
            $username = Auth::guard('admin')->user()->firstname." ".Auth::guard('admin')->user()->lastname;
            $status = Auth::guard('admin')->user()->status;
            if($status == 0){
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'Your Account has been Not Activated!');
            }
            return redirect()->route('admin.dashboard')->with('success', 'Welcome '.$username);
        }
        return back()->with('error', 'Please Enter Valid Email & Password!');
    }

    // Show Forget Password Form
    function showForgetPasswordForm()
    {
        return view('auth.admin.forget_password');
    }

    // Send Reset Password Link to specified users Mail
    function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins'
        ]);

        $token = Str::random(10);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

         // Send Mail
         try {
            Mail::send(
                'auth.admin.reset_password_mail',
                ['token' => $token],
                function ($message) use ($request) {
                    $message->from(env('MAIL_USERNAME'));
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );

           Admin::where('email', $request->email)->update(['remember_token' => $token]);
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to send an Email');
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    // Show reset password form.
    function showResetPasswordForm($token)
    {
        $token_exists = DB::table('password_resets')->where('token',$token)->first();
        if(isset($token_exists)){
            return view('auth.admin.reset_password_form', ['token' => $token]);
        }
        return redirect()->route('admin.login')->with('error', 'Token has been Expired!');
    }

    // Change New Password
    function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $updatePassword = DB::table('admins')->where(['remember_token' => $request->token])->first();
        if (!$updatePassword) {
            return back()->with('error', 'Invalid token!');
        }

        // User Update Password
        $admin = Admin::where('remember_token', $request->token)->update(['password' => bcrypt($request->password)]);
        DB::table('password_resets')->where('token',$request->token)->delete();
        return redirect()->route('admin.login')->with('success', 'Your password has been changed!');
    }

}
