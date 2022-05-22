<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
  public function accept($bookingID) {
    $booking = Booking::where('bookingID', $bookingID)->first();
    $booking->secretaryUsername = Auth::user()->username;
    $booking->state = 'ACCEPTED';
    $booking->updated_at = now();
    $save = $booking->save();
    if($save) {
      return redirect()->route('secretary.getReservationRequests')
      ->with('success','You successfully accept a booking request');
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
    // dd($booking);
    $booking->secretaryUsername = Auth::user()->username;
    $booking->state = 'DECLINED';
    // this column does not exist in bookings tables
    // $booking->declineReason = $request -> declineReason;
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
