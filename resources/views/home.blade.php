<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DSI') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('img/logodsi.png') }}" alt="Bromine" class="h-8 w-auto block md:hidden">
                    <img src="{{ asset('img/logo-dsi.png') }}" alt="Bromine" class="h-8 w-auto mr-3 hidden md:block">
                </div>
      
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-red-500 hover:text-red-600 font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                Logout
                            </button>
                        </form>
                    @else
                    
                        <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gray-50 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Website Room Booking DSI
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                       Booking ruang meeting lebih cepat, lebih rapi, tanpa konflik jadwal.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('user.bookings.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-200 text-center">
                                Pilih Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-red-500 hover:bg-red-600 text-white px-8 py-3 rounded-lg font-semibold transition duration-200 text-center">
                               Mulai
                            </a>
                        @endauth
                        <a href="#rooms" class="border-2 border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500 px-8 py-3 rounded-lg font-semibold transition duration-200 text-center">
                            Lihat Ruangan
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Building Image -->
                <div class="relative">
                    <div class="relative z-10">
                        <!-- Building illustration placeholder -->
                        <div class="w-full h-96 bg-gradient-to-br from-teal-400 via-blue-500 to-blue-800 rounded-lg shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent rounded-lg"></div>
                            <!-- Building windows pattern -->
                            <div class="absolute inset-4 grid grid-cols-8 gap-1">
                                @for($i = 0; $i < 64; $i++)
                                    <div class="bg-white/20 rounded-sm {{ $i % 3 == 0 ? 'bg-yellow-300/40' : '' }}"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!-- Background decoration -->
                    <div class="absolute top-4 left-4 w-full h-96 bg-gradient-to-br from-red-200 to-red-300 rounded-lg -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Ruang Meeting Tersedia</h3>
                <p class="text-lg text-gray-600">
                    Pilih ruangan yang sesuai dengan kebutuhan meeting Anda. 
                    Klik pada card ruangan untuk melihat kalender ketersediaan.
                </p>
            </div>

            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($rooms as $room)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer border border-gray-200"
                             onclick="window.location.href='{{ route('calendar.room', $room->id) }}'">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xl font-semibold text-gray-900">{{ $room->name }}</h4>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Tersedia
                                    </span>
                                </div>
                                
                                @if($room->description)
                                    <p class="text-gray-600 mb-4">{{ $room->description }}</p>
                                @endif
                                
                                <div class="flex items-center mb-4">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Kapasitas: {{ $room->capacity }} orang</span>
                                </div>
                                
                                @if($room->facilities && count($room->facilities) > 0)
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-gray-900 mb-2">Fasilitas:</h5>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($room->facilities as $facility)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                    {{ $facility }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <span class="text-sm text-gray-500">Klik untuk lihat kalender</span>
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada ruangan tersedia</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada ruang meeting yang terdaftar dalam sistem.</p>
                </div>
            @endif
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h4 class="text-lg font-semibold mb-2">Digital Sarana Indonesia</h4>
                <p class="text-gray-400">© {{ date('Y') }} All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>