<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{
  public function calcBookingPrice($plateNb, $pickUpDate, $dropOffDate)
  {
    $vehicule = Vehicule::find($plateNb);
    $diff = $dropOffDate->diff($pickUpDate);
    $days = $diff->days;
    $hours = $diff->h;
    $price = $vehicule->pricePerHour * $hours + $vehicule->pricePerDay * $days;
    return $price;
  }
  public function searchVehicules(Request $request)
  {
    $pickUpLat = $request->pickUpLat;
    $pickUpLng = $request->pickUpLng;
    $dropOffLat = $request->dropOffLat;
    $dropOffLng = $request->dropOffLng;

    // $vehicules = DB::table('vehicules')->where('availability',"AVAILABLE")
    //               ->join('garages','vehicules.garageID', '=' , 'garages.garageID')
    //               ->join('branches', 'garages.brancheID','=','branches.brancheID')
    //               // ->join('pickUpLocations','branches.brancheID', '=','pickUpLocations.brancheID')
    //               // ->join('pickUpLocations',function($join) {
    //               //   $join->on('branches.brancheID', '=','pickUpLocations.brancheID')
    //               //     ->where(function($query) use ($PickUpLat, $pickUpLng) {
    //               //       $query->whereBetween('address_latitude',[$PickUpLat-5, $PickUpLat+5])
    //               //             ->orWhereBetween('address_longitude',[$pickUpLng-5,$pickUpLng+5])
    //               //           })
    //               //     ->orWhere(function($query) use($dropOffLat, $dropOffLng) {
    //               //       $query->whereBetween('address_latitude',[$dropOffLat-5, $dropOffLat+5])
    //               //             ->orWhereBetween('address_longitude',[$dropOffLng-5,$dropOffLng+5])})
    //               //   })->get();

    //             //   ->join('contacts', function ($join) {
    //             //     $join->on('users.id', '=', 'contacts.user_id')
    //             //          ->where('contacts.user_id', '>', 5);
    //             // })
    // // ->where(function($query) use($PickUpLat, $pickUpLng) {
    // //               $query->whereBetween('address_latitude',[$PickUpLat-5, $PickUpLat+5])
    // //                     ->orWhereBetween('address_longitude',[$pickUpLng-5,$pickUpLng+5]);})
    // //             ->orWhere(function($query) use($dropOffLat, $dropOffLng) {
    // //               $query->whereBetween('address_latitude',[$dropOffLat-5, $dropOffLat+5])
    // //                     ->orWhereBetween('address_longitude',[$dropOffLng-5,$dropOffLng+5]);
    // // })->get()

    // // ->pluck('plateNb','brand','model','type','color','year','fuel','gearType','doorsNb','horsePower','airCooling','physicalState','rating','category','pricePerHour','pricePerDay','garageID','imagePath','address_address','address_latitude','address_longitude');

    // // $vehicules = DB::select('SELECT DISTINCT `pickUpLocations`.`address_address`,`pickUpLocations`.`address_latitude`,`pickUpLocations`.`address_longitude` from `vehicules`,`garages`,`branches`,`pickUpLocations`
    // // WHERE vehicules.garageID = garages.garageID AND garages.brancheID = branches.brancheID AND pickUpLocations.brancheID = branches.brancheID ');
    // // $vehicules = json_decode(json_encode($vehicules),True);
    $vehicules = Vehicule::where('availability', 1)
      ->join('garages', 'vehicules.garageID', '=', 'garages.garageID')
      ->join('pickUpLocations', 'garages.brancheID', '=', 'pickUpLocations.brancheID')
      ->whereBetween('address_latitude', [$pickUpLat - .18, $pickUpLat + .18])
      ->whereBetween('address_longitude', [$pickUpLng - .18, $pickUpLng + .18])
      ->select(['plateNb','brand','model','type','color','year','fuel','gearType','doorsNb','horsePower','airCooling','physicalState','rating','category','pricePerHour','pricePerDay','vehicules.garageID','imagePath'])
      ->distinct()
      ->get();

    return view('users.viewOffers')->with('vehicules', $vehicules);
  }
}
