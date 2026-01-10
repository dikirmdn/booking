<x-guest-layout>
<div class="mb-8 text-center">
    <h2 class="mb-2 text-3xl font-bold text-gray-800">Selamat Datang</h2>
    <p class="text-gray-600">Silakan Login Untuk Membuka Fitur Booking</p>
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-6" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Username -->
    <div>
        <x-input-label for="username" :value="__('Username')" />
        <x-text-input id="username" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Masukkan username anda" />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- Password -->
    <div>
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan Password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me & Forgot Password
    <div class="flex items-center justify-between">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="text-blue-600 border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:ring-offset-0" name="remember">
            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>

        @if (Route::has('password.request'))
            <a class="text-sm font-medium text-blue-600 transition-colors duration-200 hover:text-blue-800" href="{{ route('password.request') }}">
                {{ __('Forgot password?') }}
            </a>
        @endif
    </div> -->

    <!-- Login Button -->
    <div class="pt-2">
        <x-primary-button>
            {{ __('Sign In') }}
        </x-primary-button>
    </div>
</form>
</x-guest-layout>
