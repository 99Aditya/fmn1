<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'plan'])->latest();

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('status', $request->status);
            }
        }

        $subscriptions = $query->paginate(25)->withQueryString();

        $stats = [
            'active'  => Subscription::active()->count(),
            'total'   => Subscription::count(),
            'revenue' => Subscription::sum('amount'),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }
}
