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
function startMeeting(patientName) {
    alert(`Starting meeting with ${patientName}...\nThis would typically open the video/audio call interface.`);
}

function reschedule(patientName, reason) {
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

function sendFeedback(patientName, reason) {
    // Populate patient info
    const patientInfoDiv = document.getElementById('feedbackPatientInfo');
    patientInfoDiv.innerHTML = `
        <h4>${patientName}</h4>
        <p>Session reason: ${reason}</p>
    `;
    
    // Set follow-up date to tomorrow by default
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];
    document.getElementById('followUpDate').value = tomorrowStr;
    document.getElementById('followUpDate').min = new Date().toISOString().split('T')[0];
    
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
    const form = document.getElementById('rescheduleForm');
    const formData = new FormData(form);
    const newDate = document.getElementById('newDate').value;
    const newTime = document.getElementById('newTime').value;
    const reason = document.getElementById('rescheduleReason').value;
    
    if (!newDate || !newTime || !reason) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Here you would typically send the data to your PHP backend
    alert(`Appointment rescheduled successfully!\nNew Date: ${newDate}\nNew Time: ${newTime}\nReason: ${reason}`);
    
    closeModal('rescheduleModal');
}

function submitFeedback() {
    const form = document.getElementById('feedbackForm');
    const feedbackType = document.getElementById('feedbackType').value;
    const feedbackMessage = document.getElementById('feedbackMessage').value;
    const sessionRating = document.getElementById('sessionRating').value;
    const followUpDate = document.getElementById('followUpDate').value;
    const actionItems = document.getElementById('actionItems').value;
    
    if (!feedbackType || !feedbackMessage || !sessionRating) {
        alert('Please fill in all required fields (Feedback Type, Message, and Session Rating).');
        return;
    }
    
    // Here you would typically send the data to your PHP backend
    let message = `Feedback sent successfully!\nType: ${feedbackType}\nRating: ${sessionRating}`;
    if (followUpDate) {
        message += `\nFollow-up Date: ${followUpDate}`;
    }
    if (actionItems) {
        message += `\nAction Items: ${actionItems}`;
    }
    
    alert(message);
    
    closeModal('feedbackModal');
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const rescheduleModal = document.getElementById('rescheduleModal');
    const feedbackModal = document.getElementById('feedbackModal');
    
    if (event.target === rescheduleModal) {
        closeModal('rescheduleModal');
    } else if (event.target === feedbackModal) {
        closeModal('feedbackModal');
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