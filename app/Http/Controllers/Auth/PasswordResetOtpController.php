<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordResetOtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetOtpController extends Controller
{
    public function create(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has('password_reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', [
            'email' => $request->session()->get('password_reset_email'),
        ]);
    }

    public function store(Request $request, PasswordResetOtpService $otpService): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        if (! $otpService->verifyOtp($email, $request->string('otp')->trim())) {
            return redirect()
                ->route('password.verify-otp')
                ->withErrors([
                    'otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
                ]);
        }

        return redirect()
            ->route('password.reset')
            ->with('status', 'otp-verified');
    }

    public function resend(Request $request, PasswordResetOtpService $otpService): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        $otpService->sendOtp($email);

        return redirect()
            ->route('password.verify-otp')
            ->with('status', 'otp-resent');
    }
}
