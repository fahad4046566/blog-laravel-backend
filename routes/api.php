<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{slug}',[PostController::class,'show']);
Route::get('/categories',[CategoryController::class,'index']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login'])->name('login');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/posts',[PostController::class,'index']);
    Route::post('/admin/posts',[PostController::class,'store']);
    Route::put('/admin/posts/{id}',[PostController::class,'update']);
    Route::delete('/admin/posts/{id}',[PostController::class,'delete']);
});

 
