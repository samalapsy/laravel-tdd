<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase, HasFactory;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_checkout()
    {
       $book =  Book::factory()->create();
       $user =  User::factory()->create();

       $book->checkout($user);

       $reservation = Reservation::first();

       $this->assertCount(1, Reservation::all());
       $this->assertEquals($user->id, $reservation->user_id );
       $this->assertEquals($book->id, $reservation->book_id );
       $this->assertEquals(now(), $reservation->checked_out_at );

    }
}
