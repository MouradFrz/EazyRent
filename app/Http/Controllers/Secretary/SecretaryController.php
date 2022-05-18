<?php

namespace App\Http\Controllers\Secretary;

use App\Models\Vehicule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecretaryController extends Controller
{
    function check(Request $request) {
        //validation
        $request->validate([
            'username'=>'required|exists:secretaries,username',
            'password'=>'required'
        ],[
            'username.exists' => 'This username does not exist.'
        ]
        );
        $creds = $request->only('username','password');

        if(Auth::guard('secretary')->attempt($creds)){
            return redirect()->route('secretary.home');
        }else{
            return redirect()->route('workerLogin')->with('fail','The credentials you entered are wrong');
        }
    }
    public function logout(){
        Auth::guard('secretary')->logout();
        return redirect()->route('workerLogin');
    }
    function create(Request $request){

        //vehiculeeeee
        $newCarName =$request->brand.$request->model.'.'.$request->imagePath->extension();
        $request->imagePath->move(public_path('images/vehicules/imagePaths'),$newCarName);
       
            $vehicule = new Vehicule();
            $vehicule->plateNb=$request->plateNb;
            $vehicule->brand=$request->brand;
            $vehicule->model=$request->model;
            $vehicule->type=$request->type;
            $vehicule->color=$request->color;
            $vehicule->year=$request->year;
            $vehicule->fuel=$request->fuel;
            $vehicule->gearType=$request->gearType;
            $vehicule->doorsNb=$request->doorsNb;
            $vehicule->horsePower=$request->horsePower;
            $vehicule->airCooling=$request->airCooling;
            $vehicule->physicalState=$request->physicalState;
            $vehicule->rating=$request->rating;
            $vehicule->category=$request->category;
            $vehicule->pricePerHour=$request->pricePerHour;
            $vehicule->pricePerDay=$request->pricePerDay;
            $vehicule->garageID=$request->garageID;
            $vehicule->imagePath=$request->imagePath;

            $vehicule->save();
            return redirect()->route('secretary.addVehicule')->with('message','Vehicule added successfully');
        }
       
}
   

    
       
    

