<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\EditProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\CommentController;

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

