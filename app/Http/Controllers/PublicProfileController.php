<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConnection;
use App\Models\UserProfile;

class PublicProfileController extends Controller
{
    public function show(string $username)
    {
        $profile = UserProfile::where('username', $username)->firstOrFail();
        $user    = $profile->user()->with([
            'profile', 'skills', 'educations', 'experiences',
            'certificates.test', 'testAttempts' => fn($q) => $q->whereNotNull('completed_at'),
        ])->firstOrFail();

        abort_if(! $profile->is_public && auth()->id() !== $user->id, 403);

        $viewer      = auth()->user();
        $connection  = $viewer ? UserConnection::statusBetween($viewer->id, $user->id) : null;
        $isFollowing = $viewer ? $viewer->isFollowing($user->id) : false;
        $isOwner     = $viewer?->id === $user->id;

        $followerCount   = $user->followers()->count();
        $followingCount  = $user->following()->count();
        $connectionCount = UserConnection::where(function ($q) use ($user) {
            $q->where('requester_id', $user->id)->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->count();

        return view('frontend.profile.public', compact(
            'user', 'profile', 'connection', 'isFollowing', 'isOwner',
            'followerCount', 'followingCount', 'connectionCount'
        ));
    }
}
