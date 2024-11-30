<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookBorrowingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_borrow_available_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'total_copies' => 5,
            'available_copies' => 3
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken])
            ->post('/api/loans', [
                'book_id' => $book->id,
                'due_date' => now()->addDays(14)->format('Y-m-d')
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'loan' => [
                'id',
                'user_id',
                'book_id',
                'borrowed_at',
                'due_date'
            ],
            'message'
        ]);
        
        $this->assertEquals(2, $book->fresh()->available_copies);
    }

    public function test_user_cannot_borrow_unavailable_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'total_copies' => 5,
            'available_copies' => 0
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken])
            ->post('/api/loans', [
                'book_id' => $book->id,
                'due_date' => now()->addDays(14)->format('Y-m-d')
            ]);

        $response->assertStatus(400);
        $this->assertEquals(0, $book->fresh()->available_copies);
    }
}
