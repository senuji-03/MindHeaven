let currentDate = new Date();
        let selectedDate = null;
        let events = {
            '2024-12-23': [
                { id: 1, title: 'Sarah Johnson', time: '10:30', type: 'appointment', description: 'Anxiety and stress management session', priority: 'normal' },
                { id: 2, title: 'Michael Chen', time: '14:00', type: 'appointment', description: 'Academic pressure and burnout session', priority: 'normal' },
                { id: 3, title: 'Team Meeting', time: '16:30', type: 'meeting', description: 'Weekly counseling team sync', priority: 'normal' }
            ],
            '2024-12-24': [
                { id: 4, title: 'Emily Davis', time: '11:00', type: 'appointment', description: 'Social anxiety and relationship issues', priority: 'normal' },
                { id: 5, title: 'Holiday Planning', time: '15:00', type: 'meeting', description: 'Plan holiday schedule adjustments', priority: 'urgent' }
            ],
            '2024-12-26': [
                { id: 6, title: 'John Smith', time: '09:00', type: 'appointment', description: 'Depression support session', priority: 'urgent' },
                { id: 7, title: 'Training Session', time: '13:00', type: 'training', description: 'New therapy techniques workshop', priority: 'normal' }
            ]
        };

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
            
            if (!isOtherMonth && 
                dayDate.toDateString() === today.toDateString()) {
                dayElement.classList.add('today');
            }
            
            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayEvents = events[dateString] || [];
            
            if (dayEvents.length > 0) {
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
            
            dayElement.addEventListener('click', () => showDayEvents(dateString, day, month + 1, year));
            
            return dayElement;
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        function goToToday() {
            currentDate = new Date();
            renderCalendar();
        }

        function showDayEvents(dateString, day, month, year) {
            selectedDate = dateString;
            const dayEvents = events[dateString] || [];
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
                            <span class="event-item-time">${formatTime(event.time)}</span>
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
            
            // Set default date to today
            const today = new Date();
            document.getElementById('eventDate').value = today.toISOString().split('T')[0];
            
            document.getElementById('eventModal').style.display = 'block';
        }

        function addEventForDay() {
            closeModal('dayEventsModal');
            showAddEventModal();
            if (selectedDate) {
                document.getElementById('eventDate').value = selectedDate;
            }
        }

        function editEvent(eventId) {
            // Find the event
            let eventToEdit = null;
            for (const dateKey in events) {
                const event = events[dateKey].find(e => e.id === eventId);
                if (event) {
                    eventToEdit = event;
                    selectedDate = dateKey;
                    break;
                }
            }
            
            if (!eventToEdit) return;
            
            // Populate form
            document.getElementById('eventModalTitle').textContent = 'Edit Event';
            document.getElementById('eventId').value = eventToEdit.id;
            document.getElementById('eventTitle').value = eventToEdit.title;
            document.getElementById('eventDate').value = selectedDate;
            document.getElementById('eventTime').value = eventToEdit.time;
            document.getElementById('eventType').value = eventToEdit.type;
            document.getElementById('eventPriority').value = eventToEdit.priority;
            document.getElementById('eventDescription').value = eventToEdit.description;
            document.getElementById('deleteEventBtn').style.display = 'inline-block';
            
            closeModal('dayEventsModal');
            document.getElementById('eventModal').style.display = 'block';
        }

        function saveEvent() {
            const form = document.getElementById('eventForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            const eventId = document.getElementById('eventId').value;
            const eventData = {
                id: eventId ? parseInt(eventId) : Date.now(),
                title: document.getElementById('eventTitle').value,
                time: document.getElementById('eventTime').value,
                type: document.getElementById('eventType').value,
                priority: document.getElementById('eventPriority').value,
                description: document.getElementById('eventDescription').value
            };
            
            const dateString = document.getElementById('eventDate').value;
            
            if (!events[dateString]) {
                events[dateString] = [];
            }
            
            if (eventId) {
                // Update existing event
                // First, remove from old location
                for (const dateKey in events) {
                    events[dateKey] = events[dateKey].filter(e => e.id !== parseInt(eventId));
                    if (events[dateKey].length === 0) {
                        delete events[dateKey];
                    }
                }
                // Add to new location
                events[dateString].push(eventData);
            } else {
                // Add new event
                events[dateString].push(eventData);
            }
            
            // Sort events by time
            events[dateString].sort((a, b) => a.time.localeCompare(b.time));
            
            closeModal('eventModal');
            renderCalendar();
            updateTodaysEvents();
            
            // Show success message
            showNotification('Event saved successfully!', 'success');
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
            
            // Remove event from all dates
            for (const dateKey in events) {
                events[dateKey] = events[dateKey].filter(e => e.id !== eventId);
                if (events[dateKey].length === 0) {
                    delete events[dateKey];
                }
            }
            
            closeModal('eventModal');
            closeModal('dayEventsModal');
            renderCalendar();
            updateTodaysEvents();
            
            showNotification('Event deleted successfully!', 'success');
        }

        function updateTodaysEvents() {
            const today = new Date().toISOString().split('T')[0];
            const todaysEvents = events[today] || [];
            
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
                        <div class="event-time">${formatTime(event.time)}</div>
                    </div>
                `).join('');
            }
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
                background: ${type === 'success' ? '#10b981' : '#3b82f6'};
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
                    document.body.removeChild(notification);
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
            const dateString = appointmentData.date;
            const newEvent = {
                id: Date.now(),
                title: appointmentData.patientName,
                time: appointmentData.time,
                type: 'appointment',
                description: appointmentData.reason || 'Patient appointment',
                priority: 'normal'
            };
            
            if (!events[dateString]) {
                events[dateString] = [];
            }
            
            events[dateString].push(newEvent);
            events[dateString].sort((a, b) => a.time.localeCompare(b.time));
            
            renderCalendar();
            updateTodaysEvents();
            
            showNotification(`Appointment with ${appointmentData.patientName} has been scheduled!`, 'success');
        }

        // Make function available globally for appointment management integration
        window.acceptAppointment = acceptAppointment;

        // Initialize calendar
        renderCalendar();
        updateTodaysEvents();