<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
class paypalcontroller extends Controller
{
    public function cancel()
    {
        return response()->json(['error'=>'Your payment is canceled.']);
        
    }

    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
           
            return response()->json(['sucess'=>'YYour payment was successfully.']);
        }
        return response()->json(['error'=>'lease try again later.']);

    
    }
}
