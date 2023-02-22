<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\trait\ResponceApiTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/articles',[ArticleController::class,'index']);
Route::post('/article/create',[ArticleController::class,'create']);
Route::get('/article/list',[ArticleController::class,'list']);
Route::post('/article/update/{id}',[ArticleController::class,'update']);
Route::delete('/article/delete/{id}',[ArticleController::class,'delete']);