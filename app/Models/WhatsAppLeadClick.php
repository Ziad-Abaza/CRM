<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppLeadClick extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_lead_clicks';

    protected $fillable = [
        'source_page',
        'button_location',
        'prefilled_message',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
    ];

    public function scopeRecent(Builder $query): Builder
    {
        return $query->latest();
    }

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('button_location', $location);
    }
}
