@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    @include('backend_layouts.alert')
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6 position-relative">
                                <input id="password" type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <button type="button" id="togglePassword" class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-secondary" aria-label="{{ __('Show password') }}">
                                    <svg id="eyeOpenIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.1 13.1 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13.1 13.1 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13.1 13.1 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                    </svg>
                                    <svg id="eyeClosedIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="d-none">
                                        <path d="M13.359 11.238C14.142 10.468 14.738 9.55 15.145 8.77c.193-.367.33-.703.422-.97.046-.133.08-.248.102-.341a2.1 2.1 0 0 0 .027-.136l.004-.017v-.004l.001-.002 0-.001a.75.75 0 0 0-1.462-.302l.001-.001-.003.01a2.2 2.2 0 0 1-.057.19 6.4 6.4 0 0 1-.364.844c-.34.655-.85 1.446-1.54 2.123l1.063 1.075zM11.297 9.154l1.302 1.317A12.7 12.7 0 0 1 8 12.5c-1.52 0-2.87-.5-4.03-1.19l1.19-1.203A3.5 3.5 0 0 0 11.297 9.154"/>
                                        <path d="M3.35 5.47A12.7 12.7 0 0 0 1.86 7.23a6.4 6.4 0 0 0-.364.844 2.2 2.2 0 0 0-.057.19l-.003.01v.001a.75.75 0 0 1-1.462-.302l.001-.002.004-.017.027-.136a3.2 3.2 0 0 1 .102-.341c.092-.267.229-.603.422-.97.407-.78 1.003-1.698 1.786-2.468L.646 2.354a.5.5 0 1 1 .708-.708l12 12a.5.5 0 0 1-.708.708z"/>
                                        <path d="M5.354 6.768l3.878 3.878a2.5 2.5 0 0 1-3.878-3.878"/>
                                    </svg>
                                </button>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('forgot-password-email'))
                                    <a class="btn btn-link" href="{{ route('forgot-password-email') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <a class="btn btn-link" href="{{ route('supplier-sign-up') }}">
                                    {{ __('Supplier Sign Up') }}
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
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeOpenIcon = document.getElementById('eyeOpenIcon');
        const eyeClosedIcon = document.getElementById('eyeClosedIcon');

        if (!passwordInput || !toggleButton || !eyeOpenIcon || !eyeClosedIcon) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpenIcon.classList.toggle('d-none', !isPassword);
            eyeClosedIcon.classList.toggle('d-none', isPassword);
            toggleButton.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    });
</script>
@endsection
