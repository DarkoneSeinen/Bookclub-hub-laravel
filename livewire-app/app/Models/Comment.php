<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
        'parent_comment_id',
    ];

    /**
     * Get the discussion this comment belongs to
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get the user who wrote this comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment if this is a reply
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    /**
     * Get all replies to this comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    /**
     * Get all replies recursively (with eager loading)
     */
    public function repliesRecursive(): HasMany
    {
        return $this->replies()->with('repliesRecursive', 'user');
    }

    /**
     * Get all reactions to this comment
     */
    public function reactions(): HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }

    /**
     * Check if this is a root comment
     */
    public function isRootComment(): bool
    {
        return is_null($this->parent_comment_id);
    }

    /**
     * Check if this is a reply
     */
    public function isReply(): bool
    {
        return !is_null($this->parent_comment_id);
    }

    /**
     * Edit comment content
     */
    public function editContent(string $content): void
    {
        $this->update([
            'content' => $content,
            'edited_at' => now(),
        ]);
    }

    /**
     * Toggle reaction on comment
     */
    public function toggleReaction(int $userId, string $emoji = '👍'): void
    {
        $reaction = $this->reactions()
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            $this->reactions()->create([
                'user_id' => $userId,
                'emoji' => $emoji,
            ]);
        }
    }

    /**
     * Get reaction count by emoji
     */
    public function getReactionCount(string $emoji = '👍'): int
    {
        return $this->reactions()->where('emoji', $emoji)->count();
    }

    /**
     * Check if user has reacted with emoji
     */
    public function hasUserReacted(int $userId, string $emoji = '👍'): bool
    {
        return $this->reactions()
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->exists();
    }
}

