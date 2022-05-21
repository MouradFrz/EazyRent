<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
  public function mapofstore($id)
  {
    $data = DB::Table('pickUpLocations')->select('address_longitude', 'address_latitude')->where('id', $id)->get();
    // dd($data);

    return view('MainAdmin.frontend.reports.storelocation', compact('data'));
  }
}
