<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\AgencyRequest;
use App\Models\Branche;
use App\Models\complaint;
use App\Models\Garagist;
use App\Models\Secretary;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class OwnerController extends Controller
{
    public function home(){
        return view('owners.ownerHome',['hasRequest'=>count(AgencyRequest::where('ownerUsername',Auth::user()->username)->get())]);
    }
    public function create(Request $request){
        $request->validate([
            'username'=>'required|unique:owners,username|min:4|alpha_num|max:15',
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
            return redirect()->route('workerLogin')->with('fail','incorrect creds');
        }
    }
    public function logout(){
        Auth::guard('owner')->logout();
        return redirect()->route('workerLogin');
    }

    public function addEmployeePage(){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        return view('owners.addEmployee',['branches'=>Branche::where('agencyID',Auth::user()->agencyID)->get()]);
    }
    public function addEmployee(Request $request){
        //validation
        $request->validate([
            'username'=>'required|unique:secretaries,username|unique:garagemanagers,username|min:4|alpha_num|max:15',
            'lastName'=>'required|alpha|max:25',
            'firstName'=>'required|alpha|max:25',
            'birthDate'=>'required|date',
            'address'=>'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
            'email'=>'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',    
            'password'=>'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'passwordConfirm'=>'required|same:password',
            'branche'=>'required',
        ],
        [
            'address.regex'=>'The address can only contain letters, numbers and spaces.',
            'password.regex'=>'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        ]);
        //-validation

        //creating the employe
        if($request->empType=='G'){
            $garagist = new Garagist();
            $garagist->username=$request->username;
            $garagist->password=Hash::make($request->password);
            $garagist->firstName=$request->firstName;
            $garagist->lastName=$request->lastName;
            $garagist->email=$request->email;
            $garagist->address=$request->address;
            $garagist->birthDate=$request->birthDate;
            $garagist->brancheID=$request->branche;
            $garagist->save();
            return redirect()->route('owner.addEmployee')->with('message','You successfully added a new garage manager!');
        }
        if($request->empType=='S'){
            $secretary = new Secretary();
            $secretary->username=$request->username;
            $secretary->password=Hash::make($request->password);
            $secretary->firstName=$request->firstName;
            $secretary->lastName=$request->lastName;
            $secretary->email=$request->email;
            $secretary->address=$request->address;
            $secretary->birthDate=$request->birthDate;
            $secretary->brancheID=$request->branche;
            $secretary->save();
            return redirect()->route('owner.addEmployee')->with('message','You successfully added a new secretary!');
        }
    }


    public function showProfile(){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        return view('owners.editProfile');
    }


    public function editProfile(Request $request){
        
        $request->validate([
            ($request->username==Auth::user()->username) ? : 'username'=>'unique:owners,username|min:4|alpha_num|max:15',
            'lastName'=>'required|alpha|max:25',
            'firstName'=>'required|alpha|max:25',
            'birthDate'=>'required|date',
            'address'=>'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
            ($request->email==Auth::user()->email) ? : 'email'=>'email|unique:users,email|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
            ($request->phone=='') ?  :'phone'=>['digits:10','regex:/(05|06|07)[0-9]{8}/'],
            ($request->newPassword=='') ?  :'newPassword'=>'min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'passwordConfirm'=>'same:newPassword',
            'idCard'=>'required|digits_between:18,18|numeric',
            'currentPassword' => 'required|current_password:owner'
        ],
        [
            'idCard.required'=>'The identity card number is required.',
            'idCard.digits_between'=>'The identity card number has to be 18 number long.',
            'address.regex'=>'The address can only contain letters, numbers and spaces.',
            'newPassword.regex'=>'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
            'phone.digits_between'=>'The number must be made of 10 digits',
        ]);

        
        $owner = Owner::where('username',Auth::user()->username)->first();
        $owner->username=$request->username;
        $owner->firstName=$request->firstName;
        $owner->lastName=$request->lastName;
        $owner->birthDate=$request->birthDate;
        $owner->address=$request->address;
        $owner->email=$request->email;
        if($request->newPassword!=''){
            $owner->password = Hash::make($request->newPassword);
        }
        $owner->idCard=$request->idCard;
        if($request->phone!=''){
        $owner->phoneNumber=$request->phone;
        }
        $owner->save();

        return redirect()->route('owner.editProfile')->with('message','Settings updated successfully');
    }


    public function showReclamations(){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        $complaints = Complaint::where('recepient',Auth::user()->username)->latest()->paginate(25);;
        return view('owners.reclamation',['list'=>$complaints]);
    }
    public function reclamation($id){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        $complaint = Complaint::where('id',$id)->first();
        $sender = User::where('username',$complaint->sender)->first();
        return view('owners.reclamationDetails',['reclamation'=>$complaint,'sender'=>$sender]);
    }
    public function answerReclamation(Request $request,$id){
        $complaint=Complaint::where('id','=',$id)->first();
        $complaint->response=$request->response;
        $complaint->save();
        return redirect()->route('owner.reclamation',$complaint->id)->with('message','Your response successfully sent to the user');
    }

    public function branches(){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }

        $branches = Branche::where('agencyID',Auth::user()->agencyID)->get();
        
        return view('owners.branchesList',['branches'=>$branches]);
    }
    public function createBranchPage(){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }

        $branches = Branche::where('agencyID',Auth::user()->agencyID)->get();
        return view('owners.addBranch');
    }
    public function createBranch(Request $request){
        $request->validate([
            'region'=>'required|alpha',
            'address'=>'required|regex:/(^[a-zA-Z0-9 ]+$)+/'
        ]);

        $branch = new Branche();
        $branch->agencyID= Auth::user()->agencyID;
        $branch->region=$request->region;
        $branch->address=$request->address;
        $branch->save();

        return redirect()->route('owner.showBranches')->with('message','Branch added successfully!');
    }
    public function showBranch($id){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        $branch = Branche::where('brancheID',$id)->first();

        if($branch->agencyID != Auth::user()->agencyID){
            return redirect()->route('owner.home');
        }
        $secretaries = Secretary::where('brancheID',$id)->latest()->paginate(25);
     
        $garagists = Garagist::where('brancheID',$id)->latest()->paginate(25);
       
        
        return view('owners.brancheDetails',['branch'=>$branch,'secretaries'=>$secretaries,'garagists'=>$garagists]);
    }
    public function deleteBranch($id){
        if(is_null(Auth::user()->agencyID)){
            return redirect()->route('owner.home');
        }
        $branch = Branche::where('brancheID',$id)->first();
        if($branch->agencyID != Auth::user()->agencyID){
            return redirect()->route('owner.home');
        }

        Branche::where('brancheID',$id)->delete();
        return redirect()->route('owner.showBranches')->with('alert','Branch deleted successfully');
    }
}




