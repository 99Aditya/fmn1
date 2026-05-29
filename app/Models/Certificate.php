<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'attempt_id',
        'certificate_no',
        'certificate_url',
        'issued_at'
    ];
}