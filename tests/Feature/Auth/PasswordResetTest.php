<?php

namespace Tests\Feature\Auth;

use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_otp_can_be_requested(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('password.verify-otp'));

        Mail::assertSent(PasswordResetOtpMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_verify_otp_screen_can_be_rendered(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        $response = $this->get('/forgot-password/verify-otp');

        $response->assertStatus(200);
    }

    public function test_reset_password_screen_can_be_rendered_after_otp_verification(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $otp = null;

        $this->post('/forgot-password', ['email' => $user->email]);

        Mail::assertSent(PasswordResetOtpMail::class, function ($mail) use (&$otp) {
            $otp = $mail->otp;

            return true;
        });

        $this->post('/forgot-password/verify-otp', ['otp' => $otp])
            ->assertRedirect(route('password.reset'));

        $response = $this->get('/reset-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_reset_with_valid_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $otp = null;

        $this->post('/forgot-password', ['email' => $user->email]);

        Mail::assertSent(PasswordResetOtpMail::class, function ($mail) use (&$otp) {
            $otp = $mail->otp;

            return true;
        });

        $this->post('/forgot-password/verify-otp', ['otp' => $otp])
            ->assertRedirect(route('password.reset'));

        $response = $this->post('/reset-password', [
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_invalid_otp_is_rejected(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        $response = $this->post('/forgot-password/verify-otp', ['otp' => '000000']);

        $response
            ->assertSessionHasErrors('otp')
            ->assertRedirect('/forgot-password/verify-otp');
    }

    public function test_reset_password_page_requires_verified_otp(): void
    {
        $response = $this->get('/reset-password');

        $response->assertRedirect(route('password.request'));
    }
}
