<?php

namespace App\Http\Controllers\Agencies;

use App\Http\Controllers\Controller;
use App\Models\AgencyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
  public function create(Request $request)
  {
    $request->validate([
      'agencyName' => 'required|unique:agencyRequests,name|alpha_num|max:45',
      'commercialRegisterNb' => 'required',
      'registrationDate' => 'required',
      'agencyCreationYear' => 'required|digits:4|integer|max:' . (date('Y') + 1),
      'password' => 'required|current_password:owner'
    ], [
      'agencyName.required' => 'This field is required',
      'commercialRegisterNb.required' => 'This field is required',
      'registrationDate.required' => 'This field is required',
      'agencyCreationYear.required' => 'This field is required',
      'password.required' => 'This field is required'
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

      // Owner::where('username',Auth::user()->username)->update([
      //     'agencyID'=>$agency->id,
      // ]);
      return redirect()->route('owner.home');
    }
  }
}
