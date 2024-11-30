<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_book()
    {
        $bookData = [
            "title"=> "Harry Potter",
            "author"=> "J.K. Rowling",
            "isbn"=> "978-0-7475-3269-9",
            "description"=> "The famous wizard book",
            "total_copies"=> 5,
            "available_copies"=> 5
        ];

        $book = Book::create($bookData);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals($bookData['title'], $book->title);
        $this->assertEquals($bookData['author'], $book->author);
        $this->assertEquals($bookData['isbn'], $book->isbn);
        $this->assertEquals($bookData['description'], $book->description);
        $this->assertEquals($bookData['total_copies'], $book->total_copies);
        $this->assertEquals($bookData['available_copies'], $book->available_copies);
    }

    public function test_book_requires_title()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Book::create([
            'title' => 'Test Title',
            'description' => 'Test Description',
            'author' => 'Test Author',
            'isbn' => '1234567890',
        ]);
    }
}
