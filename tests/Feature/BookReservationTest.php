<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;

class BookReservationTest extends TestCase
{
    USE RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_a_library()
    {
        $response = $this->post('/books', [
            'title' => 'A new book title',
            'author' => 'Olu Sam'
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, Book::all());
    }

    public function test_title_validateion()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Olu Sam'
        ]);

        $response->assertSessionHasErrors('title');
    }


    public function test_author_validateion()
    {
        $response = $this->post('/books', [
            'title' => 'Book Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }


    public function test_a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'A new book title',
            'author' => 'Olu Sam'
        ]);
        
        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'Updated book title',
            'author' => 'Updated Olu Sam',
        ]);

        $book = Book::first();
        
        $response->assertStatus(200);
        $this->assertEquals('Updated book title', $book->title );
        $this->assertEquals('Updated Olu Sam', $book->author);
    }
}
