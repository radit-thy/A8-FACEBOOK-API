<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

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

    
}
