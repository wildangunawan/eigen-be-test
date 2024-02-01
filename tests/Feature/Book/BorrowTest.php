<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\Penalty;
use Tests\TestCase;

class BorrowTest extends TestCase
{
    public function testCanBorrowAnAvailableBook()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $this->postJson("/api/v1/books/{$book->code}/borrow", [
            'member' => $member->code
        ])->assertStatus(200);
        $this->assertDatabaseHas('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id
        ]);
    }

    public function testShouldRejectIfBookUnavailable()
    {
        $book = Book::factory()->create([
            'stock' => 1
        ]);
        $member = Member::factory()->create();
        BorrowedBook::factory()->create([
            'book_id' => $book->id,
            'end_date' => null
        ]);

        $this->postJson("/api/v1/books/{$book->code}/borrow", [
            'member' => $member->code
        ])->assertStatus(400);
        $this->assertDatabaseMissing('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id
        ]);
    }

    public function testShouldRejectIfBookAlreadyBorrowed()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        BorrowedBook::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'start_date' => now()
        ]);

        $this->postJson("/api/v1/books/{$book->code}/borrow", [
            'member' => $member->code
        ])->assertStatus(400);
    }

    public function testShouldRejectIfMemberPenalized()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        Penalty::factory()->create([
            'member_id' => $member->id,
            'end_date' => now()->addDay()
        ]);

        $this->postJson("/api/v1/books/{$book->code}/borrow", [
            'member' => $member->code
        ])->assertStatus(400);
        $this->assertDatabaseMissing('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id
        ]);
    }
}
