<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Member */
class MemberResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'code' => $this->code,

            'book' => [
                'borrowed' => $this->currentlyBorrowedBooks()->count(),
                'penalized' => $this->currentPenalties()->count() > 0,
            ],
        ];
    }
}
