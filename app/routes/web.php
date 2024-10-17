<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/feed-form', [RssController::class, 'showFeedForm']);
Route::post('/fetch-articles', [RssController::class, 'fetchArticles'])->name('fetch.articles');
Route::post('/summarize-article', [RssController::class, 'generateSummary'])->name('summarize.article');