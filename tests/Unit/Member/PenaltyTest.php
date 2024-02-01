<?php

namespace Tests\Unit\Member;

use App\Models\Member;
use App\Models\Penalty;
use App\Services\MemberService;
use Carbon\Carbon;
use Tests\TestCase;

class PenaltyTest extends TestCase
{
    protected MemberService $memberService;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->memberService = new MemberService();
    }

    public function testCanPenalizeMember()
    {
        $member = Member::factory()->create();

        $this->memberService->penalty(
            $member,
            Carbon::now()->addDays(Penalty::LATE_BOOK_RETURN_DURATION),
            Penalty::LATE_BOOK_RETURN
        );

        $this->assertDatabaseHas('penalties', [
            'member_id' => $member->id,
            'reason' => Penalty::LATE_BOOK_RETURN
        ]);
    }
}
