<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\trait\ResponceApiTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('categories' , CategoryController::class);
Route::delete('categories', [CategoryController::class, 'destroyAll']);

Route::apiResource('tags' , TagController::class);
Route::delete('tags', [TagController::class, 'destroyAll']);


<<<<<<< HEAD
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/article/create',[ArticleController::class,'create']);
Route::get('/article/list',[ArticleController::class,'list']);
Route::post('/article/update/{id}',[ArticleController::class,'update']);
Route::delete('/article/delete/{id}',[ArticleController::class,'delete']);
=======
>>>>>>> CDR-10
