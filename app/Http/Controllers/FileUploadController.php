<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use Validator;
use App\Models\PostLike;

class FileUploadController extends Controller
{
    //
    public function fileUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,200',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $result=$request->file('image')->store('public/apiDocs');
        $post=new Post;
        $post->title=$request->title;
        $post->image=$request->file('image')->hashName();
        $uploadSuccess=$post->save();
        if($uploadSuccess)
        {
            return ['result'=>"Post Added"];
        }
        else
        {
            return ['result'=>"Post Not Added"];
        }
        
    }

    public function toggle_like($id, Request $request)
    {
        $post=Post::where('post_id',$id)->first();
    
        if($post)
        {
            $user=$request->user();
            $post_like=PostLike::where('post_id',$post->post_id)->
            where('user_id',$user->id)->first();
            if($post_like){
                $post_like->delete();
                return response()->json([
                    'message'=>'Like Successfully removed',

                ],200);

            }
            else{
                PostLike::create([
                    'post_id'=>$post->post_id,
                    'user_id'=>$user->id
                ]);
                return response()->json([
                    'message'=>'Post successfully liked',
                ],200);
            }
        }
        else{
            return response()->json([
                'message'=>'No blog found',
            ],400);
        }
    }
}

        
