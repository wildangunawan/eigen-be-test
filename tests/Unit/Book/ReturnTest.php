<?php

namespace Tests\Unit\Book;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Services\BookService;
use App\Services\MemberService;
use Tests\TestCase;

class ReturnTest extends TestCase
{
    protected BookService $bookService;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->bookService = new BookService(new MemberService());
    }

    public function testCanReturnABook()
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        BorrowedBook::factory()->create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'end_date' => null
        ]);

        $this->bookService->return($book, $member);
        $this->assertDatabaseMissing('borrowed_books', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'end_date' => null
        ]);
    }

    public function testShouldRejectIfBookNotBorrowed()
    {
        $this->expectException(\Exception::class);

        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $this->bookService->return($book, $member);
    }
}
