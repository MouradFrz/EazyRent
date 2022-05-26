<?php

namespace App\Http\Controllers;

use App\Models\PickUpLocation;
use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
  public function searchVehicules(Request $request)
  {
    $request->validate([
      'pickUpLng' => 'required|numeric',
      'pickUpLat' => 'required|numeric',
      'pickUpDate' => 'required|date|after:now',
      'dropOffDate' => 'required|date|after:pickUpDate',
    ],
    [
      'pickUpLng.required' => 'Please choose one of the suggested options',
      'pickUpLat.required' => '',
      'pickUpDate.after' => 'Date invalid',
      'dropOffDate.after' => 'Date invalid',
    ]
    );
    $pickUpLat = $request->pickUpLat;
    $pickUpLng = $request->pickUpLng;
    // $dropOffLat = $request->dropOffLat;
    // $dropOffLng = $request->dropOffLng;

    $vehicules = Vehicule::where('availability', 1)
      ->join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickUpLocations', 'garages.brancheID', '=', 'pickUpLocations.brancheID')
      ->whereBetween('address_latitude', [$pickUpLat - .18, $pickUpLat + .18])
      ->whereBetween('address_longitude', [$pickUpLng - .18, $pickUpLng + .18])
      ->select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath'])
      ->distinct()
      ->get();

    $dropOffDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $request->dropOffDate));
    $pickUpDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $request->pickUpDate));
    return view('users.viewOffers')->with(['vehicules' => $vehicules, 'pickUpDate' => $pickUpDate, 'dropOffDate' => $dropOffDate]);
  }
  public function viewOfferDetails($plateNb,$pickUpDate,$dropOffDate) {
    $vehicule = Vehicule::
        join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('branches', 'garages.brancheID', '=', 'branches.brancheID')
      ->join('agencies', 'branches.agencyID','=','agencies.agencyID')
      // check later what u realy need to select
      ->select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'vehicules.rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath','agencies.name'])
      ->find($plateNb)
    ;
    // maybe later agency it will be in it's own variable
    $pickUpLocations = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')
    ->join('pickUpLocations', 'garages.brancheID', '=', 'pickUpLocations.brancheID')
    ->where('vehicules.plateNb',$plateNb)
    ->select('pickUpLocations.id','pickUpLocations.address_address')
    ->get()
    ;
    return view('users.offer')->with(['vehicule'=> $vehicule,'pickUpDate'=>str_replace(' ', 'T',$pickUpDate),'dropOffDate'=>str_replace(' ', 'T',$dropOffDate),'pickUpLocations' => $pickUpLocations ]);
  }
  public function book(Request $request,$vehiculePLateNb) {
    
    $request->validate([
      'pickUpLocation' => 'required',
      'dropOffLocation' => 'required',
    ],[
      'pickUpLocation.required' => 'you have to choose a pick up location',
      'dropOffLocation.required' => 'you have to choose a drop off location',
    ]);
    
    $booking = new Booking;
    $booking->created_at = now();
    // REQUESTED ACCEPTED REFUSED SIGNED CANCELED ON GOING FINISHED
    $booking->state = 'REQUESTED';
    // by default it's false secretary will update this when the client pay the booking
    $booking->isPaid = false;
    // 'HAND BY HAND' 'ONLINE'
    $booking->payementMethod = 'HAND BY HAND';
    $booking->pickUpLocation = $request->pickUpLocation;
    $booking->dropOffLocation = $request->pickUpLocation;
    
    // $pickUpDate = DateTime::createFromFormat('Y-m-j H:i:s', str_replace('T',' ', $request->pickUpDate));
    // $dropOffDate = DateTime::createFromFormat('Y-m-j H:i:s', str_replace('T',' ', $request->dropOffDate));
    $booking->clientUsername= 'User1';
    $booking->pickUpDate = $request->pickUpDate;
    $booking->dropOffDate = $request->dropOffDate;
    // not yet
    // $booking->clientUsername = Auth::user()->username;
    $booking->vehiculePlateNB = $vehiculePLateNb;
    
    $save = $booking->save();
    // if($save) {
    //   return redirect()->route('user.offer',)->with('success','booking success');
    // }
    // else {
    //   return redirect()->route('user/offer/vehiculePLateNb/$request->pickUpDate/$request->dropOffDate')->with('fail','booking has been failed');
    // }


  
    // http://127.0.0.1:8000/user/offer/2456376573/2022-05-27%2009:19/2022-05-31%2009:19
  }
}
