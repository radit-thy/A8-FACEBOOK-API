<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="Register",
     *     tags={"Register"},
     *     summary="Register a new user",
     *     description="User Register here",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string", format="password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent()
     *     )
     * )
     */

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        
        $success['token'] = $user->createToken('authToken')->accessToken;
        $success['name'] = $user->name;
        
        return response()->json(['success' => $success], 201);
    }


     //  Login API
        /**
        * @OA\Post(
        *     path="/api/login",
        *     operationId="loginUser",
        *     tags={"Login"},
        *     summary="Login a user",
        *     description="User Login Endpoint",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *             mediaType="multipart/form-data",
        *             @OA\Schema(
        *                 type="object",
        *                 required={"email","password"},
        *                 @OA\Property(property="email",type="text"),
        *                 @OA\Property(property="password",type="password"),
        *             ),
        *         ),
        *     ),
        *     @OA\Response(
        *         response="201",
        *         description="User Login Successfully",
        *         @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *       response="200",
        *       description="Login Successfull",
        *       @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *         response="422",
        *         description="Unprocessable Entity",
        *         @OA\JsonContent()
        *     ),
        *     @OA\Response(
        *         response="400",
        *         description="Bad Request",
        *         @OA\JsonContent()
        *     ),
        * )
        */
        public function login(Request $request){
            $validated = $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
        
            if (!auth()->attempt($validated)) {
                return response()->json(["error" => "Invalid credentials"], 401);
            } else {
                $success['token'] = auth()->$user()->createToken('authToken')->accessToken;
                $success['user'] = auth()->$user();
        
                return response()->json(["success" => $success], 200);
            }
        }
}
