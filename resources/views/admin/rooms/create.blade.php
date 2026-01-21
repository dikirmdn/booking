<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Tambah Ruangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Ruangan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500" rows="3">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="capacity" :value="__('Kapasitas')" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required min="1" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="floor" :value="__('Lantai')" />
                            <x-text-input id="floor" class="block mt-1 w-full" type="text" name="floor" :value="old('floor')" placeholder="Contoh: Lantai 1, Lantai 2" />
                            <x-input-error :messages="$errors->get('floor')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Gambar Ruangan')" />
                            <input id="image" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file 2MB. Format yang didukung: JPEG, PNG, JPG, GIF</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="facilities" :value="__('Fasilitas (pisahkan dengan koma)')" />
                            <x-text-input id="facilities" class="block mt-1 w-full" type="text" name="facilities" :value="old('facilities')" placeholder="Contoh: Projector, Whiteboard, WiFi" />
                            <x-input-error :messages="$errors->get('facilities')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Masukkan fasilitas dipisahkan dengan koma</p>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 text-sm text-gray-600">Aktif</span>
                            </label>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-0 mt-4">
                            <a href="{{ route('admin.rooms.index') }}" class="text-center sm:text-left text-gray-600 hover:text-gray-900 sm:mr-4 py-2 sm:py-0">Batal</a>
                            <x-primary-button class="w-full sm:w-auto">
                                {{ __('Simpan') }}
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

