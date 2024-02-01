<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $dummy = [
            [
                "name" => "Angga",
            ],
            [
                "name" => "Ferry",
            ],
            [
                "name" => "Putri",
            ],
        ];

        foreach ($dummy as $data) {
            Member::create($data);
        }
    }
}
