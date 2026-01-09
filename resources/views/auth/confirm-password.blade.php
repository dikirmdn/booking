<x-guest-layout>
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Confirm Password</h2>
        <p class="text-gray-600">Please confirm your password to continue</p>
    </div>

    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
        <p class="text-sm text-amber-700">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button>
                {{ __('Confirm Password') }}
            </x-primary-button>
        </div>

        <!-- Back Link -->
        <div class="text-center pt-4 border-t border-gray-100">
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                {{ __('Go Back') }}
            </a>
        </div>
    </form>
</x-guest-layout>
