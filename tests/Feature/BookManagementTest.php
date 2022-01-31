<?php

namespace Tests\Feature;

use App\Models\Author;
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
            'author_id' => 'Olu Sam'
        ]);
    }


    public function get_first_book()
    {
        return  Book::first();
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
        $book =  $this->get_first_book();
        $response->assertRedirect('/books/' . $book->id);
    }

    public function test_title_validateion()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author_id' => 'Olu Sam'
        ]);

        $response->assertSessionHasErrors('title');
    }


    public function test_author_validateion()
    {
        $response = $this->post('/books', [
            'title' => 'Book Title',
            'author_id' => ''
        ]);

        $response->assertSessionHasErrors('author_id');
    }


    public function test_a_book_can_be_updated()
    {
        $this->create_book();
        
        $book = $this->get_first_book();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'Updated book title',
            'author_id' => 'Updated Olu Sam',
        ]);

        $book = $book->fresh();

        $this->assertEquals('Updated book title', $book->title );
        $this->assertEquals(2, $book->author_id);
        $response->assertRedirect('/books/' . $book->id);
    }




    public function test_book_can_be_deleted()
    {

        $this->create_book();
        
        $book = $this->get_first_book();

        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());        
        $response->assertRedirect('/books');
    }


    public function test_automatically_add_new_author()
    {
        $this->create_book();

        $book = $this->get_first_book();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);

    }



}
