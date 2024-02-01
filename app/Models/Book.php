<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'author',
        'stock',
    ];

    public function borrowed(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function currentlyBorrowed(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->borrowed()->whereNull('end_date');
    }

    public function borrowedBy(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Member::class,
            BorrowedBook::class,
            'book_id',
            'id',
            'id',
            'member_id'
        );
    }

    public function currentlyBorrowedBy(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->borrowedBy()->whereNull('borrowed_books.end_date');
    }
}
