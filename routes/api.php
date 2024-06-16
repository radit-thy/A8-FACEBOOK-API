<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
<<<<<<< HEAD
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
=======
use App\Http\Controllers\FriendRequestController;
>>>>>>> friend_request

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
// ---------------------------Logout Route-------------------------------------
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



// //===================================================================
                        //    like router  //
// //===================================================================
Route::prefix('likes')->group(function () {
    Route::post('/', [LikeController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/like-post', [LikeController::class, 'likePost'])->middleware('auth:sanctum');
    Route::post('/unlike', [LikeController::class, 'UnlikePost'])->middleware('auth:sanctum');
    Route::get('/show-like/{id}', [LikeController::class, 'showLike'])->middleware('auth:sanctum');
});

<<<<<<< HEAD

// ..................Comment Router............................
Route::prefix('comments')->group(function () {
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/create', [CommentController::class, 'create']);
    Route::get('posts/{postId}/comments', [CommentController::class, 'index']);
    Route::put('/update', [CommentController::class, 'update']);
    Route::delete('/delete/{id}', [CommentController::class, 'destroy']);
});
Route::get('/viewProfile/{id}', [ProfileController::class, 'index'])->middleware('auth:sanctum');


Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/resetPassword', [ResetPasswordController::class, 'resetPassword']);
=======
Route::get('/friend', [FriendRequestController::class, 'index']);
Route::post('/request/friend', [FriendRequestController::class, 'requestFriend'])->middleware('auth:sanctum');
Route::get('/friend/list', [FriendRequestController::class, 'listRequest'])->middleware('auth:sanctum');
Route::put('/friend/confirm/{id}', [FriendRequestController::class, 'confirmFriend'])->middleware('auth:sanctum');
Route::delete('/friend/delete/{id}', [FriendRequestController::class, 'deleteFriend'])->middleware('auth:sanctum');
Route::delete('/friend/cancel/{id}', [FriendRequestController::class, 'cancelFriend'])->middleware('auth:sanctum');
>>>>>>> friend_request
