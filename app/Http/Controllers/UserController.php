<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){
        $user = new User();
        $user->username=$request->username;
        $user->password=Hash::make($request->password);
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        $user->address=$request->address;
        $user->birthDate=$request->birthDate;
        $user->idCard=$request->idCard;
        $user->email=$request->email;

        $save = $user->save();

        if($save){
            return redirect()->back()->with('success','you are now registered successfully');
        }else{
            return redirect()->back()->with('fail','registration failed');
        }
    }

    public function check(Request $request){
        $request->validate([
            'username'=>'required|exists:users,username',
            'password'=>'required|min:6'
        ]);
        $creds = $request->only('username','password');

        if(Auth::guard('web')->attempt($creds)){
            return redirect()->route('user.home');
        }else{
            return redirect()->route('user.login')->with('fail','incorrect creds');
        }
    }
    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
