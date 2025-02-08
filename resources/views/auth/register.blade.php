<x-guest-layout>
    <div>
        <x-slot name="header">
            <div class="d-flex justify-content-center align-items-center">
                <p class="display-5">Register</p>
            </div>
        </x-slot>

        <!-- Form with enctype for file upload -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role Selection -->
            <div class="mt-2">
                <x-input-label for="role" :value="__('Register As')" />
                <select id="role" name="role" class="form-select mt-1" aria-label="Default select example" required>
                    <option value="">Pilih role anda</option>
                    <option value="User">Pembeli</option>
                    <option value="Warung">Warung</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-2">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-2">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Profile Photo -->
            <div class="mt-2">
                <x-input-label for="photo_profile" :value="__('Photo Profile')" />
                <input id="photo_profile" class="block mt-1 w-full" type="file" name="photo_profile" accept="image/*" />
                <x-input-error :messages="$errors->get('photo_profile')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <div class="d-grid gap-2">
                    <x-primary-button class="w-100">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>

            <!-- Link to login page -->
            <div class="d-flex justify-content-center align-items-center my-4">
                <p>Have an account?
                    <a class="text-warning text-decoration-none text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
            
        </form>
    </div>
</x-guest-layout>
