<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;

class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }
    public function community()
    {
        return view('frontend.community');
    }

    public function ats() {
        return view('frontend.ats');
    }
    public function mock() {
        return view('frontend.mock');
    }
    public function mcqChallenge() {
        return view('frontend.mcq-challenge');
    }

    public function mcqTest() {
        return view('frontend.mcq-test');
    }

    public function about() {
        return view('frontend.about');
    }

    public function contact() {
        return view('frontend.contactus');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'accepted',
        ]);

        ContactUs::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Thanks! Your message has been sent. We\'ll reply shortly.');
    }
    public function privacyPolicy() {
        return view('frontend.privacy-policy');
    }
    public function termsOfService() {
        return view('frontend.terms-of-service');
    }
}
