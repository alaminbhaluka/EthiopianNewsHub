<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public TribuneBangla routes. The existing Blade templates and their
| layout are intentionally kept unchanged.
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{slug}', [HomeController::class, 'ShowNews'])->name('news.details');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'handleContactFrom'])->name('contact.send');
Route::post('/newsletter/subscribe', [HomeController::class, 'SubscribeNewsLetter'])->name('newsletter.subscribe');

Route::middleware('auth')->group(function () {
    Route::post('/comment', [HomeController::class, 'handleComment'])->name('comment.store');
    Route::post('/comment/reply', [HomeController::class, 'handleReplay'])->name('comment.reply');
    Route::delete('/comment', [HomeController::class, 'commentDestory'])->name('comment.destroy');
});
