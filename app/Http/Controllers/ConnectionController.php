<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConnection;
use App\Models\UserFollow;

class ConnectionController extends Controller
{
    /* ── Send connection request ── */
    public function connect(User $user)
    {
        abort_if(auth()->id() === $user->id, 422);

        UserConnection::firstOrCreate([
            'requester_id' => auth()->id(),
            'receiver_id'  => $user->id,
        ], ['status' => 'pending']);

        return back()->with('success', 'Connection request sent.');
    }

    /* ── Accept ── */
    public function accept(UserConnection $connection)
    {
        abort_if($connection->receiver_id !== auth()->id(), 403);
        $connection->update(['status' => 'accepted']);
        return back()->with('success', 'Connection accepted.');
    }

    /* ── Reject ── */
    public function reject(UserConnection $connection)
    {
        abort_if($connection->receiver_id !== auth()->id(), 403);
        $connection->update(['status' => 'rejected']);
        return back()->with('success', 'Request declined.');
    }

    /* ── Remove / withdraw ── */
    public function remove(User $user)
    {
        UserConnection::where(function ($q) use ($user) {
            $q->where('requester_id', auth()->id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('requester_id', $user->id)->where('receiver_id', auth()->id());
        })->delete();

        return back()->with('success', 'Connection removed.');
    }

    /* ── Pending requests page ── */
    public function requests()
    {
        $pending = UserConnection::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->with('requester.profile')
            ->latest()
            ->get();

        $connections = UserConnection::where(function ($q) {
            $q->where('requester_id', auth()->id())->orWhere('receiver_id', auth()->id());
        })->where('status', 'accepted')
            ->with(['requester.profile', 'receiver.profile'])
            ->latest()
            ->get();

        return view('frontend.profile.connections', compact('pending', 'connections'));
    }

    /* ── Follow ── */
    public function follow(User $user)
    {
        abort_if(auth()->id() === $user->id, 422);
        UserFollow::firstOrCreate(['follower_id' => auth()->id(), 'following_id' => $user->id]);
        return back()->with('success', 'You are now following ' . $user->name . '.');
    }

    /* ── Unfollow ── */
    public function unfollow(User $user)
    {
        UserFollow::where(['follower_id' => auth()->id(), 'following_id' => $user->id])->delete();
        return back()->with('success', 'Unfollowed.');
    }
}
