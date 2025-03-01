<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\userlogin;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
  
    public function Userdetails(Request $request){

        $user=$request->user();

        return apiresponse(200,'user details',  UserResource::make($user) );

    }
    public function login(userlogin $request){
        $user=User::where('email',$request->email)->first();
        if ( !$user  || ! Hash::check($request->password,$user->password)) {
   return response()->json(['massage'=>'imvaled creadtion']);
   
        }
    
        $token = $user->createToken('User-token')->plainTextToken;
        return response()->json(['token'=> $token]);
    }
    public function regster(UserRequest $reques){

       if (!$reques->hasFile('image')) {
        $user= User::create([
            'name'=>  $reques->name,
            'password'=>  $reques->password,
            'email'=>  $reques->email,
            'verification_token' => str::random(32),
        
                    ]);
       }
           
 
        if ($reques->hasFile('image')) {
            $file=$reques->image;
            $filename = Str::random().time().$file->getClientOriginalExtension();
            $path = $file->storeAs('',$filename ,['disk'=>'users'] );
            $user= User::create([
                'name'=>  $reques->name,
                'password'=>  $reques->password,
                'email'=>  $reques->email,
                'verification_token' => str::random(32),
                'image'=> $filename,
              
                        ]);
           
        
        }
            
       
        Mail::to($user->email)->send(new VerifyEmail($user));

  if ($user) {
    $token=  $user->createToken('User-token')->plainTextToken;
   return apiresponse(200,'user create sucess',['token'=> $token]);
  }
  return apiresponse(500,'fail create user');
    }
    public function logout(Request $request)
    {
        // Revoke the current user's token (For Sanctum)
        $request->user()->currentAccessToken()->delete();

        return apiresponse(200,'Logged out successfully');
    }
}
