<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\EmailVerificationOtpSendMail;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailOtpVerificationController extends Controller
{
    public function sendEmailOtp(Request $request): View|RedirectResponse
    {
        $user = $this->pendingUser();
        if (! $user) {
            return redirect()->route('login')->withErrors('Session expired. Please login again.');
        }

        if (empty($user->email_otp_number) || empty($user->email_otp_expires_at) || now()->greaterThan($user->email_otp_expires_at)) {
            EmailVerificationOtpSendMail::dispatch($user);
        }

        return view('auth.email-otp-verification', [
            'email' => $user->email,
            'verificationRoute' => $this->routeNameByPrefix($request, 'emailotpverification'),
            'resendRoute' => $this->routeNameByPrefix($request, 'resendemailotp'),
        ]);
    }

    public function resendEmailOtp(Request $request): RedirectResponse
    {
        $user = $this->pendingUser();
        if (! $user) {
            return redirect()->route('login')->withErrors('Session expired. Please login again.');
        }

        EmailVerificationOtpSendMail::dispatch($user);

        return redirect()
            ->route($this->routeNameByPrefix($request, 'sendemailotp'))
            ->with('success', 'A new OTP has been sent to your email.');
    }

    public function emailOtpVerification(Request $request): RedirectResponse
    {
        $request->validate([
            'email_otp_number' => ['required', 'array', 'size:6'],
            'email_otp_number.*' => ['required', 'digits:1'],
        ]);

        $user = $this->pendingUser();
        if (! $user) {
            return redirect()->route('login')->withErrors('Session expired. Please login again.');
        }

        $otp = implode('', $request->input('email_otp_number', []));

        if ((string) $user->email_otp_number !== $otp) {
            return back()->withErrors('Please enter a valid verification code.');
        }

        if (empty($user->email_otp_expires_at) || now()->greaterThan($user->email_otp_expires_at)) {
            return redirect()
                ->route($this->routeNameByPrefix($request, 'sendemailotp'))
                ->withErrors('Verification code expired. Please resend OTP.');
        }

        $user->email_verified_at = now();
        $user->email_otp_number = null;
        $user->email_otp_expires_at = null;
        $user->save();

        session()->forget('pending_user_id');
        Auth::login($user, false);
        $request->session()->regenerate();

        return $user->role_id == User::SUPPLIER
            ? redirect()->route('supplier.dashboard')
            : redirect()->route('admin.dashboard');
    }

    private function pendingUser(): ?User
    {
        $pendingUserId = session('pending_user_id');
        if (! $pendingUserId) {
            return null;
        }

        return User::find($pendingUserId);
    }

    private function routeNameByPrefix(Request $request, string $action): string
    {
        $path = trim($request->path(), '/');

        return str_starts_with($path, 'supplier/')
            ? "supplier.{$action}"
            : "admin.{$action}";
    }
}
