<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    protected $table = 'user_skills';

    protected $fillable = ['user_id', 'skill_name', 'proficiency', 'sort_order'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function proficiencyPercent(string $level): int
    {
        return match ($level) {
            'beginner'     => 25,
            'intermediate' => 55,
            'advanced'     => 80,
            'expert'       => 100,
            default        => 50,
        };
    }
}
