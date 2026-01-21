<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Kelola Ruangan') }}
            </h2>
            <a href="{{ route('admin.rooms.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                Tambah Ruangan
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 sm:p-6">
            <!-- Mobile Card View -->
            <div class="block md:hidden space-y-4">
                @forelse($rooms as $index => $room)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-semibold text-white bg-red-500 rounded-full">{{ $index + 1 }}</span>
                                <h3 class="font-semibold text-gray-900">{{ $room->name }}</h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $room->bookings_count }} booking
                                </span>
                                @if($room->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p><span class="font-medium">Kapasitas:</span> {{ $room->capacity }} orang</p>
                            @if($room->floor)
                                <p><span class="font-medium">Lantai:</span> {{ $room->floor }}</p>
                            @endif
                            @if($room->facilities)
                                <p class="mt-1"><span class="font-medium">Fasilitas:</span></p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($room->facilities as $facility)
                                        <span class="inline-block bg-gray-100 rounded px-2 py-1 text-xs">{{ $facility }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p><span class="font-medium">Fasilitas:</span> <span class="text-gray-400">-</span></p>
                            @endif
                        </div>
                        <div class="pt-2 flex flex-wrap gap-2">
                            <a href="{{ route('admin.rooms.show', $room) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Detail</a>
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline delete-room-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900 text-sm font-medium delete-room-btn" data-room-name="{{ $room->name }}" data-bookings-count="{{ $room->bookings_count }}">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-sm text-gray-500">Tidak ada ruangan</div>
                @endforelse
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lantai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fasilitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rooms as $index => $room)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($room->image)
                                    <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $room->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $room->floor ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $room->capacity }} orang</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($room->facilities)
                                    @foreach($room->facilities as $facility)
                                        <span class="inline-block bg-gray-100 rounded px-2 py-1 text-xs mr-1">{{ $facility }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $room->bookings_count }} booking
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($room->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.rooms.show', $room) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline delete-room-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-900 delete-room-btn" data-room-name="{{ $room->name }}" data-bookings-count="{{ $room->bookings_count }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada ruangan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete room confirmation
            const deleteButtons = document.querySelectorAll('.delete-room-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    const roomName = this.getAttribute('data-room-name');
                    const bookingsCount = parseInt(this.getAttribute('data-bookings-count'));
                    const form = this.closest('.delete-room-form');
                    
                    let message = `Apakah Anda yakin ingin menghapus ruangan "${roomName}"?`;
                    
                    if (bookingsCount > 0) {
                        message += `\n\nPeringatan: Ruangan ini memiliki ${bookingsCount} booking yang akan ikut terhapus secara permanen.`;
                    } else {
                        message += `\n\nRuangan ini tidak memiliki booking aktif.`;
                    }
                    
                    // Use the enhanced confirm dialog if available, otherwise fallback to native confirm
                    let confirmed = false;
                    
                    if (typeof confirmAction === 'function') {
                        confirmed = await confirmAction(message, {
                            title: 'Konfirmasi Hapus Ruangan',
                            confirmText: 'Ya, Hapus',
                            cancelText: 'Batal',
                            type: 'warning'
                        });
                    } else {
                        confirmed = confirm(message);
                    }
                    
                    if (confirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
