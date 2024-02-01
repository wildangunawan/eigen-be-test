<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\Penalty;
use Carbon\Carbon;
use Tests\TestCase;

class ReturnTest extends TestCase
{
    public function testCanReturnABook()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        BorrowedBook::factory()->create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'end_date' => null
        ]);

        $this->postJson("/api/v1/books/{$book->code}/return", [
            'member' => $member->code
        ])->assertStatus(200);
        $this->assertDatabaseHas('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'end_date' => now()
        ]);
    }

    public function testCanReturnABookButPenalizeMemberIfExceedMaximumDay()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        BorrowedBook::factory()->create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'start_date' => Carbon::now()->subDays(Penalty::LATE_BOOK_RETURN_DURATION + 1),
            'end_date' => null
        ]);

        $this->postJson("/api/v1/books/{$book->code}/return", [
            'member' => $member->code
        ])->assertStatus(200);
        $this->assertDatabaseHas('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'end_date' => now()
        ]);
        $this->assertDatabaseHas('penalties', [
            'member_id' => $member->id,
            'reason' => Penalty::LATE_BOOK_RETURN
        ]);
    }

    public function testShouldRejectIfBookNotBorrowed()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $this->postJson("/api/v1/books/{$book->code}/return", [
            'member' => $member->code
        ])->assertStatus(400);
    }
}
