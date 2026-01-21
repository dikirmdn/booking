<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Edit Ruangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Display validation errors with alert -->
            @if ($errors->any())
                <div class="mb-6">
                    <x-alert type="error" title="Terjadi Kesalahan!" :dismissible="true">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Ruangan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $room->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500" rows="3">{{ old('description', $room->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="capacity" :value="__('Kapasitas')" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity', $room->capacity)" required min="1" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="floor" :value="__('Lantai')" />
                            <x-text-input id="floor" class="block mt-1 w-full" type="text" name="floor" :value="old('floor', $room->floor)" placeholder="Contoh: Lantai 1, Lantai 2" />
                            <x-input-error :messages="$errors->get('floor')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Gambar Ruangan')" />
                            @if($room->image)
                                <div class="mb-2">
                                    <img src="{{ asset($room->image) }}" alt="Current room image" class="w-32 h-32 object-cover rounded-lg">
                                    <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input id="image" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file 2MB. Format yang didukung: JPEG, PNG, JPG, GIF. Kosongkan jika tidak ingin mengubah gambar.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="facilities" :value="__('Fasilitas (pisahkan dengan koma)')" />
                            <x-text-input id="facilities" class="block mt-1 w-full" type="text" name="facilities" :value="old('facilities', is_array($room->facilities) ? implode(', ', $room->facilities) : '')" placeholder="Contoh: Projector, Whiteboard, WiFi" />
                            <x-input-error :messages="$errors->get('facilities')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Masukkan fasilitas dipisahkan dengan koma</p>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.rooms.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/room-image-validation.js') }}"></script>
    @endpush
</x-app-layout>

