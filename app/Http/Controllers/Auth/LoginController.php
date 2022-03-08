<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        if( Auth()->user()->role == "admin" ) {
            return route('admin.dashboard');
        } elseif ( Auth()->user()->role == "owner" ) {
            return route('owner.dashboard');
        } elseif ( Auth()->user()->role == "staff" ) {
            return route('staff.dashboard');
        } else{
            return route('login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
         //Error messages
         $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.exists" => "Email doesn't exists",
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 6 characters"
        ];

        // validate the form data
        $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6'
            ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // attempt to log
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password ])) {
                // if successful -> redirect forward

                if (Auth::user()->role == "admin" ){
                    return redirect()->intended(route('admin.dashboard'));
                } elseif (Auth::user()->role == "owner" ){
                    return redirect()->intended(route('owner.dashboard'));
                } elseif (Auth::user()->role == "staff" ){
                    return redirect()->intended(route('staff.dashboard'));
                } elseif (Auth::user()->role == "encoder" ){
                    return redirect()->intended(route('encoder.dashboard'));
                }
            }

            // if unsuccessful -> redirect back
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'message' => 'Wrong password',
            ]);
        }
        // $input = $request->all();
        // $this->validate($request,[
        //     'email' => 'required|email',
        //     'password' => 'required|password'
        // ]);

        // if (Auth()->attempt(array('email'=>$input['email'], 'password'=>$input['password']))){
        //     if (Auth()->user()->role == "admin" ){
        //         return redirect()->route('admin.dashboard');
        //     } elseif (Auth()->user()->role == "owner" ){
        //         return redirect()->route('owner.dashboard');
        //     }
        // }else{

        //     return redirect()->route('login');
        // }
    }
}
