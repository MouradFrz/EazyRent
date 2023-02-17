<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginWithGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function callbackFromGoogle(){
        $googleUser = Socialite::driver('google')->user();

        $isUser =  User::where('email',$googleUser->getEmail())->first();


        if(!$isUser){
            return redirect()->route('user.login')->with('message',"You don't have an account");
        }else{
            $saveUser = User::where('email',$googleUser->getEmail())->update(['google_id'=>$googleUser->getId()]);
            Auth::loginUsingId($isUser->id);
            return redirect()->route('user.home');
        }
    }
}
