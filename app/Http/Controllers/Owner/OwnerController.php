<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
 
    public function create(Request $request){
        $owner = new Owner();
        $owner->username=$request->username;
        $owner->password=Hash::make($request->password);
        $owner->firstName=$request->firstName;
        $owner->lastName=$request->lastName;
        $owner->address=$request->address;
        $owner->birthDate=$request->birthDate;
        $owner->idCard=$request->idCard;
        $owner->email=$request->email;
        $owner->phoneNumber=$request->phoneNumber;
        $save = $owner->save();

        if($save){
            return redirect()->back()->with('success','you are now registered successfully');
        }else{
            return redirect()->back()->with('fail','registration failed');
        }
    }

    public function check(Request $request){
        $request->validate([
            'username'=>'required|exists:owners,username',
            'password'=>'required|min:6'
        ]);
        $creds = $request->only('username','password');

        if(Auth::guard('owner')->attempt($creds)){
            return redirect()->route('owner.home');
        }else{
            return redirect()->route('owner.login')->with('fail','incorrect creds');
        }
    }
    public function logout(){
        Auth::guard('owner')->logout();
        return redirect()->route('owner.login');
    }
}

    


