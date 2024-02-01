<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BorrowedBookFactory extends Factory
{
    protected $model = BorrowedBook::class;

    public function definition()
    {
        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
