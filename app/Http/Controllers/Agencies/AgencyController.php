<?php

namespace App\Http\Controllers\Agencies;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Owner;
use App\Models\AgencyRequest;
use App\Models\PickUpLocation;
use App\Models\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Psy\Readline\Hoa\ConsoleTput;

class AgencyController extends Controller
{
  public function create(Request $request)
  {
    $request->validate([
      'agencyName' => 'required|unique:agencyrequests,name|max:45',
      'commercialRegisterNb' => 'required|unique:agencyrequests,registeryNb|unique:agencies,registeryNb',
      'registrationDate' => 'required',
      'agencyCreationYear' => 'required|digits:4|integer|max:' . (date('Y') + 1),
      'password' => 'required|current_password:owner',
      'logo'=>'required'
    ], [
      'agencyName.required' => 'This field is required',
      'commercialRegisterNb.required' => 'This field is required',
      'commercialRegisterNb.unique' => 'This register number is already been used',
      'registrationDate.required' => 'This field is required',
      'agencyCreationYear.required' => 'This field is required',
      'agencyCreationYear.digits' => 'please enter a valide year value',
      'agencyCreationYear.integer' => 'please enter a valide year value',
      'agencyCreationYear.max' => 'please enter a valide year value',
      'password.required' => 'This field is required',
      'password.current_password' => 'password incorrect',
    
    ]);
    

    

    $requestSent = AgencyRequest::where('ownerUsername', Auth::user()->username)->get();

    if (Auth::user()->agencyID) {
      return response()->json([
        'error' => 'This owner already has an agency.',
      ]);
    } else if (count($requestSent) == 1) {
      return response([
        'error' => 'u already have a request . WAIT ',
      ]);
    } else {
      $agency = new AgencyRequest();

      $agency->ownerUsername = Auth::user()->username;
      $agency->name = $request->agencyName;
      $agency->registeryNb = $request->commercialRegisterNb;
      $agency->registrationDate = $request->registrationDate;
      $agency->creationYear = $request->agencyCreationYear;
      
      $agency->save();
      
      $newImageName = $agency->requestID . '.' . $request->logo->extension();
      $request->logo->move(public_path('images/agencies/logos'), $newImageName);
      $agency->logo = $newImageName;
      $agency->save();

      return redirect()->route('owner.home');
    }
  }
  public function getJoiningRequests()
  {
    $joiningRequests = AgencyRequest::where('state', 'ON GOING')->latest()->paginate(25);
    // dd($joiningRequests);
    return view('admin.joiningRequests', ['joiningRequests' => $joiningRequests]);
  }
  public function getAgencies()
  {
    // $agencies = Agency::latest()->paginate(25);
    $agencies = Agency::join('owners', 'agencies.AgencyId' , '=', 'owners.AgencyId')->latest()->paginate(25);
    return view('admin.agenciesList', ['agencies' => $agencies]);
  }

  public function acceptAgency($id)
  {
    AgencyRequest::where('requestID', $id)->update([
      'state' => 'ACCEPTED',
      'adminUsername' => Auth::user()->username,
    ]);
    // agecny creation after accept
    $acceptedAgency = AgencyRequest::find($id);
    $agency = new Agency();

    $agency->name = $acceptedAgency->name;
    $agency->registeryNb = $acceptedAgency->registeryNB;
    $agency->registrationDate = $acceptedAgency->registrationDate;
    $agency->creationYear = $acceptedAgency->creationYear;
    $agency->created_at = now();
    $agency->logo= $acceptedAgency->logo;
    $agency->save();
    // dd($agency);


    Owner::where('username',$acceptedAgency->ownerUsername)->update(['agencyID'=>$agency->agencyID]);
    
  
  

    return redirect()->route('admin.joiningRequests')
    ->with('message','You successfully added a new agency!');
  }
  public function refuseAgency($id)
  {
    AgencyRequest::where('requestID', $id)->update([
      'state' => 'REFUSED',
      'adminUsername' => Auth::user()->username,
    ]);
    return redirect()->route('admin.joiningRequests');
  }

  public function getPickUpLocations() {
    $brancheID = secretary::where('username', Auth::user()->username)->first()->brancheID;
    $pickUpLocations = PickUpLocation::where('brancheID', $brancheID)->get();
    // return redirect()->route('secretary.getPickUpLocations')
    // ->with('pickUpLocations', $pickUpLocations);
    return view('secretaries.pickUpLocations', ['pickUpLocations' => $pickUpLocations]);
  }
  public function addPickUpLoaction(Request $request) {

    $request->validate([
      'address_address'=>'required|min:10'
    ]);


    $brancheID = secretary::where('username', Auth::user()->username)->first()->brancheID;
    $PickUpLocation = new PickUpLocation();
    $PickUpLocation->brancheID = $brancheID;
    $PickUpLocation->added_by = Auth::user()->username;
    $PickUpLocation->address_address = $request->address_address;
    $PickUpLocation->address_longitude = $request->address_longitude;
    $PickUpLocation->address_latitude = $request->address_latitude;
    $PickUpLocation->created_at = now();
    $save = $PickUpLocation->save();

    if($save) {
      return redirect()->route('secretary.getPickUpLocations')
      ->with('success','You successfully added a new pick up location!');
    }else {
      return redirect()->route('secretary.getPickUpLocations')
      ->with('failed','added a new pick up location has been failed');
    }
  }
}
