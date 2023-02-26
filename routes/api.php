<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\EditProfileController;
// use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ArticleController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ------------
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('api.login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
// Route::post('sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);

Route::post('role-test', function(Request $request){
    return response()->json([
        'status' => 'success',
        'redirect' => false,
        'user' => [
            'name' => $request->user()->name,
            'role' => $request->user()->role->name,
            'all' => $request->user(),
        ]
    ]);
})->middleware('role:guest');

Route::get('role', [RoleController::class, 'notAuth'])->name('auth.role');

Route::post('forgot-password', [RestPasswordController::class, 'forgetPassword'])->name('password.request');
Route::post('/reset-password/{token}', [RestPasswordController::class, 'resetPassword'])->name('password.reset');
//--------------

Route::controller(EditProfileController::class)->group( function() {
    Route::get('edit','edit');
    Route::post('update','update');
    });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::apiResource('articles', ArticleController::class);
Route::post('articles/filter', [ArticleController::class, 'filter']);


Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);

Route::controller(CommentController::class)->group( function() {
    Route::get('all', 'index');
    Route::post('storecomment', 'StoreComment');
    Route::get('findcomment/{id}', 'FindComment');
    Route::delete('deletecomment/{id}', 'DeleteComment');
});




