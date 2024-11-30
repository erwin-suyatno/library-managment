<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReturnTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_return_borrowed_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'total_copies' => 5,
            'available_copies' => 2
        ]);
        
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14)
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken])
            ->post('/api/loans/' . $loan->id . '/return');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'loan' => [
                'id',
                'user_id',
                'book_id',
                'borrowed_at',
                'due_date',
                'returned_at'
            ],
            'message'
        ]);
        
        $this->assertEquals(3, $book->fresh()->available_copies);
    }

    public function test_user_cannot_return_book_they_did_not_borrow()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $book = Book::factory()->create([
            'total_copies' => 5,
            'available_copies' => 2
        ]);
        
        $loan = Loan::create([
            'user_id' => $user1->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14)
        ]);

        $response = $this->actingAs($user2)
            ->withHeaders(['Authorization' => 'Bearer ' . $user2->createToken('test')->plainTextToken])
            ->post('/api/loans/' . $loan->id . '/return');

        $response->assertStatus(403);
        $this->assertEquals(2, $book->fresh()->available_copies);
    }

    public function test_late_return_calculates_fine()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'total_copies' => 5,
            'available_copies' => 2
        ]);
        
        $loan = Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now()->subDays(16),
            'due_date' => now()->subDays(2)
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken])
            ->post('/api/loans/' . $loan->id . '/return');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'loan' => [
                'id',
                'user_id',
                'book_id',
                'borrowed_at',
                'due_date',
                'returned_at',
                'fine_amount'
            ],
            'message'
        ]);
        
        $this->assertGreaterThan(0, $response->json('loan.fine_amount'));
    }
}
