<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '9780446310789',
                'description' => 'The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it.',
                'total_copies' => 5,
                'cover' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=300&h=400',
                'available_copies' => 5
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '9780451524935',
                'description' => 'A dystopian social science fiction novel and cautionary tale.',
                'total_copies' => 3,
                'cover' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=300&h=400',
                'available_copies' => 3
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'isbn' => '9780141439518',
                'description' => 'A romantic novel of manners that follows the character development of Elizabeth Bennet.',
                'total_copies' => 4,
                'cover' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=300&h=400',
                'available_copies' => 4
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '9780743273565',
                'description' => 'The story of the fabulously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan.',
                'total_copies' => 3,
                'cover' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?auto=format&fit=crop&q=80&w=300&h=400',
                'available_copies' => 3
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'isbn' => '9780547928227',
                'description' => 'A fantasy novel about the adventures of hobbit Bilbo Baggins.',
                'total_copies' => 6,
                'cover' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=300&h=400',
                'available_copies' => 6
            ]
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['isbn' => $book['isbn']],
                $book
            );
        }
    }
}