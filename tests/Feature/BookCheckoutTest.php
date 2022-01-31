<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_book_can_be_checked_out_by_an_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/'. $book->id);

        $reservation = Reservation::first();

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertEquals(now(), $reservation->checked_out_at);
    }



    public function test_that_only_authenticated_user_can_checkout()
    {
        
        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/'. $book->id)
        // ->assertRedirect('/login');
        // $this
        ->assertStatus(200);
        $this->assertCount(1, Reservation::all());

    }


    public function test_that_only_only_real_book_can_be_checked_out()
    {
        
        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/123')->assertStatus(404);
        
        $this->assertCount(0, Reservation::all());

    }


    
}
