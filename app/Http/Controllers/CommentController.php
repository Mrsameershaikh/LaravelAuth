<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Validator;

class CommentController extends Controller
{
    //
    public function create($post_id, Request $request)
    {
        $post=Post::where('post_id',$post_id)->first();
        if($post)
        {
            $validator=Validator::make($request->all(),[
                'message'=>'required',
            ]);

            if($validator->fails())
            {
                return response()->json($validator->errors(), 400);
            }
            $comment=Comment::create([
                'message'=>$request->message,
                'post_id'=>$post->post_id,
                'user_id'=>$request->user()->id
            ]);
            $comment->load('user');
            return response()->json([
                'message'=>'Comment succefully created',
                'data'=>$comment
            ],200);
        }
        else{
            return response()->json([
                'message'=>'No post found',
            ],400);
        }
    }
}
