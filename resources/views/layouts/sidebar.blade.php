<aside x-show="sidebarOpen" 
       x-transition:enter="transition ease-out duration-300 transform"
       x-transition:enter-start="-translate-x-full lg:translate-x-0"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-300 transform"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full lg:translate-x-0"
       @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
       class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col lg:flex"
       x-cloak>
    <!-- Logo -->
    <div class="p-4 sm:p-6 border-b border-gray-200 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                <img src="{{ asset('img/logodsi.png') }}" alt="">
            </div>
            <span class="text-lg sm:text-xl font-bold text-gray-900">Booking Room</span>
        </a>
        <!-- Close button for mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-3 sm:p-4 space-y-1 sm:space-y-2 overflow-y-auto">
        <a href="{{ route('calendar.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('calendar.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">Beranda</span>
        </a>

        @auth
            @if(auth()->user()->isAdmin())
                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.rooms.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="font-medium">Ruangan</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium">Kelola Booking</span>
                    </a>
                    <a href="{{ route('user.bookings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.bookings.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium">Booking Saya</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium">User Management</span>
                    </a>
                </div>
            @else
                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">User</p>
                    <a href="{{ route('user.bookings.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.bookings.index') || request()->routeIs('user.bookings.show') || request()->routeIs('user.bookings.edit') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium">Booking Saya</span>
                    </a>
                    <a href="{{ route('user.bookings.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.bookings.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="font-medium">Ajukan Booking</span>
                    </a>
                </div>
            @endif
        @endauth
    </nav>

    <!-- Footer -->
    <div class="p-3 sm:p-4 border-t border-gray-200">
        @auth
            <div class="text-xs text-gray-500 text-center">
                <p class="font-medium text-gray-700">{{ auth()->user()->name }}</p>
                <p>{{ auth()->user()->email }}</p>
            </div>
        @else
            <div class="text-xs text-gray-500 text-center">
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium">Login</a>
            </div>
        @endauth
    </div>
</aside>

