<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_only_name_is_required()
    {
        Author::firstOrCreate([
            'name' => 'Olu Sam',
        ]);
        
        $this->assertCount(1, Author::all());
    }
}
