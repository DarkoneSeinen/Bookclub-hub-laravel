<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VotingPeriod extends Model
{
    protected $fillable = [
        'club_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'winner_book_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the club this voting belongs to
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the winning book
     */
    public function winnerBook(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'winner_book_id');
    }

    /**
     * Get all votes for this period
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Check if voting is active
     */
    public function isActive(): bool
    {
        return $this->status === 'activa' && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Check if voting is closed
     */
    public function isClosed(): bool
    {
        return $this->status === 'cerrada' || now()->isAfter($this->end_date);
    }

    /**
     * Get candidate books (unique books that have votes)
     */
    public function getCandidates()
    {
        return Book::whereIn('id', $this->votes()->distinct('book_id')->pluck('book_id'))->get();
    }

    /**
     * Get vote count per book
     */
    public function getVoteCount($bookId): int
    {
        return $this->votes()->where('book_id', $bookId)->count();
    }

    /**
     * Get user's vote
     */
    public function getUserVote($userId): ?Vote
    {
        return $this->votes()->where('user_id', $userId)->first();
    }

    /**
     * Determine winner (book with most votes)
     */
    public function determineWinner(): void
    {
        $winnerId = $this->votes()
            ->groupBy('book_id')
            ->selectRaw('book_id, COUNT(*) as vote_count')
            ->orderByDesc('vote_count')
            ->first()?->book_id;

        if ($winnerId) {
            $this->update([
                'winner_book_id' => $winnerId,
                'status' => 'completada',
            ]);
        }
    }

    /**
     * Close voting period
     */
    public function closeVoting(): void
    {
        $this->update(['status' => 'cerrada']);
        $this->determineWinner();
    }
}
