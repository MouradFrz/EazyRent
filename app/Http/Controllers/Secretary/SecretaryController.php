<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Vehicule;
use App\Models\Branche;
use App\Models\Garage;
use App\Http\Controllers\Controller;
use App\Models\AdminBan;
use App\Models\AgencyBan;
use App\Models\Booking;
use App\Models\Secretary;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SecretaryController extends Controller
{
  function check(Request $request)
  {
    //validation
    $request->validate(
      [
        'username' => 'required|exists:secretaries,username',
        'password' => 'required'
      ],
      [
        'username.exists' => 'This username does not exist.'
      ]
    );
    $creds = $request->only('username', 'password');

    if (Auth::guard('secretary')->attempt($creds)) {
      return redirect()->route('secretary.home');
    } else {
      return redirect()->route('workerLogin')->with('fail', 'The credentials you entered are wrong');
    }
  }
  public function logout()
  {
    session()->flush();
    Auth::guard('secretary')->logout();
    return redirect()->route('workerLogin');
  }
  public function storeFile($image, $path, $nameWithExtension)
  {
    $expiresAt = new \DateTime('01/01/2100');
    $uploadedfile = fopen($image, 'r');
    app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => "$path$nameWithExtension"]);
    // "Testing/other_image.png
    $url = app('firebase.storage')->getBucket()->object("$path$nameWithExtension")->signedUrl($expiresAt);
    return $url;
  }
  function addVehicule(Request $request)
  {

    $request->validate(
      [
        'plateNb' => 'required|unique:vehicules,plateNb|digits:10',
        'color' => 'required',
        'horsePower' => 'required|integer|between:70,1500',
        'pricePerHour' => 'required',
        'pricePerDay' => 'required',
        'imagePath' => 'required|mimes:jpg,jpeg,png|max:5048',
        'category' => 'required',
        'type' => 'required',
        'brand' => 'required',
        'fuel' => 'required',
        'gearType' => 'required',
        'doorsNb' => 'required',
        'garageID' => 'required',
        'model' => 'required',
        'physicalState' => 'required',

      ],
      [
        'plateNb.required' => 'Plate number is required',
        'plateNb.unique' => 'This car already exists',
        'plateNb.digits' => 'The plate number must be made of 10 digits',
        'color.required' => 'Color is required',
        'horsePower.required' => 'Horse power is required',
        'horsePower.required' => 'Horse power is invalid ',
        'imagePath,required' => 'Car image is required',
        'pricePerHour.required' => 'this field is required',
        'pricePerDay.required' => 'this field is required',
        'category.required' => 'this field is required',
        'type.required' => 'this field is required',
        'brand.required' => 'this field is required',
        'model.required' => 'this field is required',
        'fuel.required' => 'this field is required',
        'gearType.required' => 'this field is required',
        'doorsNb.required' => 'this field is required',
        'garageID.required' => 'Garage is required',
        'physicalState.required' => 'Garage is required',
      ]
    );

    //vehiculeeeee
    $newCarName = $request->plateNb . '.' . $request->imagePath->extension();
    // $request->imagePath->move(public_path('images/vehicules/imagePaths'), $newCarName);
    $url = Self::storeFile($request->imagePath,"Images/vehicules/imagePaths/",$newCarName);
    $vehicule = new Vehicule();
    $vehicule->plateNb = $request->plateNb;
    $vehicule->brand = $request->brand;
    $vehicule->model = $request->model;
    $vehicule->type = $request->type;
    $vehicule->color = $request->color;
    $vehicule->year = $request->year;
    $vehicule->fuel = $request->fuel;
    $vehicule->gearType = $request->gearType;
    $vehicule->doorsNb = $request->doorsNb;
    $vehicule->horsePower = $request->horsePower;
    $vehicule->airCooling = $request->airCooling;
    $vehicule->physicalState = $request->physicalState;
    $vehicule->rating = $request->rating;
    $vehicule->category = $request->category;
    $vehicule->pricePerHour = sprintf('%.2f', $request->pricePerHour);
    $vehicule->pricePerDay = sprintf('%.2f', $request->pricePerDay);
    $vehicule->garageID = $request->garageID;
    $vehicule->imagePath = $url;
    $vehicule->addedBy = Auth::user()->username;
    $vehicule->save();
    $garages = Garage::select('garageID')->where('garages.brancheID', Auth::user()->brancheID)->get();
    return redirect()->route('secretary.addVehicule')->with('message', 'Vehicule added successfully')->with(['garages' => $garages]);
  }
  public function showVehicules()
  {
    $bookings = Booking::orderBy('created_at', 'DESC')->get();
    $vehicules = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')->where('brancheID', Auth::user()->brancheID)->get();
    return view('secretaries.secretaryVehicules', ['vehicules' => $vehicules, 'bookings' => $bookings]);
  }

  public function vehiculeDetails($id)
  {
    $vehicule = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')->join('branches', 'garages.brancheID', '=', 'branches.brancheID')->where('plateNb', $id)->first();
    if ($vehicule->brancheID != Auth::user()->brancheID) {
      return redirect()->route('secretary.home');
    }
    $garages = Garage::where('brancheID', $vehicule->brancheID)->get();
    $latestBooking = Booking::where('vehiculePlateNB', $id)->orderBy('created_at', 'DESC')->first();
    return view('secretaries.vehiculeDetails', ['vehicule' => $vehicule, 'garages' => $garages, 'latestBooking' => $latestBooking]);
  }
  public function deleteVehicule($id)
  {
    $blob = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')->join('branches', 'garages.brancheID', '=', 'branches.brancheID')->where('plateNb', $id)->first();
    if ($blob->brancheID != Auth::user()->brancheID) {
      return redirect()->route('secretary.home');
    }

    Vehicule::where('plateNb', $id)->delete();
    return redirect()->route('secretary.showVehicules')->with('alert', 'Vehicle deleted successfully');
  }
  public function updateState($id)
  {


    $vehicule = Vehicule::where('plateNb', $id)->first();
    if ($vehicule->availability == 0) {

      $vehicule->update(['availability' => 1]);
    } else {
      $vehicule->update(['availability' => 0]);
    }
    return redirect()->back()->with('alert', 'Vehicle state was updated successfully');
  }
  public function transferVehicle(Request $request, $id)
  {
    Vehicule::find($id)->update(["garageID" => $request->garageID]);

    // dd(Vehicule::find($id));
    return redirect()->route('secretary.vehiculeDetails', $id)->with("message", "Vehicle succesfully transfered!");
  }





  public function getReservationRequests()
  {

    $bookings = Booking::join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')->join('garages', 'vehicules.garageID', '=', 'garages.garageID')->join('users', 'clientUsername', '=', 'users.username')->where('garages.brancheID', Auth::user()->brancheID)->where('state', 'REQUESTED')->latest('bookings.created_at')->paginate(25);
    $fails = Booking::join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')->join('garages', 'vehicules.garageID', '=', 'garages.garageID')->join('users', 'clientUsername', '=', 'users.username')->where('state', 'FAILED')->where('failedSeen', false)->where('secretaryUsername', Auth::user()->username)->get();
    return view('secretaries.reservationRequests', ['bookings' => $bookings, 'fails' => $fails]);
  }
  public function reservationDetails($id)
  {
    $test = Booking::where('bookingID', $id)->first();
    if ($test->secretaryUsername != Auth::user()->username && $test->secretaryUsername != null) {
      return redirect()->route('secretary.home');
    }
    $booking = Booking::join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')->join('users', 'clientUsername', '=', 'users.username')->where('bookingID', $id)->join('garages', 'vehicules.garageID', '=', 'garages.garageID')->first();

    $origin = new DateTime($booking->pickUpDate);
    $target = new DateTime($booking->dropOffDate);
    $interval = $origin->diff($target);
    $str = $interval->format('%a days and %h hours');
    return view('secretaries.reservationDetails', ['booking' => $booking, 'interval' => $str]);
  }
  public function addVehiculePage()
  {
    $garages = Garage::select(['garageID', 'address'])->where('garages.brancheID', Auth::user()->brancheID)->get();
    return view('secretaries.addVehicule', ['garages' => $garages]);
  }




  public function showProfile()
  {
    return view('secretaries.editProfile');
  }


  public function editProfile(Request $request)
  {

    $request->validate(
      [
        ($request->username == Auth::user()->username) ?: 'username' => 'unique:secretaries,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        ($request->email == Auth::user()->email) ?: 'email' => 'email|unique:users,email|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        ($request->newPassword == '') ?: 'newPassword' => 'min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'same:newPassword',
        'currentPassword' => 'required|current_password:secretary'
      ],
      [
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'newPassword.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );


    $secretary = Secretary::where('username', Auth::user()->username)->first();
    $secretary->username = $request->username;
    $secretary->firstName = $request->firstName;
    $secretary->lastName = $request->lastName;
    $secretary->birthDate = $request->birthDate;
    $secretary->address = $request->address;
    $secretary->email = $request->email;
    if ($request->newPassword != '') {
      $secretary->password = Hash::make($request->newPassword);
    }
    if ($request->phone != '') {
      $secretary->phoneNumber = $request->phone;
    }
    $secretary->save();

    return redirect()->route('secretary.editProfile')->with('message', 'Settings updated successfully');
  }

  public function getHistory()
  {

    $bookings = Booking::where('secretaryUsername', Auth::user()->username)->where('state', '<>', 'REQUESTED')->join('users', 'bookings.clientUsername', '=', 'users.username')->latest('bookings.created_at')->paginate(25);
    $secbans = AgencyBan::where('bannedBy', Auth::user()->username)->orderBy('startDate', 'DESC')->get();
    return view('secretaries.history', ['bookings' => $bookings, 'secbans' => $secbans]);
  }
  public function setRating(Request $request)
  {
    $request->validate([
      'bookingID' => 'required|numeric',
      'rating' => 'required|numeric|max:5|min:0'
    ]);
    $booking = Booking::where('bookingID', $request->bookingID)->first();
    $booking->update(['secretaryRatesClient' => $request->rating]);
    return redirect()->route('secretary.history')->with('success', 'Rating sent successfully');
  }
  public function banUser(Request $request)
  {
    $request->validate([
      'reason' => 'required',
      'duration' => 'required|numeric',
      'username' => 'required|exists:users,username'
    ]);

    $ban = new AgencyBan();
    $ban->bannedClient = $request->username;
    $ban->bannedBy = Auth::user()->username;
    $ban->startDate = now();
    $date = date_create(now());
    date_add($date, date_interval_create_from_date_string($request->duration . ' days'));

    $ban->endDate = $date;
    $ban->reason = $request->reason;
    $ban->save();

    $user =  User::where('username', $request->username)->first();

    $user->update(['nbBan' => $user->nbBan + 1]);

    if (AgencyBan::where('bannedClient', $request->username)->count() == 3) {
      $adminban = new AdminBan();
      $adminban->bannedUsername = $request->username;
      $adminban->reason = "This is an automatic ban. You have been banned from 3 agencies.";
      $adminban->save();
    }

    return redirect()->route('secretary.history')->with('success', 'User banned successfully');
  }

  public function changeImage(Request $request)
  {
    $folderPath = public_path('images/secretary/profile');
    
    $image_parts = explode(";base64,", $request->image);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file = uniqid();
    $url = Self::storeFile($request->image,"Images/secretary/profile/",$file.".".$image_type);
  
    Secretary::where('username', Auth::user()->username)->first()->update(['profilePath' => $url]);
    return response()->json(['success' => 'success']);
  }
  public function setSeen(Request $request)
  {
    Booking::find($request->bookingID)->update(["failedSeen" => true]);
    return response()->json(['Succes' => 'Changed successfully']);
  }
}
