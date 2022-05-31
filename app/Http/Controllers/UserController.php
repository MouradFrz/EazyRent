<?php

namespace App\Http\Controllers;

use App\Models\AdminBan;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
  public function create(Request $request)
  {

    if ($request->phone == '') {
    }
    $request->validate(
      [
        'username' => 'required|unique:users,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        'email' => 'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'required|same:password',
        'idCard' => 'required|digits_between:18,18|numeric',
        'idCardImage' => 'required|mimes:jpg,jpeg,png|max:5048',
        'faceIdImage' => 'required|mimes:jpg,jpeg,png|max:5048'
      ],
      [
        'idCard.required' => 'The identity card number is required.',
        'idCard.digits_between' => 'The identity card number has to be 18 number long.',
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'password.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'idCardImage.required' => 'The identity card image is required.',
        'faceIdImage.required' => 'The face image is required for the face recognition when picking a car up.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );

    $newImageName = $request->username . '.' . $request->idCardImage->extension();
    $request->idCardImage->move(public_path('images/users/idCardImages'), $newImageName);

    $faceIdImage = $request->username . '_faceId' . '.' . $request->faceIdImage->extension();
    $request->faceIdImage->move(public_path('images/users/faceIdImages'), $faceIdImage);


    $user = new User();
    $user->username = $request->username;
    $user->password = Hash::make($request->password);
    $user->firstName = $request->firstName;
    $user->lastName = $request->lastName;
    $user->address = $request->address;
    $user->birthDate = $request->birthDate;
    $user->idCard = $request->idCard;
    $user->email = $request->email;
    $user->phoneNumber = $request->phone;
    $user->idCardPath = $newImageName;
    $user->faceIdPath = $faceIdImage;

    $save = $user->save();

    if ($save) {
      return redirect()->back()->with('success', 'You are now registered! Log in to your account.');
    } else {
      return redirect()->back()->with('fail', 'Something went wrong, registration failed');
    }
  }

  public function check(Request $request)
  {
    $request->validate(
      [
        'username' => 'required|exists:users,username',
        'password' => 'required|min:6'
      ],
      [
        'username.exists' => 'Your account doesnt exist. Create an account then login'
      ]
    );
    $creds = $request->only('username', 'password');

    if (Auth::guard('web')->attempt($creds, $request->remember)) {
      $bans=AdminBan::where('bannedUsername',Auth::user()->username)->get();
      if(count($bans)!=0){
        Auth::guard('web')->logout();
        return redirect()->route('user.login')->with('ban','You have been banned from the website.')->with('reason',$bans[0]->reason);
      }
      if(session()->has('vehiculePlateNb')) {
        session()->regenerate();
        return redirect()->route('user.viewOfferDetails', ['plateNb'=>session('vehiculePlateNb')]);
      }
      return redirect()->route('user.home');
    } else {
      return redirect()->route('user.login')->with('fail', 'The credentials you entered are wrong');
    }
  }
  public function logout()
  {
    Auth::guard('web')->logout();
    return redirect()->route('user.login');
  }
  public function getUsersList()
  {
    $users = User::latest()->paginate(25);
    return view('admin.usersList', ['users' => $users]);
  }

  public function getHistory(){
    $bookings = Booking::where('clientUsername',Auth::user()->username)->join('vehicules','bookings.vehiculePlateNb','=','vehicules.plateNb')->get();
    return view('users.history',[
      'bookings'=>$bookings,
    ]);
  }
}
