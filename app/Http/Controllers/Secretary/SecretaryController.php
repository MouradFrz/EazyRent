<?php

namespace App\Http\Controllers\Secretary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretaryController extends Controller
{
    function check(Request $request) {
        //validation
        $request->validate([
            'username'=>'required|exists:secretaries,username',
            'password'=>'required'
        ],[
            'username.exists' => 'This username does not exist.'
        ]
        );
        $creds = $request->only('username','password');

        if(Auth::guard('secretary')->attempt($creds)){
            return redirect()->route('secretary.home');
        }else{
            return redirect()->route('secretary.login')->with('fail','The credentials you entered are wrong');
        }
    }
    public function logout(){
        Auth::guard('secretary')->logout();
        return redirect()->route('workerLogin');
    }
}
