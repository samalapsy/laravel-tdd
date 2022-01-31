<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_only_name_is_required()
    {
        Book::firstOrCreate([
            'title' => 'Life of a Man',
            'author_id' => 1,
        ]);
        
        $this->assertCount(1, Book::all());
    }


}
