<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'title',
        'content',
        'helpful_count',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Scopes
    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeMostHelpful($query)
    {
        return $query->orderBy('helpful_count', 'desc');
    }
}
