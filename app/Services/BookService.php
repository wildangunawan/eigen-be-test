<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\Penalty;
use Carbon\Carbon;

class BookService
{
    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * @param Book $book
     * @param Member $member
     * @return void
     * @throws \Exception
     */
    public function borrow(Book $book, Member $member): void
    {
        // 1. Check if member has the maximum number of borrowed books
        if ($member->currentlyBorrowedBooks()->count() >= BorrowedBook::MAX_BORROWED_BOOKS)
            throw new \Exception('Member has reached the maximum number of borrowed books.');

        // 2. Check if book in stock (stock - borrowed books)
        if ($book->stock - $book->currentlyBorrowed()->count() <= 0)
            throw new \Exception('Book is not available.');

        // 3. Check if the member has penalties
        if ($member->currentPenalties()->count() > 0)
            throw new \Exception("Member is penalized and cannot borrow any book until the penalties are cleared.");

        // 4. Check if member already borrow the book
        $borrowedBook = $member->borrowedBooks()
            ->where('book_id', $book->id)
            ->whereNull('end_date')
            ->first();

        if ($borrowedBook) throw new \Exception('Member already borrowed the book.');

        // 4. Process the borrow of the book
        $member->borrowedBooks()->create([
            'book_id' => $book->id,
            'start_date' => now()
        ]);
    }

    /**
     * @param Book $book
     * @param Member $member
     * @return void
     * @throws \Exception
     */
    public function return(Book $book, Member $member): void
    {
        // 1. Check if the book is borrowed by the member
        $borrowedBook = $member->borrowedBooks()
            ->where('book_id', $book->id)
            ->whereNull('end_date')
            ->first();

        if (!$borrowedBook) throw new \Exception('Book is not borrowed by the member.');

        // 2. Process the return of the book
        $borrowedBook->update([
            'end_date' => now()
        ]);

        // 3. Check if the book is overdue (7 days from the borrow date)
        // If overdue then call the penalty method from MemberService
        if ($borrowedBook->start_date->diffInDays(now()) > Penalty::LATE_BOOK_RETURN_DURATION) {
            $this->memberService->penalty(
                $member,
                Carbon::now()->addDays(Penalty::LATE_BOOK_RETURN_DURATION),
                Penalty::LATE_BOOK_RETURN
            );
        }
    }
}
