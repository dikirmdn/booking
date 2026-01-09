{{-- Helper untuk menampilkan notifikasi dari session --}}
@if(session()->has('toast_success') || session()->has('toast_error') || session()->has('toast_warning') || session()->has('toast_info'))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session()->has('toast_success'))
                Alert.success('{{ session('toast_success') }}');
            @endif
            
            @if(session()->has('toast_error'))
                Alert.error('{{ session('toast_error') }}');
            @endif
            
            @if(session()->has('toast_warning'))
                Alert.warning('{{ session('toast_warning') }}');
            @endif
            
            @if(session()->has('toast_info'))
                Alert.info('{{ session('toast_info') }}');
            @endif
        });
    </script>
    @endpush
@endif