// Appointments Page JavaScript

// Global variables
let appointments = [];
let isSubmitting = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing appointments page');
    console.log('BASE_URL available:', window.BASE_URL);
    initializeAppointmentsPage();
});

function initializeAppointmentsPage() {
    console.log('Appointments page initialized');
    
    // Load appointments from localStorage
    loadAppointments();
    
    // Load counselors and appointment types
    loadCounselors();
    loadAppointmentTypes();
    
    // Set up form validation
    setupFormValidation();
    
    // Set up form submission
    setupFormSubmission();
    
    // Set up event listeners
    setupEventListeners();
    
    // Add direct button click handler for testing
    const submitBtn = document.querySelector('#appointmentForm button[type="submit"]');
    if (submitBtn) {
        console.log('Adding direct click handler to submit button');
        submitBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked directly');
            e.preventDefault();
            if (validateForm()) {
                submitForm();
            }
        });
    } else {
        console.log('Submit button not found');
    }
    
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
    console.log('Setting up form submission for:', form);
    
    form.addEventListener('submit', function(e) {
        console.log('Form submit event triggered');
        e.preventDefault();
        
        if (isSubmitting) {
            console.log('Already submitting, returning');
            return;
        }
        
        console.log('Calling validateForm');
        if (validateForm()) {
            console.log('Validation passed, calling submitForm');
            submitForm();
        } else {
            console.log('Validation failed');
        }
    });
}

