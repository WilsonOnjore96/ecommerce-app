<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //controller endpoints
    //view where password will be updated
    public function showForgetPasswordForm()
    {
        return view("auth.passwords.email");
    }

    public function submitForgetPasswordForm(Request $req)
    {
        $req->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random();
        DB::table('password_resets')->insert([
            'email' => $req->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($req) {
            $message->to($req->email);
            $message->subject('Reset password');
        });

        return back()->with('success', "We have emailed you a password reset link");
    }

    //form to reset the password
    public function showResetPasswordForm($token)
    {
        return view("auth.passwords.reset", ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $req)
    {
        $req->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')->where([
            'email' => $req->email,
            'token' => $req->token
        ])->first();

        if(!$updatePassword){
            return back()->withInput()->with('error','Invalid token!');
        }

        //update user where email is equal to the one put in the form
        $user = User::where('email',$req->email)->update(['password'=>Hash::make($req->password)]);

        DB::table('password_resets')->where(['email'=>$req->email])->delete();

        return redirect('/login')->with('success', 'Your password has been changed!');
    }







}
