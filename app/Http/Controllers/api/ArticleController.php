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
        $listArticle = Article::with(['user','category']);
         $list = $listArticle->get();
         return response()->json([
            'mesage'=>" All Articles ",
            'data'  => $list
         ] , 200);
        
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
            if($article->user_id == $id){
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




            }else{
                return response()->json([
                    'message'=>'access denied',
                ],400);
            }
                

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
    public function list(Request $request){
        $listAll  = Article::with(['user','category']);
        if($request->keyword){
            $listAll->where('name','LIKE','%'.$request->keyword.'%');

        }
        $filterByCategory= $listAll->get
      

    }

  



























}
