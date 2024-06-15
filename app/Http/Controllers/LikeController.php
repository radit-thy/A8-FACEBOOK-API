<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
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
    public function likePost(Request $request, Like $like)
    {
        //
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);
        // Check if the like already exists
        $like = Like::where('post_id', $request->post_id)
            ->where('user_id', $request->user_id)
            ->first();
        if ($like) {
            return response()->json(['message' => 'Post already liked'], 200);
        }
        // Create a new like
        $like = new Like();
        $like->post_id = $request->post_id;
        $like->user_id = $request->user_id;
        $like->save();
        return response()->json(['likes' => $like, 'message' => 'Like successful'], 201);
    }

    // ==============================================
    // Unlike post
    // ==============================================
    public function UnlikePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);
        // Check if the like already exists
        $like = Like::where('post_id', $request->post_id)
            ->where('user_id', $request->user_id)
            ->first();
        if (!$like) {
            return response()->json(['message' => 'Post Unlike already'], 404);
        }
        // delete like from a post
        $like->delete();
        return response()->json(['message' => 'Unlike successful'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function showLike(Like $like, $post_id)
    {
        //
        //  // Validate the post_id
        //  if (!\App\Models\Post::find($post_id)) {
        //     return response()->json(['message' => 'Post not found'], 404);
        // }

        // // Retrieve likes for the post
        // $likes = Like::where('post_id', $post_id)->with('user')->get();

        // // Return the list of users who liked the post
        // return response()->json(['likes' => $likes]);

        // return response()->json($like);

    }

    public function show(Like $like)
    {
        //

        // return response()->json($like);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LikeRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPost(Like $like, string $id)
    {
        //

    }
}
