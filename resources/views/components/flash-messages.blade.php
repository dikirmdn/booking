@if(session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <div class="mb-6 space-y-4">
        @if(session()->has('success'))
            <x-alert type="success" title="Berhasil!">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session()->has('error'))
            <x-alert type="error" title="Terjadi Kesalahan!">
                {{ session('error') }}
            </x-alert>
        @endif

        @if(session()->has('warning'))
            <x-alert type="warning" title="Peringatan!">
                {{ session('warning') }}
            </x-alert>
        @endif

        @if(session()->has('info'))
            <x-alert type="info" title="Informasi">
                {{ session('info') }}
            </x-alert>
        @endif
    </div>
@endif