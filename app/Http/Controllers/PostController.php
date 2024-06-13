<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    public function create(Request $request, Post $post)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;
        $post->save();
        return response()->json(["success"=>true, "data"=>$post],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $update = Post::find($request->id);
        $update->update($request->all());
        return response($update);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Post::find($id);
        $delete->delete();
        return response($delete);
    }

    //.............................show all post ...........................................
    public function getpost(Request $request, string $id){
        $user = $request->user();
        if ($user) {
            $post = Post::where('user_id', $user->id)->get();
            for($i=0; $i<count($post); $i++) {
                if($post[$i]->id == $id){
                    return response()->json(["success"=>true, "data"=>$post[$i]],200);
                }
                
                };
            return response()->json(['message' => 'Post id not found'], 500);
        } else {
            return response()->json(['message' => 'User not authenticated'], 500);
        }
    }
    
    //.............................show all post of each user...........................................
   
    public function postlist(String $id){
       
        $post = Post::where('user_id', $id)->get();
        if(count($post) == 0){
            return response()->json(['message' => 'user id not found'], 500);
        }
        return response()->json(["success"=>true, "data"=>$post],200);
    }
}
