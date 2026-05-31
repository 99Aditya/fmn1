<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
        ];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function skills()
    {
        return $this->hasMany(UserSkill::class)->orderBy('sort_order');
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class)->orderByDesc('start_year');
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class)->orderByDesc('start_date');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function testAttempts()
    {
        return $this->hasMany(TestAttempt::class);
    }

    // Connections sent by this user
    public function sentConnections()
    {
        return $this->hasMany(UserConnection::class, 'requester_id');
    }

    // Connections received by this user
    public function receivedConnections()
    {
        return $this->hasMany(UserConnection::class, 'receiver_id');
    }

    // Users this user follows
    public function following()
    {
        return $this->hasMany(UserFollow::class, 'follower_id');
    }

    // Users following this user
    public function followers()
    {
        return $this->hasMany(UserFollow::class, 'following_id');
    }

    public function isFollowing(int $userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    public function getOrCreateProfile(): UserProfile
    {
        return $this->profile ?? $this->profile()->create([
            'username' => 'user' . $this->id,
        ]);
    }

    public function getAvatarUrlAttribute(): string
    {
        return optional($this->profile)->avatar_url
            ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2563eb&color=fff&size=200';
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
