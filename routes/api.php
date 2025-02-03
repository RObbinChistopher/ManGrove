<?php

use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user-profile', [UserController::class, 'loginUser']);
    Route::post('user-profile-update', [UserController::class, 'ProfileUpdateUser']);
    Route::post('password-update', [UserController::class, 'passwordUpdate']);
    
    // users
    Route::get('users', [UserController::class, 'users']);
    Route::get('edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);

});
Route::post('/register', [UserController::class, 'register']);
Route::post('/add-password', [UserController::class, 'addPassword']);
Route::post('/send-verification-code', [UserController::class, 'sendVerificationCode']);
Route::post('/verify-code', [UserController::class, 'verifyCode']);
