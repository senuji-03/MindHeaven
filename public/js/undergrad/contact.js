// Contact Page JavaScript

// Global variables
let formData = {};
let isSubmitting = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    initializeContactPage();
});

function initializeContactPage() {
    console.log('Contact page initialized');
    
    // Set up form validation
    setupFormValidation();
    
    // Set up form submission
    setupFormSubmission();
    
    // Set up FAQ functionality
    setupFAQ();
    
    // Load saved form data if any
    loadSavedFormData();
}

// Form Validation
function setupFormValidation() {
    const form = document.getElementById('contactForm');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        // Real-time validation
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
    const fieldName = field.name;
    const errorElement = document.getElementById(fieldName + 'Error');
    
    // Clear previous error
    clearFieldError(field);
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showFieldError(field, 'Please enter a valid email address');
            return false;
        }
    }
    
    // Phone validation
    if (field.type === 'tel' && value) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
            showFieldError(field, 'Please enter a valid phone number');
            return false;
        }
    }
    
    // Message length validation
    if (fieldName === 'message' && value.length < 10) {
        showFieldError(field, 'Message must be at least 10 characters long');
        return false;
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    const errorElement = document.getElementById(field.name + 'Error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorElement = document.getElementById(field.name + 'Error');
    if (errorElement) {
        errorElement.classList.remove('show');
    }
}

// Form Submission
function setupFormSubmission() {
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isSubmitting) return;
        
        if (validateForm()) {
            submitForm();
        }
    });
    
    // Auto-save form data
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            saveFormData();
        });
    });
}

function validateForm() {
    const form = document.getElementById('contactForm');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
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
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('contactForm');
    
    // Show loading state
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    
    // Collect form data
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // Add metadata
    data.timestamp = new Date().toISOString();
    data.userAgent = navigator.userAgent;
    data.referrer = document.referrer;
    
    // Simulate form submission (replace with actual API call)
    setTimeout(() => {
        // Store submission data
        storeSubmissionData(data);
        
        // Clear form
        form.reset();
        clearSavedFormData();
        
        // Show success modal
        showSuccessModal(data);
        
        // Reset button state
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        isSubmitting = false;
        
        // Track submission
        trackFormSubmission(data);
        
    }, 2000); // Simulate network delay
}

function storeSubmissionData(data) {
    const submissions = JSON.parse(localStorage.getItem('contactSubmissions') || '[]');
    submissions.push(data);
    localStorage.setItem('contactSubmissions', JSON.stringify(submissions));
}

function showSuccessModal(data) {
    const modal = document.getElementById('successModal');
    const referenceId = generateReferenceId();
    const expectedResponse = getExpectedResponseTime(data.subject);
    
    document.getElementById('referenceId').textContent = referenceId;
    document.getElementById('expectedResponse').textContent = expectedResponse;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Store reference ID
    data.referenceId = referenceId;
    storeSubmissionData(data);
}

function generateReferenceId() {
    const timestamp = Date.now().toString(36);
    const random = Math.random().toString(36).substr(2, 5);
    return `MH-${timestamp}-${random}`.toUpperCase();
}

function getExpectedResponseTime(subject) {
    const responseTimes = {
        'crisis': 'Within 2 hours (urgent)',
        'technical': 'Within 4 hours during business hours',
        'general': 'Within 24 hours',
        'feature': 'Within 48 hours',
        'bug': 'Within 4 hours during business hours',
        'feedback': 'Within 24 hours',
        'other': 'Within 24 hours'
    };
    
    return responseTimes[subject] || 'Within 24 hours';
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function printConfirmation() {
    const referenceId = document.getElementById('referenceId').textContent;
    const expectedResponse = document.getElementById('expectedResponse').textContent;
    
    const printContent = `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
            <h1>MindHeaven Contact Confirmation</h1>
            <p><strong>Reference ID:</strong> ${referenceId}</p>
            <p><strong>Expected Response:</strong> ${expectedResponse}</p>
            <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
            <p><strong>Time:</strong> ${new Date().toLocaleTimeString()}</p>
            <hr>
            <p>Thank you for contacting MindHeaven. We have received your message and will respond as soon as possible.</p>
            <p>If you have any urgent concerns, please call our crisis support line at 988 or visit our crisis support page.</p>
        </div>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

// FAQ Functionality
function setupFAQ() {
    // FAQ functionality is handled by onclick in HTML
}

function toggleFAQ(button) {
    const faqItem = button.closest('.faq-item');
    const isActive = faqItem.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}

// Privacy Policy
function showPrivacyPolicy() {
    const modal = document.getElementById('privacyModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePrivacyModal() {
    const modal = document.getElementById('privacyModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Form Data Persistence
function saveFormData() {
    const form = document.getElementById('contactForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    localStorage.setItem('contactFormData', JSON.stringify(data));
}

function loadSavedFormData() {
    const savedData = localStorage.getItem('contactFormData');
    if (savedData) {
        const data = JSON.parse(savedData);
        const form = document.getElementById('contactForm');
        
        Object.keys(data).forEach(key => {
            const field = form.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox') {
                    field.checked = data[key] === 'on';
                } else {
                    field.value = data[key];
                }
            }
        });
    }
}

function clearSavedFormData() {
    localStorage.removeItem('contactFormData');
}

// Utility Functions
function openLiveChat() {
    // This would integrate with a live chat service
    alert('Live chat would open here. For now, please use the contact form or call us directly.');
}

function getDirections() {
    // This would open maps with the office location
    const address = 'Student Wellness Center, 123 University Drive, Campus, ST 12345';
    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
    window.open(mapsUrl, '_blank');
}

// Analytics and Tracking
function trackFormSubmission(data) {
    // Track form submission for analytics
    const trackingData = {
        type: 'contact_form_submission',
        subject: data.subject,
        urgent: data.urgent === 'on',
        timestamp: new Date().toISOString(),
        page: 'contact'
    };
    
    // Store in localStorage for analytics
    const existingData = JSON.parse(localStorage.getItem('analytics') || '[]');
    existingData.push(trackingData);
    localStorage.setItem('analytics', JSON.stringify(existingData));
    
    console.log('Form submission tracked:', trackingData);
}

// Form Reset
function resetForm() {
    const form = document.getElementById('contactForm');
    form.reset();
    clearSavedFormData();
    
    // Clear all error states
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        clearFieldError(input);
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape key closes modals
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal:not(.hidden)');
        modals.forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = 'auto';
    }
    
    // Ctrl/Cmd + Enter submits form
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        const form = document.getElementById('contactForm');
        if (document.activeElement && form.contains(document.activeElement)) {
            e.preventDefault();
            if (!isSubmitting) {
                form.dispatchEvent(new Event('submit'));
            }
        }
    }
});

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
});

// Auto-save on page unload
window.addEventListener('beforeunload', function() {
    saveFormData();
});

// Form field formatting
document.addEventListener('input', function(e) {
    // Phone number formatting
    if (e.target.type === 'tel') {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
        }
        e.target.value = value;
    }
});

