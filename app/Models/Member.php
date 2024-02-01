<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
    ];

    public function borrowedBooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function currentlyBorrowedBooks(): \LaravelIdea\Helper\App\Models\_IH_BorrowedBook_QB|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->borrowedBooks()->whereNull('end_date');
    }

    public function penalties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Penalty::class);
    }

    public function currentPenalties(): \Illuminate\Database\Eloquent\Relations\HasMany|\LaravelIdea\Helper\App\Models\_IH_Penalty_QB
    {
        return $this->penalties()->where('end_date', '>', now());
    }
}
