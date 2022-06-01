<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
  public function accept($bookingID) {
    $booking = Booking::where('bookingID', $bookingID)->first();
    $booking->secretaryUsername = Auth::user()->username;
    $booking->state = 'ACCEPTED';
    $booking->updated_at = now();
    $save = $booking->save();

    $contractData = DB::select('SELECT bookingID,payementMethod,pickUpDate,dropOffDate,users.firstName as userFirstName,users.lastName as userLastName
    , secretaries.firstName as secFirstName,secretaries.lastName as secLastName,
    address_address,vehiculePlateNb,model,brand,bookingPrice,pricePerHour,pricePerDay,agencies.name as agencyName,registeryNb
    
    FROM bookings,vehicules,secretaries,agencies,pickuplocations,branches,users
    where bookings.vehiculePlateNB = vehicules.plateNb 
    AND bookings.clientUsername=users.username 
    AND bookings.secretaryUsername=secretaries.username
    AND secretaries.brancheID = branches.brancheID
    AND branches.agencyID = agencies.agencyID 
    AND bookings.pickUpLocation = pickuplocations.id
    AND bookings.bookingID=:bookID;',['bookID'=>$booking->bookingID]);

    $array = json_decode(json_encode($contractData), true);
    $pdf = PDF::loadView('users.contract', $array[0]);
    $pdf->save(public_path('contracts\contract_').$booking->bookingID.'.pdf');
    
    if($save) {
      return redirect()->route('secretary.getReservationRequests')
      ->with('success','You successfully accepted a booking request');
    }else {
      return redirect()->route('secretary.getReservationRequests')
      ->with('failed','accept booking request has been failed');
    }
  }
  public function decline(Request $request, $bookingID) {
  $request->validate([
    'declineReason' => 'required'
  ]);
    $booking = Booking::where('bookingID', $bookingID)->first();
   
    $booking->secretaryUsername = Auth::user()->username;
    $booking->state = 'DECLINED';
    $booking->declineReason = $request -> declineReason;
    $booking->updated_at = now();
    $save = $booking->save();
    if($save) {
      return redirect()->route('secretary.getReservationRequests')
      ->with('success','You successfully decline a booking request!');
    }else {
      return redirect()->route('secretary.getReservationRequests')
      ->with('failed','decline booking request has been failed');
    }
  }
}
