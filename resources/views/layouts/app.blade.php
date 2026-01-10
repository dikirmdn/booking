<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50" 
          x-data="{ 
              sidebarOpen: false,
              init() {
                  // Auto-open sidebar on desktop
                  if (window.innerWidth >= 1024) {
                      this.sidebarOpen = true;
                  }
                  // Handle window resize
                  window.addEventListener('resize', () => {
                      if (window.innerWidth >= 1024) {
                          this.sidebarOpen = true;
                      }
                  });
              }
          }">
        <div class="min-h-screen flex">
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"></div>

            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:ml-0">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
                    <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <div class="flex-1 lg:flex-none">
                            @isset($header)
                                <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                    {{ $header }}
                                </h2>
                            @endisset
                        </div>
                        
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            @auth
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                            <span class="hidden sm:inline font-medium">{{ Auth::user()->name }}</span>
                                            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <div class="flex space-x-2 sm:space-x-4">
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 border-2 border-gray-300 px-3 sm:px-4 py-2 rounded-lg font-medium text-sm sm:text-base">Login</a>
                                    <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg font-medium text-sm sm:text-base">Register</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-3 sm:p-4 lg:p-6">
                    <!-- Flash Messages -->
                    <x-flash-messages />
                    
                    {{ $slot }}
                </main>

            </div>
        </div>

        <!-- Notification Helper -->
        <x-notification-helper />

        @stack('scripts')
    </body>
</html>
