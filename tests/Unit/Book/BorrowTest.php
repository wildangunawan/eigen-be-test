<?php

namespace Tests\Unit\Book;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\Penalty;
use App\Services\BookService;
use App\Services\MemberService;
use Tests\TestCase;

class BorrowTest extends TestCase
{
    protected BookService $bookService;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->bookService = new BookService(new MemberService());
    }

    public function testCanBorrowAnAvailableBook()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $this->bookService->borrow($book, $member);
        $this->assertDatabaseHas('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id
        ]);
    }

    public function testShouldRejectIfBookUnavailable()
    {
        $this->expectException(\Exception::class);

        $book = Book::factory()->create([
            'stock' => 1
        ]);
        $member = Member::factory()->create();
        BorrowedBook::factory()->create([
            'book_id' => $book->id,
            'end_date' => null
        ]);

        $this->bookService->borrow($book, $member);
    }

    public function testShouldRejectIfBookAlreadyBorrowed()
    {
        $this->expectException(\Exception::class);

        $book = Book::factory()->create();
        $member = Member::factory()->create();
        BorrowedBook::create([
            'book_id' => $book->id,
            'member_id' => $member->id,
            'start_date' => now()
        ]);

        $this->bookService->borrow($book, $member);
    }

    public function testShouldRejectIfMemberPenalized()
    {
        $this->expectException(\Exception::class);

        $book = Book::factory()->create();
        $member = Member::factory()->create();
        Penalty::factory()->create([
            'member_id' => $member->id,
            'end_date' => now()->addDay()
        ]);

        $this->bookService->borrow($book, $member);
    }
}
