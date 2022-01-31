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
    use RefreshDatabase;

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


    public function test_can_return_a_book()
    {
        $book =  Book::factory()->create();
        $user =  User::factory()->create();
        $book->checkout($user);
        
        $book->checkin($user);

        $reservation = Reservation::first()->fresh();

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNotNull($reservation->checked_in_at);
        $this->assertEquals(now(), $reservation->checked_in_at);
    }


    public function test_a_user_can_checkout_a_book_twice()
    {
        $book =  Book::factory()->create();
        $user =  User::factory()->create();
        $book->checkout($user);
        $book->checkin($user);
        
        $book->checkout($user);

        $reservation = Reservation::find(2);        

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNull($reservation->checked_in_at);
        $this->assertEquals(now(), $reservation->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNotNull($reservation->checked_in_at);  
        $this->assertEquals(now(), $reservation->checked_in_at);
    }


    public function test_if_not_checked_out_throw_an_exception()
    {
        $this->expectException(\Exception::class);

        $book =  Book::factory()->create();
        $user =  User::factory()->create();
        
        $book->checkin($user);
        
    }


}
