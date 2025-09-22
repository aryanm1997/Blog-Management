<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('index', [BlogController::class, 'index'])->name('blogs.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('blogs', BlogController::class)->except(['index']);
    Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blogs/view', [BlogController::class, 'markAsViewed'])
    ->name('blogs.markAsViewed');

});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


