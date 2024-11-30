<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'total_copies',
        'available_copies',
        'cover',
    ];

    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }
}
