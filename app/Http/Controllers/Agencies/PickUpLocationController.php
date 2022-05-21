<?php

namespace App\Http\Controllers\Agencies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickUpLocation;

class PickUpLocationController extends Controller
{
  public function store(Request $request)
{
    // abort_unless(\Gate::allows('PickUpLocantion_create'), 403);
    $PickUpLocation = PickUpLocation::create($request->all());
    return redirect()->route('secretarie.pickUpLocation');
}
}
