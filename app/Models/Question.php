<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'question',
        'explanation',
        'marks',
        'question_order',
        'difficulty',
        'topic',
        'is_pooled',
    ];

    protected $casts = [
        'is_pooled' => 'boolean',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}