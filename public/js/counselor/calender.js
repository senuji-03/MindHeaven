let currentDate = new Date();
let selectedDate = null;
let events = {};

// Initialize events from PHP data
if (typeof eventsFromPHP !== 'undefined') {
    events = eventsFromPHP;
}

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    document.getElementById('currentMonth').textContent = 
        currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const dayElement = createDayElement(day, true, year, month - 1);
        calendarDays.appendChild(dayElement);
    }
    
    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = createDayElement(day, false, year, month);
        calendarDays.appendChild(dayElement);
    }
    
    // Next month days
    const totalCells = calendarDays.children.length;
    const remainingCells = 42 - totalCells;
    for (let day = 1; day <= remainingCells; day++) {
        const dayElement = createDayElement(day, true, year, month + 1);
        calendarDays.appendChild(dayElement);
    }
}

function createDayElement(day, isOtherMonth, year, month) {
    const dayElement = document.createElement('div');
    dayElement.className = 'day';
    
    if (isOtherMonth) {
        dayElement.classList.add('other-month');
    }
    
    const today = new Date();
    const dayDate = new Date(year, month, day);
    
    // Check if this is a past date (before today)
    const isPastDate = dayDate < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    
    if (isPastDate) {
        dayElement.classList.add('past-date');
    }
    
    if (!isOtherMonth && 
        dayDate.toDateString() === today.toDateString()) {
        dayElement.classList.add('today');
    }
    
    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const dayEvents = events[dateString] || [];
    
    if (dayEvents.length > 0) {
        console.log(`Day ${dateString} has ${dayEvents.length} events:`, dayEvents);
        dayElement.classList.add('has-events');
    }
    
    dayElement.innerHTML = `
        <div class="day-number">${day}</div>
        <div class="day-events">
            ${dayEvents.slice(0, 2).map(event => 
                `<div class="event-preview ${event.priority === 'urgent' ? 'urgent' : ''}">${event.title}</div>`
            ).join('')}
            ${dayEvents.length > 2 ? `<div class="event-preview">+${dayEvents.length - 2} more</div>` : ''}
        </div>
    `;
    
    // Only allow clicking on future dates or today
    if (!isPastDate) {
        dayElement.addEventListener('click', () => showDayEvents(dateString, day, month + 1, year));
    } else {
        dayElement.style.cursor = 'not-allowed';
        dayElement.title = 'Past dates cannot be selected';
    }
    
    return dayElement;
}

function previousMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    loadMonthEvents();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    loadMonthEvents();
}

function goToToday() {
    currentDate = new Date();
    loadMonthEvents();
}

function loadMonthEvents() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth() + 1;
    
    console.log(`Loading events for ${year}-${month}`);
    console.log(`API URL: ${BASE}/counselor/getEventsByMonth?year=${year}&month=${month}`);
    
    fetch(`${BASE}/counselor/getEventsByMonth?year=${year}&month=${month}`)
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);
            if (data.success) {
                events = data.events;
                console.log('Events loaded:', events);
                renderCalendar();
            } else {
                console.error('Failed to load events:', data.message);
                if (data.message === 'Not logged in') {
                    alert('Session expired. Please login again.');
                    window.location.href = '/login';
                }
            }
        })
        .catch(error => {
            console.error('Error loading events:', error);
        });
}

function showDayEvents(dateString, day, month, year) {
    selectedDate = dateString;
    
    // Load events for this specific date
    fetch(`${BASE}/counselor/getEventsByDate?date=${dateString}`)
        .then(response => response.json())
        .then(data => {
            const dayEvents = data.success ? data.events : [];
            const monthName = new Date(year, month - 1, day).toLocaleDateString('en-US', { month: 'long' });
            
            document.getElementById('dayEventsTitle').textContent = `Events for ${monthName} ${day}, ${year}`;
            
            const dayEventsList = document.getElementById('dayEventsList');
            
            if (dayEvents.length === 0) {
                dayEventsList.innerHTML = '<p style="text-align: center; color: #64748b; padding: 2rem;">No events scheduled for this day.</p>';
            } else {
                dayEventsList.innerHTML = dayEvents.map(event => `
                    <div class="day-event-item ${event.priority === 'urgent' ? 'urgent' : ''}">
                        <div class="event-item-header">
                            <span class="event-item-title">${event.title}</span>
                            <span class="event-item-time">${formatTime(event.event_time)}</span>
                        </div>
                        <div class="event-item-description">${event.description}</div>
                        <div class="event-item-actions">
                            <button class="btn-small btn-edit" onclick="editEvent(${event.id})">Edit</button>
                            <button class="btn-small btn-delete" onclick="deleteEventConfirm(${event.id})">Delete</button>
                        </div>
                    </div>
                `).join('');
            }
            
            document.getElementById('dayEventsModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error loading day events:', error);
        });
}

