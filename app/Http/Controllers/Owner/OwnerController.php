<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\AgencyRequest;
use App\Models\Booking;
use App\Models\Branche;
use App\Models\Complaint;
use App\Models\Garage;
use App\Models\Garagist;
use App\Models\PickUpLocation;
use App\Models\Secretary;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class OwnerController extends Controller
{
  public function home()
  {
    $branchesWithCount = DB::select("SELECT branches.address , count(garages.brancheID) as Co
    FROM bookings , vehicules , garages ,branches
    where bookings.vehiculePlateNB = vehicules.plateNb
    AND vehicules.garageID = garages.garageID AND garages.brancheID=branches.brancheID
    AND garages.brancheID IN
                (Select brancheID
                from branches
                            where agencyID
                            IN (SELECT agencyID
                  from owners
                                where owners.username = :owner)
                                )
    group by garages.brancheID;", ['owner' => Auth::user()->username]);
    $dates = [];
    $reservationsPerDay = [];
    for ($i = 0; $i <= 6; $i++) {
      $date = now();
      $reservationsPerDay[$i] = DB::select("SELECT count(bookingID) as Co
        FROM  bookings ,  vehicules ,  garages , branches
        where  bookings.vehiculePlateNB =  vehicules.plateNb
        AND  vehicules.garageID = garages.garageID AND garages.brancheID=branches.brancheID
        AND bookings.created_at LIKE  :date
        AND garages.brancheID IN
              (Select brancheID
              from branches
                          where agencyID
                          IN (SELECT agencyID
                from owners
                              where owners.username = :owner)
                              );", ['owner' => Auth::user()->username, 'date' => date('Y-m-d', (strtotime('-' . $i . ' day', strtotime($date)))) . '%']);
      $dates[$i] = date('Y-m-d', (strtotime('-' . $i . ' day', strtotime($date))));
    }

    $branchesWithTotalMoney = DB::select("SELECT branches.address , sum(bookings.bookingPrice) as Total
    FROM  bookings ,  vehicules ,  garages , branches
    where  bookings.vehiculePlateNB =  vehicules.plateNb
    AND  vehicules.garageID = garages.garageID AND garages.brancheID=branches.brancheID
    AND garages.brancheID IN
                (Select brancheID
                from branches
                            where agencyID
                            IN (SELECT agencyID
                  from owners
                                where owners.username = :owner)
                                )
    group by garages.brancheID;", ['owner' => Auth::user()->username]);

    $pickUpLocationsCount = DB::select("SELECT address_address,count(bookingID) as Co from bookings , pickuplocations
    where bookings.pickUpLocation = pickuplocations.id AND pickuplocations.brancheID IN
                                              (SELECT brancheID
                                                                                        from branches
                                                                                        where branches.agencyID = :agency)
    group by pickUpLocation ;", ['agency' => Auth::user()->agencyID]);
    // dd($pickUpLocationsCount);

    $mostRentedCars= DB::select('SELECT
    brand,
    model,
    rating,
    imagePath,
    plateNb,
    count(bookingID) as bookCount
 from
    bookings,
    vehicules
 where
    bookings.vehiculePlateNB = vehicules.plateNb
    AND vehiculePlateNb IN
    (
       Select
          plateNb
       from
          vehicules
       where
          garageID in
          (
             Select
                garageID
             from
                garages
             where
                brancheID in
                (
                   Select
                      brancheID
                   from
                      branches
                   where
                      agencyID = :agency
                )
          )
    )
 group by
    vehiculePlateNb
 order by
    count(bookingID) DESC
    limit 5 ;', ['agency' => Auth::user()->agencyID]);
  // dd($mostRentedCars);


    $garageCount = Garage::whereIn('brancheID', Branche::where('agencyID', Auth::user()->agencyID)->select('agencyID')->select('brancheID')->get()->toArray())->count();
    $pulCount = PickUpLocation::whereIn('brancheID', Branche::where('agencyID', Auth::user()->agencyID)->select('agencyID')->select('brancheID')->get()->toArray())->count();
    $secCount = Secretary::whereIn('brancheID', Branche::where('agencyID', Auth::user()->agencyID)->select('agencyID')->select('brancheID')->get()->toArray())->count();
    $managerCount = Garagist::whereIn('brancheID', Branche::where('agencyID', Auth::user()->agencyID)->select('agencyID')->select('brancheID')->get()->toArray())->count();
    $reviews = Booking::where('vehiculeComment', '<>', null)->join('vehicules', 'bookings.vehiculePlateNb', '=', 'vehicules.plateNb')
      ->join('garages', 'vehicules.garageID', '=', 'garages.garageID')->join('users', 'bookings.clientUsername', '=', 'users.username')
      ->whereIn('garages.brancheID', Branche::where('agencyID', Auth::user()->agencyID)->select('agencyID')->select('brancheID')->get()->toArray())
      ->select(['firstName', 'lastName', 'vehiculeRating', 'vehiculeComment', 'commentDate', 'model', 'brand', 'faceIdPath', 'state'])->latest('commentDate')->limit(5)->get();
    // dd($reviews);
    return view('owners.ownerHome', [
      'Request' => AgencyRequest::where('ownerUsername', Auth::user()->username)->first(),
      'branches' => $branchesWithCount,
      'resPerDay' => $reservationsPerDay,
      'dates' => $dates,
      'moneyPerBranch' => $branchesWithTotalMoney,
      'branchCount' => Branche::where('agencyID', Auth::user()->agencyID)->count(),
      'garageCount' => $garageCount,
      'pulCount' => $pulCount,
      'secCount' => $secCount,
      'managerCount' => $managerCount,
      'reviews' => $reviews,
      'pickUpLocationsCount' => $pickUpLocationsCount,
      'mostRentedCars'=> $mostRentedCars
    ]);
  }
  public function create(Request $request)
  {
    $request->validate(
      [
        'username' => 'required|unique:owners,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        'email' => 'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'required|same:password',
        'idCard' => 'required|digits_between:18,18|numeric',
        'idCardImage' => 'required|mimes:jpg,jpeg,png|max:5048',
      ],
      [
        'idCard.required' => 'The identity card number is required.',
        'idCard.digits_between' => 'The identity card number has to be 18 number long.',
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'password.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'idCardImage.required' => 'The identity card image is required.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );

    $newImageName = $request->username . '.' . $request->idCardImage->extension();
    $request->idCardImage->move(public_path('images/owners/idCardImages'), $newImageName);



    $owner = new Owner();
    $owner->username = $request->username;
    $owner->password = Hash::make($request->password);
    $owner->firstName = $request->firstName;
    $owner->lastName = $request->lastName;
    $owner->address = $request->address;
    $owner->birthDate = $request->birthDate;
    $owner->idCard = $request->idCard;
    $owner->email = $request->email;
    $owner->phoneNumber = $request->phoneNumber;
    $owner->idCardPath = $newImageName;

    $save = $owner->save();

    if ($save) {
      return redirect()->back()->with('success', 'you are now registered successfully');
    } else {
      return redirect()->back()->with('fail', 'registration failed');
    }
  }

  public function check(Request $request)
  {
    $request->validate([
      'username' => 'required|exists:owners,username',
      'password' => 'required|min:6'
    ]);
    $creds = $request->only('username', 'password');

    if (Auth::guard('owner')->attempt($creds)) {
      return redirect()->route('owner.home');
    } else {
      return redirect()->route('workerLogin')->with('fail', 'incorrect creds');
    }
  }
  public function logout()
  {
    session()->flush();
    Auth::guard('owner')->logout();
    return redirect()->route('workerLogin');
  }

  public function addEmployeePage()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    return view('owners.addEmployee', ['branches' => Branche::where('agencyID', Auth::user()->agencyID)->get()]);
  }
  public function addEmployee(Request $request)
  {
    //validation
    $request->validate(
      [
        'username' => 'required|unique:secretaries,username|unique:garagemanagers,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        'email' => 'required|email|unique:users,email,|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'required|same:password',
        'branche' => 'required',
      ],
      [
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'password.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
      ]
    );
    //-validation

    //creating the employe
    if ($request->empType == 'G') {
      $garagist = new Garagist();
      $garagist->username = $request->username;
      $garagist->password = Hash::make($request->password);
      $garagist->firstName = $request->firstName;
      $garagist->lastName = $request->lastName;
      $garagist->email = $request->email;
      $garagist->address = $request->address;
      $garagist->birthDate = $request->birthDate;
      $garagist->brancheID = $request->branche;
      $garagist->save();
      return redirect()->route('owner.addEmployee')->with('message', 'You successfully added a new garage manager!');
    }
    if ($request->empType == 'S') {
      $secretary = new Secretary();
      $secretary->username = $request->username;
      $secretary->password = Hash::make($request->password);
      $secretary->firstName = $request->firstName;
      $secretary->lastName = $request->lastName;
      $secretary->email = $request->email;
      $secretary->address = $request->address;
      $secretary->birthDate = $request->birthDate;
      $secretary->brancheID = $request->branche;
      $secretary->save();
      return redirect()->route('owner.addEmployee')->with('message', 'You successfully added a new secretary!');
    }
  }


  public function showProfile()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $agency=Agency::find(Auth::user()->agencyID);
    return view('owners.editProfile')->with('agency',$agency);
  }


  public function editProfile(Request $request)
  {

    $request->validate(
      [
        ($request->username == Auth::user()->username) ?: 'username' => 'unique:owners,username|min:4|alpha_num|max:15',
        'lastName' => 'required|alpha|max:25',
        'firstName' => 'required|alpha|max:25',
        'birthDate' => 'required|date',
        'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
        ($request->email == Auth::user()->email) ?: 'email' => 'email|unique:users,email|unique:admins,email|unique:garagemanagers,email|unique:secretaries,email|unique:owners,email',
        ($request->phone == '') ?: 'phone' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/'],
        ($request->newPassword == '') ?: 'newPassword' => 'min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'passwordConfirm' => 'same:newPassword',
        'idCard' => 'required|digits_between:18,18|numeric',
        'currentPassword' => 'required|current_password:owner'
      ],
      [
        'idCard.required' => 'The identity card number is required.',
        'idCard.digits_between' => 'The identity card number has to be 18 number long.',
        'address.regex' => 'The address can only contain letters, numbers and spaces.',
        'newPassword.regex' => 'The password must contain at least 1 uppercase letter,1 lowercase letter and 1 number.',
        'phone.digits_between' => 'The number must be made of 10 digits',
      ]
    );


    $owner = Owner::where('username', Auth::user()->username)->first();
    $owner->username = $request->username;
    $owner->firstName = $request->firstName;
    $owner->lastName = $request->lastName;
    $owner->birthDate = $request->birthDate;
    $owner->address = $request->address;
    $owner->email = $request->email;
    if ($request->newPassword != '') {
      $owner->password = Hash::make($request->newPassword);
    }
    $owner->idCard = $request->idCard;
    if ($request->phone != '') {
      $owner->phoneNumber = $request->phone;
    }
    $owner->save();

    return redirect()->route('owner.editProfile')->with('message', 'Settings updated successfully');
  }


  public function showReclamations()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $complaints = Complaint::where('recepient', Auth::user()->username)->latest()->paginate(25);;
    return view('owners.reclamation', ['list' => $complaints]);
  }
  public function reclamation($id)
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $complaint = Complaint::where('id', $id)->first();
    $sender = User::where('username', $complaint->sender)->first();
    return view('owners.reclamationDetails', ['reclamation' => $complaint, 'sender' => $sender]);
  }
  public function answerReclamation(Request $request, $id)
  {
    $complaint = Complaint::where('id', '=', $id)->first();
    $complaint->response = $request->response;
    $complaint->save();
    return redirect()->route('owner.reclamation', $complaint->id)->with('message', 'Your response successfully sent to the user');
  }

  public function branches()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }

    $branches = Branche::where('agencyID', Auth::user()->agencyID)->get();

    return view('owners.branchesList', ['branches' => $branches]);
  }
  public function createBranchPage()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }

    $branches = Branche::where('agencyID', Auth::user()->agencyID)->get();
    return view('owners.addBranch');
  }
  public function createBranch(Request $request)
  {
    $request->validate([
      'region' => 'required|alpha',
      'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/'
    ]);

    $branch = new Branche();
    $branch->agencyID = Auth::user()->agencyID;
    $branch->region = $request->region;
    $branch->address = $request->address;
    $branch->save();

    return redirect()->route('owner.showBranches')->with('message', 'Branch added successfully!');
  }
  public function showBranch($id)
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $branch = Branche::where('brancheID', $id)->first();

    if ($branch->agencyID != Auth::user()->agencyID) {
      return redirect()->route('owner.home');
    }
    $secretaries = Secretary::where('brancheID', $id)->latest()->paginate(25);

    $garagists = Garagist::where('brancheID', $id)->latest()->paginate(25);


    return view('owners.brancheDetails', ['branch' => $branch, 'secretaries' => $secretaries, 'garagists' => $garagists]);
  }
  public function deleteBranch($id)
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $branch = Branche::where('brancheID', $id)->first();
    if ($branch->agencyID != Auth::user()->agencyID) {
      return redirect()->route('owner.home');
    }

    Branche::where('brancheID', $id)->delete();
    return redirect()->route('owner.showBranches')->with('alert', 'Branch deleted successfully');
  }
  public function employeesList()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }

    $secretaries = DB::table('owners')->where('owners.username', Auth::user()->username)->join('branches', 'owners.agencyID', '=', 'branches.agencyID')
      ->join('secretaries', 'branches.brancheID', '=', 'secretaries.brancheID')->orderBy('secretaries.created_at')->paginate(25);

    $garagists = DB::table('owners')->where('owners.username', Auth::user()->username)->join('branches', 'owners.agencyID', '=', 'branches.agencyID')
      ->join('garagemanagers', 'branches.brancheID', '=', 'garagemanagers.brancheID')->latest()->paginate(25);

    return view('owners.employeesList', ['list' => $secretaries, 'glist' => $garagists]);
  }
  public function getSecUsername($id, Request $request)
  {
    if ($request->ajax()) {
      return Secretary::where('id', $id)->first();
    }
  }
  public function getGarUsername($id, Request $request)
  {
    if ($request->ajax()) {
      return Garagist::where('id', $id)->first();
    }
  }
  public function deleteSec(Request $request)
  {
    $sec = Secretary::where('username', $request->username)->first();

    $sec->delete();
    return redirect()->route('owner.employeesList')->with('message', 'Secretary deleted successfully');
  }
  public function deleteGar(Request $request)
  {
    $sec = Garagist::where('username', $request->username)->first();

    $sec->delete();
    return redirect()->route('owner.employeesList')->with('message', 'Garage manager deleted successfully');
  }
  public function getSecTransfer($id, Request $request)
  {
    if ($request->ajax()) {
      $sec = Secretary::where('id', $id)->first();
      $agencyID = Branche::where('brancheID', $sec->brancheID)->first('agencyID')->agencyID;
      $branchList = Branche::where('agencyID', $agencyID)->where('brancheID', '!=', $sec->brancheID)->get(['brancheID', 'region']);
      return [$branchList, $sec];
    }
  }
  public function secTransfer(Request $request)
  {
    $secretary = Secretary::where('username', $request->username)->first();
    $secretary->brancheID = $request->branche;
    $secretary->save();
    return redirect()->route('owner.employeesList')->with('message', 'Secretary transfered successfully');
  }

  public function getGarTransfer($id, Request $request)
  {
    if ($request->ajax()) {
      $gar = Garagist::where('id', $id)->first();
      $agencyID = Branche::where('brancheID', $gar->brancheID)->first('agencyID')->agencyID;
      $branchList = Branche::where('agencyID', $agencyID)->where('brancheID', '!=', $gar->brancheID)->get(['brancheID', 'region']);
      return [$branchList, $gar];
    }
  }
  public function garTransfer(Request $request)
  {
    $garagist = Garagist::where('username', $request->username)->first();

    $garagist->brancheID = $request->branche;
    $garagist->save();
    return redirect()->route('owner.employeesList')->with('message', 'Garage manager transfered successfully');
  }

  public function garages()
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }

    $garages = DB::table('garages')->join('branches', 'garages.brancheID', '=', 'branches.brancheID')->where('branches.agencyID', Auth::user()->agencyID)->join('garagemanagers', 'garages.garageManagerUsername', '=', 'garagemanagers.username')->get();
    return view('owners.garages', ['garages' => $garages]);
  }

  public function loadForm()
  {
    $avGMs = Garagist::join('branches', 'garagemanagers.brancheID', '=', 'branches.brancheID')->where('agencyID', Auth::user()->agencyID)->get();
    return [Branche::where('agencyID', Auth::user()->agencyID)->get(), $avGMs];
  }

  public function availableGaragists($brancheID)
  {
    $garagists = Garagist::where('brancheID', $brancheID)->whereNotIn('username', Garage::select('garageManagerUsername')->get())->get();
    return $garagists;
  }
  public function addGarage(Request $request)
  {
    $request->validate([
      'address' => 'required|regex:/(^[a-zA-Z0-9 ]+$)+/',
      'capacity' => 'required|numeric',
      'branche' => 'required|exists:branches,brancheID',
      'manager' => 'required|exists:garagemanagers,username'
    ]);
    $garage = new Garage();
    $garage->address = $request->address;
    $garage->capacity = $request->capacity;
    $garage->brancheID = $request->branche;
    $garage->garageManagerUsername = $request->manager;

    $garage->save();

    return redirect()->route('owner.showGarages')->with('success', 'Garage added successfully');
  }

  public function garageDetails($id)
  {
    if (is_null(Auth::user()->agencyID)) {
      return redirect()->route('owner.home');
    }
    $garage = Branche::join('garages', 'branches.brancheID', '=', 'garages.brancheID')->where('garageID', $id)->first();
    $garagist = Garagist::where('username', $garage->garageManagerUsername)->first();
    $cars = Vehicule::where('garageID', $id)->get();
    $AVgaragists = Garagist::where('brancheID', $garage->brancheID)->whereNotIn('username', Garage::select('garageManagerUsername')->get())->get();
    return view('owners.garageDetails', ['garage' => $garage, 'garagist' => $garagist, 'cars' => $cars, 'avGaragists' => $AVgaragists]);
  }
  public function deleteGarage($id)
  {
    $garage = Garage::where('garageID', $id);
    $garage->delete();
    return redirect()->route('owner.showGarages')->with('message', 'Garage deleted successfully');
  }

  public function changeManager(Request $request)
  {
    $request->validate([
      'manager' => 'required'
    ]);
    $garage = Garage::where('garageID', $request->garageID)->update(['garageManagerUsername' => $request->manager]);


    return redirect()->route('owner.garageDetails', $request->garageID)->with('message', 'Garage manager changed successfully');
  }
  public function changeImage(Request $request)
  {
      $folderPath = public_path('images/owners/profile');

      $image_parts = explode(";base64,", $request->image);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $file = $folderPath . uniqid() . '.png';

      file_put_contents('images/owners/profile/'.Auth::user()->username."_profile.png", $image_base64);
      Owner::find(Auth::user()->id)->update(['profilePath'=>Auth::user()->username."_profile.png"]);
      return response()->json(['success'=>'success']);
  }
}
