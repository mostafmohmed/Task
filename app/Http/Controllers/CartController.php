<?php

namespace App\Http\Controllers;

use App\Models\Produect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request){
        $ids = explode(',', $request->query('ids'));
        $Produects = Produect::whereIn('id', $ids)->get();

        // if ( !$Produects) {
        //    return apiresponse(404,'not found produect');
        // }
        if ($Produects==[] ) {
            return apiresponse(404,'not found produect', $Produects);
        }
        
        
  foreach($Produects as $k=> $Produect ){
    if ($Produect->quantity==0) {
      return apiresponse(404,' not available in stock');
    }
    Cart::add(['id' =>  $Produect->id, 'name' =>app()->getLocale()=='en'? $Produect->name_en:$Produect->name_ar, 'qty' => 1, 'price' => $Produect->price]);
  }
  return apiresponse(200,'add produect sucess');
    }
    public function get(){
        $cart=Cart::content();
        return apiresponse(200,'add produect sucess',  $cart);
    }
    
}
