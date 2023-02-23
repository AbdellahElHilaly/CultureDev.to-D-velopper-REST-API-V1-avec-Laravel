<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    //
    
    public function StoreComment(Request $request){
       $request->validate([
        'body'=>'required', 
       ]);
        $id=Auth::user()->id;
         $body = Comment::create([
               'user_id'=>$id,
               'article_id'=>$request->article_id,
               'body'=>$request->body,
         ]);
          
        return response()->json([
            'status'=>'true',
            'comment'=>$body,
        ]);
    }
    public function FindComment($id){
        // $categories = CategoryResource::collection(Category::all());

        // $comment = CommentResource::collection(Comment::find($id));
        $comment = new CommentResource(Comment::find($id));

     return response()->json([
      'status'=> 'true',
      'comment'=> $comment,
     ]);
    }

    public function DeleteComment($id){
     $comment= Comment::find($id);
     $comment->delete();

     return response()->json([
      'status'=>'true',
      'message'=>' delete is done',
     ]);
        
    }
        
}