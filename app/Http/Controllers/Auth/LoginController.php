<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {

        if (Auth::attempt(['email'=>$request->email, 
                           'password'=>$request->password])) {
           
                return redirect()->intended();
                //return redirect(route('account'));
          
        }
        //session()->flash('msg','Incorrect Login Credentials.');
        return redirect()->back()->with('error','Incorrect Login Credentials');
    }

     public function logout()
    {
        if (auth()->logout() ) {
            //$loggedout = 'Logged Out!';
            return redirect(route('login'));
        }

        //Session::flash('flash_msg', 'Can not logout');
        return redirect()->back()->with('error', 'Unable to logout');
    }

}
