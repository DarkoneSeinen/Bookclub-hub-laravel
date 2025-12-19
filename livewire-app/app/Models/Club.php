<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'cover_image',
        'is_private',
        'max_members',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    /**
     * Get the user who owns the club
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all members of the club
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'club_members')
            ->using(ClubMember::class)
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Get all readings for this club
     */
    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    /**
     * Get all discussions in this club
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get all voting periods in this club
     */
    public function votingPeriods(): HasMany
    {
        return $this->hasMany(VotingPeriod::class);
    }

    /**
     * Get all books in this club (through readings)
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'readings', 'club_id', 'book_id')
            ->withPivot('status', 'start_date', 'end_date')
            ->withTimestamps();
    }

    /**
     * Check if a user is a member of this club
     */
    public function isMember(User $user): bool
    {
        return $this->members()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if a user is the owner
     */
    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    /**
     * Get the role of a user in this club
     */
    public function getMemberRole(User $user): ?string
    {
        return $this->members()
            ->where('users.id', $user->id)
            ->first()?->pivot->role;
    }
}
