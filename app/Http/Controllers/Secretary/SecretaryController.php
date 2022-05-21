<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Vehicule;
use App\Models\Branche;
use App\Models\Garage;
use App\Http\Controllers\Controller;
use App\Models\Booking;
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
    public function logout(){
        Auth::guard('secretary')->logout();
        return redirect()->route('workerLogin');
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
      ]);
    
      //vehiculeeeee
      $newCarName = $request->brand . $request->model . '.' . $request->imagePath->extension();
      $request->imagePath->move(public_path('images/vehicules/imagePaths'), $newCarName);

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
      $vehicule->imagePath = $request->imagePath;
      $vehicule->save();
      $garages= Garage::select('garageID')->where('garages.brancheID',Auth::user()->brancheID)->get();
      return redirect()->route('secretary.addVehicule')->with('message','Vehicule added successfully')->with(['garages'=>$garages]);
    }
    public function showVehicules()
    {
     $vehicules = Vehicule::join('garages','vehicules.garageID','=','garages.garageID')->join('branches','garages.garageID','=','vehicules.garageID')->where('branches.brancheID',Auth::user()->brancheID)->get();
     
           return view('secretaries.secretaryVehicules',['vehicules'=>$vehicules]);   
    }

      public function vehiculeDetails($id){
        if(is_null(Auth::user()->username)){
          return redirect()->route('secretary.home');
      }
     

      }
 

  public function getReservationRequests(){

    $bookings = Booking::join('vehicules','bookings.vehiculePlateNb','=','vehicules.plateNb')->join('garages','vehicules.garageID','=','garages.garageID')->join('users','clientUsername','=','users.username')->where('garages.brancheID',Auth::user()->brancheID)->where('state','REQUESTED')->latest('bookings.created_at')->paginate(25);
    return view('secretaries.reservationRequests',['bookings'=>$bookings]);
  }
  public function reservationDetails($id){
    $booking = Booking::join('vehicules','bookings.vehiculePlateNb','=','vehicules.plateNb')->join('users','clientUsername','=','users.username')->where('bookingID',$id)->join('garages','vehicules.garageID','=','garages.garageID')->first();
    
    $origin = new DateTime($booking->pickUpDate);
    $target = new DateTime($booking->dropOffDate);
    $interval = $origin->diff($target);
    $str=$interval->format('%a days and %h hours');
    return view('secretaries.reservationDetails',['booking'=>$booking,'interval'=>$str]);


    Vehicule::join('garages','garageID','=','garages.garageID')->join('branches','garages.garageID','=','vehicules.garageID')->where('branches.brancheID',Auth::user()->brancheID)->get();
  }
  public function addVehiculePage(){
    $garages = Garage::select(['garageID','address'])->where('garages.brancheID',Auth::user()->brancheID)->get();
    return view('secretaries.addVehicule',['garages'=>$garages]);
  }
}



