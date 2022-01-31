<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function create_book()
    {
        return  $this->post('/books', [
            'title' => 'A new book title',
            'author' => 'Olu Sam'
        ]);
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_a_library()
    {
        $response = $this->create_book();
        $this->assertCount(1, Book::all());
        $book =  Book::first();
        $response->assertRedirect('/books/' . $book->id);
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
        $this->create_book();
        
        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'Updated book title',
            'author' => 'Updated Olu Sam',
        ]);

        $book = $book->fresh();
        $this->assertEquals('Updated book title', $book->title );
        $this->assertEquals('Updated Olu Sam', $book->author);
        $response->assertRedirect('/books/' . $book->id);
    }




    public function test_book_can_be_deleted()
    {

        $this->create_book();
        
        $book = Book::first();

        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());        
        $response->assertRedirect('/books');
    }
}
