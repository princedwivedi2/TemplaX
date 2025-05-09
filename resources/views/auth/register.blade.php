<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex items-center justify-center">
                <x-application-logo class="w-20 h-20 fill-current text-templax-600 dark:text-templax-400" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <x-label for="name" :value="__('Full Name')" required="true" />
                <x-input id="name"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    placeholder="John Doe"
                    :icon="'<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-5 w-5\' viewBox=\'0 0 20 20\' fill=\'currentColor\'><path fill-rule=\'evenodd\' d=\'M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z\' clip-rule=\'evenodd\' /></svg>'"
                />
            </div>

            <!-- Email Address -->
            <div class="mb-6">
                <x-label for="email" :value="__('Email')" required="true" />
                <x-input id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
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
                    autocomplete="new-password"
                />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Password must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-label for="password_confirmation" :value="__('Confirm Password')" required="true" />
                <x-password-input
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                />
            </div>

            <div class="flex flex-col space-y-4">
                <x-button>
                    {{ __('Create Account') }}
                </x-button>

                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}" class="text-templax-600 hover:text-templax-500 dark:text-templax-400 dark:hover:text-templax-300 hover:underline transition-colors duration-200">
                        {{ __('Sign in') }}
                    </a>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
