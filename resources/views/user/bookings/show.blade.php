<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between md:gap-x-4">
            <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">
                {{ __('Detail Booking') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ $booking->title }}</h3>
                        
                        <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Ruangan:</span>
                                <span class="ml-2 text-gray-900">{{ $booking->room->name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Pembooking:</span>
                                <span class="ml-2 text-gray-900">{{ $booking->booker_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                @if($booking->status === 'approved')
                                    <span class="px-2 py-1 ml-2 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>
                                @elseif($booking->status === 'pending')
                                    <span class="px-2 py-1 ml-2 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="px-2 py-1 ml-2 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 ml-2 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Dibatalkan</span>
                                @endif
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
                                    Pukul {{ $booking->end_time->format('H:i') }}
                                </span>
                            </div>
                        </div>

                        @if($booking->description)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                            <p class="mt-1 text-gray-900">{{ $booking->description }}</p>
                        </div>
                        @endif

                        @if($booking->rejection_reason)
                        <div class="p-4 mb-4 rounded bg-red-50">
                            <span class="text-sm font-medium text-red-800">Alasan Penolakan:</span>
                            <p class="mt-1 text-red-700">{{ $booking->rejection_reason }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        @if($booking->canBeEdited())
                            <a href="{{ route('user.bookings.edit', $booking) }}" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-700">Edit</a>
                        @endif
                        @if($booking->canBeCancelled())
                            <form action="{{ route('user.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Batal</button>
                            </form>
                        @endif
                        <a href="{{ route('user.bookings.index') }}" class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

