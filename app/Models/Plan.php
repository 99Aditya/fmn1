<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'billing_interval',
        'features', 'is_free', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'features'  => 'array',
        'price'     => 'float',
        'is_free'   => 'boolean',
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Does this plan grant a given capability? */
    public function grants(string $feature): bool
    {
        return in_array($feature, $this->features ?? [], true);
    }

    /** Human-readable billing label, e.g. "/month". */
    public function getIntervalLabelAttribute(): string
    {
        return match ($this->billing_interval) {
            'month'    => '/month',
            'year'     => '/year',
            'lifetime' => '',
            default    => '/' . $this->billing_interval,
        };
    }

    /** Add one billing period to a starting point. */
    public function periodEndsFrom(\DateTimeInterface $start): ?\Illuminate\Support\Carbon
    {
        $start = \Illuminate\Support\Carbon::instance($start);
        return match ($this->billing_interval) {
            'month'    => $start->copy()->addMonth(),
            'year'     => $start->copy()->addYear(),
            'lifetime' => null, // never expires
            default    => $start->copy()->addMonth(),
        };
    }
}
