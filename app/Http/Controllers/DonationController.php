<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    /** Show the donation page. */
    public function show()
    {
        return view('frontend.donate', [
            'enabled'     => $this->isConfigured(),
            'razorpayKey' => config('services.razorpay.key'),
            'currency'    => config('services.razorpay.currency', 'INR'),
        ]);
    }

    /** Create a Razorpay order and return it as JSON for the checkout widget. */
    public function createOrder(Request $request)
    {
        if (!$this->isConfigured()) {
            return response()->json(['message' => 'Online donations are not available right now. Please check back soon.'], 503);
        }

        $data = $request->validate([
            'amount' => 'required|numeric|min:1|max:500000',
            'name'   => 'nullable|string|max:120',
            'email'  => 'nullable|email|max:160',
        ]);

        $currency = config('services.razorpay.currency', 'INR');
        $amountInSubunit = (int) round($data['amount'] * 100); // Razorpay expects the smallest currency unit (paise).

        try {
            $response = Http::withBasicAuth(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            )->asJson()->post('https://api.razorpay.com/v1/orders', [
                'amount'   => $amountInSubunit,
                'currency' => $currency,
                'receipt'  => 'donation_' . now()->timestamp,
                'notes'    => [
                    'name'  => $data['name'] ?? 'Anonymous',
                    'email' => $data['email'] ?? '',
                    'type'  => 'donation',
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Razorpay order creation failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Could not reach the payment gateway. Please try again.'], 502);
        }

        if (!$response->successful()) {
            Log::error('Razorpay order rejected', ['status' => $response->status(), 'body' => $response->body()]);
            return response()->json(['message' => 'The payment gateway rejected the request. Please try again.'], 502);
        }

        $order = $response->json();

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $order['amount'],
            'currency' => $order['currency'],
            'key'      => config('services.razorpay.key'),
            'payee'    => config('services.razorpay.payee', 'FindMyNaukri'),
            'name'     => $data['name'] ?? '',
            'email'    => $data['email'] ?? '',
        ]);
    }

    /** Verify the Razorpay payment signature after checkout completes. */
    public function verify(Request $request)
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
            Log::warning('Razorpay signature mismatch', ['order' => $data['razorpay_order_id']]);
            return response()->json(['verified' => false, 'message' => 'Payment could not be verified.'], 422);
        }

        Log::info('Donation received', [
            'payment_id' => $data['razorpay_payment_id'],
            'order_id'   => $data['razorpay_order_id'],
        ]);

        return response()->json([
            'verified' => true,
            'message'  => 'Thank you for your generous support!',
        ]);
    }

    private function isConfigured(): bool
    {
        return !empty(config('services.razorpay.key')) && !empty(config('services.razorpay.secret'));
    }
}
