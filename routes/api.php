<?php

use App\Http\Controllers\AuthController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

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


// ---------------------------log in, Logout Route-------------------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');


// ..................Posts Router............................ 
Route::prefix('posts')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'create']);
    Route::put('/edit', [PostController::class, 'update']);
    Route::delete('/delete/{id}', [PostController::class, 'destroy']);   
    Route::get('/getpost/{id}', [PostController::class, 'getpost'])->middleware('auth:sanctum');
    Route::get('/postlist/{user_id}', [PostController::class, 'postlist'])->middleware('auth:sanctum');
});

// ..................Profile Router............................
Route::post('/profile', [ProfileController::class, 'create'])->middleware('auth:sanctum');
Route::post('/upload', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');



// ..................Comment Router............................
Route::prefix('comments')->group(function () {
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/create', [CommentController::class, 'create']);
});
