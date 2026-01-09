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
            gap: 0.5rem;
        }
        @media (min-width: 640px) {
            .fc-header-toolbar {
                margin-bottom: 1.5rem;
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
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            color: white !important;
            font-size: 0.75rem !important;
            line-height: 1.25rem !important;
        }
        @media (min-width: 640px) {
            .fc-button {
                padding: 0.5rem 1rem !important;
                font-size: 0.875rem !important;
            }
        }
        .fc-button:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        .fc-button-active {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
        }
        .fc-today-button {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }
        .fc-today-button:hover {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
        .fc-day-today {
            background-color: #eff6ff !important;
        }
        .fc-event {
            border-radius: 0.25rem;
            padding: 0.125rem 0.375rem;
            border: none;
            font-size: 0.625rem;
            line-height: 1.2;
        }
        @media (min-width: 640px) {
            .fc-event {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
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
                gap: 0.25rem;
            }
            .fc-header-toolbar .fc-button-group {
                display: flex;
                flex-wrap: wrap;
            }
            .fc-prev-button,
            .fc-next-button {
                padding: 0.375rem 0.5rem !important;
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
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                height: 'auto',
                aspectRatio: window.innerWidth < 640 ? 1.2 : 1.8,
                eventDidMount: function(info) {
                    const room = info.event.extendedProps.room || 'N/A';
                    const user = info.event.extendedProps.user || 'N/A';
                    info.el.setAttribute('title', `${info.event.title}\nRuangan: ${room}\nPemesan: ${user}`);
                    info.el.style.cursor = 'pointer';
                },
                eventClick: function(info) {
                    const room = info.event.extendedProps.room || 'N/A';
                    const user = info.event.extendedProps.user || 'N/A';
                    const start = info.event.start ? info.event.start.toLocaleString('id-ID') : 'N/A';
                    const end = info.event.end ? info.event.end.toLocaleString('id-ID') : 'N/A';
                    alert(`${info.event.title}\nRuangan: ${room}\nPemesan: ${user}\nWaktu: ${start} - ${end}`);
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
