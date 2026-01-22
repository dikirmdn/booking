// Home Page Filter Functionality

// Make functions globally accessible for onclick handlers
window.refreshSchedule = refreshSchedule;
window.quickBook = quickBook;
window.goToRoomDetail = goToRoomDetail;
window.goToBooking = goToBooking;

document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterControls = document.querySelectorAll('.filter-controls select, .filter-controls input');
    const roomCards = document.querySelectorAll('.room-card');
    
    // Add event listeners to filter controls
    filterControls.forEach(control => {
        control.addEventListener('change', filterRooms);
        if (control.type === 'text') {
            control.addEventListener('input', debounce(filterRooms, 300));
        }
    });
    
    function filterRooms() {
        const filters = {
            floor: document.querySelector('select[name="floor"]')?.value || '',
            capacity: document.querySelector('select[name="capacity"]')?.value || '',
            facilities: document.querySelector('select[name="facilities"]')?.value || '',
            search: document.querySelector('input[type="text"]')?.value.toLowerCase() || ''
        };
        
        let filteredCount = 0;
        
        roomCards.forEach(card => {
            let show = true;
            
            // Search filter
            if (filters.search) {
                const roomName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const roomDescription = card.querySelector('.room-description')?.textContent.toLowerCase() || '';
                show = show && (roomName.includes(filters.search) || roomDescription.includes(filters.search));
            }
            
            // Floor filter
            if (filters.floor && filters.floor !== 'Semua Lantai') {
                const floorText = card.querySelector('.floor-info')?.textContent || '';
                show = show && floorText.includes(filters.floor);
            }
            
            // Capacity filter
            if (filters.capacity && filters.capacity !== 'Semua') {
                const capacityText = card.querySelector('.capacity-info')?.textContent || '';
                const capacity = parseInt(capacityText.match(/\d+/)?.[0] || 0);
                
                switch (filters.capacity) {
                    case '1-5 orang':
                        show = show && capacity >= 1 && capacity <= 5;
                        break;
                    case '6-10 orang':
                        show = show && capacity >= 6 && capacity <= 10;
                        break;
                    case '11+ orang':
                        show = show && capacity >= 11;
                        break;
                }
            }
            
            // Show/hide card with animation
            if (show) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
                filteredCount++;
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Show no results message if no rooms are visible
        let noResultsMsg = document.querySelector('.no-results-message');
        if (filteredCount === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-message text-center py-12';
                noResultsMsg.innerHTML = `
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada ruangan ditemukan</h3>
                    <p class="text-gray-500 mb-4">Coba ubah filter pencarian Anda</p>
                    <button onclick="clearAllFilters()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Reset Filter
                    </button>
                `;
                document.querySelector('.room-grid').appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
            
            // Show info toast for no results
            Alert.info(`Tidak ditemukan ruangan dengan kriteria yang dipilih.`, {
                title: 'Filter Hasil',
                duration: 3000
            });
        } else if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
            
            // Show success toast for filtered results
            if (filteredCount < roomCards.length) {
                Alert.success(`Menampilkan ${filteredCount} dari ${roomCards.length} ruangan.`, {
                    title: 'Filter Diterapkan',
                    duration: 2000
                });
            }
        }
    }
    
    // Debounce function for search input
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading states to buttons
    document.querySelectorAll('button, a[href]').forEach(element => {
        element.addEventListener('click', function() {
            if (!this.classList.contains('no-loading')) {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 2000);
            }
        });
    });
    
    // Auto-refresh schedule every 30 seconds
    setInterval(refreshSchedule, 30000);
    
    // Update last updated time every second
    setInterval(updateLastUpdatedTime, 1000);
    
    // Show welcome message on first load
    setTimeout(() => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('welcome') === '1') {
            Alert.success('Selamat datang di sistem booking ruang meeting DSI!', {
                title: 'Selamat Datang',
                duration: 5000
            });
        }
    }, 1000);
});

