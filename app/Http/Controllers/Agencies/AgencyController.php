<?php

namespace App\Http\Controllers\Agencies;

use App\Http\Controllers\Controller;
use App\Models\AgencyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    public function create(Request $request){
        $requestSent = AgencyRequest::where('ownerUsername',Auth::user()->username)->get();
        if(Auth::user()->agencyID){
            return response()->json([
                'error'=>'This owner already has an agency.',
            ]);
        }else if(count($requestSent)==1){
            return response([
                'error'=>'u already have a request . WAIT ',
            ]);
        }
        else{
            $agency = new AgencyRequest();

            $agency->name=$request->name;
            $agency->registeryNb=$request->registeryNb;
            $agency->ownerUsername=Auth::user()->username;

            $agency->save();

            // Owner::where('username',Auth::user()->username)->update([
            //     'agencyID'=>$agency->id,
            // ]);
            return redirect()->route('owner.home');
        }
    }
}
