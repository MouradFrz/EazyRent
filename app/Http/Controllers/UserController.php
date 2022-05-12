<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'username'=>'required|unique:users,username|min:4|alpha_num|max:15',
            'lastName'=>'required|alpha|max:25',
            'firstName'=>'required|alpha|max:25',
            'birthDate'=>'required|date',
            'address'=>'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
            'email'=>'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
            'phone'=>'numeric|digits_between:10,10|regex:/0[0-9]{9}/',
            'password'=>'required|alpha_num|min:6',
            'passwordConfirm'=>'required|same:password',
            'idCard'=>'required|digits_between:18,18|numeric'
        ]);




        $user = new User();
        $user->username=$request->username;
        $user->password=Hash::make($request->password);
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        $user->address=$request->address;
        $user->birthDate=$request->birthDate;
        $user->idCard=$request->idCard;
        $user->email=$request->email;
        $user->phoneNumber=$request->phone;

        $save = $user->save();

        if($save){
            return redirect()->back()->with('success','You are now registered! Log in to your account.');
        }else{
            return redirect()->back()->with('fail','Something went wrong, registration failed');
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
            return redirect()->route('user.login')->with('fail','The credentials you entered are wrong');
        }
    }
    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
}
