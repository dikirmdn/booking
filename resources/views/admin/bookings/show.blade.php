<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Detail Booking') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $booking->title }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Ruangan:</span>
                                <span class="ml-2 text-gray-900">{{ $booking->room->name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Pembooking:</span>
                                <span class="ml-2 text-gray-900">{{ $booking->booker_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Waktu Mulai:</span>
                                <span class="ml-2 text-gray-900">
                                    {{ $booking->start_time->format('d M Y') }}
                                    Pukul {{ $booking->start_time->format('H:i') }}
                                </span>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Waktu Selesai:</span>
                                <span class="ml-2 text-gray-900">
                                    {{ $booking->end_time->format('d M Y') }}
                                    Pukul {{ $booking->end_time->format('H:i')}}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                @if($booking->status === 'approved')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                @elseif($booking->status === 'pending')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Dibatalkan</span>
                                @endif
                            </div>
                        </div>

                        @if($booking->description)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                            <p class="mt-1 text-gray-900">{{ $booking->description }}</p>
                        </div>
                        @endif

                        @if($booking->rejection_reason)
                        <div class="mb-4 p-4 bg-red-50 rounded">
                            <span class="text-sm font-medium text-red-800">Alasan Penolakan:</span>
                            <p class="mt-1 text-red-700">{{ $booking->rejection_reason }}</p>
                        </div>
                        @endif
                    </div>

                    @if($booking->status === 'pending')
                    <div class="flex space-x-4">
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline" id="rejectForm">
                            @csrf
                            <input type="text" name="rejection_reason" id="rejection_reason" placeholder="Alasan penolakan" required class="rounded border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 mr-2">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Tolak
                            </button>
                        </form>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.bookings.index') }}" class="text-gray-600 hover:text-gray-900">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

