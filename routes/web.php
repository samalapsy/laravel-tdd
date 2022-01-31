<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});
Route::resource('books',  App\Http\Controllers\BookController::class);
Route::resource('authors', App\Http\Controllers\AuthorController::class);