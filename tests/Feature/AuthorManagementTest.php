<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function create_author()
    {
        return  $this->post('/authors', [
            'name' => 'Olu Sam',
            'dob' => '02/04/2000',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_author_can_be_created()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->create_author();
        $this->assertCount(1, Author::all());
        $author =  Author::first();
        $response->assertRedirect('/authors/' . $author->id);
        
        $this->assertInstanceOf(Carbon::class, $author->dob);
        $this->assertEquals('2000/04/02', $author->dob->format('Y/d/m'));

    }
}
