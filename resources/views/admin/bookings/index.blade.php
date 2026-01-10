<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Kelola Booking') }}
            </h2>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filter dan Download Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter & Download Laporan</h3>
            
            <!-- Tab Navigation -->
            <div class="mb-4">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button" id="monthly-tab" class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                            Filter Bulanan
                        </button>
                        <button type="button" id="daterange-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Filter Rentang Tanggal
                        </button>
                    </nav>
                </div>
            </div>
            
            <!-- Monthly Filter Form -->
            <form method="GET" action="{{ route('admin.bookings.index') }}" id="monthly-filter" class="filter-form">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" id="month" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ Carbon\Carbon::create(null, $i, 1)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="flex-1 min-w-[150px]">
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="year" id="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Tahun</option>
                            @for($year = now()->year; $year >= now()->year - 5; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Filter
                        </button>
                        
                        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            
            <!-- Date Range Filter Form -->
            <form method="GET" action="{{ route('admin.bookings.index') }}" id="daterange-filter" class="filter-form hidden">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="flex-1 min-w-[200px]">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Filter
                        </button>
                        
                        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    <!-- Download Semua Data -->
                    <a href="{{ route('admin.bookings.download-report') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Semua Data
                    </a>
                    
                    <!-- Download Data Terfilter Bulanan -->
                    @if(request('month') && request('year'))
                        <a href="{{ route('admin.bookings.download-report', ['month' => request('month'), 'year' => request('year')]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download {{ Carbon\Carbon::create(request('year'), request('month'), 1)->format('F Y') }}
                        </a>
                    @endif
                    
                    <!-- Download Data Terfilter Rentang Tanggal -->
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('admin.bookings.download-report', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download 
                            @if(request('start_date') && request('end_date'))
                                {{ Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} - {{ Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                            @elseif(request('start_date'))
                                Mulai {{ Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}
                            @else
                                Sampai {{ Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 sm:p-6">
                    <!-- Mobile Card View -->
                    <div class="block md:hidden space-y-4">
                        @forelse($bookings as $booking)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900">{{ $booking->title }}</h3>
                                    @if($booking->status === 'approved')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><span class="font-medium">Ruangan:</span> {{ $booking->room->name }}</p>
                                    <p><span class="font-medium">Pemesan:</span> {{ $booking->user->name }}</p>
                                    <p><span class="font-medium">Waktu:</span> {{ $booking->start_time->format('d M Y H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                                </div>
                                <div class="pt-2">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Detail →</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-sm text-gray-500">Tidak ada booking</div>
                        @endforelse
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->room->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->start_time->format('d M Y H:i') }} - {{ $booking->end_time->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->status === 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($booking->status === 'rejected')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada booking</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyTab = document.getElementById('monthly-tab');
    const daterangeTab = document.getElementById('daterange-tab');
    const monthlyFilter = document.getElementById('monthly-filter');
    const daterangeFilter = document.getElementById('daterange-filter');
    
    // Check if we have date range parameters in URL to show the correct tab
    const urlParams = new URLSearchParams(window.location.search);
    const hasDateRange = urlParams.has('start_date') || urlParams.has('end_date');
    const hasMonthly = urlParams.has('month') || urlParams.has('year');
    
    if (hasDateRange && !hasMonthly) {
        showDateRangeTab();
    }
    
    monthlyTab.addEventListener('click', function() {
        showMonthlyTab();
    });
    
    daterangeTab.addEventListener('click', function() {
        showDateRangeTab();
    });
    
    function showMonthlyTab() {
        // Update tab styles
        monthlyTab.classList.add('active', 'border-blue-500', 'text-blue-600');
        monthlyTab.classList.remove('border-transparent', 'text-gray-500');
        
        daterangeTab.classList.remove('active', 'border-blue-500', 'text-blue-600');
        daterangeTab.classList.add('border-transparent', 'text-gray-500');
        
        // Show/hide forms
        monthlyFilter.classList.remove('hidden');
        daterangeFilter.classList.add('hidden');
    }
    
    function showDateRangeTab() {
        // Update tab styles
        daterangeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
        daterangeTab.classList.remove('border-transparent', 'text-gray-500');
        
        monthlyTab.classList.remove('active', 'border-blue-500', 'text-blue-600');
        monthlyTab.classList.add('border-transparent', 'text-gray-500');
        
        // Show/hide forms
        daterangeFilter.classList.remove('hidden');
        monthlyFilter.classList.add('hidden');
    }
});
</script>

