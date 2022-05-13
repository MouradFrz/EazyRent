<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function check(Request $request) {
        //validation
        $request->validate([
            'username'=>'required|exists:users,username',
            'password'=>'required'
        ],[
            'username.exists' => 'This username does not exist.'
        ]
        );
        $creds = $request->only('username','password');

        if(Auth::guard('admin')->attempt($creds)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->with('fail','The credentials you entered are wrong');
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
