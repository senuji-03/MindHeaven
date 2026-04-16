/**
 * University Representative Dashboard JavaScript
 * Location: public/js/university-rep/script.js
 */

// Set active navigation based on current URL
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    
    let bestMatch = null;
    let longestMatchLen = -1;

    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href) {
            try {
                const url = new URL(href, window.location.origin);
                // Normalize trailing slashes for safer matching
                const urlPath = url.pathname.replace(/\/$/, "");
                const windowPath = window.location.pathname.replace(/\/$/, "");

                // Check for exact match or deeper path match
                if (windowPath === urlPath || windowPath.startsWith(urlPath + '/')) {
                    if (urlPath.length > longestMatchLen) {
                        longestMatchLen = urlPath.length;
                        bestMatch = item;
                    }
                }
            } catch (e) {
                // Ignore invalid URLs
            }
        }
    });

    if (bestMatch) {
        navItems.forEach(nav => nav.classList.remove('active'));
        bestMatch.classList.add('active');
    }

    // Initialize Event Filters if on the events page
    if (document.getElementById('searchEvents') && document.getElementById('filterStatus')) {
        initEventsFilter();
    }
});

/**
 * Combined filtering for University Representative Events
 */
function initEventsFilter() {
    const searchInput = document.getElementById('searchEvents');
    const statusSelect = document.getElementById('filterStatus');
    const eventCards = document.querySelectorAll('.event-card');
    const eventsGrid = document.querySelector('.events-grid');
    const emptyState = document.querySelector('.empty-state');

    function filterEvents() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedStatus = statusSelect.value.toLowerCase();
        let visibleCount = 0;

        eventCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            const statusBadge = card.querySelector('.event-status');
            const cardStatus = statusBadge ? statusBadge.textContent.trim().toLowerCase() : '';

            const matchesSearch = cardText.includes(searchTerm);
            const matchesStatus = selectedStatus === '' || cardStatus === selectedStatus;

            if (matchesSearch && matchesStatus) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Toggle empty state if no events match
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    searchInput.addEventListener('input', filterEvents);
    statusSelect.addEventListener('change', filterEvents);
}

// Notification icon click
const notificationIcon = document.querySelector('.notification-icon');
if (notificationIcon) {
    notificationIcon.addEventListener('click', function() {
        alert('Notifications feature coming soon!');
    });
}

// Auto-hide alerts after 4 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.classList.add('alert-fade-out');
        setTimeout(() => alert.remove(), 400);
    });
}, 4000);

// Manual alert close
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('alert-close') || e.target.closest('.alert-close')) {
        const alert = e.target.closest('.alert');
        if (alert) {
            alert.classList.add('alert-fade-out');
            setTimeout(() => alert.remove(), 400);
        }
    }
});

// Confirm delete actions
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-delete') || 
        e.target.closest('.btn-delete')) {
        if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
            e.preventDefault();
            return false;
        }
    }
});

// Form validation helper
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });
    
    return isValid;
}

// File upload preview
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Search filter helper
function filterItems(searchInputId, itemSelector) {
    const searchInput = document.getElementById(searchInputId);
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll(itemSelector);
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
}

// Console log for debugging
console.log('University Representative Dashboard JavaScript Loaded');
console.log('Current Path:', window.location.pathname);