<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});
Route::resource('books',  App\Http\Controllers\BookController::class);
Route::resource('authors', App\Http\Controllers\AuthorController::class);

Route::post('/checkout/{book}', [App\Http\Controllers\CheckoutBookController::class, 'store'])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
