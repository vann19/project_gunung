<?php

namespace App\Services;

use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetOtpService
{
    private const OTP_TTL_SECONDS = 600;

    private const VERIFIED_TTL_SECONDS = 900;

    private const MAX_ATTEMPTS = 5;

    public function sendOtp(string $email): bool
    {
        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            return false;
        }

        $otp = (string) random_int(100000, 999999);

        Cache::put($this->otpCacheKey($email), [
            'hash' => Hash::make($otp),
            'attempts' => 0,
        ], self::OTP_TTL_SECONDS);

        Cache::forget($this->verifiedCacheKey($email));

        Mail::to($user->email)->send(new PasswordResetOtpMail($otp, $user->name));

        return true;
    }

    public function verifyOtp(string $email, string $otp): bool
    {
        $cacheKey = $this->otpCacheKey($email);
        $payload = Cache::get($cacheKey);

        if (! is_array($payload) || ! isset($payload['hash'])) {
            return false;
        }

        if (($payload['attempts'] ?? 0) >= self::MAX_ATTEMPTS) {
            Cache::forget($cacheKey);

            return false;
        }

        if (! Hash::check($otp, $payload['hash'])) {
            $payload['attempts'] = ($payload['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $payload, self::OTP_TTL_SECONDS);

            return false;
        }

        Cache::forget($cacheKey);
        Cache::put($this->verifiedCacheKey($email), true, self::VERIFIED_TTL_SECONDS);

        return true;
    }

    public function isVerified(string $email): bool
    {
        return Cache::get($this->verifiedCacheKey($email)) === true;
    }

    public function clear(string $email): void
    {
        Cache::forget($this->otpCacheKey($email));
        Cache::forget($this->verifiedCacheKey($email));
    }

    private function otpCacheKey(string $email): string
    {
        return 'password_reset_otp:'.Str::lower($email);
    }

    private function verifiedCacheKey(string $email): string
    {
        return 'password_reset_verified:'.Str::lower($email);
    }
}
