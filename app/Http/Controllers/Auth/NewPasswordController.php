<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PasswordResetOtpService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request, PasswordResetOtpService $otpService): RedirectResponse|View
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email || ! $otpService->isVerified($email)) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    public function store(Request $request, PasswordResetOtpService $otpService): RedirectResponse
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email || ! $otpService->isVerified($email)) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $otpService->clear($email);
            $request->session()->forget('password_reset_email');

            return redirect()->route('password.request');
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        $otpService->clear($email);
        $request->session()->forget('password_reset_email');

        return redirect()
            ->route('login')
            ->with('status', 'password-reset-success');
    }
}
