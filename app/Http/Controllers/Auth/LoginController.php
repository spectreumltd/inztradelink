<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Jobs\ForgotPasswordOtpSendMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function loginForm()
    {
        Session::forget('forgot_password_user_id');
        return view('auth.login');
    }
    
    protected function validateLogin(Request $request)
    {
      
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        // dd($request->all());
    }

    protected function authenticated($request, $user)
    {
        if ($user->role_id == User::ADMIN || $user->role_id == User::SUPPLIER) {
            if (empty($user->email_verified_at)) {
                session(['pending_user_id' => $user->id]);

                return $user->role_id == User::SUPPLIER
                    ? redirect()->route('supplier.sendemailotp')
                    : redirect()->route('admin.sendemailotp');
            }

            if ((int) $user->is_active !== 1) {
                Auth::logout();

                return redirect()->back()->with('error', 'Your account is inactive, please contact support team.');
            }

            $this->redirectTo = $user->role_id == User::SUPPLIER
                ? route('supplier.dashboard')
                : route('admin.dashboard');
        } else {
            Auth::logout();
            return redirect()->back()->with('error','you have not right access for web login');
        }
    }
    
    public function logout()
    {
        Auth::logout();
        Session::forget('pending_user_id');
        Session::forget('forgot_password_user_id');
        return redirect()->route('login');
    }

    public function forgotPasswordEmail()
    {
        Session::forget('forgot_password_user_id');

        return view('auth.forgot-password-email');
    }

    public function forgotPasswordEmailVerification(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->string('email')->toString())->first();
        if (! $user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.'])->withInput();
        }

        ForgotPasswordOtpSendMail::dispatch($user);
        Session::put('forgot_password_user_id', $user->id);

        return redirect()->route('forgot-password-otp')->with('success', 'Password reset OTP has been sent to your email.');
    }

    public function forgotPasswordOtp(): RedirectResponse|\Illuminate\Contracts\View\View
    {
        if (! Session::has('forgot_password_user_id')) {
            return redirect()->route('forgot-password-email')->withErrors('Session expired. Please try again.');
        }

        return view('auth.forgot-password-otp');
    }

    public function forgotPasswordOtpVerification(Request $request): RedirectResponse
    {
        $request->validate([
            'email_otp_number' => ['required', 'array', 'size:6'],
            'email_otp_number.*' => ['required', 'digits:1'],
        ]);

        $userId = Session::get('forgot_password_user_id');
        $user = User::find($userId);
        if (! $user) {
            Session::forget('forgot_password_user_id');

            return redirect()->route('forgot-password-email')->withErrors('Session expired. Please try again.');
        }

        $otp = implode('', $request->input('email_otp_number', []));
        if ((string) $user->forgot_otp_number !== $otp) {
            return back()->withErrors(['email_otp_number' => 'Please enter a valid verification code.'])->withInput();
        }

        if (empty($user->forgot_otp_expires_at) || now()->greaterThan($user->forgot_otp_expires_at)) {
            return redirect()->route('forgot-password-email')->withErrors('Verification code expired. Please resend OTP.');
        }

        $user->forgot_verified_at = now();
        $user->save();

        return redirect()->route('reset-password')->with('success', 'Verification code verified successfully.');
    }

    public function resetPassword(): RedirectResponse|\Illuminate\Contracts\View\View
    {
        if (! Session::has('forgot_password_user_id')) {
            return redirect()->route('forgot-password-email')->withErrors('Session expired. Please try again.');
        }

        return view('auth.reset-password');
    }

    public function resetPasswordPost(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'min:8', 'max:24'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $userId = Session::get('forgot_password_user_id');
        $user = User::find($userId);
        if (! $user) {
            Session::forget('forgot_password_user_id');

            return redirect()->route('forgot-password-email')->withErrors('Session expired. Please try again.');
        }

        if (empty($user->forgot_verified_at)) {
            return redirect()->route('forgot-password-otp')->withErrors('Please verify OTP before resetting password.');
        }

        $user->password = Hash::make($request->string('password')->toString());
        $user->forgot_otp_number = null;
        $user->forgot_otp_expires_at = null;
        $user->forgot_verified_at = null;
        $user->save();

        Session::forget('forgot_password_user_id');

        return redirect()->route('login')->with('success', 'Your password has been changed successfully.');
    }
}
