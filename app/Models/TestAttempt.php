<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'correct_answers',
        'wrong_answers',
        'total_questions',
        'percentage',
        'passed',
        'certificate_earned',
        'started_at',
        'completed_at'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class, 'attempt_id');
    }
}