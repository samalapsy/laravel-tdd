<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutBookController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $ans = $book->checkout(auth()->user());
    }
}
