<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex items-center justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-templax-600 dark:text-templax-400" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <x-label for="email" :value="__('Email')" required="true" />
                <x-input id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    placeholder="your.email@example.com"
                    :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-5 w-5\' viewBox=\'0 0 20 20\' fill=\'currentColor\'><path d=\'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z\' /><path d=\'M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z\' /></svg>'"
                />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-label for="password" :value="__('Password')" required="true" />
                <x-password-input
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <!-- Remember Me and Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <x-checkbox id="remember_me" name="remember" :label="__('Remember me')" />

                @if (Route::has('password.request'))
                    <a class="text-sm text-templax-600 hover:text-templax-500 dark:text-templax-400 dark:hover:text-templax-300 hover:underline transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="flex flex-col space-y-4">
                <x-button>
                    {{ __('Sign in') }}
                </x-button>

                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="text-templax-600 hover:text-templax-500 dark:text-templax-400 dark:hover:text-templax-300 hover:underline transition-colors duration-200">
                        {{ __('Sign up') }}
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