function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':');
    const time = new Date();
    time.setHours(parseInt(hours), parseInt(minutes));
    return time.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
}

function showAddEventModal() {
    document.getElementById('eventModalTitle').textContent = 'Add New Event';
    document.getElementById('eventForm').reset();
    document.getElementById('eventId').value = '';
    document.getElementById('deleteEventBtn').style.display = 'none';
    
    // Set default date to today and set minimum date to today
    const today = new Date();
    const todayString = today.toISOString().split('T')[0];
    const eventDateInput = document.getElementById('eventDate');
    
    eventDateInput.value = todayString;
    eventDateInput.min = todayString; // Prevent selecting past dates
    
    document.getElementById('eventModal').style.display = 'block';
}

function addEventForDay() {
    closeModal('dayEventsModal');
    showAddEventModal();
    if (selectedDate) {
        const eventDateInput = document.getElementById('eventDate');
        const today = new Date().toISOString().split('T')[0];
        
        // Only set the date if it's not in the past
        if (selectedDate >= today) {
            eventDateInput.value = selectedDate;
        } else {
            eventDateInput.value = today;
        }
    }
}

function editEvent(eventId) {
    // Find the event in current events
    let eventToEdit = null;
    for (const dateKey in events) {
        const event = events[dateKey].find(e => e.id === eventId);
        if (event) {
            eventToEdit = event;
            selectedDate = dateKey;
            break;
        }
    }
    
    if (!eventToEdit) {
        // If not found in current events, fetch from server
        fetch(`${BASE}/counselor/getEventById?id=${eventId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateEditForm(data.event);
                } else {
                    showNotification('Event not found', 'error');
                }
            })
            .catch(error => {
                console.error('Error loading event:', error);
                showNotification('Error loading event', 'error');
            });
        return;
    }
    
    populateEditForm(eventToEdit);
}

function populateEditForm(eventToEdit) {
    // Populate form with null checks
    const eventModalTitle = document.getElementById('eventModalTitle');
    const eventId = document.getElementById('eventId');
    const eventTitle = document.getElementById('eventTitle');
    const eventDate = document.getElementById('eventDate');
    const eventTime = document.getElementById('eventTime');
    const eventPriority = document.getElementById('eventPriority');
    const eventDescription = document.getElementById('eventDescription');
    const deleteEventBtn = document.getElementById('deleteEventBtn');
    
    if (eventModalTitle) eventModalTitle.textContent = 'Edit Event';
    if (eventId) eventId.value = eventToEdit.id;
    if (eventTitle) eventTitle.value = eventToEdit.title;
    if (eventDate) eventDate.value = selectedDate || eventToEdit.event_date;
    if (eventTime) eventTime.value = eventToEdit.event_time || eventToEdit.time;
    if (eventPriority) eventPriority.value = eventToEdit.priority;
    if (eventDescription) eventDescription.value = eventToEdit.description;
    if (deleteEventBtn) deleteEventBtn.style.display = 'inline-block';
    
    closeModal('dayEventsModal');
    const eventModal = document.getElementById('eventModal');
    if (eventModal) eventModal.style.display = 'block';
}

function saveEvent() {
    console.log('=== saveEvent function called ===');
    console.log('Current timestamp:', new Date().toISOString());
    
    const form = document.getElementById('eventForm');
    console.log('Form element:', form);
    
    if (!form) {
        console.error('Form not found!');
        alert('Form not found!');
        return;
    }
    
    console.log('Form found, proceeding with validation...');
    
    if (!form.checkValidity()) {
        console.log('Form validation failed');
        form.reportValidity();
        return;
    }
    
    // Additional validation: Check if selected date is not in the past
    const eventDateInput = document.getElementById('eventDate');
    if (!eventDateInput) {
        alert('Event date input not found!');
        return;
    }
    
    const selectedDate = new Date(eventDateInput.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time to start of day for accurate comparison
    
    if (selectedDate < today) {
        showNotification('Cannot create events for past dates', 'error');
        return;
    }
    
    console.log('Form validation passed');
    
    // Debug: Check if all form elements exist
    const eventId = document.getElementById('eventId');
    const eventTitle = document.getElementById('eventTitle');
    const eventDateElement = document.getElementById('eventDate');
    const eventTime = document.getElementById('eventTime');
    const eventPriority = document.getElementById('eventPriority');
    const eventDescription = document.getElementById('eventDescription');
    
    console.log('Form elements found:');
    console.log('eventId:', eventId);
    console.log('eventTitle:', eventTitle);
    console.log('eventDateElement:', eventDateElement);
    console.log('eventTime:', eventTime);
    console.log('eventPriority:', eventPriority);
    console.log('eventDescription:', eventDescription);
    
    if (!eventTitle) {
        alert('eventTitle element not found!');
        return;
    }
    if (!eventDateElement) {
        alert('eventDate element not found!');
        return;
    }
    if (!eventTime) {
        alert('eventTime element not found!');
        return;
    }
    if (!eventPriority) {
        alert('eventPriority element not found!');
        return;
    }
    if (!eventDescription) {
        alert('eventDescription element not found!');
        return;
    }
    
    const formData = new FormData();
    
    formData.append('title', eventTitle.value);
    formData.append('event_date', eventDateElement.value);
    formData.append('event_time', eventTime.value);
    formData.append('priority', eventPriority.value);
    formData.append('description', eventDescription.value);
    
    console.log('Form data prepared:', {
        title: eventTitle.value,
        event_date: eventDateElement.value,
        event_time: eventTime.value,
        priority: eventPriority.value,
        description: eventDescription.value
    });
    
    let url, method;
    if (eventId && eventId.value) {
        // Update existing event
        url = `${BASE}/counselor/updateEvent`;
        formData.append('event_id', eventId.value);
    } else {
        // Create new event
        url = `${BASE}/counselor/createEvent`;
    }
    
    console.log('Sending request to:', url);
    console.log('Form data:', Object.fromEntries(formData.entries()));
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response received:', response);
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            console.log('Event saved successfully');
            closeModal('eventModal');
            loadMonthEvents(); // Reload events from server
            updateTodaysEvents();
            showNotification(data.message || 'Event saved successfully!', 'success');
        } else {
            console.error('Server returned error:', data.message);
            showNotification(data.message || 'Failed to save event', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving event:', error);
        showNotification('Error saving event: ' + error.message, 'error');
    });
}

function deleteEvent() {
    const eventId = document.getElementById('eventId').value;
    if (!eventId) return;
    
    deleteEventConfirm(parseInt(eventId));
}

function deleteEventConfirm(eventId) {
    if (!confirm('Are you sure you want to delete this event?')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('event_id', eventId);
    
    fetch(`${BASE}/counselor/deleteEvent`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('eventModal');
            closeModal('dayEventsModal');
            loadMonthEvents(); // Reload events from server
            updateTodaysEvents();
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting event:', error);
        showNotification('Error deleting event', 'error');
    });
}

function updateTodaysEvents() {
    const today = new Date().toISOString().split('T')[0];
    
    fetch(`${BASE}/counselor/getEventsByDate?date=${today}`)
        .then(response => response.json())
        .then(data => {
            const todaysEvents = data.success ? data.events : [];
            const todaysEventsList = document.getElementById('todaysEventsList');
            
            if (todaysEvents.length === 0) {
                todaysEventsList.innerHTML = '<div class="event-item"><div class="event-details"><h4>No events scheduled</h4><p>You have a free day today!</p></div></div>';
            } else {
                todaysEventsList.innerHTML = todaysEvents.map(event => `
                    <div class="event-item">
                        <div class="event-details">
                            <h4>${event.title}</h4>
                            <p>${event.description}</p>
                        </div>
                        <div class="event-time">${formatTime(event.event_time)}</div>
                    </div>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Error updating today\'s events:', error);
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 3000;
        animation: slideInRight 0.3s ease-out;
        max-width: 300px;
        font-weight: 500;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Close modals when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
};

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const openModal = document.querySelector('.modal[style*="display: block"]');
        if (openModal) {
            openModal.style.display = 'none';
        }
    }
    
    if (event.key === '+' && event.ctrlKey) {
        event.preventDefault();
        showAddEventModal();
    }
});

// API simulation for accepting appointments
function acceptAppointment(appointmentData) {
    const formData = new FormData();
    formData.append('title', appointmentData.patientName);
    formData.append('event_date', appointmentData.date);
    formData.append('event_time', appointmentData.time);
    formData.append('priority', 'normal');
    formData.append('description', appointmentData.reason || 'Patient appointment');
    
    fetch('/MindHeaven/counselor/createEvent', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadMonthEvents();
            updateTodaysEvents();
            showNotification(`Appointment with ${appointmentData.patientName} has been scheduled!`, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error accepting appointment:', error);
        showNotification('Error scheduling appointment', 'error');
    });
}

// Make function available globally for appointment management integration
window.acceptAppointment = acceptAppointment;

// Test if saveEvent function is available
console.log('saveEvent function available:', typeof saveEvent);
window.saveEvent = saveEvent; // Make sure it's globally available

// Initialize calendar
loadMonthEvents();
updateTodaysEvents();