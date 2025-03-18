<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    // public function redirectToKeycloak()
    // {
    //       return Socialite::driver('keycloak')->redirect();
    // }

    // public function handleKeycloakCallback()
    // {
               
    //     // $user = Socialite::driver('keycloak')->user();
        
    //     // dd($user);


    //     // try {
    //     //     $user = Socialite::driver('keycloak')->user();
    //     //     dd($user); // ดูค่าที่ได้รับจาก Keycloak
    //     // } catch (\Exception $e) {
    //     //     dd($e->getMessage());
    //     // }


    //      $user = Socialite::driver('keycloak')->user();
    //     if ($user) {
    //         $q = User::where('user_code', $user->user['preferred_username'])->first();
    //         if ($q) {
    //             Auth::login($q);
    //             return redirect()->route('dashboard');
    //         }
    //         echo 'User not found';
    //         // return redirect()->route('login.keycloak', ['error' => 'User not found']);
    //     }
    //     return redirect()->route('login.keycloak', ['error' => 'User not found']);
        
    // }
}