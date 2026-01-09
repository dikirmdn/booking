<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DSI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
            
            <div class="relative flex flex-col justify-center items-center min-h-screen px-4 py-12">
                <!-- Logo Section -->
                <div class="mb-8">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-32 h-16 md:w-52 md:h-24 rounded-xl flex items-center justify-center shadow-lg">
                            <x-application-logo  />
                        </div>
                       
                    </a>
                </div>

                <!-- Main Card -->
                <div class="w-full max-w-md">
                    <div class="bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20 overflow-hidden">
                        <div class="px-8 py-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        © {{ date('Y') }} {{ config('app.name', 'DSI') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
