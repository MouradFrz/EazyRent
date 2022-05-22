<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{
  public function calcBookingPrice($plateNb,$pickUpDate,$dropOffDate){
    $vehicule = Vehicule::find($plateNb);
    $diff = $dropOffDate->diff($pickUpDate);
    $days = $diff->days;
    $hours = $diff->h;
    $price = $vehicule->pricePerHour * $hours + $vehicule->pricePerDay * $days;
    return $price;
  }
  public function searchVehicules(Request $request)
  {
    $vehicules = DB::table('vehicules')->where('state',"AVAILABLE");
    $vehicules = $vehicules->join('garages','vehicules.garageID', '=' , 'garages.garageID')
                  ->join('branches', 'garages.brancheID','=','branches.brancheID')
                  ->join('pickUpLocations','branches.brancheID', '=','pickUpLocations.brancheID')
    ;
    $vehicules = $vehicules->distinct()->pluck('plateNb','brand','model','type','color','year','fuel','gearType','doorsNb','horsePower','airCooling','physicalState','rating','category','pricePerHour','pricePerDay','garageID','imagePath','address_address','address_latitude','address_longitude') ;
    $lng = $request->lng;
    $lat = $request->lat;
    $vehicules = $vehicules
                ->where(function($query) use($lat, $lng) {
                  $query->whereBetween('address_latitude',[$lat-5, $lat+5])
                        ->orWhereBetween('address_longitude',[$lng-5,$lng+5]);})
                ->orWhere(function($query) use($lat, $lng) {
                  $query->whereBetween('address_latitude',[$lat-5, $lat+5])
                        ->orWhereBetween('address_longitude',[$lng-5,$lng+5]);
                  });
  }
}
