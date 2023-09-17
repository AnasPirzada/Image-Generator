<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ListingController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/store-post', [PostController::class, 'store'])->name('store-post');
Route::get('listing', [ListingController::class, 'index']);
Route::post('/posts', [PostController::class, 'index']);
Route::post('/posts/delete/{id}', [ListingController::class, 'delete'])->name('posts.delete');
