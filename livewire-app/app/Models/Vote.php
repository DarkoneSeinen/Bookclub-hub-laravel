<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'voting_period_id',
        'user_id',
        'book_id',
    ];

    /**
     * Get the voting period
     */
    public function votingPeriod(): BelongsTo
    {
        return $this->belongsTo(VotingPeriod::class);
    }

    /**
     * Get the user who voted
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book being voted for
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
