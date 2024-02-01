<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'start_date',
        'end_date',
        'reason',
    ];

    // Types
    const LATE_BOOK_RETURN = 1;

    // Duration
    const LATE_BOOK_RETURN_DURATION = 3;

    public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
