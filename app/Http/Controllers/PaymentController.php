<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Session;
class PaymentController extends Controller
{
public function stripe(){

return view('users.payment');    
}
public function paymentPost(Request $request)
    {
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose"
        ]);
   
        Session::flash('success', 'Payment successful!');
           
        return back();
        
    }
public function paymentSuccess(){
    return view('user.paymentSuccess');
}    
}

