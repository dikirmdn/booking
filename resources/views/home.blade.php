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
    @vite(['resources/css/app.css', 'resources/css/home-rooms.css', 'resources/css/footer.css', 'resources/css/home-animations.css', 'resources/js/app.js', 'resources/js/header-scroll.js', 'resources/js/home-animations.js'])
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
                <div class="hero-content">
                    <h1 class="hero-title text-4xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Website Room Booking DSI
                    </h1>
                    <p class="hero-description text-lg text-gray-600 mb-8 leading-relaxed">
                       Booking ruang meeting lebih cepat, lebih rapi, tanpa konflik jadwal.
                    </p>
                    <div class="hero-buttons flex flex-col sm:flex-row gap-4">
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
                <div class="hero-image relative">
                    <div class="relative z-10">
                        <!-- Building illustration placeholder -->
                        <div class="hero-building w-full h-96 bg-gradient-to-br from-teal-400 via-blue-500 to-blue-800 rounded-lg shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
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
                    <div class="hero-building-bg absolute top-4 left-4 w-full h-96 bg-gradient-to-br from-red-200 to-red-300 rounded-lg -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rooms-header text-center mb-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Ruang Meeting Tersedia</h3>
                <p class="text-lg text-gray-600">
                    Pilih ruangan yang sesuai dengan kebutuhan meeting Anda. 
                    Klik pada card ruangan untuk melihat kalender ketersediaan.
                </p>
            </div>

            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach($rooms as $room)
                        <div class="room-card relative overflow-hidden rounded-xl enhanced-shadow hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-1 group bg-pattern"
                             onclick="window.location.href='{{ route('calendar.room', $room->id) }}'">
                            
                            <!-- Background dengan tema kalender dan ruangan -->
                            <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-rose-50 to-pink-50"></div>
                            
                            <!-- Pattern kalender sebagai background -->
                            <div class="absolute inset-0 opacity-10 calendar-pattern">
                                <div class="grid grid-cols-7 gap-1 p-4 h-full">
                                    @for($i = 1; $i <= 35; $i++)
                                        <div class="bg-red-300 rounded-sm {{ $i % 7 == 0 ? 'bg-rose-400' : '' }} {{ $i % 5 == 0 ? 'bg-pink-300' : '' }}"></div>
                                    @endfor
                                </div>
                            </div>
                            
                            <!-- Icon ruangan di pojok kanan atas -->
                            <div class="absolute top-4 right-4 opacity-20 group-hover:opacity-30 transition-opacity duration-300 room-icon">
                                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    <circle cx="12" cy="10" r="2" stroke-width="1.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14h8"/>
                                </svg>
                            </div>
                            
                            <!-- Konten card -->
                            <div class="relative p-6 bg-white/80 backdrop-blur-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Icon kalender mini -->
                                        <div class="calendar-mini-icon flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-md">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-900 gradient-text">{{ $room->name }}</h4>
                                    </div>
                                    <span class="status-available bg-gradient-to-r from-green-400 to-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                        Tersedia
                                    </span>
                                </div>
                                
                                @if($room->description)
                                    <p class="text-gray-700 mb-4 leading-relaxed">{{ $room->description }}</p>
                                @endif
                                
                                <div class="flex items-center mb-4 bg-red-50/50 rounded-lg p-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">Kapasitas: <span class="capacity-highlight text-red-600 font-bold">{{ $room->capacity }} orang</span></span>
                                </div>
                                
                                @if($room->facilities && count($room->facilities) > 0)
                                    <div class="mb-4">
                                        <h5 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                            <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Fasilitas:
                                        </h5>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($room->facilities as $facility)
                                                <span class="facility-badge bg-gradient-to-r from-red-100 to-rose-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full border border-red-200">
                                                    {{ $facility }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200/60">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Klik untuk lihat kalender
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                                        <svg class="w-5 h-5 text-red-600 arrow-animate" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hover effect overlay -->
                            <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-rose-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
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
    <x-footer />
</body>
</html>