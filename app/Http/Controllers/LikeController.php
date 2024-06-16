<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use App\Models\Post;
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

        // Retrieve the post details
        $post = Post::find($request->post_id);

        // Return the response with the like and post details
        return response()->json([
            'like_details' => [
                'user_id' => $like->user_id,
                'post_id' => $like->post_id,
            ],
            'postDetails' => [
                'post_title' => $post->title,
                'post_description' => $post->description
            ],
            'message' => 'Like successful',
        ], 201);
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
        // show the post details
        $post = Post::find($request->post_id);

        // Return the response with the like and post details
        return response()->json([
            'Unlike_details' => [
                'user_id' => $like->user_id,
                'post_id' => $like->post_id,
            ],
            'postDetails' => [
                'post_title' => $post->title,
                'post_description' => $post->description
            ],
            'message' => 'Unlike successful'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    // ==============================================
                // show like details
    // ==============================================
    public function showLike(Request $request, $post_id)
    {
        // Validate the post_id
        $post = Post::find($post_id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        // Retrieve likes for the post with user details
        $likes = Like::where('post_id', $post_id)->with('user:id,name')->get();
        // Extract user id and name from the likes
        $userLikes = $likes->map(function ($like) {
            return [
                'user_id' => $like->user->id,
                'user_name' => $like->user->name
            ];
        });
        // Count the number of likes
        $likeCount = $likes->count();

        // Return the list of users who liked the post and the count of likes
        return response()->json([
            'count_of_like' => $likeCount,
            'users' => $userLikes,
            'message' => 'Show like successful'

        ]);
    }
}
