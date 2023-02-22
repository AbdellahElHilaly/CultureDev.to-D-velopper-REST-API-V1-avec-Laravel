<?php

namespace App\Http\Controllers\api;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;


class ArticleController extends Controller
{

    public function index (){



    }
    public function create(Request $request){
        $validator =Validator::make($request->all(), [
            'title'=>'required|max:255',

            'description' =>'required ',
            'content'=>'required ',
            'category_id'=>'required ',
            'user_id'=>'required '

        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'validation errors',
                'errors' =>$validator->messages()
            ],422);
        }
        $article = Article::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'category_id'=>$request->category_id,
            'user_id'=>$request->user_id
        ]);
        $article->load('category','user');// relation
        return response()->json([
            'message'=>'Article Seved Successfuly',
            'data'=>$article
        ],200);
    }




























}
