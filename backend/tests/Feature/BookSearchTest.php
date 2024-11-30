<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookSearchTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_search_books_by_title()
    {
        Book::factory()->create([
            'title' => 'The Great Gatsby',
            'total_copies' => 5,
            'available_copies' => 3
        ]);
        Book::factory()->create([
            'title' => 'To Kill a Mockingbird',
            'total_copies' => 5,
            'available_copies' => 5
        ]);
        Book::factory()->create([
            'title' => 'The Great Expectations',
            'total_copies' => 5,
            'available_copies' => 4
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('test')->plainTextToken
        ])->get('/api/books?search=great');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['title' => 'The Great Gatsby']);
        $response->assertJsonFragment(['title' => 'The Great Expectations']);
    }

    public function test_can_search_books_by_author()
    {
        Book::factory()->create([
            'title' => 'Book 1',
            'author' => 'John Smith',
            'total_copies' => 5,
            'available_copies' => 5
        ]);
        Book::factory()->create([
            'title' => 'Book 2',
            'author' => 'Jane Smith',
            'total_copies' => 5,
            'available_copies' => 3
        ]);
        Book::factory()->create([
            'title' => 'Book 3',
            'author' => 'John Doe',
            'total_copies' => 5,
            'available_copies' => 4
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('test')->plainTextToken
        ])->get('/api/books?search=smith');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['author' => 'John Smith']);
        $response->assertJsonFragment(['author' => 'Jane Smith']);
    }

    public function test_can_filter_books_by_availability()
    {
        Book::factory()->create([
            'title' => 'Available Book',
            'total_copies' => 5,
            'available_copies' => 5
        ]);
        Book::factory()->create([
            'title' => 'Borrowed Book',
            'total_copies' => 5,
            'available_copies' => 0
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('test')->plainTextToken
        ])->get('/api/books?available=true');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.title', 'Available Book');
        $response->assertJsonCount(1, 'data');
    }
}
