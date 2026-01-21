document.addEventListener('DOMContentLoaded', function() {
    const imageInputs = document.querySelectorAll('input[type="file"][name="image"]');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                const maxSize = 2 * 1024 * 1024;
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                
                if (file.size > maxSize) {
                    // Show professional alert with file size info
                    if (typeof Alert !== 'undefined' && Alert.error) {
                        Alert.error(
                            `Ukuran file yang Anda pilih adalah ${fileSizeMB} MB. Silakan pilih gambar dengan ukuran maksimal 2 MB.`,
                            { 
                                title: 'File Terlalu Besar!',
                                duration: 6000 
                            }
                        );
                    } else {
                        alert(`Ukuran file terlalu besar (${fileSizeMB} MB)! Maksimal 2 MB.`);
                    }
                    
                    // Clear the input
                    e.target.value = '';
                    return;
                }
                
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    if (typeof Alert !== 'undefined' && Alert.error) {
                        Alert.error(
                            'Format file tidak didukung. Silakan pilih gambar dengan format JPEG, PNG, JPG, atau GIF.',
                            { 
                                title: 'Format File Tidak Valid!',
                                duration: 5000 
                            }
                        );
                    } else {
                        alert('Format file tidak didukung! Gunakan JPEG, PNG, JPG, atau GIF.');
                    }
                    
                    // Clear the input
                    e.target.value = '';
                    return;
                }
                
                // Show success message with file info
                if (typeof Alert !== 'undefined' && Alert.success) {
                    Alert.success(
                        `${file.name} (${fileSizeMB} MB) siap untuk diupload.`,
                        { 
                            title: 'File Berhasil Dipilih!',
                            duration: 4000 
                        }
                    );
                }
            }
        });
    });
});