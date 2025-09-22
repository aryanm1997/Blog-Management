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

    .register-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        width: 450px;
        max-width: 95%;
        transition: all 0.3s ease;
    }

    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .register-card-header {
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
        .register-card-header {
            font-size: 1.5rem;
            padding: 15px;
        }
    }
</style>

<div class="register-card">
    <div class="register-card-header">{{ __('Register') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Full Name') }}</label>
                <input id="name" type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                       placeholder="Enter your name">
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" 
                       placeholder="Enter your email">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password" 
                       placeholder="Enter password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" 
                       class="form-control" 
                       name="password_confirmation" required autocomplete="new-password" 
                       placeholder="Re-enter password">
            </div>

            <!-- Register Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <small class="text-muted">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="btn-link fw-bold">Login</a>
                </small>
            </div>
        </form>
    </div>

    <div class="card-footer">
        &copy; 2025 My Application
    </div>
</div>
@endsection
