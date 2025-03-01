<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class emailveryfycontroller extends Controller
{
    public function verfiy($token){
        $user = User::where('verification_token', $token)->first();
        
        if (!$user) {
            return response()->json(['message' => 'Invalid verification token'], 400);
        }
    
        $user->email_verified_at = now();
        $user->verification_token = null; // Clear the token
        $user->save();
    
        return response()->json(['verfy' => 'sucess email verify '], 400);
       }
}
