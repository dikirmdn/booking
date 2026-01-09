@props(['booking'])

<div class="flex items-center space-x-2">
    @if($booking->canBeEdited())
        <a href="{{ route('user.bookings.edit', $booking) }}" 
           class="text-blue-600 hover:text-blue-800 font-medium text-sm">
            Edit
        </a>
    @endif
    
    @if($booking->canBeCancelled())
        <button onclick="cancelBooking({{ $booking->id }}, '{{ $booking->title }}')"
                class="text-red-600 hover:text-red-800 font-medium text-sm">
            Batalkan
        </button>
    @endif
    
    <a href="{{ route('user.bookings.show', $booking) }}" 
       class="text-gray-600 hover:text-gray-800 font-medium text-sm">
        Detail
    </a>
</div>

@push('scripts')
<script>
function cancelBooking(bookingId, bookingTitle) {
    confirmAction(
        `Apakah Anda yakin ingin membatalkan booking "${bookingTitle}"? Tindakan ini tidak dapat dibatalkan.`,
        {
            title: 'Konfirmasi Pembatalan',
            confirmText: 'Ya, Batalkan',
            cancelText: 'Tidak',
            type: 'warning'
        }
    ).then((confirmed) => {
        if (confirmed) {
            // Show loading toast
            const loadingToast = Alert.info('Membatalkan booking...', {
                title: 'Memproses',
                duration: 0,
                dismissible: false
            });
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/user/bookings/${bookingId}`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            // Add method override
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush