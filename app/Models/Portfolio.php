<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'client',
        'completion_date',
        'summary',
        'content',
        'image',
        'gallery',
        'technologies',
        'website_url',
        'is_featured',
        'is_active',
        'order',
    ];

    /**
     * @var array<int, string>
     */
    protected $translatable = [
        'title',
        'client',
        'summary',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'completion_date' => 'date',
            'gallery' => 'array',
            'technologies' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('id');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
