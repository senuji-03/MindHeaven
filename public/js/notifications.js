/**
 * MindHeaven — Notifications JS
 * Handles real-time polling and UI for system notifications.
 */

(function() {
    // Detect BASE_URL from window if defined, else fallback
    const BASE = window.BASE_URL || '/MindHeaven/public';
    const POLLING_INTERVAL = 30000; // 30 seconds
    
    let dropdownOpen = false;

    /**
     * Initialize the notification system
     */
    function init() {
        // First, check if we need to "adopt" a legacy/custom navbar icon (e.g., Counselor Dashboard)
        adoptCustomNavbar();

        const bellBtn = document.getElementById('notificationBtn');
        const badge = document.getElementById('notificationBadge');
        const dropdown = document.getElementById('notificationDropdown');
        const list = document.getElementById('notificationList');
        const markAllReadBtn = document.getElementById('markAllReadBtn');

        if (!bellBtn || !badge || !dropdown || !list || !markAllReadBtn) {
            // If still missing (maybe a page without are nav), don't error out
            return;
        }

        // Toggle dropdown
        bellBtn.onclick = (e) => {
            e.stopPropagation();
            dropdownOpen = !dropdownOpen;
            dropdown.style.display = dropdownOpen ? 'flex' : 'none';
            if (dropdownOpen) {
                fetchNotifications();
            }
        };

        // Close dropdown on outside click
        document.addEventListener('click', () => {
            dropdownOpen = false;
            if (dropdown) dropdown.style.display = 'none';
        });

        dropdown.addEventListener('click', (e) => e.stopPropagation());

        // Mark all as read
        markAllReadBtn.onclick = async () => {
            try {
                const res = await fetch(`${BASE}/api/notifications/mark-read`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ all: true })
                });
                const data = await res.json();
                if (data.success) {
                    fetchNotifications();
                    updateBadge(0);
                }
            } catch (err) {
                console.error('Failed to mark notifications as read:', err);
            }
        };

        // Start Initial Fetch
        fetchUnreadCount();
        setInterval(fetchUnreadCount, POLLING_INTERVAL);
    }

    /**
     * Searches for older hardcoded badges and replaces them with our dynamic system
     */
    function adoptCustomNavbar() {
        // Look for counselor-style nav-icons
        const navIcons = document.querySelectorAll('.nav-icon');
        navIcons.forEach(icon => {
            if (icon.textContent.includes('🔔')) {
                // This is the notification bell
                const badge = icon.querySelector('.badge');
                if (badge && !badge.id) {
                    badge.id = 'notificationBadge';
                    badge.textContent = '0'; // Reset static 3/7 to 0
                    badge.className = 'notification-badge'; // Standardize class
                }
                
                if (!icon.id) icon.id = 'notificationBtn';
                
                // Remove existing onclick if any
                icon.removeAttribute('onclick');
                
                // Inject dropdown if it doesn't exist in the parent
                injectDropdown(icon.parentElement);
            }
        });
    }

    /**
     * Injects the notification dropdown into the parent element
     */
    function injectDropdown(parent) {
        if (document.getElementById('notificationDropdown')) return;

        const dropdownHtml = `
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <h3>Notifications</h3>
                </div>
                <div class="notification-list" id="notificationList">
                    <div class="notification-item-empty">Loading...</div>
                </div>
                <div class="notification-footer">
                    <button type="button" id="markAllReadBtn">Mark all as read</button>
                </div>
            </div>
        `;
        
        // Find a good spot to wrap or append
        const wrapper = document.createElement('div');
        wrapper.className = 'notification-wrapper';
        
        const btn = document.getElementById('notificationBtn');
        if (btn) {
            btn.parentNode.insertBefore(wrapper, btn);
            wrapper.appendChild(btn);
            wrapper.insertAdjacentHTML('beforeend', dropdownHtml);
        }
    }

    /**
     * API Calls
     */
    async function fetchUnreadCount() {
        try {
            const res = await fetch(`${BASE}/api/notifications/unread-count`);
            const data = await res.json();
            if (data.success) {
                updateBadge(data.count);
            }
        } catch (err) {}
    }

    async function fetchNotifications() {
        const list = document.getElementById('notificationList');
        try {
            const res = await fetch(`${BASE}/api/notifications`);
            const data = await res.json();
            if (data.success) {
                renderNotifications(data.notifications);
                updateBadge(data.unreadCount);
            }
        } catch (err) {
            if (list) list.innerHTML = '<div class="notification-item-empty">Failed to load.</div>';
        }
    }

    function renderNotifications(notifications) {
        const list = document.getElementById('notificationList');
        if (!list) return;

        if (!notifications || notifications.length === 0) {
            list.innerHTML = '<div class="notification-item-empty">No notifications yet.</div>';
            return;
        }

        list.innerHTML = notifications.map(n => `
            <div class="notification-item ${n.is_read == 0 ? 'unread' : ''}" data-id="${n.id}" data-type="${n.type}" data-related="${n.related_id}">
                <div class="notification-item-msg">${escapeHtml(n.message)}</div>
                <div class="notification-item-time">${formatTimeAgo(n.created_at)}</div>
            </div>
        `).join('');

        document.querySelectorAll('.notification-item').forEach(item => {
            item.onclick = (e) => {
                e.stopPropagation();
                const { id, type, related } = item.dataset;
                markAsRead(id);
                handleNavigation(type, related);
            };
        });
    }

    function updateBadge(count) {
        const badge = document.getElementById('notificationBadge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    async function markAsRead(id) {
        try {
            await fetch(`${BASE}/api/notifications/mark-read`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
        } catch (err) {}
    }

    function handleNavigation(type, relatedId) {
        switch (type) {
            case 'appointment_booked':
            case 'reschedule_accepted':
                window.location.href = `${BASE}/counselor/appointmentmgt`;
                break;
            case 'appointment_accepted':
            case 'appointment_rejected':
            case 'appointment_rescheduled':
                window.location.href = `${BASE}/ug/appointment`;
                break;
            case 'session_started':
                if (relatedId) {
                    window.location.href = `${BASE}/chat/room?session_id=${relatedId}`;
                } else {
                    window.location.href = `${BASE}/ug/appointment`;
                }
                break;
        }

        // Close dropdown after click
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            dropdown.style.display = 'none';
            dropdownOpen = false;
        }
    }

    function formatTimeAgo(dateStr) {
        const date = new Date(dateStr.replace(/-/g, "/")); // Compatibility
        const diff = Math.floor((new Date() - date) / 1000);
        if (diff < 60) return 'Just now';
        if (diff < 3600) return Math.floor(diff/60) + 'm ago';
        if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
        return date.toLocaleDateString();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Run init on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
