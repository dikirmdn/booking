# Sistem Alert Profesional

Sistem alert yang komprehensif dan profesional untuk aplikasi Laravel dengan dukungan penuh untuk accessibility, responsiveness, dan user experience yang optimal.

## 🚀 Fitur Utama

### 1. Komponen Alert
- **4 Tipe Alert**: Success, Error, Warning, Info
- **Customizable**: Title, size, dismissible, icon
- **Responsive**: Optimal di semua ukuran layar
- **Accessible**: ARIA labels dan keyboard navigation

### 2. Toast Notifications
- **Auto-dismiss**: Durasi dapat dikustomisasi
- **Positioning**: 6 posisi berbeda (top-right, top-left, dll)
- **Stacking**: Multiple toasts dengan animasi smooth
- **Interactive**: Dapat ditutup manual

### 3. Confirmation Dialogs
- **Modal-based**: Backdrop blur dengan animasi
- **Customizable**: Text, buttons, icons, colors
- **Promise-based**: Modern async/await support
- **Keyboard support**: ESC untuk cancel

### 4. Flash Messages Integration
- **Laravel Integration**: Seamless dengan session flash
- **Auto-display**: Otomatis tampil dari controller
- **Multiple types**: Support semua tipe alert

## 📁 Struktur File

```
resources/
├── views/components/
│   ├── alert.blade.php              # Komponen alert utama
│   ├── toast.blade.php              # Komponen toast
│   ├── flash-messages.blade.php     # Flash messages handler
│   ├── notification-helper.blade.php # Helper untuk toast dari session
│   └── booking-actions.blade.php    # Contoh implementasi
├── js/
│   └── alerts.js                    # JavaScript alert system
└── css/
    └── alerts.css                   # Styling khusus alert
```

## 🎯 Cara Penggunaan

### 1. Blade Components

#### Alert Dasar
```blade
<x-alert type="success">
    Operasi berhasil dilakukan!
</x-alert>
```

#### Alert dengan Title dan Opsi
```blade
<x-alert type="error" title="Terjadi Kesalahan" :dismissible="false" size="lg">
    Tidak dapat memproses permintaan Anda saat ini.
</x-alert>
```

#### Flash Messages (Otomatis)
```blade
<x-flash-messages />
```

### 2. JavaScript API

#### Toast Notifications
```javascript
// Basic usage
Alert.success('Data berhasil disimpan!');
Alert.error('Terjadi kesalahan!');
Alert.warning('Peringatan penting!');
Alert.info('Informasi sistem');

// Advanced usage
Alert.success('Data tersimpan', {
    title: 'Berhasil!',
    duration: 3000,
    dismissible: true
});

// Clear all toasts
Alert.clear();
```

#### Confirmation Dialogs
```javascript
confirmAction('Apakah Anda yakin ingin menghapus?', {
    title: 'Konfirmasi Hapus',
    confirmText: 'Ya, Hapus',
    cancelText: 'Batal',
    type: 'warning'
}).then((confirmed) => {
    if (confirmed) {
        // Lakukan aksi hapus
        Alert.success('Data berhasil dihapus!');
    }
});
```

### 3. Laravel Controller

#### Flash Messages
```php
// Success message
return redirect()->back()->with('success', 'Data berhasil disimpan');

// Error message
return redirect()->back()->with('error', 'Terjadi kesalahan');

// Warning message
return redirect()->back()->with('warning', 'Peringatan penting');

// Info message
return redirect()->back()->with('info', 'Informasi tambahan');
```

#### Toast Messages
```php
// Toast notifications (akan muncul sebagai toast, bukan alert)
return redirect()->back()->with('toast_success', 'Data berhasil disimpan');
return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
```

#### Validation Errors
```php
return back()->withErrors([
    'error' => 'Pesan error khusus untuk ditampilkan'
])->withInput();
```

## 🎨 Customization

### Alert Types & Colors
- **Success**: Green theme (`bg-green-50`, `border-green-200`, `text-green-800`)
- **Error**: Red theme (`bg-red-50`, `border-red-200`, `text-red-800`)
- **Warning**: Yellow theme (`bg-yellow-50`, `border-yellow-200`, `text-yellow-800`)
- **Info**: Blue theme (`bg-blue-50`, `border-blue-200`, `text-blue-800`)

### Sizes
- **Small**: `sm` - Padding 3, text-sm
- **Default**: `default` - Padding 4
- **Large**: `lg` - Padding 6, text-lg

### Toast Positions
- `top-right` (default)
- `top-left`
- `bottom-right`
- `bottom-left`
- `top-center`
- `bottom-center`

## ♿ Accessibility Features

### ARIA Support
- `role="alert"` untuk screen readers
- Proper ARIA labels pada buttons
- Focus management untuk keyboard navigation

### Keyboard Navigation
- **ESC**: Tutup modal/dialog
- **Tab**: Navigate antar elemen
- **Enter/Space**: Activate buttons