// Function to clear all filters
function clearAllFilters() {
    // Reset all filter controls
    document.querySelector('select[name="floor"]').value = 'Semua Lantai';
    document.querySelector('select[name="capacity"]').value = 'Semua';
    document.querySelector('select[name="facilities"]').value = 'Semua Fasilitas';
    document.querySelector('input[type="text"]').value = '';
    
    // Show all room cards
    const roomCards = document.querySelectorAll('.room-card');
    roomCards.forEach(card => {
        card.style.display = 'block';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    });
    
    // Hide no results message
    const noResultsMsg = document.querySelector('.no-results-message');
    if (noResultsMsg) {
        noResultsMsg.style.display = 'none';
    }
    
    // Show success message
    Alert.success('Filter berhasil direset. Menampilkan semua ruangan.', {
        title: 'Filter Direset',
        duration: 3000
    });
}

// Function to refresh schedule data
function refreshSchedule() {
    console.log('Refreshing schedule...'); // Debug log
    
    // Show loading toast
    const refreshToast = Alert.info('Memperbarui jadwal...', {
        title: 'Refresh',
        duration: 0,
        dismissible: false
    });
    
    // Show loading state
    const scheduleTable = document.querySelector('#schedule .schedule-table-body');
    if (scheduleTable) {
        scheduleTable.style.opacity = '0.6';
    }
    
    // Fetch fresh schedule data from API
    fetch('/api/schedule', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Schedule data received:', data); // Debug log
        if (data.success) {
            updateScheduleTable(data.data, data.rooms);
            updateLastUpdatedTime();
            
            // Remove loading toast and show success
            if (refreshToast && refreshToast.parentNode) {
                refreshToast.parentNode.removeChild(refreshToast);
            }
            Alert.success('Jadwal berhasil diperbarui!', {
                title: 'Berhasil',
                duration: 2000
            });
        } else {
            throw new Error(data.message || 'Failed to refresh schedule');
        }
    })
    .catch(error => {
        console.error('Error refreshing schedule:', error);
        
        // Remove loading toast
        if (refreshToast && refreshToast.parentNode) {
            refreshToast.parentNode.removeChild(refreshToast);
        }
        
        // Show error with option to retry or reload
        confirmAction('Gagal memperbarui jadwal. Apakah Anda ingin memuat ulang halaman?', {
            title: 'Error Refresh',
            confirmText: 'Muat Ulang',
            cancelText: 'Batal',
            type: 'error'
        }).then((confirmed) => {
            if (confirmed) {
                window.location.reload();
            } else {
                Alert.warning('Jadwal mungkin tidak terbaru. Coba refresh lagi nanti.', {
                    title: 'Peringatan',
                    duration: 4000
                });
            }
        });
    })
    .finally(() => {
        if (scheduleTable) {
            scheduleTable.style.opacity = '1';
        }
    });
}

// Function to update schedule table with new data
function updateScheduleTable(scheduleData, rooms) {
    const tbody = document.querySelector('#schedule .schedule-table-body tbody');
    if (!tbody) {
        Alert.error('Tidak dapat menemukan tabel jadwal untuk diperbarui.', {
            title: 'Error Update',
            duration: 4000
        });
        return;
    }
    
    try {
        let html = '';
        const timeSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'];
        const currentHour = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' }).substring(0, 2) + ':00';
        
        timeSlots.forEach(time => {
            const isCurrentTime = currentHour === time;
            const rowClass = isCurrentTime ? 'current-time-row hover:bg-blue-50' : 'hover:bg-gray-50';
            
            html += `<tr class="${rowClass} transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-20 sticky left-0 bg-white border-r border-gray-200">
                    <div class="flex items-center">
                        <span class="${isCurrentTime ? 'text-blue-600 font-semibold' : 'text-gray-900'}">${time}</span>
                        ${isCurrentTime ? '<div class="ml-2 w-2 h-2 bg-blue-500 rounded-full animate-pulse" title="Jam saat ini"></div>' : ''}
                    </div>
                </td>`;
            
            rooms.forEach(room => {
                const roomStatus = scheduleData[time] && scheduleData[time][room.id] 
                    ? scheduleData[time][room.id] 
                    : { status: 'available' };
                
                let statusHtml = '';
                let titleAttr = '';
                
                switch (roomStatus.status) {
                    case 'available':
                        statusHtml = `<span class="inline-flex px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full cursor-pointer hover:bg-green-600 transition-colors quick-book-available" onclick="quickBook('${room.id}', '${time}')">Tersedia</span>`;
                        break;
                    case 'approved':
                        titleAttr = roomStatus.user ? `title="Booked by: ${roomStatus.user}"` : '';
                        statusHtml = `<span class="inline-flex px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full" ${titleAttr}>BOOKED</span>`;
                        break;
                    case 'pending':
                        titleAttr = roomStatus.user ? `title="Pending by: ${roomStatus.user}"` : '';
                        statusHtml = `<span class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full" ${titleAttr}>MENUNGGU</span>`;
                        break;
                    default:
                        statusHtml = `<span class="inline-flex px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full cursor-pointer hover:bg-gray-300 transition-colors quick-book-available" onclick="quickBook('${room.id}', '${time}')">Tersedia</span>`;
                }
                
                html += `<td class="px-6 py-4 whitespace-nowrap">${statusHtml}</td>`;
            });
            
            html += `<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium w-16">
                <button class="text-gray-400 hover:text-gray-600 transition-colors" onclick="refreshSchedule()" title="Refresh">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </td></tr>`;
        });
        
        tbody.innerHTML = html;
        
        // Auto-scroll to current time
        scrollToCurrentTime();
        
    } catch (error) {
        console.error('Error updating schedule table:', error);
        Alert.error('Terjadi kesalahan saat memperbarui tampilan jadwal.', {
            title: 'Error Update Table',
            duration: 4000
        });
    }
}

