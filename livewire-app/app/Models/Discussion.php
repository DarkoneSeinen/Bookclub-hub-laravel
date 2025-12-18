<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    protected $fillable = [
        'club_id',
        'book_id',
        'title',
        'description',
        'created_by',
        'status',
        'is_resolved',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];
    /**
     * Get the club this discussion belongs to
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the book being discussed (optional)
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user who created this discussion
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all comments on this discussion
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get root comments (not replies)
     */
    public function rootComments(): HasMany
    {
        return $this->comments()->whereNull('parent_comment_id');
    }

    /**
     * Check if discussion is open
     */
    public function isOpen(): bool
    {
        return $this->status === 'activa';
    }

    /**
     * Close discussion
     */
    public function close(): void
    {
        $this->update(['status' => 'cerrada']);
    }

    /**
     * Reopen discussion
     */
    public function reopen(): void
    {
        $this->update(['status' => 'activa']);
    }

    /**
     * Mark as resolved
     */
    public function markAsResolved(): void
    {
        $this->update(['is_resolved' => true]);
    }

    /**
     * Mark as unresolved
     */
    public function markAsUnresolved(): void
    {
        $this->update(['is_resolved' => false]);
    }

    /**
     * Check if discussion is resolved
     */
    public function isResolved(): bool
    {
        return (bool) $this->is_resolved;
    }
}
