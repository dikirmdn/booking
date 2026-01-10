<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between md:gap-x-4 items-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                {{ __('Manajemen User') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                Tambah User
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Statistics -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $users->total() }}</div>
                        <div class="text-sm text-gray-500">Total User</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $users->sum('bookings_count') }}</div>
                        <div class="text-sm text-gray-500">Total Booking</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar User</h3>
                
                <!-- Mobile Card View -->
                <div class="block md:hidden space-y-4">
                    @forelse($users as $user)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $user->bookings_count }} booking
                                    </span>
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p><span class="font-medium">Username:</span> {{ $user->username }}</p>
                                <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
                                <p><span class="font-medium">Bergabung:</span> {{ $user->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex space-x-2 pt-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Detail</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-900 text-sm font-medium">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline delete-user-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900 text-sm font-medium delete-user-btn" data-user-name="{{ $user->name }}" data-bookings-count="{{ $user->bookings_count }}">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-sm text-gray-500">Belum ada user</div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->username }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Admin
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $user->bookings_count }} booking
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-user-btn" data-user-name="{{ $user->name }}" data-bookings-count="{{ $user->bookings_count }}">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada user</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete user confirmation
            const deleteButtons = document.querySelectorAll('.delete-user-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    
                    const userName = this.getAttribute('data-user-name');
                    const bookingsCount = parseInt(this.getAttribute('data-bookings-count'));
                    const form = this.closest('.delete-user-form');
                    
                    let message = `Apakah Anda yakin ingin menghapus user "${userName}"?`;
                    
                    if (bookingsCount > 0) {
                        message += `\n\nPeringatan: User ini memiliki ${bookingsCount} booking aktif yang akan ikut terhapus secara permanen.`;
                    } else {
                        message += `\n\nUser ini tidak memiliki booking aktif.`;
                    }
                    
                    // Use the enhanced confirm dialog if available, otherwise fallback to native confirm
                    let confirmed = false;
                    
                    if (typeof confirmAction === 'function') {
                        confirmed = await confirmAction(message, {
                            title: 'Konfirmasi Hapus User',
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