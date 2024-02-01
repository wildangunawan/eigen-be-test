<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
