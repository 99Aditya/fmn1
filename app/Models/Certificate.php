<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $casts = [
        'issued_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'test_id',
        'attempt_id',
        'certificate_no',
        'certificate_url',
        'issued_at'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function attempt()
    {
        return $this->belongsTo(TestAttempt::class, 'attempt_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}