// Appointments Page JavaScript

// Global variables
let appointments = [];
let isSubmitting = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    initializeAppointmentsPage();
});

function initializeAppointmentsPage() {
    console.log('Appointments page initialized');
    
    // Load appointments from localStorage
    loadAppointments();
    
    // Set up form validation
    setupFormValidation();
    
    // Set up form submission
    setupFormSubmission();
    
    // Set up event listeners
    setupEventListeners();
    
    // Update stats
    updateStats();
    
    // Render appointments
    renderAppointments();
}

// Form Validation
function setupFormValidation() {
    const form = document.getElementById('appointmentForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name || field.id;
    const errorElement = document.getElementById(fieldName.replace('appointment', '') + 'Error');
    
    // Clear previous error
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Date validation
    if (field.type === 'date' && value) {
        const selectedDate = new Date(value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showFieldError(field, 'Appointment date cannot be in the past');
            return false;
        }
    }
    
    // Time validation
    if (field.type === 'time' && value) {
        const selectedTime = value;
        const [hours, minutes] = selectedTime.split(':').map(Number);
        
        // Check if time is within business hours (8 AM - 6 PM)
        if (hours < 8 || hours > 18) {
            showFieldError(field, 'Appointments are only available between 8 AM and 6 PM');
            return false;
        }
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    const fieldName = field.name || field.id;
    const errorElement = document.getElementById(fieldName.replace('appointment', '') + 'Error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
}

function clearFieldError(field) {
    field.classList.remove('error');
    const fieldName = field.name || field.id;
    const errorElement = document.getElementById(fieldName.replace('appointment', '') + 'Error');
    if (errorElement) {
        errorElement.classList.remove('show');
    }
}

// Form Submission
function setupFormSubmission() {
    const form = document.getElementById('appointmentForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isSubmitting) return;
        
        if (validateForm()) {
            submitForm();
        }
    });
}

function validateForm() {
    const form = document.getElementById('appointmentForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function submitForm() {
    if (isSubmitting) return;
    
    isSubmitting = true;
    const submitBtn = document.querySelector('#appointmentForm button[type="submit"]');
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="btn-icon">⏳</span><span class="btn-text">Saving...</span>';
    
    // Collect form data
    const formData = new FormData(document.getElementById('appointmentForm'));
    const data = Object.fromEntries(formData.entries());
    
    // Get appointment ID
    const appointmentId = document.getElementById('appointmentId').value;
    
    // Create appointment object
    const appointment = {
        id: appointmentId || Date.now(),
        title: data.appointmentTitle,
        type: data.appointmentType,
        date: data.appointmentDate,
        time: data.appointmentTime,
        notes: data.appointmentNotes || '',
        status: 'scheduled',
        createdAt: appointmentId ? appointments.find(a => a.id == appointmentId)?.createdAt : new Date().toISOString(),
        updatedAt: new Date().toISOString()
    };
    
    // Simulate API call
    setTimeout(() => {
        if (appointmentId) {
            // Update existing appointment
            const index = appointments.findIndex(a => a.id == appointmentId);
            if (index !== -1) {
                appointments[index] = appointment;
                showAlert('Appointment updated successfully!', 'success');
            }
        } else {
            // Add new appointment
            appointments.push(appointment);
            showAlert('Appointment booked successfully!', 'success');
        }
        
        // Save to localStorage
        saveAppointments();
        
        // Reset form
        resetForm();
        
        // Update UI
        updateStats();
        renderAppointments();
        
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="btn-icon">💾</span><span class="btn-text">Save Appointment</span>';
        
        isSubmitting = false;
        
    }, 1000); // Simulate network delay
}

// Event Listeners
function setupEventListeners() {
    // Reset form button
    document.getElementById('resetAppointmentForm').addEventListener('click', resetForm);
    
    // Import demo data
    document.getElementById('importDemoAppointments').addEventListener('click', importDemoAppointments);
    
    // Export CSV
    document.getElementById('exportAppointmentsCsv').addEventListener('click', exportAppointmentsCsv);
}

// Data Management
function loadAppointments() {
    const saved = localStorage.getItem('appointments');
    appointments = saved ? JSON.parse(saved) : [];
}

function saveAppointments() {
    localStorage.setItem('appointments', JSON.stringify(appointments));
}

function getAppointments() {
    return appointments;
}

// CRUD Operations
function editAppointment(id) {
    const appointment = appointments.find(a => a.id == id);
    if (!appointment) return;
    
    // Populate form
    document.getElementById('appointmentId').value = appointment.id;
    document.getElementById('appointmentTitle').value = appointment.title;
    document.getElementById('appointmentType').value = appointment.type;
    document.getElementById('appointmentDate').value = appointment.date;
    document.getElementById('appointmentTime').value = appointment.time;
    document.getElementById('appointmentNotes').value = appointment.notes || '';
    
    // Scroll to form
    document.querySelector('.booking-form-card').scrollIntoView({ 
        behavior: 'smooth',
        block: 'start'
    });
    
    // Focus on title field
    document.getElementById('appointmentTitle').focus();
}

function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        appointments = appointments.filter(a => a.id != id);
        saveAppointments();
        updateStats();
        renderAppointments();
        showAlert('Appointment deleted successfully!', 'success');
    }
}

function updateAppointmentStatus(id, status) {
    const appointment = appointments.find(a => a.id == id);
    if (appointment) {
        appointment.status = status;
        appointment.updatedAt = new Date().toISOString();
        saveAppointments();
        updateStats();
        renderAppointments();
        showAlert('Appointment status updated!', 'success');
    }
}

// UI Updates
function renderAppointments() {
    const tbody = document.getElementById('appointmentsTableBody');
    const emptyState = document.getElementById('appointmentsEmptyState');
    
    if (appointments.length === 0) {
        emptyState.style.display = 'block';
        tbody.innerHTML = '';
        return;
    }
    
    emptyState.style.display = 'none';
    
    // Sort appointments by date and time
    const sortedAppointments = [...appointments].sort((a, b) => {
        const dateA = new Date(a.date + ' ' + a.time);
        const dateB = new Date(b.date + ' ' + b.time);
        return dateA - dateB;
    });
    
    tbody.innerHTML = sortedAppointments.map(appointment => `
        <tr>
            <td>
                <div class="appointment-title">${appointment.title}</div>
                ${appointment.notes ? `<div class="appointment-notes">${appointment.notes}</div>` : ''}
            </td>
            <td>
                <span class="type-badge ${appointment.type}">${formatAppointmentType(appointment.type)}</span>
            </td>
            <td>${formatDate(appointment.date)}</td>
            <td>${formatTime(appointment.time)}</td>
            <td>
                <select onchange="updateAppointmentStatus(${appointment.id}, this.value)" class="status-select">
                    <option value="scheduled" ${appointment.status === 'scheduled' ? 'selected' : ''}>Scheduled</option>
                    <option value="completed" ${appointment.status === 'completed' ? 'selected' : ''}>Completed</option>
                    <option value="cancelled" ${appointment.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                </select>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-xs" onclick="editAppointment(${appointment.id})" title="Edit">
                        ✏️
                    </button>
                    <button class="btn btn-xs btn-danger" onclick="deleteAppointment(${appointment.id})" title="Delete">
                        🗑️
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function updateStats() {
    const total = appointments.length;
    const completed = appointments.filter(a => a.status === 'completed').length;
    const upcoming = appointments.filter(a => a.status === 'scheduled' && new Date(a.date + ' ' + a.time) > new Date()).length;
    const attendanceRate = total > 0 ? Math.round((completed / total) * 100) : 0;
    
    document.getElementById('totalAppointments').textContent = total;
    document.getElementById('completedAppointments').textContent = completed;
    document.getElementById('upcomingAppointments').textContent = upcoming;
    document.getElementById('attendanceRate').textContent = attendanceRate + '%';
}

// Utility Functions
function resetForm() {
    document.getElementById('appointmentForm').reset();
    document.getElementById('appointmentId').value = '';
    
    // Clear all error states
    const inputs = document.querySelectorAll('#appointmentForm input, #appointmentForm select, #appointmentForm textarea');
    inputs.forEach(input => {
        clearFieldError(input);
    });
}

function importDemoAppointments() {
    const demoAppointments = [
        {
            id: Date.now() + 1,
            title: 'Dr. Sarah Johnson - Individual Counseling',
            type: 'individual',
            date: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            time: '10:00',
            notes: 'Discuss anxiety management techniques',
            status: 'scheduled',
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        },
        {
            id: Date.now() + 2,
            title: 'Group Therapy Session',
            type: 'group',
            date: new Date(Date.now() + 14 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            time: '14:00',
            notes: 'Social anxiety support group',
            status: 'scheduled',
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        },
        {
            id: Date.now() + 3,
            title: 'Dr. Michael Chen - Follow-up Session',
            type: 'follow-up',
            date: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
            time: '16:00',
            notes: 'Review progress on depression treatment',
            status: 'completed',
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        }
    ];
    
    appointments = [...appointments, ...demoAppointments];
    saveAppointments();
    updateStats();
    renderAppointments();
    showAlert('Demo appointments loaded successfully!', 'success');
}

function exportAppointmentsCsv() {
    if (appointments.length === 0) {
        showAlert('No appointments to export', 'info');
        return;
    }
    
    const csvContent = [
        ['Title', 'Type', 'Date', 'Time', 'Status', 'Notes', 'Created At'],
        ...appointments.map(appointment => [
            appointment.title,
            formatAppointmentType(appointment.type),
            formatDate(appointment.date),
            formatTime(appointment.time),
            appointment.status,
            appointment.notes || '',
            formatDateTime(appointment.createdAt)
        ])
    ].map(row => row.map(field => `"${field}"`).join(',')).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `appointments-${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('Appointments exported successfully!', 'success');
}

// Formatting Functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':');
    const date = new Date();
    date.setHours(parseInt(hours), parseInt(minutes));
    return date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

function formatAppointmentType(type) {
    const types = {
        'individual': 'Individual Counseling',
        'group': 'Group Therapy',
        'crisis': 'Crisis Support',
        'assessment': 'Assessment',
        'follow-up': 'Follow-up Session'
    };
    return types[type] || type;
}

// Alert System
function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.innerHTML = `
        <span class="alert-icon">${getAlertIcon(type)}</span>
        <span class="alert-message">${message}</span>
    `;
    
    // Insert at top of main content
    const main = document.getElementById('main');
    main.insertBefore(alert, main.firstChild);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

function getAlertIcon(type) {
    const icons = {
        'success': '✅',
        'error': '❌',
        'info': 'ℹ️',
        'warning': '⚠️'
    };
    return icons[type] || 'ℹ️';
}

// Initialize page when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAppointmentsPage);
} else {
    initializeAppointmentsPage();
}

