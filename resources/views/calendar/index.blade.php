<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">
            {{ __('Kalender Booking Ruang Meeting') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2 sm:p-4 lg:p-6 overflow-x-auto">
        <div id="calendar" class="calendar-container"></div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet" />
    <style>
        @import url('{{ asset('css/calendar-id.css') }}');
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
    </style>
    @endpush

    @push('scripts')
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
                timeZone: 'Asia/Jakarta',
                displayEventTime: false, // Nonaktifkan tampilan waktu
                eventDisplay: 'block',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'Daftar',
                    prev: 'Sebelumnya',
                    next: 'Selanjutnya'
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
                    failure: function() {
                        console.error('Failed to load calendar events');
                    }
                },
                eventDisplay: 'block',
                displayEventTime: false, // Nonaktifkan tampilan waktu default
                height: 'auto',
                aspectRatio: window.innerWidth < 640 ? 1.2 : 1.8,
                eventDidMount: function(info) {
                    const props = info.event.extendedProps;
                    const tooltip = `${props.booking_title || info.event.title}\nRuangan: ${props.room}\nPembooking: ${props.booker_name}\nWaktu: ${props.start_time}-${props.end_time}`;
                    info.el.setAttribute('title', tooltip);
                    info.el.style.cursor = 'pointer';
                },
                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    
                    // Create detailed modal
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4';
                    
                    const statusBadge = props.status === 'approved' 
                        ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>'
                        : props.status === 'pending'
                        ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>';
                    
                    modal.innerHTML = `
                        <div class="bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-semibold text-gray-900">Detail Booking</h3>
                                        </div>
                                    </div>
                                    ${statusBadge}
                                </div>
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Judul Acara:</span>
                                        <span class="text-sm text-gray-900">${props.booking_title || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Ruangan:</span>
                                        <span class="text-sm text-gray-900">${props.room}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Pembooking:</span>
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
                                        <p class="text-sm text-gray-900 mt-1">${props.description}</p>
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
                                    <button class="close-btn px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
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
                }
            });
            
            calendar.render();
            console.log('Calendar rendered');
            
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
    @endpush
</x-app-layout>
