<?php

namespace App\Http\Controllers\Garagist;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Garage;
use App\Models\Garagist;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GaragistController extends Controller
{
  function check(Request $request)
  {
    //validation
    $request->validate(
      [
        'username' => 'required|exists:garagemanagers,username',
        'password' => 'required'
      ],
      [
        'username.exists' => 'This username does not exist.'
      ]
    );
    $creds = $request->only('username', 'password');

    if (Auth::guard('garagist')->attempt($creds)) {
      return redirect()->route('garagist.home');
    } else {
      return redirect()->route('workerLogin')->with('fail', 'The credentials you entered are wrong');
    }
  }
  public function logout()
  {
    session()->flush();
    Auth::guard('garagist')->logout();
    return redirect()->route('workerLogin');
  }

  public function showProfile()
  {
    return view('garagists.editProfile');
  }
  public function editProfile(Request $request)
  {

    $request->validate(
      [
        ($request->username == Auth::user()->username) ?: 'username' => 'unique:garagemanagers,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        ($request->email == Auth::user()->email) ?: 'email' => 'email|unique:users,email|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        ($request->newPassword == '') ?: 'newPassword' => 'min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'same:newPassword',
        'currentPassword' => 'required|current_password:garagist'
      ],
      [
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'newPassword.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );


    $garagist = Garagist::where('username', Auth::user()->username)->first();
    $garagist->username = $request->username;
    $garagist->firstName = $request->firstName;
    $garagist->lastName = $request->lastName;
    $garagist->birthDate = $request->birthDate;
    $garagist->address = $request->address;
    $garagist->email = $request->email;
    if ($request->newPassword != '') {
      $garagist->password = Hash::make($request->newPassword);
    }
    if ($request->phone != '') {
      $garagist->phoneNumber = $request->phone;
    }
    $garagist->save();

    return redirect()->route('garagist.editProfile')->with('message', 'Settings updated successfully');
  }
  public function home()
  {
    $hasGarage = Garage::join('garagemanagers', 'garageManagerUsername', '=', 'garagemanagers.username')->where('username', Auth::user()->username)->count();
    if ($hasGarage == 0) {
      return view('garagists.garagistHome');
    } else {
      return redirect()->route('garagist.getReservations');
    }
  }


  public function showVehicles()
  {
    $hasGarage = Garage::join('garagemanagers', 'garageManagerUsername', '=', 'garagemanagers.username')->where('username', Auth::user()->username)->get();
    if (count($hasGarage) == 0) {
      return redirect()->route('garagist.home');
    }
    $vehicles = Vehicule::where('garageID', $hasGarage[0]->garageID)->get();
    return view('garagists.vehicles', ['vehicles' => $vehicles]);
  }

  public function manageVehicle($id)
  {
    $vehicle = Vehicule::find($id);
    $bookings = Booking::where('vehiculePlateNb', $id)->join('users', 'bookings.clientUsername', '=', 'users.username')->get();
    return view('garagists.manageVehicle', ['vehicule' => $vehicle, 'bookings' => $bookings]);
  }
  public function setCondition(Request $request, $id)
  {
    $hasGarage = Garage::join('garagemanagers', 'garageManagerUsername', '=', 'garagemanagers.username')->where('username', Auth::user()->username)->get();

    $vehicule = Vehicule::find($id);

    if ($vehicule->garageID != $hasGarage[0]->garageID) {
      return redirect()->route('garagist.home');
    }
    $request->validate([
      'condition' => 'required',
      'note' => 'required|regex:/^[a-z\d\-_\s\,.]+$/i|min:10',
    ]);
    $vehicule->update([
      'physicalState' => $request->condition,
      'note' => $request->note
    ]);

    return redirect()->route('garagist.manageVehicle', $id)->with('message', 'Vehicle condition updated successfully!');
  }


  public function getReservations()
  {
    $hasGarage = Garage::join('garagemanagers', 'garageManagerUsername', '=', 'garagemanagers.username')->where('username', Auth::user()->username)->get();
    if (count($hasGarage) == 0) {
      return redirect()->route('garagist.home');
    }
    $bookings = Booking::join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')->join('users', 'bookings.clientUsername', '=', 'users.username')->join('pickuplocations', 'bookings.dropOffLocation', '=', 'pickuplocations.id')->where('bookings.state', 'ON GOING')->where('garageID', $hasGarage[0]->garageID)->latest('bookings.created_at')->paginate(25);
    $pickUpLocations = Booking::join('pickuplocations', 'bookings.pickUpLocation', '=', 'pickuplocations.id')->join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')->where('garageID', $hasGarage[0]->garageID)->latest('bookings.created_at')->paginate(25);
    return view('garagists.ongoingBookings', compact('bookings', 'pickUpLocations'));
  }
  public function storeImage($image, $path, $nameWithExtension)
  {
    $expiresAt = new \DateTime('01/01/2100');
    $uploadedfile = fopen($image, 'r');
    app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => "$path$nameWithExtension"]);
    // "Testing/other_image.png
    $url = app('firebase.storage')->getBucket()->object("$path$nameWithExtension")->signedUrl($expiresAt);
    return $url;
  }
  public function changeImage(Request $request)
  {
    $image_parts = explode(";base64,", $request->image);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file =  uniqid() . '.' . $image_type;

    $url = Self::storeImage($request->image, "Images/garagist/profile/", $file);
    Garagist::where('username', Auth::user()->username)->first()->update(['profilePath' => $url]);
    return response()->json(['success' => 'success']);
  }
  public function validateReturn(Request $request)
  {
    Booking::find($request->bookingID)->update(['state' => 'FINISHED']);
    return redirect()->route('garagist.getReservations')->with('message', 'Vehicule return successfully validated!');
  }
}
