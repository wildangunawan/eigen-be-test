<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Book */
class BookResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'title' => $this->title,
            'code' => $this->code,

            'author' => $this->author,
            'stock' => [
                'all' => $this->stock,
                'available' => $this->stock - $this->borrowed()->whereNull('end_date')->count(),
            ],
        ];
    }
}
