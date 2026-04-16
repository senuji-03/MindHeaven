// Navigation Functions
function showNotifications() {
    alert('Notifications:\n• New appointment request from John Doe\n• Reminder: Session with Sarah in 30 mins\n• Weekly report is ready');
}

function showMessages() {
    alert('Messages:\n• Sarah Johnson: Thank you for yesterday\'s session\n• Michael Chen: Can we reschedule tomorrow\'s appointment?\n• System: Weekly feedback summary available');
}

// Sidebar Navigation
function showSection(section) {
    // Remove active class from all items
    const items = document.querySelectorAll('.sidebar-item');
    items.forEach(item => item.classList.remove('active'));
    
    // Add active class to clicked item
    event.target.classList.add('active');
    
    // Here you would typically show/hide different sections
    // For now, we'll just show an alert
    switch(section) {
        case 'dashboard':
            // Already visible
            break;
        case 'calendar':
            alert('Calendar view - This would show your weekly/monthly schedule');
            break;
        case 'appointments':
            alert('Appointment Management - This would show all appointment management features');
            break;
        case 'history':
            alert('Session History - This would show past session records');
            break;
        case 'forum':
            alert('Forum - This would show community discussions and Q&A');
            break;
        case 'resources':
            alert('Resource Hub - This would show educational materials and tools');
            break;
        case 'settings':
            alert('Settings - This would show account and application settings');
            break;
    }
}

// Appointment Functions
function startMeeting(appointmentId, studentName, studentUserId, mode) {
    if (mode === 'chat') {
        const btn = event.target;
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Starting...';

        // 1. Start or find a chat session
        fetch(window.BASE_URL + '/api/chat/start', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ undergrad_user_id: studentUserId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.session_id) {
                const sessionUrl = window.BASE_URL + '/chat/room?session_id=' + data.session_id;

                // 2. Link this chat URL to the appointment so the undergrad can join
                return fetch(window.BASE_URL + '/api/appointments/start-session', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: appointmentId, meeting_link: sessionUrl })
                })
                .then(res => res.json())
                .then(linkData => {
                    if (linkData.success) {
                        // 3. Redirect counselor to the chat room
                        window.location.href = sessionUrl;
                    } else {
                        alert('Could not start session link: ' + (linkData.error || 'Unknown error'));
                        btn.disabled = false;
                        btn.textContent = originalText;
                    }
                });
            } else {
                alert('Could not start chat: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.textContent = originalText;
            }
        })
        .catch(err => {
            console.error('Error starting session:', err);
            alert('A network error occurred while starting the session.');
            btn.disabled = false;
            btn.textContent = originalText;
        });
    } else {
        alert(`No meeting link found for this session. Please ensure the appointment is correctly scheduled.`);
    }
}

function joinMeeting(appointmentId, url) {
    // Notify server to set status to in_progress
    fetch(window.BASE_URL + '/api/appointments/start-session', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: appointmentId, meeting_link: url })
    })
    .finally(() => {
        // Open the meeting link in a new tab
        window.open(url, '_blank');
        // Reload to update dashboard (e.g., move to Active Sessions)
        setTimeout(() => window.location.reload(), 500);
    });
}


let currentRescheduleId = null;

function reschedule(appointmentId, patientName, reason) {
    currentRescheduleId = appointmentId;
    // Populate patient info
    const patientInfoDiv = document.getElementById('reschedulePatientInfo');
    patientInfoDiv.innerHTML = `
        <h4>${patientName}</h4>
        <p>Current reason: ${reason}</p>
    `;
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('newDate').min = today;
    document.getElementById('newDate').value = today;
    
    // Show modal
    document.getElementById('rescheduleModal').style.display = 'block';
}

function sendFeedback(appointmentId, patientName, reason) {
    // Populate appointment ID
    document.getElementById('feedbackAppointmentId').value = appointmentId;

    // Populate patient info
    const patientInfoDiv = document.getElementById('feedbackPatientInfo');
    patientInfoDiv.innerHTML = `
        <h4>${patientName}</h4>
        <p>Session Topic: ${reason}</p>
    `;

    // Show modal
    document.getElementById('feedbackModal').style.display = 'block';
}


function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset forms when closing
    if (modalId === 'rescheduleModal') {
        document.getElementById('rescheduleForm').reset();
    } else if (modalId === 'feedbackModal') {
        document.getElementById('feedbackForm').reset();
    }
}

function submitReschedule() {
    const newDate = document.getElementById('newDate').value;
    const newTime = document.getElementById('newTime').value;
    const reason = document.getElementById('rescheduleReason').value;
    
    if (!newDate || !newTime || !reason) {
        alert('Please fill in all required fields.');
        return;
    }
    
    if (!currentRescheduleId) {
        alert('Missing appointment ID.');
        return;
    }

    const payload = {
        id: currentRescheduleId,
        date: newDate,
        time: newTime,
        reason: reason
    };

    fetch(window.BASE_URL + '/api/appointments/reschedule', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            alert(`Appointment rescheduled successfully!\nNew Date: ${newDate}\nNew Time: ${newTime}\nReason: ${reason}`);
            closeModal('rescheduleModal');
            window.location.reload(); // refresh page to see updated appointment
        }
    })
    .catch(error => {
        console.error('Failed to reschedule:', error);
        alert('Failed to reschedule. Please try again.');
    });
}