### Visual Accessibility
- High contrast mode support
- Reduced motion support untuk users dengan vestibular disorders
- Proper color contrast ratios

### Screen Reader Support
- Descriptive text untuk semua interactive elements
- Proper heading hierarchy
- Status announcements untuk dynamic content

## 📱 Responsive Design

### Mobile (< 640px)
- Full-width toasts
- Adjusted padding dan font sizes
- Touch-friendly button sizes
- Simplified layouts

### Tablet (640px - 1024px)
- Optimized spacing
- Balanced layouts
- Medium-sized interactive elements

### Desktop (> 1024px)
- Full feature set
- Larger interactive areas
- Enhanced animations

## 🔧 Advanced Configuration

### Custom Alert Component
```blade
<x-alert 
    type="success" 
    title="Custom Title"
    :dismissible="true"
    :icon="true"
    size="lg"
    class="mb-4"
>
    Custom content here
</x-alert>
```

### Custom Toast Options
```javascript
Alert.show('Custom message', 'info', {
    title: 'Custom Title',
    duration: 5000,
    dismissible: true,
    position: 'top-center'
});
```

### Custom Confirmation Dialog
```javascript
confirmAction('Custom message', {
    title: 'Custom Title',
    confirmText: 'Custom Confirm',
    cancelText: 'Custom Cancel',
    type: 'info'
});
```

## 🎯 Best Practices

### 1. Pemilihan Tipe Alert
- **Success**: Untuk konfirmasi aksi berhasil
- **Error**: Untuk error dan kegagalan
- **Warning**: Untuk peringatan dan konfirmasi
- **Info**: Untuk informasi umum dan tips

### 2. Durasi Toast
- **Success**: 3-4 detik
- **Error**: 6-8 detik (user perlu waktu baca)
- **Warning**: 5-6 detik
- **Info**: 4-5 detik

### 3. Penempatan
- **Flash messages**: Di atas konten utama
- **Toast**: Top-right untuk desktop, full-width untuk mobile
- **Confirmation**: Center screen dengan backdrop

### 4. Accessibility
- Selalu sertakan title yang descriptive
- Gunakan warna dan icon untuk redundancy
- Test dengan screen reader
- Pastikan keyboard navigation berfungsi

## 🚀 Performance

### Optimizations
- CSS animations menggunakan `transform` dan `opacity`
- JavaScript debouncing untuk multiple toasts
- Lazy loading untuk modal components
- Minimal DOM manipulation

### Bundle Size
- **CSS**: ~2KB (minified + gzipped)
- **JavaScript**: ~4KB (minified + gzipped)
- **Total**: ~6KB additional overhead

## 🔍 Troubleshooting

### Common Issues

1. **Toast tidak muncul**
   - Pastikan `alerts.js` ter-import dengan benar
   - Check console untuk JavaScript errors
   - Verify Alpine.js loaded

2. **Styling tidak sesuai**
   - Pastikan `alerts.css` ter-import di `app.css`
   - Check Tailwind CSS configuration
   - Verify CSS build process

3. **Flash messages tidak tampil**
   - Pastikan `<x-flash-messages />` ada di layout
   - Check session configuration
   - Verify redirect dengan session data

### Debug Mode
```javascript
// Enable debug logging
window.AlertDebug = true;

// Check alert system status
console.log('Alert System:', window.Alert);
```

## 📊 Browser Support

- **Chrome**: 90+
- **Firefox**: 88+
- **Safari**: 14+
- **Edge**: 90+
- **Mobile browsers**: iOS Safari 14+, Chrome Mobile 90+

## 🔄 Migration dari Alert Lama

### Ganti `alert()` JavaScript
```javascript
// Lama
alert('Pesan sukses');

// Baru
Alert.success('Pesan sukses');
```

### Ganti `confirm()` JavaScript
```javascript
// Lama
if (confirm('Yakin hapus?')) {
    // aksi hapus
}

// Baru
confirmAction('Yakin hapus?').then(confirmed => {
    if (confirmed) {
        // aksi hapus
    }
});
```

### Update Flash Messages
```blade
{{-- Lama --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Baru --}}
<x-flash-messages />
```

## 📈 Metrics & Analytics

### Tracking User Interactions
```javascript
// Track alert dismissals
document.addEventListener('alertDismissed', (e) => {
    analytics.track('Alert Dismissed', {
        type: e.detail.type,
        message: e.detail.message
    });
});

// Track confirmation responses
document.addEventListener('confirmationResponse', (e) => {
    analytics.track('Confirmation Dialog', {
        action: e.detail.confirmed ? 'confirmed' : 'cancelled',
        message: e.detail.message
    });
});
```

## 🎉 Demo

Kunjungi `/demo/alerts` untuk melihat semua fitur sistem alert dalam aksi.

---

**Dibuat dengan ❤️ untuk pengalaman user yang lebih baik**