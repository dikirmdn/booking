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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $booking->title }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Ruangan:</span>
                                <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $booking->room->name }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</span>
                                @if($booking->status === 'approved')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Disetujui</span>
                                @elseif($booking->status === 'pending')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Ditolak</span>
                                @else
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Dibatalkan</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Waktu Mulai:</span>
                                <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $booking->start_time->format('d M Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Waktu Selesai:</span>
                                <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $booking->end_time->format('d M Y H:i') }}</span>
                            </div>
                        </div>

                        @if($booking->description)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi:</span>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $booking->description }}</p>
                        </div>
                        @endif

                        @if($booking->rejection_reason)
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 rounded">
                            <span class="text-sm font-medium text-red-800 dark:text-red-200">Alasan Penolakan:</span>
                            <p class="mt-1 text-red-700 dark:text-red-300">{{ $booking->rejection_reason }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex space-x-4">
                        @if($booking->canBeEdited())
                            <a href="{{ route('user.bookings.edit', $booking) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        @endif
                        @if($booking->canBeCancelled())
                            <form action="{{ route('user.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Batal</button>
                            </form>
                        @endif
                        <a href="{{ route('user.bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

