<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $table = 'user_experiences';

    protected $fillable = [
        'user_id', 'company', 'position', 'location', 'employment_type',
        'start_date', 'end_date', 'is_current', 'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationAttribute(): string
    {
        $start = $this->start_date->format('M Y');
        $end   = $this->is_current ? 'Present' : $this->end_date?->format('M Y');
        return $start . ' – ' . $end;
    }

    public function getLengthAttribute(): string
    {
        $end  = $this->is_current ? now() : ($this->end_date ?? now());
        $diff = $this->start_date->diff($end);
        $parts = [];
        if ($diff->y) $parts[] = $diff->y . ' yr' . ($diff->y > 1 ? 's' : '');
        if ($diff->m) $parts[] = $diff->m . ' mo' . ($diff->m > 1 ? 's' : '');
        return implode(' ', $parts) ?: '< 1 mo';
    }
}
