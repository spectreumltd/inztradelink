@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Email OTP Verification') }}</div>

                <div class="card-body">
                    @include('backend_layouts.alert')

                    <p class="mb-3">
                        OTP sent to <strong>{{ $email }}</strong>. Enter the 6-digit code below.
                    </p>

                    <form method="POST" action="{{ route($verificationRoute ?? 'admin.emailotpverification') }}">
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
                                        {{ $i === 0 ? 'autofocus' : '' }}
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
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify OTP') }}
                                </button>
                                <a class="btn btn-link" href="{{ route($resendRoute ?? 'admin.resendemailotp') }}">
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
