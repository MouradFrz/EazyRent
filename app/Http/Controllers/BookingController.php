<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
  public function storeFile($image, $path, $nameWithExtension)
  {
    $expiresAt = new \DateTime('01/01/2100');
    $uploadedfile = fopen($image, 'r');
    app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => "$path$nameWithExtension"]);
    // "Testing/other_image.png
    $url = app('firebase.storage')->getBucket()->object("$path$nameWithExtension")->signedUrl($expiresAt);
    return $url;
  }
  public function accept($bookingID) {
    $booking = Booking::where('bookingID', $bookingID)->first();
    $booking->secretaryUsername = Auth::user()->username;
    $booking->state = 'ACCEPTED';
    $booking->updated_at = now();
    $save = $booking->save();

    $contractData = DB::select('SELECT bookingID,payementMethod,pickUpDate,dropOffDate,users.firstName as userFirstName,users.lastName as userLastName
    , secretaries.firstName as secFirstName,secretaries.lastName as secLastName,
    address_address,vehiculePlateNb,model,year,color,plateNb,brand,bookingPrice,pricePerHour,pricePerDay,agencies.name as agencyName,registeryNb,logo
    
    FROM bookings,vehicules,secretaries,agencies,pickuplocations,branches,users
    where bookings.vehiculePlateNB = vehicules.plateNb 
    AND bookings.clientUsername=users.username 
    AND bookings.secretaryUsername=secretaries.username
    AND secretaries.brancheID = branches.brancheID
    AND branches.agencyID = agencies.agencyID 
    AND bookings.pickUpLocation = pickuplocations.id
    AND bookings.bookingID=:bookID;',['bookID'=>$booking->bookingID]);

    $array = json_decode(json_encode($contractData), true);
    $pdf = Pdf::loadView('users.contract', $array[0]);
    $pdf->save(public_path('../storage/app/public/').$booking->bookingID.'.pdf');
    // Storage::
    // Self::storeFile($pdf,"Contracts/",$booking->bookingID.'.pdf');
    $notif = new Notification();
    $notif->notifiedUsername = $booking->clientUsername;
    $notif->bookingID = $booking->bookingID;
    $notif->type="ACCEPTED";
    $notif->created_at=now();
    $notif->message = "Your booking request for the ".$contractData[0]->brand." ".$contractData[0]->model." has been accepted by the agency. Click here to view the contract and sign it.";
    $notif->save();
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



    $notif = new Notification();
    $notif->notifiedUsername = $booking->clientUsername;
    $notif->bookingID = $booking->bookingID;
    $notif->type="DECLINED";
    $notif->message = "Your booking request for the ".$contractData[0]->brand." ".$contractData[0]->model." has been declined by the agency. Click here to view more details.";
    $notif->save();


    if($save) {
      return redirect()->route('secretary.getReservationRequests')
      ->with('success','You successfully decline a booking request!');
    }else {
      return redirect()->route('secretary.getReservationRequests')
      ->with('failed','decline booking request has been failed');
    }
  }
}
