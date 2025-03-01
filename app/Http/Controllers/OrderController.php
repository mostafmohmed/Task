<?php

namespace App\Http\Controllers;
use Stripe\PaymentIntent;
use App\Http\Requests\orderrequesr;
use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;
class OrderController extends Controller
{
    public function checkout( orderrequesr $request){
        $cart=Cart::content();
        if (!$cart) {
return apiresponse(404,'not fount cart');
        }
        $totalprice=0;
        foreach ( $cart as $value) {
            $totalprice=  $totalprice+  ($value->price*$value->qty);
        }
      
   $order= Order::create([
'user_id'=>$request->user()->id,
'user_name'=>$request->user_name,
'address_name'=>$request->address_name,
'building_number'=>$request->building_number,
'total_price'=>$totalprice,
'user_phone'=>$request->user_phone,
'country'=>$request->country,
'payment_method'=>$request->payment_method,
    ]);

    ///////////////////////
    foreach ( $cart as $value) {
        OrderItem::create([ 'prodect_id'=>$value->id,	'oreder_id'=>$order->id, 	'produect_name'=>$value->name,'produect_quantity'=> $value->qty,	'produect_price'=>$value->price]);
    }
    $data=[];
$i=1;
if ($order->payment_method=='paypal') {
    foreach ( $cart as $k=> $value) {
        $data['items'][$i]= 
            [
                'name' => $value->name,
                'price' => $value->price,
                'desc'  => 'Macbook pro 14 inch',
                'qty' => $value->qty,
            ];
        
        $i++;
    }
  

    
   

    $data['invoice_id'] = 1;
    $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
    $data['return_url'] = route('payment.success');
    $data['cancel_url'] = route('payment.cancel');
    $data['total'] =  $totalprice;

    $provider = new ExpressCheckout;

    $response = $provider->setExpressCheckout($data);

    $response = $provider->setExpressCheckout($data, true);

    Cart::destroy();
    $order->update([  'status'=> 'deliverd']);
    return response()->json(['pypail_link'=>$response['paypal_link']]);
    # code...
}
   
if ($order->payment_method=='Stripe') {
    try {
        // Set your secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a PaymentIntent with the amount and currency
        $paymentIntent = PaymentIntent::create([
            'amount' => $totalprice * 100, // Amount in cents
            'currency' => 'usd',
            
        ]);
        Cart::destroy();
        $order->update([  'status'=> 'deliverd']);
        return response()->json(['clientSecret' => $paymentIntent->client_secret,'massage'=>'YYour payment was successfully.']);

    } catch (ApiErrorException $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
    # code...
}
    ///////////////////

   
        
    }
}
