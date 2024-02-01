<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowABookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'member' => 'required|exists:members,code',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
