<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            {{ __('Ajukan Booking') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
        <form method="POST" action="{{ route('user.bookings.store') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <x-input-label for="room_id" :value="__('Ruangan')" />
                    <select id="room_id" name="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" 
                                {{ (old('room_id', $selectedRoomId ?? null) == $room->id) ? 'selected' : '' }}>
                                {{ $room->name }} (Kapasitas: {{ $room->capacity }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="title" :value="__('Judul Booking')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" rows="3">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                        <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" :value="old('start_time', $defaultStartTime ?? null)" required />
                        <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                        <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" :value="old('end_time')" required />
                        <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:space-x-4 sm:gap-0">
                    <a href="{{ route('user.bookings.index') }}" class="text-center sm:text-left text-gray-600 hover:text-gray-900 font-medium py-2 sm:py-0">Batal</a>
                    <x-primary-button class="w-full sm:w-auto">
                        {{ __('Ajukan') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            
            // Set minimum datetime to current time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            startTimeInput.min = currentDateTime;
            
            // Auto-set end time when start time changes (add 1 hour by default)
            startTimeInput.addEventListener('change', function() {
                if (this.value && !endTimeInput.value) {
                    const startTime = new Date(this.value);
                    const endTime = new Date(startTime.getTime() + (60 * 60 * 1000)); // Add 1 hour
                    
                    // Format to datetime-local format
                    const year = endTime.getFullYear();
                    const month = String(endTime.getMonth() + 1).padStart(2, '0');
                    const day = String(endTime.getDate()).padStart(2, '0');
                    const hours = String(endTime.getHours()).padStart(2, '0');
                    const minutes = String(endTime.getMinutes()).padStart(2, '0');
                    
                    endTimeInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                }
                
                // Update minimum end time to be after start time
                if (this.value) {
                    endTimeInput.min = this.value;
                }
            });
            
            // Add visual feedback for pre-filled room selection
            const roomSelect = document.getElementById('room_id');
            if (roomSelect.value) {
                roomSelect.style.backgroundColor = '#f0f9ff';
                roomSelect.style.borderColor = '#0ea5e9';
                
                // Add a small notice
                const notice = document.createElement('p');
                notice.className = 'text-sm text-blue-600 mt-1';
                notice.textContent = 'Ruangan telah dipilih dari kalender';
                roomSelect.parentNode.appendChild(notice);
            }
        });
    </script>
</x-app-layout>
