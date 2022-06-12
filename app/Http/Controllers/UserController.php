<?php

namespace App\Http\Controllers;

use App\Models\AdminBan;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Branche;
use App\Models\Complaint;
use App\Models\Notification;
use App\Models\Owner;
use App\Models\Secretary;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
  public function create(Request $request)
  {

    if ($request->phone == '') {
    }
    $request->validate(
      [
        'username' => 'required|unique:users,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        'email' => 'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        // 'password' => ['required', Password::min(8)->mixedCase()->numbers()->uncompromised()],
        'passwordConfirm' => 'required|same:password',
        'idCard' => 'required|digits_between:18,18|numeric',
        'idCardImage' => 'required|mimes:jpg,jpeg,png|max:5048',
        'faceIdImage' => 'required|mimes:jpg,jpeg,png|max:5048'
      ],
      [
        'idCard.required' => 'The identity card number is required.',
        'idCard.digits_between' => 'The identity card number has to be 18 number long.',
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'password.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        // 'password.Password' => 'The password you entered is weak,<br>make sure your password containe at least 8 carecters : at least 1 uppercase letter,1 lowercase letter, 1 number. ',
        'idCardImage.required' => 'The identity card image is required.',
        'faceIdImage.required' => 'The face image is required for the face recognition when picking a car up.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );

    $newImageName = $request->username . '.' . $request->idCardImage->extension();
    $request->idCardImage->move(public_path('images/users/idCardImages'), $newImageName);

    $faceIdImage = $request->username . '_faceId' . '.' . $request->faceIdImage->extension();
    $request->faceIdImage->move(public_path('images/users/faceIdImages'), $faceIdImage);


    $user = new User();
    $user->username = $request->username;
    $user->password = Hash::make($request->password);
    $user->firstName = $request->firstName;
    $user->lastName = $request->lastName;
    $user->address = $request->address;
    $user->birthDate = $request->birthDate;
    $user->idCard = $request->idCard;
    $user->email = $request->email;
    $user->phoneNumber = $request->phone;
    $user->idCardPath = $newImageName;
    $user->faceIdPath = $faceIdImage;

    $save = $user->save();

    if ($save) {
      return redirect()->back()->with('success', 'You are now registered! Log in to your account.');
    } else {
      return redirect()->back()->with('fail', 'Something went wrong, registration failed');
    }
  }

  public function check(Request $request)
  {

    if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
      $request->validate(
        [
          'username' => 'required|exists:users,email',
          'password' => 'required|min:6'
        ],
        [
          'username.exists' => 'Your account doesnt exist. Create an account then login'
        ]
      );
      $request->merge([
        'email' => $request->username,
    ]);
      $creds = $request->only('email', 'password');
    }else{
      $request->validate(
        [
          'username' => 'required|exists:users,username',
          'password' => 'required|min:6'
        ],
        [
          'username.exists' => 'Your account doesnt exist. Create an account then login'
        ]
      );
      $creds = $request->only('username', 'password');
    }


    // dd($creds);
    if (Auth::guard('web')->attempt($creds, $request->remember)) {
      $bans=AdminBan::where('bannedUsername',Auth::user()->username)->get();
      if(count($bans)!=0){
        Auth::guard('web')->logout();
        return redirect()->route('user.login')->with('ban','You have been banned from the website.')->with('reason',$bans[0]->reason);
      }
      if(session()->has('vehiculePlateNb')) {
        session()->regenerate();
        return redirect()->route('user.viewOfferDetails', ['plateNb'=>session('vehiculePlateNb')]);
      }
      return redirect()->route('user.home');
    } else {
      return redirect()->route('user.login')->with('fail', 'The credentials you entered are wrong');
    }
  }
  public function logout()
  {
    session()->flush();
    Auth::guard('web')->logout();
    return redirect()->route('user.login');
  }
  public function getUsersList()
  {
    $users = User::latest()->paginate(25);
    return view('admin.usersList', ['users' => $users]);
  }

  public function getHistory(){
    $bookings = Booking::where('clientUsername',Auth::user()->username)->join('vehicules','bookings.vehiculePlateNb','=','vehicules.plateNb')->join('garages','vehicules.garageID','=','garages.garageID')->join('branches','garages.brancheID','=','branches.brancheID')->get();
    return view('users.history',[
      'bookings'=>$bookings,
    ]);
  }

  public function getBookingDetails($id){
    $booking = Booking::find($id);

    Notification::where('bookingID',$id)->update(['read_at'=>now()]);
    if($booking->clientUsername!=Auth::user()->username){
      return redirect()->route('user.home');
    }

    return view('users.bookingDetails',['booking'=>$booking]);
  }

  public function downloadPdf($id){
    $booking = Booking::find($id);
    if($booking->clientUsername!=Auth::user()->username){
      return redirect()->route('user.home');
    }
    $path = public_path('contracts\contract_').$id.'.pdf';
    return response()->download($path);
  }
  public function signContract(Request $request,$id){
    $booking = Booking::find($id);
    if($booking->clientUsername!=Auth::user()->username){
      return redirect()->route('user.home');
    }


    $contractData = DB::select('SELECT bookingID,payementMethod,pickUpDate,dropOffDate,users.firstName as userFirstName,users.lastName as userLastName
    , secretaries.firstName as secFirstName,secretaries.lastName as secLastName,
    address_address,vehiculePlateNb,model,year,color,plateNb,brand,bookingPrice,pricePerHour,pricePerDay,agencies.name as agencyName,registeryNb

    FROM bookings,vehicules,secretaries,agencies,pickuplocations,branches,users
    where bookings.vehiculePlateNB = vehicules.plateNb
    AND bookings.clientUsername=users.username
    AND bookings.secretaryUsername=secretaries.username
    AND secretaries.brancheID = branches.brancheID
    AND branches.agencyID = agencies.agencyID
    AND bookings.pickUpLocation = pickuplocations.id
    AND bookings.bookingID=:bookID;',['bookID'=>$id]);

    $array = json_decode(json_encode($contractData), true);

    $array[0]['signature']=true;
    $pdf = PDF::loadView('users.contract', $array[0]);
    $pdf->save(public_path('contracts\contract_').$id.'.pdf');


    $request->validate([
      'password'=>'required|current_password:web',
      'valid'=>'accepted'
    ]);
    $booking->update(['state'=>'SIGNED']);
    return redirect()->route('user.bookingDetails',$id)->with('success','Contract Signed successfully.');
  }

  public function declineContract(Request $request,$id){
    $booking = Booking::find($id);
    if($booking->clientUsername!=Auth::user()->username){
      return redirect()->route('user.home');
    }


    $request->validate([
      'password'=>'required|current_password:web',
      'valid'=>'accepted'
    ]);
    $booking->update(['state'=>'CANCELED']);
    return redirect()->route('user.bookingDetails',$id)->with('declined','Contract declined.');
  }

  public function loadNotifications(Request $request){
    if ($request->ajax()) {
    return Notification::where("notifiedUsername",Auth::user()->username)->get();
    }
  }
  public function editProfile(){
    return view('users.editProfile');
  }
  public function checkPassword(Request $request){
    if(Hash::check($request->password,Auth::user()->password)){
      return response()->json(['success'=>true]);
    }else{
      return response()->json(['success'=>false]);
    }
  }
  public function editProfilePost(Request $request){
    $request->validate(
      [
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        ($request->email == Auth::user()->email) ?: 'email' => 'email|unique:users,email|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        ($request->password == '') ?: 'password' => 'min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'same:password',
      ],
      [
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'password.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );

    $owner = User::where('username', Auth::user()->username)->first();

    $owner->firstName = $request->firstName;
    $owner->lastName = $request->lastName;
    $owner->birthDate = $request->birthDate;
    $owner->address = $request->address;
    $owner->email = $request->email;
    if ($request->password != '') {
      $owner->password = Hash::make($request->password);
    }
    if ($request->phone != '') {
      $owner->phoneNumber = $request->phone;
    }
    $owner->save();

    return redirect()->route('user.editProfile')->with('message', 'Settings updated successfully');
  }

  public function changeImage(Request $request)
  {
      $folderPath = public_path('images/users/profile');

      $image_parts = explode(";base64,", $request->image);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $file = $folderPath . uniqid() . '.png';

      file_put_contents('images/users/profile/'.Auth::user()->username."_profile.png", $image_base64);
      User::find(Auth::user()->id)->update(['profilePath'=>Auth::user()->username."_profile.png"]);
      return response()->json(['success'=>'success']);
  }
  public function checkFace($id){
    if(Booking::find($id)->state!="SIGNED"){
      return redirect()->route('user.home');
    }
    return view('users.faceRecognition',['bookingID'=>$id]);
  }
  public function setGoing(Request $request){
    Booking::find($request->bookingID)->update(['state'=>"ON GOING"]);
    return response()->json(['Succes'=>'Changed successfully']);
  }
  public function setFailed(Request $request){
    Booking::find($request->bookingID)->update(['state'=>"FAILED","failedSeen"=>false,"failedDate"=>now()]);
    return response()->json(['Succes'=>'Changed successfully']);
  }
  public function sendComplaint(Request $request){
    $complaint = new Complaint();
    $username = Owner::where('agencyID',$request->agencyID)->first()->username;
    $complaint->problemType = $request->type;
    $complaint->message = $request->message;
    $complaint->sender = Auth::user()->username;
    $complaint->recepient=$username;
    $complaint->save();
    Booking::find($request->bookingID)->update(['complaintID'=>$complaint->id]);

    return redirect()->route('user.history')->with('message','Your complaint has been send');
  }
  public function rateVehicle(Request $request){
    $request->validate([
      'rating'=>'required|between:0,5'
    ]);
    $booking = Booking::find($request->bookingID);
    $vehicule = Vehicule::find($booking->vehiculePlateNB);
    // dd($vehicule);
    
    if($booking->clientUsername != Auth::user()->username || !is_null($booking->vehiculeRating)){
      return "You are not allowed to do this action";
    }
    $booking->vehiculeRating = $request->rating;
    $booking->vehiculeComment = $request->comment;
    $booking->commentDate=now();
    $booking->save();
    $count = Booking::where('vehiculePlateNB',$booking->vehiculePlateNB)->whereNotNull('vehiculeRating')->count();

   
    $vehicule->rating = ($vehicule->rating + $request->rating )/$count;
    $vehicule->save();

    return redirect()->route('user.history')->with('message',"Thanks for your feedback!");
  }
  public function rateAgency(Request $request){
    $request->validate([
      'rating'=>'required|between:0,5'
    ]);
    
    $booking = Booking::find($request->bookingID);
    $agencyID = Agency::join('branches','agencies.agencyID','=','branches.agencyID')->join('secretaries','branches.brancheID','=','secretaries.brancheID')->first()->agencyID;
    
    $agency = Agency::find($agencyID);

    $booking->clientRatesSecretary = $request->rating;
    $booking->save();
    $count = Booking::whereIn('secretaryUsername',Secretary::whereIn('brancheID',Branche::where('agencyID',$agencyID)->select(['brancheID'])->get()->toArray())->select(['username'])->get()->toArray())->whereNotNull('clientRatesSecretary')->count();
    $agency->rating = ($agency->rating + $request->rating) / $count;
    $agency->save();
    return redirect()->route('user.history')->with('message',"Thanks for your feedback!");
  }
  public function activateAccount(Request $request){
    if(!is_null(Auth::user()->faceIdPath)){
      return redirect()->route('user.home');
    }
    return view('users.activateAccount');
  }

  public function upload(Request $request){
     
    $img = $request->image;
    $folderPath = "images/users/faceIdImages/"; //path location
    
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
   
    $file = $folderPath . Auth::user()->username.'_'.$request->counter.'.'.$image_type;
    file_put_contents($file, $image_base64);
    return response()->json(['succes'=>'success']);
  }
  public function setActive(){
    User::find(Auth::user()->id)->update(['faceIdPath'=>true]);
    return response()->json(['succes'=>'success']);
  }
  public function sessionSetting(Request $request){
    session([
      'pickUpLocation' => $request->pickUpLocation, 'dropOffLocation' => $request->dropOffLocation]);
      return response()->json(['result'=>'success']);
  }
  public function paymentSuccess(){
    if(is_null(Auth::user()->faceIdPath)){
      return redirect()->route('user.activateAccount');
    }
    $vehicule = Vehicule::find(session('vehiculePlateNb'));
    if ($vehicule->availability == false) {
      return redirect()->route('user.viewOfferDetails', ['plateNb' => session('vehiculePlateNb')])->with('fail', 'vehicle is not available');
    }

    $booking = new Booking;
    $booking->created_at = now();
    // REQUESTED ACCEPTED REFUSED SIGNED CANCELED ON GOING FINISHED
    $booking->state = 'REQUESTED';
    // by default it's false secretary will update this when the client pay the booking
    $booking->isPaid = true;
    // 'HAND BY HAND' 'ONLINE'
    $booking->payementMethod = 'ONLINE';
    $booking->pickUpLocation = session('pickUpLocation');
    $booking->dropOffLocation = session('dropOffLocation');

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
    return view('users.paymentSuccess');
  }
}
