<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Edit Booking') }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
        <form method="POST" action="{{ route('user.bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <x-input-label for="room_id" :value="__('Ruangan')" />
                    <select id="room_id" name="room_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} (Kapasitas: {{ $room->capacity }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="title" :value="__('Judul Booking')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $booking->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3">{{ old('description', $booking->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                        <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" :value="old('start_time', $booking->start_time->format('Y-m-d\TH:i'))" required />
                        <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                        <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" :value="old('end_time', $booking->end_time->format('Y-m-d\TH:i'))" required />
                        <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                    </div>
                </div>

                @if($errors->has('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-medium">
                                    {{ $errors->first('error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:space-x-4 sm:gap-0">
                    <a href="{{ route('user.bookings.index') }}" class="text-center sm:text-left text-gray-600 hover:text-gray-900 font-medium py-2 sm:py-0">Batal</a>
                    <x-primary-button class="w-full sm:w-auto">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

