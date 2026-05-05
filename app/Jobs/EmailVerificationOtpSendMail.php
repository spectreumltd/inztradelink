<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailVerificationOtpSendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public function __construct(public User $user)
    {
        
    }

    public function handle(): void
    {
        $otpExpireAt = now()->addMinutes(5);
        $otp = (string) random_int(100000, 999999);

        $this->user->email_otp_number = $otp;
        $this->user->email_otp_expires_at = $otpExpireAt;
        $this->user->save();

        Mail::send('emails.email-verification', [
            'name' => $this->user->name,
            'email_otp_number' => $otp,
            'email_otp_expires_at' => $otpExpireAt->format('Y-m-d H:i:s'),
        ], function ($message): void {
            $message->to($this->user->email)
                ->subject('Email Verification OTP');
        });
    }
}
