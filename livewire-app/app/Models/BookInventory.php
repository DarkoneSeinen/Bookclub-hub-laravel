<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookInventory extends Model
{
    /** @use HasFactory<\Database\Factories\BookInventoryFactory> */
    use HasFactory;

    protected $table = 'book_inventory';

    protected $fillable = [
        'book_id',
        'quantity_available',
        'quantity_sold',
        'price',
        'discount_percentage',
        'format',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_percentage' => 'decimal:2',
        ];
    }

    // Relaciones
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Métodos helper
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('quantity_available', $quantity);
        $this->increment('quantity_sold', $quantity);
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('quantity_available', $quantity);
        $this->decrement('quantity_sold', $quantity);
    }
}
