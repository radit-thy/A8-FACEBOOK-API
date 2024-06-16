<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request){
        $status = User::where("email", $request->email)->first();
        if($status){
            $resetStatus = resetPassword::where("email", $request->email)->first();
            if(!$resetStatus){
                $forgotPassword = new resetPassword();
                $forgotPassword->email = $request->email;
                $forgotPassword->passcode = random_int(100000, 999999);

                $forgotPassword->save();
    
                return response()->json([
                    "message"=>"code aleady send",
                    "success"=>true,
                    "You passcode"=>$forgotPassword
                ]);
            }

            $resetStatus->passcode = random_int(100000, 999999);
            $resetStatus->save();
            return response()->json([
                "message"=>"code aleady send",
                "success"=>true,
                "forgotPwd"=>$resetStatus
            ]);
            
        }

        return response()->json([
            "message"=>"email not found",
            "success"=>false
        ]);
    }
}
