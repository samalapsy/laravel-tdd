<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'checked_out_at', 'checked_in_at'];


    /**
     * Get the book that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
