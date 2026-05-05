<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordOtpSendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function handle(): void
    {
        $otpExpireAt = now()->addMinutes(5);
        $otp = (string) random_int(100000, 999999);

        $this->user->forgot_otp_number = $otp;
        $this->user->forgot_otp_expires_at = $otpExpireAt;
        $this->user->forgot_verified_at = null;
        $this->user->save();

        Mail::send('emails.forgot-password-otp', [
            'name' => $this->user->name,
            'forgot_otp_number' => $otp,
            'forgot_otp_expires_at' => $otpExpireAt->format('Y-m-d H:i:s'),
        ], function ($message): void {
            $message->to($this->user->email)
                ->subject('Forgot Password OTP');
        });
    }
}
