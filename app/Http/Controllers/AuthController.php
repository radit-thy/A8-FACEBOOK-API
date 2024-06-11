<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function login(Request $request){
        $request->validate([
            "email"=>'required',
            "password" => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response([
                'message'=>'User not found',
                'success'=>false,

            ]);
        }

        if(Hash::check($request->password, $user->password)){
            $access_token = $user->createToken('authToken')->plainTextToken;
            return response([
                'message'=>'Login successful',
                'success'=>true,
                'user'=>$user,
                'access_token'=>$access_token,

            ]);
        }
        
    }
}
