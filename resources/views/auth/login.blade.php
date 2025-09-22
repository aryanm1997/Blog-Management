@extends('layouts.app')

@section('content')
<style>
    body {
        background: white;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        width: 400px;
        max-width: 450px;
        transition: all 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .login-card-header {
        background: #6c63ff;
        color: #fff;
        font-size: 1.75rem;
        text-align: center;
        padding: 20px;
        font-weight: 600;
    }

    .card-body {
        padding: 30px 25px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.4);
    }

    .btn-primary {
        background: #6c63ff;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #584bd1;
    }

    .btn-link {
        color: #6c63ff;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .remember-me {
        font-size: 0.9rem;
    }

    .card-footer {
        text-align: center;
        font-size: 0.85rem;
        padding: 15px;
        background: #f7f7f7;
        color: #888;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .card-body {
            padding: 20px;
        }
        .login-card-header {
            font-size: 1.5rem;
            padding: 15px;
        }
    }
</style>

<div class="login-card">
    <div class="login-card-header">{{ __('Login') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" 
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label remember-me" for="remember">{{ __('Remember Me') }}</label>
            </div>

            <!-- Login Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            </div>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>

    <div class="card-footer">
        &copy; 2025 My Application
    </div>
</div>
@endsection
