// Professional Alert System
class AlertSystem {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(message, type = 'info', options = {}) {
        const defaultOptions = {
            title: null,
            duration: 5000,
            dismissible: true,
            position: 'top-right'
        };

        const config = { ...defaultOptions, ...options };
        
        // Create toast element
        const toast = this.createToast(message, type, config);
        
        // Add to container
        this.container.appendChild(toast);
        
        // Auto remove after duration
        if (config.duration > 0) {
            setTimeout(() => {
                this.remove(toast);
            }, config.duration);
        }

        return toast;
    }

    createToast(message, type, config) {
        const toast = document.createElement('div');
        toast.className = `toast-item max-w-sm w-full bg-white rounded-lg shadow-lg border-l-4 p-4 transform transition-all duration-300 ease-out opacity-0 translate-y-2 ${this.getTypeClasses(type)}`;
        
        const icon = this.getIcon(type);
        const iconColor = this.getIconColor(type);
        
        toast.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    ${config.title ? `<p class="font-semibold text-gray-900 mb-1">${config.title}</p>` : ''}
                    <div class="text-sm text-gray-700">${message}</div>
                </div>
                ${config.dismissible ? `
                    <div class="ml-4 flex-shrink-0 flex">
                        <button class="toast-close inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                ` : ''}
            </div>
        `;

        // Add close functionality
        if (config.dismissible) {
            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                this.remove(toast);
            });
        }

        // Animate in
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 10);

        return toast;
    }

    remove(toast) {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    getTypeClasses(type) {
        const classes = {
            success: 'border-green-500',
            error: 'border-red-500',
            warning: 'border-yellow-500',
            info: 'border-green-500'
        };
        return classes[type] || classes.info;
    }

    getIconColor(type) {
        const colors = {
            success: 'text-green-500',
            error: 'text-red-500',
            warning: 'text-yellow-500',
            info: 'text-green-500'
        };
        return colors[type] || colors.info;
    }

    getIcon(type) {
        const icons = {
            success: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            error: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
            info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        };
        return icons[type] || icons.info;
    }

    // Convenience methods
    success(message, options = {}) {
        return this.show(message, 'success', { title: 'Berhasil!', ...options });
    }

    error(message, options = {}) {
        return this.show(message, 'error', { title: 'Terjadi Kesalahan!', ...options });
    }

    warning(message, options = {}) {
        return this.show(message, 'warning', { title: 'Peringatan!', ...options });
    }

    info(message, options = {}) {
        return this.show(message, 'info', { title: 'Informasi', ...options });
    }

    // Clear all toasts
    clear() {
        const toasts = this.container.querySelectorAll('.toast-item');
        toasts.forEach(toast => this.remove(toast));
    }
}

// Initialize global alert system
window.Alert = new AlertSystem();

// Enhanced confirm dialog
window.confirmAction = function(message, options = {}) {
    const defaultOptions = {
        title: 'Konfirmasi',
        confirmText: 'Ya',
        cancelText: 'Batal',
        type: 'warning'
    };
    
    const config = { ...defaultOptions, ...options };
    
    return new Promise((resolve) => {
        // Create modal backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4';
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0';
        
        const iconColor = {
            success: 'text-green-500',
            error: 'text-red-500',
            warning: 'text-yellow-500',
            info: 'text-green-500'
        }[config.type];
        
        const icon = {
            success: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            error: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
            warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
            info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        }[config.type];
        
        modal.innerHTML = `
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">${config.title}</h3>
                    </div>
                </div>
                <div class="mb-6">
                    <p class="text-gray-700">${message}</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button class="cancel-btn px-4 py-2 text-gray-600 hover:text-gray-800 font-medium rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        ${config.cancelText}
                    </button>
                    <button class="confirm-btn px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                        ${config.confirmText}
                    </button>
                </div>
            </div>
        `;
        
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        
        // Animate in
        setTimeout(() => {
            modal.classList.remove('scale-95', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Event listeners
        const confirmBtn = modal.querySelector('.confirm-btn');
        const cancelBtn = modal.querySelector('.cancel-btn');
        
        const cleanup = () => {
            modal.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                document.body.removeChild(backdrop);
            }, 300);
        };
        
        confirmBtn.addEventListener('click', () => {
            cleanup();
            resolve(true);
        });
        
        cancelBtn.addEventListener('click', () => {
            cleanup();
            resolve(false);
        });
        
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                cleanup();
                resolve(false);
            }
        });
        
        // ESC key
        const handleEsc = (e) => {
            if (e.key === 'Escape') {
                cleanup();
                resolve(false);
                document.removeEventListener('keydown', handleEsc);
            }
        };
        document.addEventListener('keydown', handleEsc);
    });
};

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { AlertSystem, confirmAction };
}