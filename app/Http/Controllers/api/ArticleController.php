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

    public function update(Request $request, $id){
        $article = Article::with(['user','category'])->where('id',$id)->first();
        if($article){
            // if($article->user_id == auth()->user()->id){ for update just her article
                $validator =Validator::make($request->all(), [
                    'title'=>'required|max:255',
                    'description' =>'required ',
                    'content'=>'required ',
                    'category_id'=>'required ',
                ]);
                if($validator->fails()){
                    return response()->json([
                        'message' => 'validation errors',
                        'errors' =>$validator->messages()
                    ],422);
                }
                $article ->update([
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'content'=>$request->content,
                    'category_id'=>$request->category_id,
                ]);
                return response()->json([
                    'message'=>'Article update Successfuly',
                    'data'=>$article
                ],200);


            // }else{
            //     return response()->json([
            //         'message'=>'access denied',
            //     ],400);
            // }


        }else{
            return response()->json([
            'message'=>"Article Not Found",
            ],400);
        }






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
