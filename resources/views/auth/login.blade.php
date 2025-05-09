<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TemplaX') }} - Login</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="logo-container">
            <a href="/">
                <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path d="M158 0C70.7 0 0 70.7 0 158s70.7 158 158 158 158-70.7 158-158S245.3 0 158 0zm-35.7 256h-22.1V60h22.1v196zm93.5 0h-22.1v-87.7l-50.2-74.6h27l36.2 58.9 35.4-58.9h26.6l-52.9 74.6V256z"/>
                </svg>
            </a>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>TemplaX</h2>
                <p>Business Card Generator</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label form-label-required">Email</label>
                    <div class="input-with-icon">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </span>
                        <input id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="your.email@example.com"
                        >
                    </div>
                    @error('email')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label form-label-required">Password</label>
                    <div class="password-input-container">
                        <input id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="d-flex justify-between align-center mb-4">
                    <div class="form-checkbox-group">
                        <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        <label for="remember_me" class="form-checkbox-label">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="auth-link text-sm" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    Sign in
                </button>

                <div class="text-center text-sm mt-4">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="auth-link">
                        Sign up
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</body>
</html>
