<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;
use DateTime;

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
    $vehicule = Vehicule::find($plateNb)->first();
    return view('users.offer')->with(['vehicule'=> $vehicule,'pickUpDate'=>$pickUpDate,'dropOffDate'=>$dropOffDate]);
  }
}
