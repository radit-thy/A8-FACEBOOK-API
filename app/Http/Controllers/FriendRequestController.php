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
    public function confirmFriend(Request $request, string $id)
    {
        $friend = FriendRequest::find($id);
        if($friend){
            if($friend->sender_id == $request->user()->id){
                $friend->status = 'accepted';
                $friend->save();
                return response()->json([
                   'message' => 'confirm friend successfully',
                   'success' => true,
                ]);
            }
        }

        return response()->json([
           'message' => 'confirm friend failed',
           'success' => false,
        ]);
    }



   public function deleteFriend(Request $request, string $id){
    $friend = FriendRequest::find($id);
    if($friend){
        if($friend->sender_id == $request->user()->id){
            $friend->delete();
            return response()->json([
               'message' => 'delete friend successfully',
               'success' => true,
            ]);
        }
    }

    return response()->json([
       'message' => 'delete friend failed',
       'success' => false,
    ]);
   }
   public function cancelFriend(Request $request, string $id){
    $friend = FriendRequest::find($id);
    if($friend){
        if($friend->sender_id == $request->user()->id && $friend->status != 'pending'){
            $friend->delete();
            return response()->json([
               'message' => 'delete friend successfully',
               'success' => true,
            ]);
        }
    }

    return response()->json([
       'message' => 'delete friend failed',
       'success' => false,
    ]);
   }
}
