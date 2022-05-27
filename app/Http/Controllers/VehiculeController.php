<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Booking;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Exception;

class VehiculeController extends Controller
{
  public function searchVehicules(Request $request)
  {
    if(session()->has('vehicules')) {
      return view('users.viewOffers');
    }
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
      ->get()
    ;
    $dropOffDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $request->dropOffDate));
    $pickUpDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T',' ', $request->pickUpDate));

    session(['pickUpDate' => $pickUpDate, 'dropOffDate' => $dropOffDate,
    'pickUpString' => $request->pickUpDate, 'dropOffString' => $request->dropOffDate,
    'pickUpLat' => $pickUpLat, 'pickUpLng' => $pickUpLng,
    'vehicules' => $vehicules
    ]);

    return view('users.viewOffers');
  }
  public function viewOfferDetails($plateNb) {
    $vehicule = Vehicule::select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'vehicules.rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath'])
    ->find($plateNb)
    ;
    $agency = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('branches', 'garages.brancheID', '=', 'branches.brancheID')
      ->join('agencies', 'branches.agencyID','=','agencies.agencyID')
      ->select(['agencies.name'])
      ->find($plateNb)
    ;
    $pickUpLocations = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickUpLocations', 'garages.brancheID', '=', 'pickUpLocations.brancheID')
      ->where('vehicules.plateNb',$plateNb)
      ->select('pickUpLocations.id','pickUpLocations.address_address')
      ->get()
    ;
    session()->forget(['0', '1']);
    $agnecyName = $agency -> name;
    session(['vehiculePlateNb' => $plateNb,'agencyName' => $agnecyName, 'vehicule' => $vehicule, 'pickUpLocations' => $pickUpLocations]);
    return view('users.offer');
  }
  public function book(Request $request) {

    $request->validate([
      'pickUpLocation' => 'required',
      'dropOffLocation' => 'required',
    ],[
      'pickUpLocation.required' => 'you have to choose a pick up location',
      'dropOffLocation.required' => 'you have to choose a drop off location',
    ]);

    $vehicule = Vehicule::find(session('vehiculePlateNb'));
    if($vehicule->availability == false) {
      return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail','vehicle is not available');
    }

    // foreach(session('vehicules') as $vehicule) {
    //   if($vehicule->plateNb == session('vehiculePlateNb')){
    //     session('vehicules').$vehicule = null;
    //     dd(session('vehicules').$vehicule);
    //   }
    // }
    // dd(session('vehicules'));

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

    $booking->pickUpDate = session('pickUpDate');
    $booking->dropOffDate = session('dropOffDate');

    $booking->clientUsername = Auth::user()->username;
    $booking->vehiculePlateNB = session('vehiculePlateNb');
    $save = $booking->save();
    if($save) {
      try {
        $vehicule ->availability = false;
        $vehicule -> save();
        $plateNb = session('vehiculePlateNb');
        session()->forget(['vehiculePlateNb', 'vehicule', 'agencyName','pickUpLocations']);
        return redirect()->route('user.viewOfferDetails', ['plateNb' => $plateNb ])->with('success','booking success');
      }catch(Exception $e) {
        return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail','booking has been failed');
      }
    }
    else {
      return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail','booking has been failed');
    }
    // http://127.0.0.1:8000/user/offer/2456376573/2022-05-27%2009:19/2022-05-31%2009:19
  }
}
