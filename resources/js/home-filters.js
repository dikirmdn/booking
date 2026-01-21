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
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Show no results message if no rooms are visible
        const visibleRooms = Array.from(roomCards).filter(card => 
            card.style.display !== 'none'
        );
        
        let noResultsMsg = document.querySelector('.no-results-message');
        if (visibleRooms.length === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results-message text-center py-12';
                noResultsMsg.innerHTML = `
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada ruangan ditemukan</h3>
                    <p class="text-gray-500">Coba ubah filter pencarian Anda</p>
                `;
                document.querySelector('.room-grid').appendChild(noResultsMsg);
            }
            noResultsMsg.style.display = 'block';
        } else if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
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
});

// Function to refresh schedule data
function refreshSchedule() {
    console.log('Refreshing schedule...'); // Debug log
    
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
    .then(response => response.json())
    .then(data => {
        console.log('Schedule data received:', data); // Debug log
        if (data.success) {
            updateScheduleTable(data.data, data.rooms);
            updateLastUpdatedTime();
        }
    })
    .catch(error => {
        console.error('Error refreshing schedule:', error);
        // Fallback to page reload if API fails
        window.location.reload();
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
    if (!tbody) return;
    
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
}

// Function to scroll to current time
function scrollToCurrentTime() {
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
}

// Quick booking function
function quickBook(roomId, time) {
    console.log('Quick book clicked:', roomId, time); // Debug log
    
    // Check if user is authenticated by looking for logout form
    const isAuthenticated = document.querySelector('form[action*="logout"]') !== null;
    
    if (!isAuthenticated) {
        if (confirm('Anda perlu login terlebih dahulu untuk melakukan booking. Login sekarang?')) {
            window.location.href = '/login';
        }
        return;
    }
    
    if (confirm(`Apakah Anda ingin booking ruangan ini pada jam ${time}?`)) {
        // Show loading state
        const clickedElement = event.target;
        if (clickedElement) {
            clickedElement.style.opacity = '0.7';
            clickedElement.style.pointerEvents = 'none';
            clickedElement.textContent = 'Loading...';
        }
        
        // Redirect to booking page with pre-filled data
        const bookingUrl = `/user/bookings/create?room_id=${roomId}&time=${time}`;
        window.location.href = bookingUrl;
    }
}

// Function to navigate to room detail (calendar page)
function goToRoomDetail(url) {
    // Add loading state
    const card = event.target.closest('.room-card');
    if (card) {
        card.style.opacity = '0.7';
        card.style.pointerEvents = 'none';
    }
    
    // Navigate to room detail page
    window.location.href = url;
}

// Function to navigate to booking page
function goToBooking(url) {
    // Add loading state
    const button = event.target;
    if (button) {
        button.style.opacity = '0.7';
        button.style.pointerEvents = 'none';
        button.textContent = 'Loading...';
    }
    
    // Navigate to booking page
    window.location.href = url;
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