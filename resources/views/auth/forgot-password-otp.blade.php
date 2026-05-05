@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('OTP Verification') }}</div>

                <div class="card-body">
                    @include('backend_layouts.alert')
                    <p class="text-muted">{{ __('Please enter the 6-digit OTP sent to your email.') }}</p>

                    <form method="POST" action="{{ route('forgot-password-otp-verification') }}">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-8 d-flex justify-content-between">
                                @for ($i = 0; $i < 6; $i++)
                                    <input
                                        type="text"
                                        name="email_otp_number[]"
                                        class="form-control text-center mx-1 otp-digit @error('email_otp_number') is-invalid @enderror @error('email_otp_number.'.$i) is-invalid @enderror"
                                        maxlength="1"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        required
                                    >
                                @endfor
                            </div>
                        </div>

                        @error('email_otp_number')
                            <div class="row mb-2">
                                <div class="col-md-8 offset-md-2">
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                </div>
                            </div>
                        @enderror

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-2 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify OTP') }}
                                </button>
                                <a class="btn btn-outline-primary" href="{{ route('forgot-password-email') }}">
                                    {{ __('Resend OTP') }}
                                </a>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('Back to Login') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = Array.from(document.querySelectorAll('.otp-digit'));

        inputs.forEach(function (input, index) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 1);
                if (this.value && inputs[index + 1]) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'Backspace' && !this.value && inputs[index - 1]) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
@endsection
