<?php

namespace App\Models;

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
}
