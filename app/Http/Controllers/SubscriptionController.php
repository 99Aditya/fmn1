<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /** Public pricing page. */
    public function pricing()
    {
        $plans = Plan::active()->orderBy('sort_order')->get();

        return view('frontend.subscription.pricing', [
            'plans'       => $plans,
            'current'     => Auth::check() ? Auth::user()->activeSubscription() : null,
            'razorpayKey' => config('services.razorpay.key'),
            'gatewayReady' => $this->gatewayReady(),
        ]);
    }

    /** Billing area inside the user dashboard. */
    public function billing()
    {
        $user = Auth::user();

        return view('frontend.subscription.billing', [
            'current' => $user->activeSubscription(),
            'history' => $user->subscriptions()->with('plan')->latest()->get(),
            'isPro'   => $user->isPro(),
        ]);
    }

    /** Create a Razorpay order for a paid plan. */
    public function createOrder(Request $request, Plan $plan)
    {
        if ($plan->is_free || !$plan->is_active) {
            return response()->json(['message' => 'This plan cannot be purchased.'], 422);
        }
        if (!$this->gatewayReady()) {
            return response()->json(['message' => 'Payments are not available right now. Please try again later.'], 503);
        }

        $amountInSubunit = (int) round($plan->price * 100);

        try {
            $response = Http::withBasicAuth(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            )->asJson()->post('https://api.razorpay.com/v1/orders', [
                'amount'   => $amountInSubunit,
                'currency' => config('services.razorpay.currency', 'INR'),
                'receipt'  => 'sub_' . $plan->id . '_' . now()->timestamp,
                'notes'    => [
                    'plan_id' => $plan->id,
                    'user_id' => Auth::id(),
                    'type'    => 'subscription',
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Subscription order failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Could not reach the payment gateway.'], 502);
        }

        if (!$response->successful()) {
            Log::error('Subscription order rejected', ['body' => $response->body()]);
            return response()->json(['message' => 'The payment gateway rejected the request.'], 502);
        }

        $order = $response->json();

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $order['amount'],
            'currency' => $order['currency'],
            'key'      => config('services.razorpay.key'),
            'plan'     => $plan->name,
            'name'     => Auth::user()->name,
            'email'    => Auth::user()->email,
        ]);
    }

    /** Verify payment signature, then activate the subscription. */
    public function verify(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $expected = hash_hmac(
            'sha256',
            $data['razorpay_order_id'] . '|' . $data['razorpay_payment_id'],
            (string) config('services.razorpay.secret')
        );

        if (!hash_equals($expected, $data['razorpay_signature'])) {
            Log::warning('Subscription signature mismatch', ['order' => $data['razorpay_order_id']]);
            return response()->json(['verified' => false, 'message' => 'Payment could not be verified.'], 422);
        }

        $user = Auth::user();

        // Extend from the later of now / current expiry so renewals stack.
        $current = $user->activeSubscription();
        $start = ($current && $current->ends_at && $current->ends_at->isFuture())
            ? $current->ends_at
            : now();

        $subscription = Subscription::create([
            'user_id'             => $user->id,
            'plan_id'             => $plan->id,
            'status'              => 'active',
            'amount'              => $plan->price,
            'starts_at'           => now(),
            'ends_at'             => $plan->periodEndsFrom($start),
            'razorpay_order_id'   => $data['razorpay_order_id'],
            'razorpay_payment_id' => $data['razorpay_payment_id'],
        ]);

        Log::info('Subscription activated', ['user' => $user->id, 'plan' => $plan->slug, 'sub' => $subscription->id]);

        return response()->json([
            'verified' => true,
            'message'  => "Welcome to {$plan->name}! Your subscription is now active.",
            'redirect' => route('billing'),
        ]);
    }

    private function gatewayReady(): bool
    {
        return !empty(config('services.razorpay.key')) && !empty(config('services.razorpay.secret'));
    }
}
