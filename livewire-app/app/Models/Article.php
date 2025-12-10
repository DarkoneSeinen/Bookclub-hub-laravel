<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [ // campos asignables
        'title',
        'content',
        'is_published',
        'author_id'
    ];

    protected $casts = [ // casteo de atributos
        'is_published' => 'boolean',
    ];

    //relación con el modelo User (autor del artículo)
    public function author(): BelongsTo{
        return $this->belongsTo(User::class, 'author_id');
    }
}
