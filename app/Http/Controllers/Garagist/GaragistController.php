<?php

namespace App\Http\Controllers\Garagist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaragistController extends Controller
{
    function check(Request $request) {
        //validation
        $request->validate([
            'username'=>'required|exists:garagemanagers,username',
            'password'=>'required'
        ],[
            'username.exists' => 'This username does not exist.'
        ]
        );
        $creds = $request->only('username','password');

        if(Auth::guard('garagist')->attempt($creds)){
            return redirect()->route('garagist.home');
        }else{
            return redirect()->route('garagist.login')->with('fail','The credentials you entered are wrong');
        }
    }
    public function logout(){
        Auth::guard('garagist')->logout();
        return redirect()->route('workerLogin');
    }
}
