<x-app-layout>
    <x-slot name="header">
        Demo Sistem Alert Profesional
    </x-slot>

    <div class="space-y-8">
        <!-- Alert Components Demo -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Komponen Alert</h2>
            
            <div class="space-y-4">
                <x-alert type="success" title="Berhasil!">
                    Operasi telah berhasil dilakukan. Data Anda telah tersimpan dengan aman.
                </x-alert>

                <x-alert type="error" title="Terjadi Kesalahan">
                    Tidak dapat memproses permintaan Anda saat ini. Silakan coba lagi dalam beberapa saat.
                </x-alert>

                <x-alert type="warning" title="Peringatan Penting" :dismissible="false">
                    Data akan dihapus secara permanen dan tidak dapat dikembalikan.
                </x-alert>

                <x-alert type="info" title="Informasi Sistem" size="lg">
                    Sistem akan menjalani maintenance terjadwal pada hari Minggu, 12 Januari 2025 pukul 02:00 - 04:00 WIB.
                </x-alert>
            </div>
        </div>

        <!-- Interactive Demo -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Demo Interaktif</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <h3 class="font-semibold text-gray-800">Toast Notifications</h3>
                    <button onclick="Alert.success('Booking berhasil dibuat!')" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                        Success Toast
                    </button>
                    <button onclick="Alert.error('Gagal menyimpan data!')" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                        Error Toast
                    </button>
                    <button onclick="Alert.warning('Ruangan hampir penuh!')" 
                            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium">
                        Warning Toast
                    </button>
                    <button onclick="Alert.info('Sistem akan maintenance')" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        Info Toast
                    </button>
                </div>

                <div class="space-y-3">
                    <h3 class="font-semibold text-gray-800">Confirmation Dialogs</h3>
                    <button onclick="demoConfirm('delete')" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                        Delete Confirmation
                    </button>
                    <button onclick="demoConfirm('save')" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        Save Confirmation
                    </button>
                    <button onclick="demoConfirm('logout')" 
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                        Logout Confirmation
                    </button>
                    <button onclick="Alert.clear()" 
                            class="w-full bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium">
                        Clear All Toasts
                    </button>
                </div>
            </div>
        </div>

        <!-- Usage Examples -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Contoh Penggunaan</h2>
            
            <div class="space-y-6">
                <!-- Blade Components -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Blade Components</h3>
                    <div class="bg-gray-100 rounded-lg p-4 text-sm font-mono">
                        <div class="space-y-2">
                            <div>&lt;x-alert type="success" title="Berhasil!"&gt;</div>
                            <div class="ml-4">Data berhasil disimpan</div>
                            <div>&lt;/x-alert&gt;</div>
                            <br>
                            <div>&lt;x-flash-messages /&gt;</div>
                        </div>
                    </div>
                </div>

                <!-- JavaScript -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">JavaScript</h3>
                    <div class="bg-gray-100 rounded-lg p-4 text-sm font-mono">
                        <div class="space-y-2">
                            <div>Alert.success('Operasi berhasil!');</div>
                            <div>Alert.error('Terjadi kesalahan!');</div>
                            <div>confirmAction('Yakin hapus?').then(confirmed => {});</div>
                        </div>
                    </div>
                </div>

                <!-- Laravel Controller -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Laravel Controller</h3>
                    <div class="bg-gray-100 rounded-lg p-4 text-sm font-mono">
                        <div class="space-y-2">
                            <div>return redirect()-&gt;with('success', 'Data tersimpan');</div>
                            <div>return redirect()-&gt;with('toast_success', 'Toast message');</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Fitur Sistem Alert</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-green-600 mb-2">✓ Fitur Utama</h3>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• 4 tipe alert: success, error, warning, info</li>
                        <li>• Toast notifications dengan auto-dismiss</li>
                        <li>• Confirmation dialogs yang elegan</li>
                        <li>• Responsive design untuk semua device</li>
                        <li>• Animasi smooth dengan CSS transitions</li>
                        <li>• Integrasi dengan Laravel flash messages</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-blue-600 mb-2">⚡ Keunggulan</h3>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li>• Accessibility compliant (ARIA labels)</li>
                        <li>• Keyboard navigation support</li>
                        <li>• High contrast mode support</li>
                        <li>• Reduced motion support</li>
                        <li>• Print-friendly (hidden saat print)</li>
                        <li>• Lightweight dan performant</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function demoConfirm(type) {
            const configs = {
                delete: {
                    message: 'Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.',
                    title: 'Konfirmasi Hapus',
                    confirmText: 'Ya, Hapus',
                    cancelText: 'Batal',
                    type: 'error'
                },
                save: {
                    message: 'Simpan perubahan yang telah Anda buat?',
                    title: 'Simpan Perubahan',
                    confirmText: 'Simpan',
                    cancelText: 'Batal',
                    type: 'info'
                },
                logout: {
                    message: 'Anda akan keluar dari sistem. Pastikan semua pekerjaan telah tersimpan.',
                    title: 'Konfirmasi Logout',
                    confirmText: 'Logout',
                    cancelText: 'Batal',
                    type: 'warning'
                }
            };

            const config = configs[type];
            
            confirmAction(config.message, {
                title: config.title,
                confirmText: config.confirmText,
                cancelText: config.cancelText,
                type: config.type
            }).then((confirmed) => {
                if (confirmed) {
                    Alert.success(`Aksi ${type} berhasil dilakukan!`);
                } else {
                    Alert.info('Aksi dibatalkan');
                }
            });
        }

        // Demo auto-toast on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                Alert.info('Selamat datang di demo sistem alert!', {
                    title: 'Demo Ready',
                    duration: 4000
                });
            }, 1000);
        });
    </script>
    @endpush
</x-app-layout>