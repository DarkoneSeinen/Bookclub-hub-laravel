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
}
