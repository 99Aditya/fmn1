<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'total_questions',
        'total_marks',
        'total_time',
        'passing_marks',
        'difficulty',
        'has_certificate',
        'certificate_min_score',
        'hashtags',
        'youtube_video_link',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(TestAttempt::class);
    }
}