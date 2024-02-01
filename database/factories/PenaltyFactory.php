<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Penalty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PenaltyFactory extends Factory
{
    protected $model = Penalty::class;

    public function definition()
    {
        return [
            'member_id' => Member::factory(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDay(),
            'reason' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
