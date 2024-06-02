<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// List articles
Route::get('/articles', [ArticleController::class, 'index']);

// List one
Route::get('article/{id}', [ArticleController::class, 'show']);

// Create new article
Route::post('article', [ArticleController::class, 'store']);

// Update article
Route::put('article', [ArticleController::class, 'store']);
// Route::put('articles/{id}', [ArticleController::class, 'update']);

// Delete article
Route::delete('article/{id}', [ArticleController::class, 'destroy']);