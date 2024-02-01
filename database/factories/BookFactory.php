<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'code' => $this->faker->name(),
            'title' => $this->faker->name(),
            'author' => $this->faker->name(),
            'stock' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
