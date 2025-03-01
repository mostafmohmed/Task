<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthgoogleController extends Controller
{
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user exists
        $user = User::where('email', $googleUser->email)->first();
        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt(str()->random(16)), // Set random password
            ]);
        }
        $token = $user->createToken('User-token')->plainTextToken;
        return response()->json(['token'=> $token]);



    }
    public function redirectToGoogle(Request $request){
        $Socialite= Socialite::driver('google')->redirect();
        return   response()->json(['link_coogle'=>$Socialite]) ;

    }
}
