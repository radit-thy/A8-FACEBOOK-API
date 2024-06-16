<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $friends = FriendRequest::all();
        $lists = [];
        foreach ($friends as $friend) {
            if($friend->status != 'pending'){
                array_push($lists, $friend);
            }
        };
        if(count($lists) != 0){
            return response()->json([
                'message' => 'get friend successfully',
                'success' => true,
                'lists' => $lists
            ]);
        }

        return response()->json([
           'message' => 'get friend successfully',
           'success' =>false,
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function requestFriend(Request $request)
    {
        $request->validate([
            'receiver_id' =>'required'
        ]);

        $status = FriendRequest::find($request->reveiver_id);

        if($status != ''){
            $friendRequest = new FriendRequest();
            $friendRequest->sender_id = $request->user()->id;
            $friendRequest->receiver_id = $request->receiver_id;
            $friendRequest->save();
            return response()->json([
               'message' =>'request friend successfully',
               'success' => true,
            ]);
        }

        return response()->json([
           'message' =>'request friend failed',
           'success' => false,
        ]);
    }



    public function listRequest(Request $request){

        $friends = FriendRequest::all();
        $lists = [];
        foreach ($friends as $friend) {
            if($friend->status == 'pending'){
                if($friend->sender_id == $request->user()->id){
                    array_push($lists, $friend);
                }
            }
        };
        if(count($lists) != 0){
            return response()->json([
                'message' => 'get friend successfully',
               'success' => true,
                'lists' => $lists
            ]);
        };

        return response()->json([
           'message' => "You don't have friend requests",
           'success' =>false,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FriendRequest $friendRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FriendRequest $friendRequest)
    {
        //
    }
}
