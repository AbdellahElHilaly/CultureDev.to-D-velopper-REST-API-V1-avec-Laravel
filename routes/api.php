<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RoleController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('api.login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::post('sendPasswordResetLink', [ResetPasswordController::class, 'sendEmail']);

Route::get('role-test', function(Request $request){
    return response()->json([
        'status' => 'success',
        'redirect' => false,
        'user' => [
            'name' => $request->user()->name,
            'role' => $request->user()->role->name,
            'all' => $request->user(),
        ]
    ]);
})->middleware('role:admin');

Route::get('role', [RoleController::class, 'notAuth'])->name('auth.role');
