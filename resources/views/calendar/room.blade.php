<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $room->name }} - {{ config('app.name', 'Meeting Room Booking') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/calendar-id.css', 'resources/css/footer.css', 'resources/js/app.js'])
    
    <style>
        .calendar-container {
            min-height: 400px;
            width: 100%;
            overflow-x: auto;
        }
        @media (min-width: 640px) {
            .calendar-container {
                min-height: 500px;
            }
        }
        @media (min-width: 1024px) {
            .calendar-container {
                min-height: 600px;
            }
        }
        .fc {
            font-family: inherit;
            font-size: 0.875rem;
        }
        @media (min-width: 640px) {
            .fc {
                font-size: 1rem;
            }
        }
        .fc-header-toolbar {
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        @media (min-width: 640px) {
            .fc-header-toolbar {
                margin-bottom: 1.5rem;
                gap: 1rem;
            }
        }
        .fc-toolbar-chunk {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        @media (min-width: 640px) {
            .fc-toolbar-chunk {
                gap: 0.75rem;
            }
        }
        .fc-toolbar-title {
            font-size: 1rem !important;
            margin: 0 0.5rem;
        }
        @media (min-width: 640px) {
            .fc-toolbar-title {
                font-size: 1.5rem !important;
            }
        }
        @media (min-width: 1024px) {
            .fc-toolbar-title {
                font-size: 1.875rem !important;
            }
        }
        .fc-button {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            color: white !important;
            font-size: 0.75rem !important;
            line-height: 1.25rem !important;
            margin: 0 0.125rem !important;
        }
        @media (min-width: 640px) {
            .fc-button {
                padding: 0.5rem 1rem !important;
                font-size: 0.875rem !important;
                margin: 0 0.25rem !important;
            }
        }
        .fc-button-group {
            gap: 0.25rem;
        }
        @media (min-width: 640px) {
            .fc-button-group {
                gap: 0.375rem;
            }
        }
        .fc-button:hover {
            background-color: #b91c1c !important;
            border-color: #b91c1c !important;
        }
        .fc-button-active {
            background-color: #991b1b !important;
            border-color: #991b1b !important;
        }
        .fc-today-button {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
        }
        .fc-today-button:hover {
            background-color: #b91c1c !important;
            border-color: #b91c1c !important;
        }
        .fc-day-today {
            background-color: #fef2f2 !important;
        }
        .fc-event {
            border-radius: 0.25rem;
            padding: 0.125rem 0.375rem;
            border: none;
            font-size: 0.625rem;
            line-height: 1.2;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            .fc-event {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                white-space: normal;
            }
        }
        .fc-event-time {
            display: none !important; /* Sembunyikan waktu yang ditampilkan FullCalendar */
        }
        .fc-event-title {
            font-weight: 500;
        }
        .fc-daygrid-day {
            border-color: #e5e7eb;
        }
        .fc-col-header-cell {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            padding: 0.5rem 0.25rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.75rem;
        }
        @media (min-width: 640px) {
            .fc-col-header-cell {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
        }
        .fc-daygrid-day-number {
            padding: 0.5rem !important;
            font-size: 0.75rem;
        }
        @media (min-width: 640px) {
            .fc-daygrid-day-number {
                padding: 0.75rem !important;
                font-size: 0.875rem;
            }
        }
        .fc-scrollgrid {
            border-width: 1px;
        }
        .fc-scrollgrid-section {
            border-width: 1px;
        }
        @media (max-width: 639px) {
            .fc-header-toolbar .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                gap: 0.375rem;
            }
            .fc-header-toolbar .fc-button-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            .fc-prev-button,
            .fc-next-button {
                padding: 0.375rem 0.5rem !important;
                margin: 0 0.125rem !important;
            }
            .fc-today-button {
                margin: 0 0.25rem !important;
            }
        }
        
        /* TimeGrid specific styles */
        .fc-timegrid-slot {
            height: 3rem !important;
        }
        .fc-timegrid-slot-label {
            font-size: 0.75rem;
            color: #6b7280;
        }
        .fc-timegrid-axis {
            width: 60px !important;
        }
        .fc-timegrid-col {
            border-color: #e5e7eb;
        }
        .fc-timegrid-event {
            border-radius: 0.25rem;
            font-size: 0.75rem;
        }
        .fc-timegrid-now-indicator-line {
            border-color: #ef4444;
            border-width: 2px;
        }
        .fc-timegrid-now-indicator-arrow {
            border-color: #ef4444;
        }
        
        /* Selection styles */
        .fc-highlight {
            background-color: #fee2e2 !important;
            opacity: 0.7;
        }
        

        .fc-non-business {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-red-600 hover:text-red-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $room->name }}</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('user.bookings.create') }}?room_id={{ $room->id }}" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                            Book
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900">
                            Login untuk Book
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Room Info -->
    <section class="bg-white border-b border-gray-200">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="md:col-span-2">
                    @if($room->description)
                        <p class="mb-4 text-gray-600">{{ $room->description }}</p>
                    @endif
                    
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="text-gray-700">Kapasitas: <strong>{{ $room->capacity }} orang</strong></span>
                    </div>
                </div>
                
                @if($room->facilities && count($room->facilities) > 0)
                    <div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-900">Fasilitas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($room->facilities as $facility)
                                <span class="px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                                    {{ $facility }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm lg:p-6">
                <div class="mb-6">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">Kalender Ketersediaan</h2>
                    <p class="mb-3 text-gray-600">
                        Lihat jadwal booking untuk ruangan {{ $room->name }}. 
                        Tanggal yang terisi menunjukkan ruangan sudah dibooking.
                    </p>
                    @auth
                        <x-alert type="info" title="Cara Membuat Booking" icon="true" class="mb-4">
                            <div class="space-y-2 text-sm">
                                <p><strong>Klik tanggal</strong> untuk membuat booking baru</p>
                                <p>Anda akan diarahkan ke halaman booking dengan ruangan yang sudah terpilih</p>
                                <p>Isi tanggal, waktu, dan detail booking di halaman tersebut</p>
                            </div>
                        </x-alert>
                    @else
                        <x-alert type="warning" title="Login Diperlukan" icon="true" class="mb-4">
                            <p>Anda perlu <a href="{{ route('login') }}" class="font-semibold text-yellow-800 underline hover:text-yellow-900">login</a> untuk dapat membuat booking ruangan.</p>
                        </x-alert>
                    @endauth
                </div>
                
                <div id="calendar" class="calendar-container"></div>
            </div>
        </div>
    </section>

    <!-- Legend -->
    <section class="pb-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-gray-100 rounded-lg">
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Keterangan</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="flex items-center">
                        <div class="w-4 h-4 mr-2 bg-green-500 rounded"></div>
                        <span class="text-sm text-gray-700">Booking Disetujui</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 mr-2 bg-yellow-500 rounded"></div>
                        <span class="text-sm text-gray-700">Menunggu Persetujuan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                console.error('Calendar element not found');
                return;
            }
            
            // Function to get responsive header toolbar config
            function getHeaderToolbar() {
                const isMobile = window.innerWidth < 640;
                const isTablet = window.innerWidth >= 640 && window.innerWidth < 1024;
                
                if (isMobile) {
                    return {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today'
                    };
                } else if (isTablet) {
                    return {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    };
                } else {
                    return {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    };
                }
            }
            
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                timeZone: 'Asia/Jakarta', // Gunakan timezone Jakarta yang konsisten
                displayEventTime: false, // Nonaktifkan tampilan waktu
                eventDisplay: 'block',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'Daftar',
                    prev: '<',
                    next: '>'
                },
                dayHeaderFormat: { weekday: 'short' },
                titleFormat: { 
                    year: 'numeric', 
                    month: 'long' 
                },
                moreLinkText: function(n) {
                    return '+ ' + n + ' lainnya';
                },
                noEventsText: 'Tidak ada acara untuk ditampilkan',
                headerToolbar: getHeaderToolbar(),
                events: {
                    url: '{{ route("calendar.api") }}',
                    extraParams: {
                        room_id: {{ $room->id }}
                    },
                    failure: function() {
                        Alert.error('Gagal memuat data kalender. Silakan refresh halaman.', {
                            title: 'Error Loading'
                        });
                        console.error('Failed to load calendar events');
                    }
                },
                eventDisplay: 'block',
                displayEventTime: false, // Nonaktifkan tampilan waktu default
                slotMinTime: '07:00:00',
                slotMaxTime: '23:00:00',
                slotDuration: '01:00:00',
                slotLabelInterval: '01:00:00',
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                height: 'auto',
                aspectRatio: window.innerWidth < 640 ? 1.2 : 1.8,
                selectable: true,
                selectMirror: true,
                selectConstraint: {
                    start: '07:00',
                    end: '23:00'
                },
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5, 6], // Monday - Saturday
                    startTime: '07:00',
                    endTime: '23:00'
                },
                eventDidMount: function(info) {
                    const props = info.event.extendedProps;
                    const tooltip = `${props.booking_title || info.event.title}\nPemesan: ${props.booker_name}\nWaktu: ${props.start_time}-${props.end_time}`;
                    info.el.setAttribute('title', tooltip);
                    info.el.style.cursor = 'pointer';
                },
                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    
                    // Create detailed modal
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4';
                    
                    const statusBadge = props.status === 'approved' 
                        ? '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>'
                        : props.status === 'pending'
                        ? '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>';
                    
                    modal.innerHTML = `
                        <div class="w-full max-w-md transition-all duration-300 transform scale-95 bg-white rounded-lg shadow-xl opacity-0">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-semibold text-gray-900">Detail Booking</h3>
                                        </div>
                                    </div>
                                    ${statusBadge}
                                </div>
                                <div class="mb-6 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Judul Acara:</span>
                                        <span class="text-sm text-gray-900">${props.booking_title || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Ruangan:</span>
                                        <span class="text-sm text-gray-900">${props.room}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Pemesan:</span>
                                        <span class="text-sm text-gray-900">${props.booker_name}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Tanggal:</span>
                                        <span class="text-sm text-gray-900">${props.start_date}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Waktu:</span>
                                        <span class="text-sm text-gray-900">${props.start_time} - ${props.end_time}</span>
                                    </div>
                                    ${props.description ? `
                                    <div class="pt-2 border-t border-gray-200">
                                        <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                                        <p class="mt-1 text-sm text-gray-900">${props.description}</p>
                                    </div>
                                    ` : ''}
                                    <div class="pt-2 border-t border-gray-200">
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Dibuat:</span>
                                            <span class="text-sm text-gray-900">${props.created_at}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button class="px-4 py-2 font-medium text-white transition-colors duration-200 bg-red-600 rounded-lg close-btn hover:bg-red-700">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    // Animate in
                    setTimeout(() => {
                        const modalContent = modal.querySelector('div > div');
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                    
                    // Close functionality
                    const closeBtn = modal.querySelector('.close-btn');
                    const cleanup = () => {
                        const modalContent = modal.querySelector('div > div');
                        modalContent.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            document.body.removeChild(modal);
                        }, 300);
                    };
                    
                    closeBtn.addEventListener('click', cleanup);
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) cleanup();
                    });
                },
                dateClick: function(info) {
                    @auth
                        // Langsung redirect ke halaman booking dengan room_id saja
                        const bookingUrl = '{{ route("user.bookings.create") }}?room_id={{ $room->id }}';
                        window.location.href = bookingUrl;
                    @else
                        // Redirect ke login jika belum login
                        window.location.href = '{{ route("login") }}';
                    @endauth
                },
                select: function(info) {
                    @auth
                        // Langsung redirect ke halaman booking dengan room_id saja
                        const bookingUrl = '{{ route("user.bookings.create") }}?room_id={{ $room->id }}';
                        window.location.href = bookingUrl;
                        calendar.unselect();
                    @else
                        // Redirect ke login jika belum login
                        window.location.href = '{{ route("login") }}';
                        calendar.unselect();
                    @endauth
                }
            });
            
            calendar.render();
            console.log('Calendar rendered for room: {{ $room->name }}');
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    calendar.setOption('headerToolbar', getHeaderToolbar());
                    calendar.setOption('aspectRatio', window.innerWidth < 640 ? 1.2 : 1.8);
                    calendar.updateSize();
                }, 250);
            });
        });
    </script>

    <!-- Footer -->
    <x-footer />
</body>
</html>