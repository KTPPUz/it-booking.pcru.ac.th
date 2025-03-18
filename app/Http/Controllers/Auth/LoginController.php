<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            session()->flash('success', 'Welcome back, ' . Auth::guard('web')->user()->name . '!');
            return redirect()->route('welcome'); 
        }
        
        if (Auth::guard('staff')->attempt($request->only('email', 'password'))) {
            session()->flash('success', 'Welcome back, ' . Auth::guard('staff')->user()->name . '!');
            return redirect()->route('staff.homestaff'); 
        }

        session()->flash('error', 'Invalid credentials. Please try again.');
        return redirect()->back();
    }


    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
      
        
        return redirect()->route('welcome')->with('success', 'You have been logged out.');
    }

    public function staffLogout(Request $request)
    {
        if (Auth::guard('staff')->check()) {
            Auth::guard('staff')->logout(); 

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('welcome')->with('success', 'You have been logged out.');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    public function redirectToKeycloak()
    {
        
        return Socialite::driver('keycloak')->redirect();
        
    }

    public function handleKeycloakCallback()
    {
        
        $user = Socialite::driver('keycloak')->user();

        $existingUser = User::where('email', $user->email)->first();

        return redirect()->intended('welcome');
        

    }
}