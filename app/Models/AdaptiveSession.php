<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdaptiveSession extends Model
{
    protected $fillable = [
        'user_id', 'test_id', 'current_difficulty', 'max_questions',
        'questions_answered', 'correct_count', 'wrong_count',
        'served_ids', 'log', 'pending_question_id',
        'final_level', 'final_score', 'final_band',
        'status', 'started_at', 'completed_at',
    ];

    protected $casts = [
        'served_ids'   => 'array',
        'log'          => 'array',
        'final_level'  => 'float',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
