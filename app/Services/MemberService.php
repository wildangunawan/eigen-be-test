<?php

namespace App\Services;

use App\Models\Member;
use Carbon\Carbon;

class MemberService
{
    public function penalty(Member $member, Carbon $end_date, int $reason): void
    {
        $member->penalties()
            ->create([
                'end_date' => $end_date,
                'reason' => $reason
            ]);
    }
}
