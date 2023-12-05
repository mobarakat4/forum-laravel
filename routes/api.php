<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Feed\FeedController;
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
Route::get('/test', function (Request $request) {
 return response(['message'=> 'api is work'],200);
});

Route::post('register',[AuthController::class,'register'])->name('register');
Route::post('login',   [AuthController::class,'login'])   ->name('login');


Route::get('/feeds',[FeedController::class,'index'])->middleware('auth:sanctum');
Route::get('/getcomments/{feed_id}',[FeedController::class,'getcomments'])->middleware('auth:sanctum');
Route::post('/feed/store',[FeedController::class,'store'])->middleware('auth:sanctum');
Route::post('/feed/like/{feed_id}',[FeedController::class,'likepost'])->middleware('auth:sanctum');
Route::post('/feed/comment/{feed_id}',[FeedController::class,'comment'])->middleware('auth:sanctum');
// Route::get('tst',function(){
//     return response(['message' => 'done'],200);
// });