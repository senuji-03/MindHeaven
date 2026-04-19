// Appointments loaded from backend for the logged-in counselor
let appointments = [];

let currentRescheduleId = null;

// Base URL injected from PHP view (see appointmentmgt.php)
const BASE_URL = window.BASE_URL || '';

// Load appointments for the current counselor from the backend
function loadAppointments() {
    fetch(BASE_URL + '/api/counselor/appointments')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                appointments = data;
            } else {
                console.error('Unexpected appointments response format:', data);
                appointments = [];
            }
            renderAppointments();
        })
        .catch(error => {
            console.error('Failed to load appointments:', error);
            appointments = [];
            renderAppointments();
        });
}

// Navigation Functions
function showNotifications() {
    alert('Notifications:\n• New appointment request from John Doe\n• Reminder: Session with Sarah in 30 mins\n• Weekly report is ready');
}

function showMessages() {
    alert('Messages:\n• Sarah Johnson: Thank you for yesterday\'s session\n• Michael Chen: Can we reschedule tomorrow\'s appointment?\n• System: Weekly feedback summary available');
}

// Render appointments
function renderAppointments(appointmentsToRender = appointments) {
    const appointmentsList = document.getElementById('appointmentsList');

    if (appointmentsToRender.length === 0) {
        appointmentsList.innerHTML = `
                    <div style="text-align: center; padding: 3rem; color: var(--text-secondary);">
                        <h3>No appointments found</h3>
                        <p>No appointments match your current filters.</p>
                    </div>
                `;
        return;
    }

    appointmentsList.innerHTML = appointmentsToRender.map(appointment => `
                <div class="appointment-card ${appointment.status}" data-id="${appointment.id}">
                    <div class="appointment-header">
                        <div class="patient-info">
                            <h4>${appointment.patientName}</h4>
                            <p>${appointment.reason}</p>
                        </div>
                        <div class="time-info">
                            <div class="date-time">${formatDate(appointment.requestedDate)} at ${formatTime(appointment.requestedTime)}</div>
                            <div class="duration"><i class="fa-regular fa-clock"></i> ${appointment.duration}</div>
                        </div>
                        <div class="media-type ${appointment.mediaType === 'chat' ? 'audio' : 'video'}-call">
                            ${appointment.mediaType === 'chat' ? '<i class="fa-regular fa-comment-dots"></i> Chat' : '<i class="fa-solid fa-video"></i> Audio/Video'}
                        </div>
                        <div class="status-badge status-${appointment.status}">
                            ${appointment.status}
                        </div>
                        <div class="initial-actions">
                            <button class="btn-history" onclick="viewStudentHistory(${appointment.studentUserId}, '${appointment.patientName.replace(/'/g, "\\'")}')">
                                <i class="fa-regular fa-clipboard"></i> History
                            </button>

                            <button class="btn btn-view" onclick="toggleDetails(${appointment.id})">
                                <span id="viewText-${appointment.id}">View</span>
                            </button>
                        </div>
                    </div>
                    <div class="appointment-details" id="details-${appointment.id}">
                        <div class="details-grid">
                            <div class="detail-section">
                                <h5>Patient Information</h5>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Request Date:</span>
                                    <span class="detail-value">${formatDate(appointment.bookedDate)}</span>
                                </div>
                            </div>
                            <div class="detail-section">
                                <h5>Appointment Details</h5>
    
                                <div class="detail-item">
                                    <span class="detail-label">Duration:</span>
                                    <span class="detail-value">${appointment.duration}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Media Type:</span>
                                    <span class="detail-value">${appointment.mediaType === 'chat' ? 'Chat' : 'Audio/Video'}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Session Type:</span>
                                    <span class="detail-value">${appointment.sessionType ? appointment.sessionType.charAt(0).toUpperCase() + appointment.sessionType.slice(1).replace('_', ' ') : 'Standard'}</span>
                                </div>
                                ${appointment.originalDate && (appointment.originalDate !== appointment.requestedDate || appointment.originalTime !== appointment.requestedTime) ? `
                                <div class="detail-item" style="margin-top: 10px; padding: 12px; background: rgba(232, 168, 124, 0.1); border-radius: 8px; border-left: 4px solid var(--accent-warm);">
                                    <span class="detail-label" style="color: var(--text-primary); font-weight: 700;">Original Undergrad Booking:</span>
                                    <span class="detail-value" style="color: var(--text-secondary);">${formatDate(appointment.originalDate)} at ${formatTime(appointment.originalTime)}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        ${appointment.notes ? `
                            <div class="detail-section" style="margin-bottom: 24px;">
                                <h5>Notes</h5>
                                <p style="color: var(--text-secondary); line-height: 1.6;">${appointment.notes}</p>
                            </div>
                        ` : ''}
                        <div class="action-section">
                            <div class="action-buttons">
                                ${appointment.status === 'pending' ? `
                                    <button class="btn btn-accept" onclick="updateStatus(${appointment.id}, 'accepted')"><i class="fa-solid fa-check"></i> Accept</button>
                                    <button class="btn btn-reject" onclick="openRejectModal(${appointment.id})"><i class="fa-solid fa-xmark"></i> Reject</button>
                                ` : ''}
                                ${appointment.status === 'rejected' || appointment.status === 'reject' ? `
                                    <button class="btn btn-reject" onclick="hideAppointment(${appointment.id})"><i class="fa-solid fa-trash"></i> Delete</button>
                                ` : (!['completed', 'no_show', 'in_progress', 'cancelled', 'cancel'].includes(appointment.status) ? `
                                    <button class="btn btn-reschedule" onclick="reschedule('${appointment.patientName}', '${appointment.reason}', ${appointment.id})"><i class="fa-solid fa-calendar-day"></i> Reschedule</button>
                                ` : '')}
                                ${appointment.status === 'accept' || appointment.status === 'accepted' ? `
                                    <button class="btn btn-save" onclick="saveToCalendar(${appointment.id})"><i class="fa-solid fa-calendar-plus"></i> Save to Calendar</button>
                                    ${appointment.meeting_link ? `<a href="${appointment.meeting_link}" target="_blank" class="btn btn-accept" style="text-decoration:none;"><i class="fa-solid fa-video"></i> Join Meeting</a>` : ''}
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
}

// Toggle appointment details
function toggleDetails(id) {
    const details = document.getElementById(`details-${id}`);
    const viewText = document.getElementById(`viewText-${id}`);

    if (details.classList.contains('show')) {
        details.classList.remove('show');
        viewText.textContent = 'View';
    } else {
        details.classList.add('show');
        viewText.textContent = 'Hide';
    }
}

// Update appointment status (accept / reject) and persist to backend
function updateStatus(id, status) {
    const appointment = appointments.find(app => app.id === id);
    if (!appointment) return;

    fetch(BASE_URL + '/api/appointments/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, status })
    })
        .then(response => response.json())
        .then(() => {
            appointment.status = status;
            showSuccessMessage(`Appointment ${status} successfully!`);
            
            // Redirect to dashboard if accepted, so they can see it in Upcoming Appointments
            if (status === 'accepted') {
                setTimeout(() => {
                    window.location.href = BASE_URL + '/counselor/dashboard';
                }, 1500); // 1.5s delay to let the user see the success message
            } else {
                renderAppointments();
            }
        })
        .catch(error => {
            console.error('Failed to update appointment status:', error);
            alert('Failed to update appointment status. Please try again.');
        });
}

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    if (date.toDateString() === today.toDateString()) {
        return 'Today';
    } else if (date.toDateString() === tomorrow.toDateString()) {
        return 'Tomorrow';
    } else {
        return date.toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric'
        });
    }
}

// Format time for display
function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
}

// Filter appointments
function filterAppointments() {
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const patientSearch = document.getElementById('patientSearch').value.toLowerCase();
    const modeFilter = document.getElementById('modeFilter') ? document.getElementById('modeFilter').value : 'all';
    const typeFilter = document.getElementById('typeFilter') ? document.getElementById('typeFilter').value : 'all';

    let filteredAppointments = appointments.filter(appointment => {
        const statusMatch = statusFilter === 'all' || appointment.status === statusFilter || (statusFilter === 'accepted' && appointment.status === 'accept');
        const dateMatch = !dateFilter || appointment.requestedDate === dateFilter;
        const patientMatch = !patientSearch || appointment.patientName.toLowerCase().includes(patientSearch);
        const modeMatch = modeFilter === 'all' || appointment.mediaType === modeFilter;
        const typeMatch = typeFilter === 'all' || appointment.sessionType === typeFilter;

        return statusMatch && dateMatch && patientMatch && modeMatch && typeMatch;
    });

    renderAppointments(filteredAppointments);
}

// Reschedule appointment
function reschedule(patientName, reason, appointmentId) {
    currentRescheduleId = appointmentId;

    // Populate patient info
    const patientInfoDiv = document.getElementById('reschedulePatientInfo');
    patientInfoDiv.innerHTML = `
                <h4>${patientName}</h4>
                <p>Current reason: ${reason}</p>
            `;

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    const newDateEl = document.getElementById('newDate');
    newDateEl.min = today;
    newDateEl.value = today;

    // Reset and disable time selection until date is picked (or re-picked)
    const newTimeEl = document.getElementById('newTime');
    newTimeEl.innerHTML = '<option value="">Loading slots...</option>';
    newTimeEl.disabled = true;

    // Load slots for default today
    loadAvailableSlots(today);

    // Show modal
    document.getElementById('rescheduleModal').style.display = 'flex'; // Ensure Flex is used since we updated the CSS globally
}

// Fetch available slots for counselor on a specific date
function loadAvailableSlots(date) {
    const timeSel = document.getElementById('newTime');
    if (!timeSel) return;
    
    fetch(BASE_URL + '/api/appointments/slots?date=' + date + '&counselor_id=self') // I might need to update backend to support 'self'
        .then(response => response.json())
        .then(data => {
            const slots = data.slots || [];
            if (slots.length === 0) {
                timeSel.innerHTML = '<option value="">No slots available</option>';
                timeSel.disabled = true;
            } else {
                timeSel.innerHTML = '<option value="">Select Time</option>' + 
                    slots.map(s => {
                        const isUnavailable = s.is_booked == 1 || s.is_frozen == 1;
                        return `<option value="${s.start_time}" ${isUnavailable ? 'disabled' : ''}>${formatTime(s.start_time)} ${isUnavailable ? '(Booked)' : ''}</option>`;
                    }).join('');
                timeSel.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading slots:', error);
            timeSel.innerHTML = '<option value="">Error loading slots</option>';
        });
}

// Submit reschedule
function submitReschedule(force = false) {
    const newDate = document.getElementById('newDate').value;
    const newTime = document.getElementById('newTime').value;
    const reason = document.getElementById('rescheduleReason').value;

    if (!newDate || !newTime || !reason) {
        alert('Please fill in all required fields.');
        return;
    }

    // Update appointment in backend
    const appointment = appointments.find(app => app.id === currentRescheduleId);
    if (!appointment) {
        closeModal('rescheduleModal');
        return;
    }

    const payload = {
        id: appointment.id,
        date: newDate,
        time: newTime,
        reason: reason,
        force: force
    };

    fetch(BASE_URL + '/api/appointments/reschedule', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
        .then(response => {
            if (response.status === 409) {
                return response.json().then(data => {
                    if (data.status === 'conflict' && data.type === 'calendar') {
                        if (confirm(data.message)) {
                            submitReschedule(true); // Retry with force: true
                        }
                    } else {
                        alert(data.error || 'Conflict detected');
                    }
                    throw new Error('Conflict');
                });
            }
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.error || 'Failed to reschedule');
                });
            }
            return response.json();
        })
        .then(() => {
            // Update local copy after successful backend update
            appointment.requestedDate = newDate;
            appointment.requestedTime = newTime;
            appointment.notes = (appointment.notes || '') + `\n\nRescheduled Reason: ${reason}`;

            showSuccessMessage(`Appointment rescheduled successfully!\nNew Date: ${formatDate(newDate)}\nNew Time: ${formatTime(newTime)}`);
            renderAppointments();
            closeModal('rescheduleModal');
        })
        .catch(error => {
            if (error.message !== 'Conflict') {
                console.error('Failed to reschedule appointment:', error);
                alert(error.message || 'Failed to reschedule appointment. Please try again.');
            }
        });
}

// Save to calendar
function saveToCalendar(appointmentId) {
    const appointment = appointments.find(app => app.id === appointmentId);
    if (!appointment) return;

    const formData = new FormData();
    formData.append('title', `Session with ${appointment.patientName}`);
    formData.append('event_date', appointment.requestedDate);
    formData.append('event_time', appointment.requestedTime);
    formData.append('priority', 'normal');
    formData.append('description', `Appointment Reason: ${appointment.reason || 'N/A'}\nType: ${appointment.mediaType} call`);
    formData.append('appointment_id', appointment.id);

    fetch(BASE_URL + '/counselor/createEvent', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(`Appointment saved to calendar successfully!\nPatient: ${appointment.patientName}\nDate: ${formatDate(appointment.requestedDate)}\nTime: ${formatTime(appointment.requestedTime)}`);
            } else if (data.message === 'Time conflict: Another event exists at this time') {
                alert('Cannot save: an event already exists at this time in your calendar.');
            } else {
                alert('Failed to save to calendar: ' + (data.message || 'Unknown error.'));
            }
        })
        .catch(error => {
            console.error('Error saving to calendar:', error);
            alert('An error occurred while saving to calendar.');
        });
}

// Show success message
function showSuccessMessage(message) {
    const successDiv = document.getElementById('successMessage');
    successDiv.textContent = message;
    successDiv.classList.add('show');

    setTimeout(() => {
        successDiv.classList.remove('show');
    }, 5000);
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset forms when closing
    if (modalId === 'rescheduleModal') {
        document.getElementById('rescheduleForm').reset();
        currentRescheduleId = null;
    } else if (modalId === 'rejectModal') {
        document.getElementById('rejectReason').value = '';
        document.getElementById('otherReason').value = '';
        document.getElementById('otherReasonGroup').style.display = 'none';
        currentRejectId = null;
    }
}

let currentRejectId = null;

function openRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectModal').style.display = 'flex'; // Use flex for centering via our updated css
}

function submitReject() {
    const reasonSelect = document.getElementById('rejectReason').value;
    const otherReason = document.getElementById('otherReason').value;
    
    let rejectionReason = reasonSelect;
    if (reasonSelect === 'Other') {
        rejectionReason = otherReason;
    }

    if (!rejectionReason) {
        alert('Please select or specify a reason for rejection.');
        return;
    }

    fetch(BASE_URL + '/api/appointments/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            id: currentRejectId, 
            status: 'rejected',
            rejectionReason: rejectionReason
        })
    })
    .then(response => response.json())
    .then(data => {
        showSuccessMessage('Appointment rejected successfully.');
        loadAppointments(); // Reload all to update local state and filter
        closeModal('rejectModal');
    })
    .catch(error => {
        console.error('Error rejecting appointment:', error);
        alert('Failed to reject appointment.');
    });
}

function hideAppointment(id) {
    if (!confirm('Are you sure you want to delete this rejected appointment? It will be hidden from your view.')) {
        return;
    }

    fetch(BASE_URL + '/api/appointments/hide', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
    .then(response => response.json())
    .then(data => {
        showSuccessMessage('Appointment removed from your view.');
        loadAppointments();
    })
    .catch(error => {
        console.error('Error hiding appointment:', error);
        alert('Failed to remove appointment.');
    });
}

// View Student History
function viewStudentHistory(studentUserId, patientName) {
    if (!studentUserId) {
        alert('Missing student ID.');
        return;
    }

    document.getElementById('historyStudentName').textContent = patientName;
    const historyList = document.getElementById('historyList');
    historyList.innerHTML = '<div class="history-empty"><i class="fa-solid fa-spinner fa-spin"></i><br>Loading history...</div>';
    document.getElementById('studentHistoryModal').style.display = 'flex';

    fetch(BASE_URL + '/api/student/history?student_id=' + studentUserId)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const history = data.history || [];
                if (history.length === 0) {
                    historyList.innerHTML = '<div class="history-empty"><i class="fa-regular fa-clipboard"></i><br>No previous session notes found for this student.</div>';
                } else {
                    historyList.innerHTML = history.map(item => `
                        <div class="history-item">
                            <div class="history-item-header">
                                <span class="history-date">${formatDate(item.date)} at ${formatTime(item.time)}</span>
                                <span class="history-counselor">By ${item.counselor_name}</span>
                            </div>
                            <div class="history-topic">Session: ${item.title || 'N/A'}</div>
                            <div class="history-content">${item.counselor_notes}</div>
                        </div>
                    `).join('');
                }
            } else {
                historyList.innerHTML = `<div class="history-empty" style="color: var(--crisis);"><i class="fa-solid fa-circle-exclamation"></i><br>Error: ${data.error || 'Failed to load history'}</div>`;
            }
        })
        .catch(err => {
            console.error('Error fetching history:', err);
            historyList.innerHTML = '<div class="history-empty" style="color: var(--crisis);"><i class="fa-solid fa-circle-exclamation"></i><br>A connection error occurred.</div>';
        });
}

// Close modal when clicking outside of it
window.onclick = function (event) {
    const rescheduleModal = document.getElementById('rescheduleModal');
    const rejectModal = document.getElementById('rejectModal');
    const historyModal = document.getElementById('studentHistoryModal');

    if (event.target === rescheduleModal) {
        closeModal('rescheduleModal');
    } else if (event.target === rejectModal) {
        closeModal('rejectModal');
    } else if (event.target === historyModal) {
        closeModal('studentHistoryModal');
    }
}

// Initialize page
document.addEventListener('DOMContentLoaded', function () {
    loadAppointments();
    console.log('Appointment Management loaded successfully!');

    // Set today's date as default for date filter
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateFilter').value = '';

    // Add event listener for newDate in reschedule modal
    const newDateEl = document.getElementById('newDate');
    if (newDateEl) {
        newDateEl.addEventListener('change', function() {
            loadAvailableSlots(this.value);
        });
    }
});

// Additional utility functions for integration

// Function to add new appointment request (can be called from other parts of the system)
function addNewAppointmentRequest(appointmentData) {
    const newId = Math.max(...appointments.map(app => app.id)) + 1;
    const newAppointment = {
        id: newId,
        ...appointmentData,
        status: 'pending',
        requestDate: new Date().toISOString().split('T')[0]
    };

    appointments.unshift(newAppointment); // Add to beginning of array
    renderAppointments();
    showSuccessMessage('New appointment request received!');
}

// Function to get appointment statistics
function getAppointmentStats() {
    const stats = {
        total: appointments.length,
        pending: appointments.filter(app => app.status === 'pending').length,
        accepted: appointments.filter(app => app.status === 'accept' || app.status === 'accepted').length,
        rejected: appointments.filter(app => app.status === 'rejected').length,
        scheduled: appointments.filter(app => app.status === 'scheduled').length
    };

    return stats;
}

// Export functions for use in other pages
window.appointmentManager = {
    addNewAppointmentRequest,
    getAppointmentStats,
    appointments: () => appointments // Return copy of appointments
};