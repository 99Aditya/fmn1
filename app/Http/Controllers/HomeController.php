<?php

namespace App\Http\Controllers;

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
}
