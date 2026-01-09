{{-- Contoh penggunaan komponen Alert --}}

{{-- Alert dasar --}}
<x-alert type="success">
    Operasi berhasil dilakukan!
</x-alert>

<x-alert type="error" title="Terjadi Kesalahan">
    Tidak dapat memproses permintaan Anda saat ini.
</x-alert>

<x-alert type="warning" title="Peringatan" :dismissible="false">
    Data akan dihapus secara permanen.
</x-alert>

<x-alert type="info" title="Informasi" size="lg">
    Sistem akan maintenance pada pukul 02:00 WIB.
</x-alert>

{{-- Toast notifications --}}
<x-toast type="success" title="Berhasil!" position="top-right" :duration="3000">
    Data berhasil disimpan.
</x-toast>

{{-- Flash messages otomatis --}}
<x-flash-messages />

{{-- JavaScript Usage Examples --}}
<script>
// Menampilkan toast
Alert.success('Operasi berhasil!');
Alert.error('Terjadi kesalahan!');
Alert.warning('Peringatan!');
Alert.info('Informasi penting');

// Dengan opsi kustom
Alert.success('Data tersimpan', {
    title: 'Berhasil!',
    duration: 3000,
    dismissible: true
});

// Konfirmasi dialog
confirmAction('Apakah Anda yakin?', {
    title: 'Konfirmasi',
    confirmText: 'Ya',
    cancelText: 'Tidak',
    type: 'warning'
}).then((confirmed) => {
    if (confirmed) {
        // Lakukan aksi
        Alert.success('Aksi berhasil dilakukan!');
    }
});

// Membersihkan semua toast
Alert.clear();
</script>

{{-- Controller Usage Examples --}}
{{--
// Di Controller Laravel:

// Flash messages biasa
return redirect()->back()->with('success', 'Data berhasil disimpan');
return redirect()->back()->with('error', 'Terjadi kesalahan');
return redirect()->back()->with('warning', 'Peringatan penting');
return redirect()->back()->with('info', 'Informasi tambahan');

// Toast notifications
return redirect()->back()->with('toast_success', 'Data berhasil disimpan');
return redirect()->back()->with('toast_error', 'Terjadi kesalahan');

// Validation errors
return back()->withErrors(['error' => 'Pesan error khusus'])->withInput();
--}}