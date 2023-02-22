<?php

namespace App\Http\Controllers\api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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





    public function delete($id){

        $article = Article::with(['user','category'])->where('id',$id)->first();
        if($article){
            $article->delete();
            return response()->json([
                'message' => 'article deleted successfuly',
                // 'data'=>$article
            ],200);
        }else{
            return response()->json([

                'message'=>'No Articles Found'
            ],400);
        }

    }





























}
