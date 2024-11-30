<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\BookLoan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookLoanResource;

class BookLoanController extends Controller
{
    public function index()
    {
        $loans = BookLoan::with(['user', 'book'])->get();
        return BookLoanResource::collection($loans);
    }
    
    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $book = Book::findOrFail($request->book_id);
        
        if ($book->available_copies <= 0) {
            return response()->json(['message' => 'Book not available'], 400);
        }

        $book->available_copies -= 1;
        $book->save();

        $loan = BookLoan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(7),
            'is_returned' => false
        ]);

        return response()->json([
            'message' => 'Book borrowed successfully',
            'data' => $loan
        ]);
    }

    public function returnBook(Request $request, BookLoan $loan)
    {
        if ($loan->is_returned) {
            return response()->json(['message' => 'Book already returned'], 400);
        }

        $daysLate = now()->diffInDays($loan->due_date, false);
        $fine = $daysLate > 0 ? $daysLate * 1000 : 0;
        
        $loan->update([
            'returned_at' => now(),
            'is_returned' => true,
            'fine_amount' => $fine
        ]);

        $loan->book->increment('available_copies');

        return new BookLoanResource($loan);
    }
}
