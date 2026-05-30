<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id', 'username', 'headline', 'bio', 'avatar', 'cover_photo',
        'location', 'website', 'linkedin_url', 'github_url', 'twitter_url',
        'phone', 'date_of_birth', 'is_public',
    ];

    protected $casts = [
        'is_public'     => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=2563eb&color=fff&size=200';
    }
}
