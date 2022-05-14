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
        if($request->phone==''){
            
        }
        $request->validate([
            'username'=>'required|unique:users,username|min:4|alpha_num|max:15',
            'lastName'=>'required|alpha|max:25',
            'firstName'=>'required|alpha|max:25',
            'birthDate'=>'required|date',
            'address'=>'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
            'email'=>'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',    
            ($request->phone=='') ?  :'phone'=>['digits:10','regex:/(05|06|07)[0-9]{8}/'],
            'password'=>'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'passwordConfirm'=>'required|same:password',
            'idCard'=>'required|digits_between:18,18|numeric',
            'idCardImage'=>'required|mimes:jpg,jpeg,png|max:5048',
            
        ],
        [
            'idCard.required'=>'The identity card number is required.',
            'idCard.digits_between'=>'The identity card number has to be 18 number long.',
            'address.regex'=>'The address can only contain letters, numbers and spaces.',
            'password.regex'=>'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
            'idCardImage.required'=>'The identity card image is required.',
            'phone.digits_between'=>'The number must be made of 10 digits',
        ]);

        $newImageName =$request->username.'.'.$request->idCardImage->extension();
        $request->idCardImage->move(public_path('images/owners/idCardImages'),$newImageName);

    

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
        $owner->idCardPath=$newImageName;
       
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
        return redirect()->route('workerLogin');
    }
}

    


