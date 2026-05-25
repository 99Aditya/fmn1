<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Str;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'A password reset link has been sent to your email address.')
            : back()->withErrors(['email' => 'Unable to send password reset link. Please try again.']);
    }

    public function showResetForm(Request $request, string $token = null)
    {
        return view('frontend.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset. You can now sign in.')
            : back()->withErrors(['email' => 'Unable to reset password. Please check your link and try again.']);
    }
}
