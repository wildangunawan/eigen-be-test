<?php

namespace App\Observers;

use App\Models\Member;

class MemberObserver
{
    public function creating(Member $member): void
    {
        $member->code = "M" . str_pad(Member::count() + 1, 3, "0", STR_PAD_LEFT);
    }
}
