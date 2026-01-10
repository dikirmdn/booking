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

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

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
                            @if($room->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">
                            <p><span class="font-medium">Kapasitas:</span> {{ $room->capacity }} orang</p>
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
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fasilitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rooms as $index => $room)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $room->name }}</td>
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
                                @if($room->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.rooms.show', $room) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada ruangan</td>
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
</x-app-layout>
