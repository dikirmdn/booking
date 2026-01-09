<x-guest-layout>
<div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Sealamat Datang</h2>
    <p class="text-gray-600">Silakan Login Untuk Mmebuka Fitur Booking</p>
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-6" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email anda" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-0" name="remember">
            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>

        @if (Route::has('password.request'))
            <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200" href="{{ route('password.request') }}">
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
