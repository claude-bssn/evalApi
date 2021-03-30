<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\AuthorController;
use App\http\Controllers\GenreController;
use App\http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('authors', AuthorController::class); // le string d'accès de l'URI, le controller qui control la class
Route::resource('genres', GenreController::class); // le string d'accès de l'URI, le controller qui control la class
Route::resource('books', BookController::class); // le string d'accès de l'URI, le controller qui control la class


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
