<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    protected $table = 'user_educations';

    protected $fillable = [
        'user_id', 'institution', 'degree', 'field_of_study',
        'start_year', 'end_year', 'is_current', 'description',
    ];

    protected $casts = ['is_current' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationAttribute(): string
    {
        $end = $this->is_current ? 'Present' : $this->end_year;
        return $this->start_year . ' – ' . $end;
    }
}
