<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo',
        'social_links',
        'email',
        'phone',
        'order',
        'is_active',
    ];

    /**
     * @var array<int, string>
     */
    protected $translatable = [
        'name',
        'role',
        'bio',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