function submitFeedback() {
    const appointmentId = document.getElementById('feedbackAppointmentId').value;
    const feedbackMessage = document.getElementById('feedbackMessage').value;

    if (!feedbackMessage.trim()) {
        alert('Please enter your notes before saving.');
        return;
    }

    const submitBtn = document.getElementById('submitFeedbackBtn');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';

    const payload = {
        id: appointmentId,
        feedback_message: feedbackMessage
    };

    fetch(window.BASE_URL + '/api/appointments/notes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Session notes saved successfully!');
            closeModal('feedbackModal');
        } else {
            alert('Error: ' + (data.error || 'Could not save notes'));
        }
    })
    .catch(err => {
        console.error('Error saving session notes:', err);
        alert('A network error occurred.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
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
    historyList.innerHTML = '<div class="history-empty">Loading history...</div>';
    document.getElementById('studentHistoryModal').style.display = 'block';

    fetch(window.BASE_URL + '/api/student/history?student_id=' + studentUserId)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const history = data.history || [];
                if (history.length === 0) {
                    historyList.innerHTML = '<div class="history-empty"><i>📝</i><br>No previous session notes found for this student.</div>';
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
                historyList.innerHTML = `<div class="history-empty" style="color: #ef4444;">Error: ${data.error || 'Failed to load history'}</div>`;
            }
        })
        .catch(err => {
            console.error('Error fetching history:', err);
            historyList.innerHTML = '<div class="history-empty" style="color: #ef4444;">A connection error occurred.</div>';
        });
}

// Helper: Format date for display
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

// Helper: Format time for display
function formatTime(timeString) {
    if (!timeString) return '';
    const parts = timeString.split(':');
    if (parts.length < 2) return timeString;
    const hours = parseInt(parts[0]);
    const minutes = parts[1];
    const ampm = hours >= 12 ? 'PM' : 'AM';
    const displayHour = hours % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
}

// ── Session status: Completed / No Show ──────────────────────
var _pendingStatusAppointmentId = null;
var _pendingStatus              = null;

/**
 * Open a confirmation modal before sending the status update.
 * @param {number} appointmentId
 * @param {string} status  'completed' or 'no_show'
 * @param {string} patientName
 */
function markSessionStatus(appointmentId, status, patientName) {
    _pendingStatusAppointmentId = appointmentId;
    _pendingStatus              = status;

    var label     = status === 'completed' ? 'Completed' : 'No Show';
    var colorClass = status === 'completed' ? '#10b981' : '#f59e0b';

    document.getElementById('sessionStatusModalTitle').textContent = 'Mark as ' + label;
    document.getElementById('sessionStatusModalMsg').innerHTML =
        'Are you sure you want to mark the session with <strong>' + patientName + '</strong> as <strong style="color:' + colorClass + ';">' + label + '</strong>?<br><br>' +
        '<span style="color:#64748b;font-size:0.9rem;">This will move the appointment to Session History.</span>';

    var confirmBtn = document.getElementById('sessionStatusConfirmBtn');
    confirmBtn.style.background = colorClass;
    confirmBtn.textContent      = 'Yes, Mark as ' + label;

    document.getElementById('sessionStatusModal').style.display = 'block';
}

function closeSessionStatusModal() {
    document.getElementById('sessionStatusModal').style.display = 'none';
    _pendingStatusAppointmentId = null;
    _pendingStatus              = null;
}

function confirmSessionStatus() {
    if (!_pendingStatusAppointmentId || !_pendingStatus) return;

    var appointmentId = _pendingStatusAppointmentId;
    var status        = _pendingStatus;

    // Disable button to prevent double-click
    var confirmBtn = document.getElementById('sessionStatusConfirmBtn');
    confirmBtn.disabled     = true;
    confirmBtn.textContent  = 'Saving…';

    fetch(window.BASE_URL + '/api/appointments/status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ id: appointmentId, status: status })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        if (data.error) {
            alert('Error: ' + data.error);
            confirmBtn.disabled    = false;
            confirmBtn.textContent = 'Confirm';
        } else {
            closeSessionStatusModal();
            // Reload page so the appointment disappears from Upcoming and shows in Session History
            window.location.reload();
        }
    })
    .catch(function (err) {
        console.error('Failed to update session status:', err);
        alert('Failed to update session status. Please try again.');
        confirmBtn.disabled    = false;
        confirmBtn.textContent = 'Confirm';
    });
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    var rescheduleModal    = document.getElementById('rescheduleModal');
    var feedbackModal      = document.getElementById('feedbackModal');
    var sessionStatusModal = document.getElementById('sessionStatusModal');
    var studentHistoryModal = document.getElementById('studentHistoryModal');

    if (rescheduleModal && event.target === rescheduleModal) {
        closeModal('rescheduleModal');
    } else if (feedbackModal && event.target === feedbackModal) {
        closeModal('feedbackModal');
    } else if (sessionStatusModal && event.target === sessionStatusModal) {
        closeSessionStatusModal();
    } else if (studentHistoryModal && event.target === studentHistoryModal) {
        closeModal('studentHistoryModal');
    }
}

function viewAllFeedbacks() {
    alert('View All Feedbacks\nThis would show a complete list of all student feedbacks with filtering and sorting options.');
}

// Update time display
function updateStats() {
    // This function could periodically update the dashboard stats
    // For demo purposes, we'll just update once
    const now = new Date();
    console.log('Dashboard updated at:', now.toLocaleTimeString());
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    updateStats();
    console.log('Mindheaven Counselor Dashboard loaded successfully!');
});