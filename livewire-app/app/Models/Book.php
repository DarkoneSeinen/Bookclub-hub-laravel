<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'pages',
        'cover_image',
        'published_year',
        'genres',
        'rating_avg',
        'review_count',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'genres' => 'array',
        ];
    }

    // Relaciones
    public function inventory(): HasOne
    {
        return $this->hasOne(BookInventory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistEntries(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlist');
    }

    // Métodos helper
    public function isAvailable(): bool
    {
        return $this->inventory && $this->inventory->quantity_available > 0;
    }

    public function getDiscountedPrice(): float
    {
        if (!$this->inventory) return 0;
        
        $discount = ($this->inventory->price * $this->inventory->discount_percentage) / 100;
        return $this->inventory->price - $discount;
    }

    public function getOriginalPrice(): float
    {
        return $this->inventory?->price ?? 0;
    }
}
