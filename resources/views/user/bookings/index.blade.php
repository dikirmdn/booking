<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Booking Saya') }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 sm:p-6">
            <!-- Mobile Card View -->
            <div class="block md:hidden space-y-4">
                @forelse($bookings as $index => $booking)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-500 rounded-full">{{ $index + 1 }}</span>
                                <h3 class="font-semibold text-gray-900">{{ $booking->title }}</h3>
                            </div>
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
                            <p><span class="font-medium">Waktu:</span> {{ $booking->start_time->format('d M Y H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                        </div>
                        <div class="pt-2 flex flex-wrap gap-2">
                            <a href="{{ route('user.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Detail</a>
                            @if($booking->canBeEdited())
                                <a href="{{ route('user.bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                            @endif
                            @if($booking->canBeCancelled())
                                <button onclick="cancelBooking({{ $booking->id }}, '{{ $booking->title }}')" class="text-red-600 hover:text-red-900 text-sm font-medium">Batal</button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-sm text-gray-500">Anda belum memiliki booking</div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ruangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $index => $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->room->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->title }}</td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('user.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                @if($booking->canBeEdited())
                                    <a href="{{ route('user.bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                @endif
                                @if($booking->canBeCancelled())
                                    <button onclick="cancelBooking({{ $booking->id }}, '{{ $booking->title }}')" class="text-red-600 hover:text-red-900">Batal</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Anda belum memiliki booking</td>
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

    @push('scripts')
    <script>
    function cancelBooking(bookingId, bookingTitle) {
        confirmAction(
            `Apakah Anda yakin ingin membatalkan booking "${bookingTitle}"? Tindakan ini tidak dapat dibatalkan.`,
            {
                title: 'Konfirmasi Pembatalan',
                confirmText: 'Ya, Batalkan',
                cancelText: 'Tidak',
                type: 'warning'
            }
        ).then((confirmed) => {
            if (confirmed) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/user/bookings/${bookingId}`;
                form.style.display = 'none';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);
                
                // Add method override
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
    @endpush
</x-app-layout>
