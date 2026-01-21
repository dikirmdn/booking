<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Detail Ruangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($room->image)
                    <div class="mb-6">
                        <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="w-full max-w-md h-64 object-cover rounded-lg shadow-md">
                    </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $room->name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $room->description ?? '-' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Kapasitas:</span>
                            <span class="ml-2 text-gray-900">{{ $room->capacity }} orang</span>
                        </div>
                        @if($room->floor)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Lantai:</span>
                            <span class="ml-2 text-gray-900">{{ $room->floor }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            @if($room->is_active)
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>

                    @if($room->facilities)
                    <div class="mb-6">
                        <span class="text-sm font-medium text-gray-500">Fasilitas:</span>
                        <div class="mt-2">
                            @foreach($room->facilities as $facility)
                                <span class="inline-block bg-gray-200 rounded px-2 py-1 text-sm mr-2">{{ $facility }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="flex space-x-4">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