// Function to scroll to current time
function scrollToCurrentTime() {
    try {
        const currentTimeRow = document.querySelector('.current-time-row');
        const scrollContainer = document.querySelector('.schedule-table-body');
        
        if (currentTimeRow && scrollContainer) {
            setTimeout(() => {
                const containerHeight = scrollContainer.clientHeight;
                const rowTop = currentTimeRow.offsetTop;
                const rowHeight = currentTimeRow.clientHeight;
                
                // Scroll to center the current time row
                const scrollTop = rowTop - (containerHeight / 2) + (rowHeight / 2);
                
                scrollContainer.scrollTo({
                    top: Math.max(0, scrollTop),
                    behavior: 'smooth'
                });
            }, 100);
        }
    } catch (error) {
        console.error('Error scrolling to current time:', error);
        // Don't show alert for this as it's not critical
    }
}

// Quick booking function
function quickBook(roomId, time) {
    console.log('Quick book clicked:', roomId, time); // Debug log
    
    // Check if user is authenticated by looking for logout form
    const isAuthenticated = document.querySelector('form[action*="logout"]') !== null;
    
    if (!isAuthenticated) {
        confirmAction('Anda perlu login terlebih dahulu untuk melakukan booking. Login sekarang?', {
            title: 'Login Diperlukan',
            confirmText: 'Login',
            cancelText: 'Batal',
            type: 'info'
        }).then((confirmed) => {
            if (confirmed) {
                // Store the intended booking for after login
                sessionStorage.setItem('pendingBooking', JSON.stringify({
                    roomId: roomId,
                    time: time,
                    returnUrl: window.location.href
                }));
                window.location.href = '/login';
            }
        });
        return;
    }
    
    confirmAction(`Apakah Anda ingin booking ruangan ini pada jam ${time}?`, {
        title: 'Konfirmasi Booking',
        confirmText: 'Ya, Booking',
        cancelText: 'Batal',
        type: 'info'
    }).then((confirmed) => {
        if (confirmed) {
            // Show loading toast
            const loadingToast = Alert.info('Memproses booking...', {
                title: 'Memproses',
                duration: 0,
                dismissible: false
            });
            
            // Show loading state on clicked element
            const clickedElement = event.target;
            const originalText = clickedElement ? clickedElement.textContent : '';
            if (clickedElement) {
                clickedElement.style.opacity = '0.7';
                clickedElement.style.pointerEvents = 'none';
                clickedElement.textContent = 'Loading...';
            }
            
            // Simulate a small delay for better UX
            setTimeout(() => {
                try {
                    // Redirect to booking page with pre-filled data
                    const bookingUrl = `/user/bookings/create?room_id=${roomId}&time=${time}`;
                    window.location.href = bookingUrl;
                } catch (error) {
                    // Handle error case
                    Alert.error('Terjadi kesalahan saat mengarahkan ke halaman booking.', {
                        title: 'Error',
                        duration: 5000
                    });
                    
                    // Restore button state
                    if (clickedElement) {
                        clickedElement.style.opacity = '1';
                        clickedElement.style.pointerEvents = 'auto';
                        clickedElement.textContent = originalText;
                    }
                }
            }, 500);
        }
    });
}

