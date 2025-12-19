<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingCandidate extends Model
{
    protected $fillable = [
        'voting_period_id',
        'book_id',
    ];

    public function votingPeriod()
    {
        return $this->belongsTo(VotingPeriod::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
