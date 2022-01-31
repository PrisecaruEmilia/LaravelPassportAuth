<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ForgetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Login routes
Route::post('/login', [AuthController::class, 'login']);

//Register routes
Route::post('/register', [AuthController::class, 'register']);

//Forget Password routes
Route::post('/forget-password', [ForgetController::class, 'forgetPassword']);

//Reset routes
Route::post('/reset-password', [ResetController::class, 'resetPassword']);

//Curent User routes
Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
