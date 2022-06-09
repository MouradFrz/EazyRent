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
    // if (session()->has('vehicules')) {
    //   return view('users.viewOffers');
    // }
    $request->validate(
      [
        'pickUpLng' => 'required|numeric',
        'pickUpLat' => 'required|numeric',
        'pickUpDate' => 'required|date|after:now',
        'dropOffDate' => 'required|date|after:pickUpDate',
      ],
      [
        'pickUpLng.required' => 'Please choose one of the suggested options.',
        'pickUpLat.required' => '',
        'pickUpDate.after' => 'Date invalid.',
        'dropOffDate.after' => 'Invalide dates.',
        'dropOffDate.required' => 'Please enter a valid range of dates.',
      ]
    );
  
    $pickUpLat = $request->pickUpLat;
    $pickUpLng = $request->pickUpLng;


    $vehicules = Vehicule::where('availability', 1)
      ->join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickuplocations', 'garages.brancheID', '=', 'pickuplocations.brancheID')
      ->where('brand','LIKE',($request->make) ? $request->model : '%' )
      ->whereBetween('address_latitude', [$pickUpLat - .18, $pickUpLat + .18])
      ->whereBetween('address_longitude', [$pickUpLng - .18, $pickUpLng + .18])
      ->select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath'])
      ->groupBy('plateNb')
      
      ->paginate(8)
      ->appends(request()->query());
      
    $dropOffDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T', ' ', $request->dropOffDate));
    $pickUpDate = DateTime::createFromFormat('Y-m-j H:i', str_replace('T', ' ', $request->pickUpDate));

    session([
      'pickUpDate' => $pickUpDate, 'dropOffDate' => $dropOffDate,
      'pickUpString' => $request->pickUpDate, 'dropOffString' => $request->dropOffDate,
      'pickUpLat' => $pickUpLat, 'pickUpLng' => $pickUpLng
    ]);

    return view('users.viewOffers')->with(['vehicules' => $vehicules]);
  }
  public function filterVehicules(Request $request){
    $vehicules = Vehicule::where('availability', 1)
      ->join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickuplocations', 'garages.brancheID', '=', 'pickuplocations.brancheID')
      ->where('brand','LIKE',($request->make) ? $request->make : '%' )
      ->where('model','LIKE',($request->model) ? $request->model : '%' )
      ->where('type','LIKE',($request->type) ? $request->type : '%' )
      ->where('category','LIKE',($request->category) ? $request->category : '%' )
      ->where('color','LIKE',($request->color) ? $request->color : '%' )
      ->where('year','LIKE',($request->year) ? $request->year : '%' )
      ->where('gearType','LIKE',($request->gear) ? $request->gear : '%' )
      ->where('gearType','LIKE',($request->gear) ? $request->gear : '%' )
      ->where('pricePerDay','>=',($request->minDay) ? $request->minDay : 0 )
      ->where('pricePerDay','<=',($request->maxDay) ? $request->maxDay : 9999999999 )
      ->where('pricePerHour','>=',($request->minHour) ? $request->minHour : 0 )
      ->where('pricePerHour','<=',($request->maxHour) ? $request->maxHour : 9999999999 )
      ->whereBetween('address_latitude', [session()->get('pickUpLat') - .18, session()->get('pickUpLat') + .18])
      ->whereBetween('address_longitude', [session()->get('pickUpLng') - .18, session()->get('pickUpLng') + .18])
      ->select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath'])
      ->groupBy('plateNb')
      ->paginate(8)
      ->appends(request()->query());
      // dd($vehicules);
      return view('users.viewOffers')->with(['vehicules' => $vehicules]);
  }
  public function viewOfferDetails($plateNb)
  {
    $vehicule = Vehicule::select(['plateNb', 'brand', 'model', 'type', 'color', 'year', 'fuel', 'gearType', 'doorsNb', 'horsePower', 'airCooling', 'physicalState', 'vehicules.rating', 'category', 'pricePerHour', 'pricePerDay', 'vehicules.garageID', 'imagePath'])
      ->find($plateNb);
    $agency = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('branches', 'garages.brancheID', '=', 'branches.brancheID')
      ->join('agencies', 'branches.agencyID', '=', 'agencies.agencyID')
      ->select(['agencies.name'])
      ->find($plateNb);
    $pickUpLocations = Vehicule::join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickuplocations', 'garages.brancheID', '=', 'pickuplocations.brancheID')
      ->where('vehicules.plateNb', $plateNb)
      ->select('pickuplocations.id', 'pickuplocations.address_address')
      ->get();
    session()->forget(['0', '1']);
    $agnecyName = $agency->name;
    session(['vehiculePlateNb' => $plateNb]);
    return view('users.offer')->with(['vehicule' => $vehicule, 'pickUpLocations' => $pickUpLocations, 'agencyName' => $agnecyName]);
  }
  public function book(Request $request)
  {

    $request->validate([
      'pickUpLocation' => 'required',
      'dropOffLocation' => 'required',
    ], [
      'pickUpLocation.required' => 'you have to choose a pick up location',
      'dropOffLocation.required' => 'you have to choose a drop off location',
    ]);

    $vehicule = Vehicule::find(session('vehiculePlateNb'));
    if ($vehicule->availability == false) {
      return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail', 'vehicle is not available');
    }

    $booking = new Booking;
    $booking->created_at = now();
    // REQUESTED ACCEPTED REFUSED SIGNED CANCELED ON GOING FINISHED
    $booking->state = 'REQUESTED';
    // by default it's false secretary will update this when the client pay the booking
    $booking->isPaid = false;
    // 'HAND BY HAND' 'ONLINE'
    $booking->payementMethod = 'HAND BY HAND';
    $booking->pickUpLocation = $request->pickUpLocation;
    $booking->dropOffLocation = $request->dropOffLocation;

    $booking->pickUpDate = session('pickUpString');
    $booking->dropOffDate = session('dropOffString');

    $booking->clientUsername = Auth::user()->username;
    $booking->vehiculePlateNB = session('vehiculePlateNb');
    $diff = session('dropOffDate')->diff(session('pickUpDate'));
    $days =  $diff->days;
    $hours = $diff->h;
    $price = $vehicule->pricePerHour * $hours + $vehicule->pricePerDay * $days;
    $booking->bookingPrice = $price;
    $save = $booking->save();
    if ($save) {
      try {
        $vehicule->availability = false;
        $vehicule->save();
        session()->forget(['agencyName', 'pickUpLocations']);
        return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('success', 'booking success');
      } catch (Exception $e) {
        return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail', 'booking has been failed');
      }
    } else {
      return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail', 'booking has been failed');
    }
    // http://127.0.0.1:8000/user/offer/2456376573/2022-05-27%2009:19/2022-05-31%2009:19
  }
}
