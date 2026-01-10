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
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('img/logodsi.png') }}" alt="Bromine" class="block w-auto h-8 md:hidden">
                    <img src="{{ asset('img/logo-dsi.png') }}" alt="Bromine" class="hidden w-auto h-8 mr-3 md:block">
                </div>
      
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="font-medium text-red-500 hover:text-red-600">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 font-medium text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                                Logout
                            </button>
                        </form>
                    @else
                    
                        <a href="{{ route('login') }}" class="px-6 py-2 font-medium text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-16 bg-gray-50 lg:py-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
                <div class="hero-content">
                    <h1 class="mb-6 text-4xl font-bold leading-tight text-gray-900 hero-title lg:text-6xl">
                        Website Room Booking DSI
                    </h1>
                    <p class="mb-8 text-lg leading-relaxed text-gray-600 hero-description">
                       Booking ruang meeting lebih cepat, lebih rapi, tanpa konflik jadwal.
                    </p>
                    <div class="flex flex-col gap-4 hero-buttons sm:flex-row">
                        @auth
                            <a href="{{ route('user.bookings.create') }}" class="px-8 py-3 font-semibold text-center text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                                Pilih Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 font-semibold text-center text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                               Mulai
                            </a>
                        @endauth
                        <a href="#rooms" class="px-8 py-3 font-semibold text-center text-gray-700 transition duration-200 border-2 border-gray-300 rounded-lg hover:border-red-500 hover:text-red-500">
                            Lihat Ruangan
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Building Image -->
                <div class="relative hero-image">
                    <div class="relative z-10">
                        <!-- Building illustration placeholder -->
                        <div class="w-full transition-transform duration-300 transform rounded-lg shadow-2xl hero-building h-96 bg-gradient-to-br from-teal-400 via-blue-500 to-blue-800 rotate-3 hover:rotate-0">
                            <div class="absolute inset-0 rounded-lg bg-gradient-to-t from-blue-900/20 to-transparent"></div>
                            <!-- Building windows pattern -->
                            <div class="absolute grid grid-cols-8 gap-1 inset-4">
                                @for($i = 0; $i < 64; $i++)
                                    <div class="bg-white/20 rounded-sm {{ $i % 3 == 0 ? 'bg-yellow-300/40' : '' }}"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!-- Background decoration -->
                    <div class="absolute w-full rounded-lg hero-building-bg top-4 left-4 h-96 bg-gradient-to-br from-red-200 to-red-300 -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-16">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-12 text-center rooms-header">
                <h3 class="mb-4 text-3xl font-bold text-gray-900">Ruang Meeting Tersedia</h3>
                <p class="text-lg text-gray-600">
                    Pilih ruangan yang sesuai dengan kebutuhan meeting Anda. 
                    Klik pada card ruangan untuk melihat kalender ketersediaan.
                </p>
            </div>

            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
                    @foreach($rooms as $room)
                        <div class="relative overflow-hidden transition-all duration-300 transform cursor-pointer room-card rounded-xl enhanced-shadow hover:shadow-xl hover:-translate-y-1 group bg-pattern"
                             onclick="window.location.href='{{ route('calendar.room', $room->id) }}'">
                            
                            <!-- Background dengan tema kalender dan ruangan -->
                            <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-rose-50 to-pink-50"></div>
                            
                            <!-- Pattern kalender sebagai background -->
                            <div class="absolute inset-0 opacity-10 calendar-pattern">
                                <div class="grid h-full grid-cols-7 gap-1 p-4">
                                    @for($i = 1; $i <= 35; $i++)
                                        <div class="bg-red-300 rounded-sm {{ $i % 7 == 0 ? 'bg-rose-400' : '' }} {{ $i % 5 == 0 ? 'bg-pink-300' : '' }}"></div>
                                    @endfor
                                </div>
                            </div>
                            
                            <!-- Icon ruangan di pojok kanan atas -->
                            <div class="absolute transition-opacity duration-300 top-4 right-4 opacity-20 group-hover:opacity-30 room-icon">
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
                                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg shadow-md calendar-mini-icon bg-gradient-to-br from-red-500 to-red-600">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-900 gradient-text">{{ $room->name }}</h4>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold text-white rounded-full shadow-sm status-available bg-gradient-to-r from-green-400 to-green-500">
                                        Tersedia
                                    </span>
                                </div>
                                
                                @if($room->description)
                                    <p class="mb-4 leading-relaxed text-gray-700">{{ $room->description }}</p>
                                @endif
                                
                                <div class="flex items-center p-3 mb-4 rounded-lg bg-red-50/50">
                                    <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 mr-3 bg-red-100 rounded-full">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-700">Kapasitas: <span class="font-bold text-red-600 capacity-highlight">{{ $room->capacity }} orang</span></span>
                                </div>
                                
                                @if($room->facilities && count($room->facilities) > 0)
                                    <div class="mb-4">
                                        <h5 class="flex items-center mb-3 text-sm font-semibold text-gray-800">
                                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Fasilitas:
                                        </h5>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($room->facilities as $facility)
                                                <span class="px-3 py-1 text-xs font-medium text-red-800 border border-red-200 rounded-full facility-badge bg-gradient-to-r from-red-100 to-rose-100">
                                                    {{ $facility }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200/60">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <div class="absolute inset-0 transition-opacity duration-300 opacity-0 pointer-events-none bg-gradient-to-br from-red-600/5 to-rose-600/5 group-hover:opacity-100"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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