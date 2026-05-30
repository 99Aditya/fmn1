<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    protected $table = 'user_connections';

    protected $fillable = ['requester_id', 'receiver_id', 'status'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public static function statusBetween(int $a, int $b): ?self
    {
        return static::where(function ($q) use ($a, $b) {
            $q->where('requester_id', $a)->where('receiver_id', $b);
        })->orWhere(function ($q) use ($a, $b) {
            $q->where('requester_id', $b)->where('receiver_id', $a);
        })->first();
    }
}
