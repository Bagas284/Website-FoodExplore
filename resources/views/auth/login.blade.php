<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div>
        <x-slot name="header">
            <div class="d-flex justify-content-center align-items-center">
                <p class="display-5">Login</p>
            </div>

        </x-slot>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                
                <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
                
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <div class="d-grid gap-2">
                    <x-primary-button class="w-100">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-2">
                <!-- Remember Me -->
                <label for="remember_me" class="d-inline-flex align-items-center me-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                <a class="text-secondary text-decoration-none text-sm text-gray-600 hover:text-gray-900 rounded focus-outline-none focus-ring-2 focus-ring-offset-2 focus-ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
                @endif
            </div>

            <div class="d-flex justify-content-center align-items-center my-4">
                <p>Don't have a account?
                    <a class="text-warning text-decoration-none text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
