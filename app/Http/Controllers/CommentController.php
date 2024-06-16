<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->save();
        return response()->json(["success"=>true, "data"=>$comment],200);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update (Request $request){
        $comments = Comment::all();
        for($i=0;$i<count($comments);$i++){
            if($comments[$i]->id == $request->id){
                $commentUpdate = $comments[$i]->update([
                    'body' => $request->body,
                ]);
                return response()->json([
                    "message"=>"Updated successfully",
                    "success" => true,
                    "comment"=>$comments[$i]
                ]);
            }
        }
        return response()->json([
            "message"=>"The id not found",
            "success" => false,
        ]);
        // return $comments;
         
     
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Comment::find($id);
        if($delete){
            $delete->delete();
            return response()->json([
                "message"=>"Delete successfully",
                "success" => true,
                "comment"=>$delete
            ]);
        }
        return response()->json([
            "message"=>"The id not found",
            "success" => false,
        ]);
    }

     
}