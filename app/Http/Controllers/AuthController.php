<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    // ======================================================
    //                 Registeration
    // ======================================================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>'required|string|max:255',
            'email'     => 'required|string|max:255|unique:users',
            'password'  => 'required|string'
          ]);

        if ($validator->fails()) {
            return response()->json(["message"=>$validator->errors()],500);
        }
        $name=$request->get("name");
        $email=$request->get("email");
        $password=$request->get("password");
        $isRegister=User::create(["name"=>$name,"email"=>$email,"password"=>$password]);
        if($isRegister){
            return response(["data"=>$isRegister,"message"=>"Register has been successfuly"],200);
        }else{
            return response(["data"=>$isRegister,"message"=>"Register is not successfuly"],500);
        }

    }

    
    
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
