// Home Page Animations
document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations when page loads
    initializeAnimations();
    
    // Setup intersection observer for scroll-triggered animations
    setupIntersectionObserver();
});

function initializeAnimations() {
    // Add animation classes to elements
    const header = document.querySelector('header');
    if (header) {
        header.classList.add('header-animate');
    }
    
    // Hero section elements
    const heroContent = document.querySelector('.hero-content');
    const heroTitle = document.querySelector('.hero-title');
    const heroDescription = document.querySelector('.hero-description');
    const heroButtons = document.querySelector('.hero-buttons');
    const heroImage = document.querySelector('.hero-image');
    const heroBuilding = document.querySelector('.hero-building');
    const heroBuildingBg = document.querySelector('.hero-building-bg');
    
    if (heroContent) heroContent.classList.add('animate-on-load');
    if (heroTitle) heroTitle.classList.add('animate-on-load');
    if (heroDescription) heroDescription.classList.add('animate-on-load');
    if (heroButtons) heroButtons.classList.add('animate-on-load');
    if (heroImage) heroImage.classList.add('animate-on-load');
    if (heroBuilding) heroBuilding.classList.add('animate-on-load');
    if (heroBuildingBg) heroBuildingBg.classList.add('animate-on-load');
    
    // Rooms section
    const roomsHeader = document.querySelector('.rooms-header');
    if (roomsHeader) {
        roomsHeader.classList.add('fade-in-observer');
    }
    
    // Room cards
    const roomCards = document.querySelectorAll('.room-card');
    roomCards.forEach((card, index) => {
        card.classList.add('animate-on-load');
        card.style.animationDelay = `${0.1 + (index * 0.1)}s`;
    });
}

function setupIntersectionObserver() {
    // Create intersection observer for scroll-triggered animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optional: unobserve after animation to improve performance
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements that should animate on scroll
    const elementsToObserve = document.querySelectorAll('.fade-in-observer');
    elementsToObserve.forEach(element => {
        observer.observe(element);
    });
}

// Add smooth scrolling for anchor links
document.addEventListener('click', function(e) {
    if (e.target.matches('a[href^="#"]')) {
        e.preventDefault();
        const targetId = e.target.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// Add loading animation for room cards on hover
document.addEventListener('mouseover', function(e) {
    if (e.target.closest('.room-card')) {
        const card = e.target.closest('.room-card');
        card.style.transform = 'translateY(-8px) scale(1.02)';
    }
});

document.addEventListener('mouseout', function(e) {
    if (e.target.closest('.room-card')) {
        const card = e.target.closest('.room-card');
        card.style.transform = '';
    }
});

// Preload animations for better performance
function preloadAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        .preload-animations * {
            animation-duration: 0s !important;
            transition-duration: 0s !important;
        }
    `;
    document.head.appendChild(style);
    
    setTimeout(() => {
        document.head.removeChild(style);
    }, 100);
}

// Call preload on page load
if (document.readyState === 'loading') {
    preloadAnimations();
}