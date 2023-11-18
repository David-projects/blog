<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
* Route for each post, when you select a post you will be send here. 
* This uses 
* app/Model/Post.php 
* views/posts/index.blade.php 
* conf/filesystem.php
* conf/sheets.php
* and sheets
*/

Route::get('/', function () {

    $posts = Sheets::collection('posts')->all();

    return view('posts.index', [
        'posts' => $posts
    ]);

});

/*
* Route for each post, when you select a post you will be send here. 
* This uses 
* app/Model/Post.php 
* views/posts/show.blade.php 
* conf/filesystem.php
* conf/sheets.php 
* and sheets
*/
Route::get('/posts/{slug}', function ($slug) {

    $post = Sheets::collection('posts')->all()->where('slug', $slug)->first();
    
    abort_if(is_null($post), 404);

    return view('posts.show', [
        'post' => $post
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