// Function to navigate to room detail (calendar page)
function goToRoomDetail(url) {
    // Show loading toast
    Alert.info('Memuat detail ruangan...', {
        title: 'Loading',
        duration: 2000
    });
    
    // Add loading state
    const card = event.target.closest('.room-card');
    if (card) {
        card.style.opacity = '0.7';
        card.style.pointerEvents = 'none';
    }
    
    // Navigate to room detail page with small delay for better UX
    setTimeout(() => {
        window.location.href = url;
    }, 300);
}

// Function to navigate to booking page
function goToBooking(url) {
    // Check if user is authenticated
    const isAuthenticated = document.querySelector('form[action*="logout"]') !== null;
    
    if (!isAuthenticated) {
        confirmAction('Anda perlu login terlebih dahulu untuk melakukan booking. Login sekarang?', {
            title: 'Login Diperlukan',
            confirmText: 'Login',
            cancelText: 'Batal',
            type: 'info'
        }).then((confirmed) => {
            if (confirmed) {
                // Store the intended URL for after login
                sessionStorage.setItem('intendedUrl', url);
                window.location.href = '/login';
            }
        });
        return;
    }
    
    // Show loading toast
    Alert.info('Mengarahkan ke halaman booking...', {
        title: 'Loading',
        duration: 2000
    });
    
    // Add loading state
    const button = event.target;
    if (button) {
        button.style.opacity = '0.7';
        button.style.pointerEvents = 'none';
        button.textContent = 'Loading...';
    }
    
    // Navigate to booking page with small delay for better UX
    setTimeout(() => {
        window.location.href = url;
    }, 300);
}

// Add scroll to current time on page load
document.addEventListener('DOMContentLoaded', function() {
    // Existing code...
    
    // Auto-scroll to current time after page loads
    setTimeout(scrollToCurrentTime, 500);
    
    // Add smooth scrolling behavior to schedule container
    const scheduleContainer = document.querySelector('.schedule-table-body');
    if (scheduleContainer) {
        scheduleContainer.style.scrollBehavior = 'smooth';
    }
    
    // Check for pending booking from session storage
    const pendingBooking = sessionStorage.getItem('pendingBooking');
    if (pendingBooking) {
        try {
            const booking = JSON.parse(pendingBooking);
            sessionStorage.removeItem('pendingBooking');
            
            setTimeout(() => {
                confirmAction(`Anda memiliki booking yang tertunda untuk jam ${booking.time}. Lanjutkan booking sekarang?`, {
                    title: 'Booking Tertunda',
                    confirmText: 'Lanjutkan',
                    cancelText: 'Batal',
                    type: 'info'
                }).then((confirmed) => {
                    if (confirmed) {
                        const bookingUrl = `/user/bookings/create?room_id=${booking.roomId}&time=${booking.time}`;
                        window.location.href = bookingUrl;
                    }
                });
            }, 1000);
        } catch (error) {
            console.error('Error parsing pending booking:', error);
            sessionStorage.removeItem('pendingBooking');
        }
    }
    
    // Check for intended URL from session storage
    const intendedUrl = sessionStorage.getItem('intendedUrl');
    if (intendedUrl) {
        sessionStorage.removeItem('intendedUrl');
        setTimeout(() => {
            Alert.info('Mengarahkan ke halaman yang diminta...', {
                title: 'Redirect',
                duration: 2000
            });
            setTimeout(() => {
                window.location.href = intendedUrl;
            }, 1000);
        }, 500);
    }
});

// Function to update last updated time
function updateLastUpdatedTime() {
    const lastUpdatedElement = document.querySelector('#lastUpdated');
    if (lastUpdatedElement) {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        });
        lastUpdatedElement.textContent = timeString;
    }
}