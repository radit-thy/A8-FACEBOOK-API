<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $likes = Like::all();
        return $likes;
    }

    /**
     * Store a newly created resource in storage.
     */
    // ==============================================
    // like post
    // ==============================================
    public function likePost(Request $request)
    {
        //
        // $like = new Like();
        // $like->post_id = $request->post_id;
        // $like->user_id = $request->user_id;
        // $like->save();
        // return $like;

        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $like = new Like();
        $like->post_id = $request->post_id;
        $like->user_id = auth()->id(); // Take or Retrieve authenticated user's ID
        $like->save();
        return response()->json($like, 201);
    }

    // ==============================================
    // Unlike post
    // ==============================================
    public function UnlikePost(Request $request)
    {
        //
        $like = Like::where('post_id', $request->post_id)
            ->where('user_id', $request->user_id)
            ->first();
            
        if (!$like) {
            return response()->json(['message' => 'Like not found'], 404);
        }
        $like->delete();
        return response()->json(['message' => 'Unlike successful'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
