<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;

Route::get('/', function () {
    $posts = [];

    /** @var \App\Models\User $user */
    $user = auth()->guard()->user();
    if (auth()->guard()->check()) {
        $posts = $user->userPostRelation()->latest()->get();
        //$posts = Post::where('user_id', auth()->guard()->id())->get();
        //$posts = Post::all();
    }
    
    return view('home', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'actuallyUpdatePost']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);