function validateForm() {
    console.log('validateForm called');
    const form = document.getElementById('appointmentForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    console.log('Found required inputs:', inputs.length);
    let isValid = true;
    
    inputs.forEach(input => {
        console.log('Validating field:', input.name, 'value:', input.value);
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    console.log('Form validation result:', isValid);
    return isValid;
}

function submitForm() {
    console.log('submitForm called');
    if (isSubmitting) {
        console.log('Already submitting, returning');
        return;
    }
    
    isSubmitting = true;
    const submitBtn = document.querySelector('#appointmentForm button[type="submit"]');
    console.log('Submit button found:', submitBtn);
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="btn-icon">⏳</span><span class="btn-text">Saving...</span>';
    
    // Collect form data
    const formData = new FormData(document.getElementById('appointmentForm'));
    const data = Object.fromEntries(formData.entries());
    console.log('Form data collected:', data);
    
    // Get appointment ID
    const appointmentId = document.getElementById('appointmentId').value;
    console.log('Appointment ID:', appointmentId);
    
    // Create appointment object
    const appointment = {
        id: appointmentId || Date.now(),
        title: data.title,
        type: data.type,
        date: data.date,
        time: data.time,
        notes: data.notes || '',
        counselor_user_id: data.counselor_user_id,
        status: 'scheduled',
        createdAt: appointmentId ? appointments.find(a => a.id == appointmentId)?.createdAt : new Date().toISOString(),
        updatedAt: new Date().toISOString()
    };
    
    // Determine if this is an update or create operation
    const isUpdate = appointmentId && appointmentId !== '';
    console.log('Is update operation:', isUpdate, 'Appointment ID:', appointmentId);
    
    // Save to database via API
    saveAppointmentToDatabase(appointment, appointmentId, submitBtn, isUpdate);
}

// Save appointment to database
async function saveAppointmentToDatabase(appointment, appointmentId, submitBtn, isUpdate = false) {
    console.log('saveAppointmentToDatabase called with:', appointment, 'isUpdate:', isUpdate);
    try {
        // Prepare appointment data for API
        const appointmentData = {
            counselor_user_id: parseInt(appointment.counselor_user_id),
            title: appointment.title,
            type: appointment.type,
            date: appointment.date,
            time: appointment.time,
            notes: appointment.notes || null
        };
        
        // Add ID for update operations
        if (isUpdate) {
            appointmentData.id = parseInt(appointmentId);
        }
        
        console.log('Submitting appointment data:', appointmentData);
        
        // Determine API endpoint and method
        const endpoint = isUpdate ? '/api/appointments/update' : '/api/appointments/create';
        const method = isUpdate ? 'PUT' : 'POST';
        
        console.log('Using endpoint:', endpoint, 'method:', method);
        
        // Send to API
        const response = await fetch(window.BASE_URL + endpoint, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(appointmentData)
        });
        
        console.log('API response status:', response.status);
        
        if (!response.ok) {
            const errorData = await response.json();
            console.error('API error:', errorData);
            throw new Error(errorData.error || 'Failed to save appointment');
        }
        
        const result = await response.json();
        console.log(isUpdate ? 'Appointment updated:' : 'Appointment created:', result);
        
        if (isUpdate) {
            // Update existing appointment in local array
            const index = appointments.findIndex(a => a.id == appointmentId);
            if (index !== -1) {
                appointments[index] = appointment;
            }
        } else {
            // Update appointment with database ID for new appointments
            appointment.id = result.id;
            // Add to local appointments array
            appointments.push(appointment);
        }
        
        // Save to localStorage for local display
        saveAppointments();
        
        // Reset form
        resetForm();
        
        // Update UI
        updateStats();
        renderAppointments();
        
        // Show success message
        const action = isUpdate ? 'updated' : 'booked';
        const actionPast = isUpdate ? 'updated' : 'saved';
        showAlert(`Appointment ${action} successfully!`, 'success');
        alert(`✅ Appointment ${action} successfully!\n\nDetails:\n• Title: ${appointment.title}\n• Type: ${appointment.type}\n• Date: ${appointment.date}\n• Time: ${appointment.time}\n\nYour appointment has been ${actionPast} to the database.`);
        
    } catch (error) {
        console.error('Error saving appointment:', error);
        showAlert('Failed to save appointment: ' + error.message, 'error');
        alert(`❌ Failed to save appointment!\n\nError: ${error.message}\n\nPlease try again or contact support if the problem persists.`);
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span class="btn-icon">💾</span><span class="btn-text">Save Appointment</span>';
        isSubmitting = false;
    }
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

// Load counselors from API
async function loadCounselors() {
    try {
        console.log('Loading counselors from:', window.BASE_URL + '/api/counselors');
        
        // First test if API is working
        try {
            const testResponse = await fetch(window.BASE_URL + '/api/test');
            const testData = await testResponse.json();
            console.log('API test result:', testData);
        } catch (testError) {
            console.error('API test failed:', testError);
        }
        
        const response = await fetch(window.BASE_URL + '/api/counselors');
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response error:', errorText);
            throw new Error(`Failed to load counselors: ${response.status} ${errorText}`);
        }
        
        const counselors = await response.json();
        console.log('Counselors data:', counselors);
        
        const counselorSelect = document.getElementById('appointmentCounselor');
        counselorSelect.innerHTML = '<option value="">Select a counselor...</option>';
        
        if (counselors.length === 0) {
            counselorSelect.innerHTML = '<option value="">No counselors available</option>';
            console.log('No counselors found');
            return;
        }
        
        counselors.forEach(counselor => {
            const option = document.createElement('option');
            option.value = counselor.id;
            option.textContent = counselor.full_name || counselor.username;
            if (counselor.specialization) {
                option.textContent += ` (${counselor.specialization})`;
            }
            counselorSelect.appendChild(option);
        });
        
        console.log('Counselors loaded successfully:', counselors.length);
    } catch (error) {
        console.error('Error loading counselors:', error);
        const counselorSelect = document.getElementById('appointmentCounselor');
        counselorSelect.innerHTML = '<option value="">Error loading counselors</option>';
    }
}

// Load appointment types
function loadAppointmentTypes() {
    const typeSelect = document.getElementById('appointmentType');
    const types = [
        'Individual Therapy',
        'Group Therapy', 
        'Crisis Intervention',
        'Assessment',
        'Follow-up Session',
        'Initial Consultation',
        'Family Therapy',
        'Couples Counseling'
    ];
    
    typeSelect.innerHTML = '<option value="">Select appointment type...</option>';
    types.forEach(type => {
        const option = document.createElement('option');
        option.value = type;
        option.textContent = type;
        typeSelect.appendChild(option);
    });
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
    
    console.log('Editing appointment:', appointment);
    
    // Populate form
    document.getElementById('appointmentId').value = appointment.id;
    document.getElementById('appointmentTitle').value = appointment.title;
    document.getElementById('appointmentType').value = appointment.type;
    document.getElementById('appointmentDate').value = appointment.date;
    document.getElementById('appointmentTime').value = appointment.time;
    document.getElementById('appointmentNotes').value = appointment.notes || '';
    
    // Populate counselor if available
    if (appointment.counselor_user_id) {
        document.getElementById('appointmentCounselor').value = appointment.counselor_user_id;
    }
    
    // Update form title to indicate edit mode
    const formTitle = document.querySelector('.booking-form-card h2');
    if (formTitle) {
        formTitle.textContent = '✏️ Edit Appointment';
    }
    
    // Update submit button text
    const submitBtn = document.querySelector('#appointmentForm button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<span class="btn-icon">💾</span><span class="btn-text">Update Appointment</span>';
    }
    
    // Show cancel edit button
    showCancelEditButton();
    
    // Scroll to form
    document.querySelector('.booking-form-card').scrollIntoView({ 
        behavior: 'smooth',
        block: 'start'
    });
    
    // Focus on title field
    document.getElementById('appointmentTitle').focus();
}

async function deleteAppointment(id) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        try {
            console.log('Deleting appointment with ID:', id);
            
            // Call API to delete from database
            const response = await fetch(window.BASE_URL + '/api/appointments/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            });
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Failed to delete appointment');
            }
            
            const result = await response.json();
            console.log('Delete API response:', result);
            
            // Remove from local array
            appointments = appointments.filter(a => a.id != id);
            saveAppointments();
            updateStats();
            renderAppointments();
            
            // Show success message
            showAlert('Appointment deleted successfully from database!', 'success');
            alert('✅ Appointment deleted successfully!\n\nThe appointment has been removed from the database.');
            
        } catch (error) {
            console.error('Error deleting appointment:', error);
            showAlert('Failed to delete appointment: ' + error.message, 'error');
            alert('❌ Failed to delete appointment!\n\nError: ' + error.message + '\n\nPlease try again or contact support if the problem persists.');
        }
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
    
    // Reset form title to create mode
    const formTitle = document.querySelector('.booking-form-card h2');
    if (formTitle) {
        formTitle.textContent = '📝 Book / Edit Appointment';
    }
    
    // Reset submit button text
    const submitBtn = document.querySelector('#appointmentForm button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<span class="btn-icon">💾</span><span class="btn-text">Save Appointment</span>';
    }
    
    // Hide cancel edit button
    hideCancelEditButton();
    
    // Clear all error states
    const inputs = document.querySelectorAll('#appointmentForm input, #appointmentForm select, #appointmentForm textarea');
    inputs.forEach(input => {
        clearFieldError(input);
    });
}

function showCancelEditButton() {
    // Check if cancel button already exists
    let cancelBtn = document.getElementById('cancelEditBtn');
    if (!cancelBtn) {
        // Create cancel edit button
        cancelBtn = document.createElement('button');
        cancelBtn.id = 'cancelEditBtn';
        cancelBtn.type = 'button';
        cancelBtn.className = 'btn outline';
        cancelBtn.innerHTML = '<span class="btn-icon">❌</span><span class="btn-text">Cancel Edit</span>';
        cancelBtn.onclick = cancelEdit;
        
        // Insert after the reset button
        const resetBtn = document.getElementById('resetAppointmentForm');
        resetBtn.parentNode.insertBefore(cancelBtn, resetBtn.nextSibling);
    }
    cancelBtn.style.display = 'inline-flex';
}

function hideCancelEditButton() {
    const cancelBtn = document.getElementById('cancelEditBtn');
    if (cancelBtn) {
        cancelBtn.style.display = 'none';
    }
}

function cancelEdit() {
    if (confirm('Are you sure you want to cancel editing? Any unsaved changes will be lost.')) {
        resetForm();
    }
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

