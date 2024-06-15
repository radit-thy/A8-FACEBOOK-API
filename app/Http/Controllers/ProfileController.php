<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProfileRescource;
use App\Models\User;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $users = UserResource::collection(User::all());
        foreach ($users as $user) {
            if ($user->id == $id) {
                return response()->json([
                    "message" => "view profile successfully",
                    "success" => true,
                    "data" => $user,
                ]);
            }
        };
        return response()->json(['message' => 'User id not found'], 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProfileRequest $request)
    {
        $userId = $request->user()->id;
        $user = Profile::where('user_id', $userId)->first();
        if ($user) {
            return response([
                'message' => 'User already exists',
                'success' => false,
            ]);
        }
        $image = Str::random(30) . "." . $request->image->getClientOriginalExtension();

        $pl = Profile::create([
            'image' => $image,
            'user_id' => $userId
        ]);

        Storage::disk('public')->put($image, file_get_contents($request->image));

        return response()->json([
            'message' => 'upload profile already',
            'success' => true,
            'data' => $pl,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(ProfileRequest $request)
    {
        $image = Str::random(30) . "." . $request->image->getClientOriginalExtension();
        $userId = $request->user()->id;
        $user = Profile::where('user_id', $userId)->first();
        if ($user) {
            $profileAcc = Profile::find($userId);
            $profileAcc->update([
                'image' => $image,
            ]);
            Storage::disk('public')->put($image, file_get_contents($request->image));
            return response()->json([
                'message' => 'update profile',
                'success' => true,
                'data' => $profileAcc,
            ]);
        }

        return response()->json([
           'message' => 'update profile not found',
           'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
