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
    @vite(['resources/css/app.css', 'resources/css/home-rooms.css', 'resources/css/footer.css', 'resources/css/home-animations.css', 'resources/css/home-new.css', 'resources/js/app.js', 'resources/js/header-scroll.js', 'resources/js/home-animations.js', 'resources/js/home-filters.js'])
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
    <section class="py-16 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
                <!-- Left Content -->
                <div class="hero-content">
                    <h1 class="mb-6 text-4xl font-bold leading-tight text-gray-900 hero-title lg:text-5xl">
                        Booking Ruang Meeting DSI
                    </h1>
                    <p class="mb-8 text-lg leading-relaxed text-gray-600 hero-description">
                        Pesan ruang meeting dengan cepat, <span class="font-semibold text-red-600">realtime</span>, dan tanpa bentrok jadwal
                    </p>
                    <div class="flex flex-col gap-4 hero-buttons sm:flex-row">
                        @auth
                            <a href="{{ route('user.bookings.create') }}" class="inline-flex items-center px-6 py-3 font-semibold text-center text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Booking Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 font-semibold text-center text-white transition duration-200 bg-red-500 rounded-lg hover:bg-red-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Booking Sekarang
                            </a>
                        @endauth
                        <a href="#schedule" class="inline-flex items-center px-6 py-3 font-semibold text-center text-red-700 transition duration-200 border-2 border-red-300 rounded-lg hover:border-red-500 hover:text-red-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Ruangan
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Illustration -->
                <div class="relative hero-image">
                    <img src="{{asset('img/hero.jpeg')}}" alt="" class="rounded-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Section -->
    <section id="schedule" class="py-12 bg-white">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Jadwal Ruangan Hari Ini</h2>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-gray-600">Tersedia</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-gray-600">Booked</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-gray-600">Menunggu</span>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Schedule Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden schedule-table">
                <!-- Table Header  -->
                <div class="bg-gray-50 border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Jam</th>
                                    @foreach($rooms as $room)
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $room->name }}</th>
                                    @endforeach
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                
                <!-- Scrollable Table Body -->
                <div class="overflow-x-auto overflow-y-auto max-h-96 schedule-table-body">
                    <table class="min-w-full">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($scheduleData as $time => $roomStatuses)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-20 sticky left-0 bg-white border-r border-gray-200">
                                        <div class="flex items-center">
                                            <span class="text-gray-900">{{ $time }}</span>
                                            @if(\Carbon\Carbon::now('Asia/Jakarta')->format('H:00') === $time)
                                                <div class="ml-2 w-2 h-2 bg-red-500 rounded-full animate-pulse" title="Jam saat ini"></div>
                                            @endif
                                        </div>
                                    </td>
                                    @foreach($rooms as $room)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-center items-center">
                                                @php
                                                    $roomStatus = $roomStatuses[$room->id] ?? ['status' => 'available'];
                                                    $status = $roomStatus['status'];
                                                    $user = $roomStatus['user'] ?? null;
                                                @endphp
                                                
                                                @if($status === 'available')
                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full cursor-pointer hover:bg-green-600 transition-colors"
                                                          onclick="quickBook('{{ $room->id }}', '{{ $time }}')">
                                                        Tersedia
                                                    </span>
                                                @elseif($status === 'approved')
                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full" 
                                                          title="Booked by: {{ $user }}">
                                                        BOOKED
                                                    </span>
                                                @elseif($status === 'pending')
                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full"
                                                          title="Pending by: {{ $user }}">
                                                        MENUNGGU
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full cursor-pointer hover:bg-gray-300 transition-colors"
                                                          onclick="quickBook('{{ $room->id }}', '{{ $time }}')">
                                                        Tersedia
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium w-16">
                                        <button class="text-gray-400 hover:text-gray-600 transition-colors" onclick="refreshSchedule()" title="Refresh">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="bg-gray-50 border-t border-gray-200 px-4 py-2 text-center">
                    <p class="text-xs text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m0 0l7-7 7 7z"></path>
                        </svg>
                        Scroll untuk melihat jam lainnya (08:00 - 22:00)
                    </p>
                </div>
            </div>
            
            <!-- Real-time Update Info -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500">
                    <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Data diperbarui secara real-time
                    </span>
                    • Terakhir diperbarui: <span id="lastUpdated">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }}</span>
                </p>
            </div>
        </div>
    </section>


    <!-- Available Rooms Section -->
    <section class="py-12 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Ruang Meeting Tersedia</h2>
                
                <!-- Filter Controls -->
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 filter-controls">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="flex flex-col space-y-1">
                            <label class="text-sm font-medium text-gray-700">Lantai:</label>
                            <select name="floor" class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 w-full">
                                <option>Semua Lantai</option>
                                <option>Lantai 1</option>
                                <option>Lantai 2</option>
                                <option>Lantai 3</option>
                            </select>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <label class="text-sm font-medium text-gray-700">Kapasitas</label>
                            <select name="capacity" class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 w-full">
                                <option>Semua</option>
                                <option>1-5 orang</option>
                                <option>6-10 orang</option>
                                <option>11+ orang</option>
                            </select>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <label class="text-sm font-medium text-gray-700">Fasilitas</label>
                            <select name="facilities" class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 w-full">
                                <option>Semua Fasilitas</option>
                                <option>Projector</option>
                                <option>WiFi</option>
                                <option>AC</option>
                            </select>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <label class="text-sm font-medium text-gray-700">Cari</label>
                            <input type="text" placeholder="Cari ruangan..." class="px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 w-full">
                        </div>
                    </div>
                </div>
            </div>

            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 room-grid">
                    @foreach($rooms as $room)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 room-card cursor-pointer" 
                             onclick="goToRoomDetail('{{ route('calendar.room', $room->id) }}')"
                             data-room-id="{{ $room->id }}">
                            <!-- Room Image -->
                            <div class="h-48 bg-gray-200 relative room-image">
                                    <img src="{{  asset($room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                
                                @php
                                    // cek ketersediaan
                                    $currentHour = \Carbon\Carbon::now('Asia/Jakarta')->format('H:00');
                                    $currentStatus = 'available';
                                    
                                    if (isset($scheduleData[$currentHour][$room->id])) {
                                        $currentStatus = $scheduleData[$currentHour][$room->id]['status'];
                                    }
                                @endphp
                                
                                @if($currentStatus === 'available')
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-500 rounded-full absolute top-3 left-3">
                                        <div class="w-2 h-2 bg-white rounded-full mr-1"></div>
                                        Tersedia
                                    </span>
                                @elseif($currentStatus === 'approved')
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-500 rounded-full absolute top-3 left-3">
                                        <div class="w-2 h-2 bg-white rounded-full mr-1"></div>
                                        Sedang Digunakan
                                    </span>
                                @elseif($currentStatus === 'pending')
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-full absolute top-3 left-3">
                                        <div class="w-2 h-2 bg-yellow-600 rounded-full mr-1"></div>
                                        Menunggu Konfirmasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-500 rounded-full absolute top-3 left-3">
                                        <div class="w-2 h-2 bg-white rounded-full mr-1"></div>
                                        Tersedia
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Room Details -->
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $room->name }}</h3>
                                    <span class="text-sm font-semibold text-gray-500 floor-info">({{ $room->floor ?? '3' }})</span>
                                </div>
                                
                                @if($room->description)
                                    <p class="text-sm text-gray-600 mb-3 room-description">{{ $room->description }}</p>
                                @endif
                                
                                <div class="flex items-center mb-3">
                                    <span class="text-sm text-gray-600 capacity-info">Kapasitas: {{ $room->capacity }} Orang</span>
                                </div>
                                
                                @if($room->facilities && count($room->facilities) > 0)
                                    <div class="mb-4">
                                        <span class="text-sm font-medium text-gray-700">Fasilitas: </span>
                                        <span class="text-sm text-gray-600 facilities-info">
                                            {{ implode(', ', array_slice($room->facilities, 0, 3)) }}
                                            @if(count($room->facilities) > 3)
                                                , +{{ count($room->facilities) - 3 }} lainnya
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between button-container">
                                    <button onclick="event.stopPropagation(); goToRoomDetail('{{ route('calendar.room', $room->id) }}')" 
                                            class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 no-loading transition-colors duration-200">
                                        Lihat Detail
                                    </button>
                                    <button onclick="event.stopPropagation(); goToBooking('{{ route('user.bookings.create', ['room_id' => $room->id]) }}')" 
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200">
                                        Booking
                                    </button>
                                </div>
                            </div>
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

    <!-- Inline JavaScript for immediate function availability -->
    <script>
        // Global functions for onclick handlers
        window.refreshSchedule = function() {
            console.log('Refresh clicked');
            location.reload();
        };
        
        window.quickBook = function(roomId, time) {
            console.log('Quick book clicked:', roomId, time);
            
            // Check if user is authenticated
            const isAuthenticated = document.querySelector('form[action*="logout"]') !== null;
            
            if (!isAuthenticated) {
                if (confirm('Anda perlu login terlebih dahulu untuk melakukan booking. Login sekarang?')) {
                    window.location.href = '/login';
                }
                return;
            }
            
            if (confirm(`Apakah Anda ingin booking ruangan ini pada jam ${time}?`)) {
                // Show loading state
                const clickedElement = event.target;
                if (clickedElement) {
                    clickedElement.style.opacity = '0.7';
                    clickedElement.style.pointerEvents = 'none';
                    clickedElement.textContent = 'Loading...';
                }
                
                // Redirect to booking page with pre-filled data
                const bookingUrl = `/user/bookings/create?room_id=${roomId}&time=${time}`;
                window.location.href = bookingUrl;
            }
        };
        
        // Adjust table layout based on number of room columns
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleTable = document.querySelector('.schedule-table table');
            if (scheduleTable) {
                const headerCells = scheduleTable.querySelectorAll('thead th');
                const roomColumns = headerCells.length - 2; // Exclude time and action columns
                
                if (roomColumns === 2) {
                    scheduleTable.classList.add('two-rooms-layout');
                } else if (roomColumns === 3) {
                    scheduleTable.classList.add('three-rooms-layout');
                }
            }
        });
    </script>
</body>
</html>