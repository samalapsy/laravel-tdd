<?php

namespace App\Models;

use Exception;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id'];


    public function path()
    {
        return '/books/'.$this->id;
    }

    public function setAuthorIdAttribute($str)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $str
        ])->id;
    }


    /**
     * Get all of the comments for the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


    public function checkout(User $user)
    {
        $this->reservations()->firstOrCreate([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }


    public function checkin(User $user)
    {
        $reservation = $this->reservations()
        ->whereUserId($user->id)
        ->whereNotNull('checked_out_at')->whereNull('checked_in_at')->first();
        if(is_null($reservation))
            throw new Exception;

        $reservation->update([
            'checked_in_at' => now(),
        ]);
        
    }
}
