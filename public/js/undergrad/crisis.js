// Crisis Support Page JavaScript

// Global variables
let breathingInterval;
let currentBreathingPhase = 'ready';
let groundingStep = 1;
let groundingData = {};

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    initializeCrisisPage();
});

function initializeCrisisPage() {
    // Add any initialization logic here
    console.log('Crisis support page initialized');
    
    // Set up emergency button analytics (if needed)
    setupEmergencyButtons();
    
    // Initialize support contacts from localStorage
    loadSupportContacts();
}

// Emergency button functionality
function setupEmergencyButtons() {
    const emergencyButtons = document.querySelectorAll('.emergency-btn');
    
    emergencyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Track emergency button usage (for analytics)
            const buttonType = this.classList.contains('primary') ? '988' : '911';
            trackEmergencyCall(buttonType);
        });
    });
}

function trackEmergencyCall(type) {
    // Store emergency call data for analytics
    const emergencyData = {
        type: type,
        timestamp: new Date().toISOString(),
        page: 'crisis'
    };
    
    // Store in localStorage for analytics
    const existingData = JSON.parse(localStorage.getItem('emergencyCalls') || '[]');
    existingData.push(emergencyData);
    localStorage.setItem('emergencyCalls', JSON.stringify(existingData));
}

// Breathing Exercise Functions
function openBreathingExercise() {
    const modal = document.getElementById('breathingModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeBreathingExercise() {
    const modal = document.getElementById('breathingModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    stopBreathingExercise();
}

function startBreathingExercise() {
    const circle = document.getElementById('breathingCircle');
    const text = document.getElementById('breathingText');
    const startBtn = document.getElementById('startBreathing');
    const stopBtn = document.getElementById('stopBreathing');
    
    startBtn.style.display = 'none';
    stopBtn.style.display = 'inline-flex';
    
    let phase = 'inhale';
    let count = 0;
    
    breathingInterval = setInterval(() => {
        if (phase === 'inhale') {
            circle.classList.add('inhale');
            text.textContent = 'Breathe In...';
            phase = 'hold';
        } else if (phase === 'hold') {
            circle.classList.remove('inhale');
            text.textContent = 'Hold...';
            phase = 'exhale';
        } else if (phase === 'exhale') {
            circle.classList.add('exhale');
            text.textContent = 'Breathe Out...';
            phase = 'pause';
        } else {
            circle.classList.remove('exhale');
            text.textContent = 'Pause...';
            phase = 'inhale';
            count++;
            
            if (count >= 5) {
                text.textContent = 'Great job! Take a moment to notice how you feel.';
                setTimeout(() => {
                    stopBreathingExercise();
                }, 3000);
                return;
            }
        }
    }, 3000);
}

function stopBreathingExercise() {
    if (breathingInterval) {
        clearInterval(breathingInterval);
        breathingInterval = null;
    }
    
    const circle = document.getElementById('breathingCircle');
    const text = document.getElementById('breathingText');
    const startBtn = document.getElementById('startBreathing');
    const stopBtn = document.getElementById('stopBreathing');
    
    circle.classList.remove('inhale', 'exhale');
    text.textContent = 'Click Start to Begin';
    startBtn.style.display = 'inline-flex';
    stopBtn.style.display = 'none';
}

// Grounding Technique Functions
function openGroundingTechnique() {
    const modal = document.getElementById('groundingModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    resetGrounding();
}

function closeGroundingTechnique() {
    const modal = document.getElementById('groundingModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function resetGrounding() {
    groundingStep = 1;
    groundingData = {};
    
    // Hide all steps
    document.querySelectorAll('.step').forEach(step => {
        step.classList.remove('active');
    });
    
    // Show first step
    document.getElementById('step1').classList.add('active');
    
    // Clear all inputs
    document.querySelectorAll('.grounding-steps input').forEach(input => {
        input.value = '';
    });
}

function nextGroundingStep() {
    const currentStep = document.getElementById(`step${groundingStep}`);
    const input = currentStep.querySelector('input');
    const value = input.value.trim();
    
    if (!value) {
        alert('Please fill in this step before continuing.');
        return;
    }
    
    // Store the data
    groundingData[`step${groundingStep}`] = value;
    
    // Hide current step
    currentStep.classList.remove('active');
    
    // Show next step
    groundingStep++;
    if (groundingStep <= 5) {
        document.getElementById(`step${groundingStep}`).classList.add('active');
    } else {
        // Complete the exercise
        completeGroundingExercise();
    }
}

function completeGroundingExercise() {
    const modal = document.getElementById('groundingModal');
    const modalBody = modal.querySelector('.modal-body');
    
    modalBody.innerHTML = `
        <div class="grounding-complete">
            <h3>🎉 Great job completing the grounding exercise!</h3>
            <p>Here's what you noticed:</p>
            <div class="grounding-summary">
                <p><strong>5 Things You Saw:</strong> ${groundingData.step1}</p>
                <p><strong>4 Things You Touched:</strong> ${groundingData.step2}</p>
                <p><strong>3 Things You Heard:</strong> ${groundingData.step3}</p>
                <p><strong>2 Things You Smelled:</strong> ${groundingData.step4}</p>
                <p><strong>1 Thing You Tasted:</strong> ${groundingData.step5}</p>
            </div>
            <p>Take a moment to notice how you feel now compared to when you started.</p>
            <div class="grounding-controls">
                <button class="btn" onclick="closeGroundingTechnique()">Close</button>
                <button class="btn outline" onclick="resetGrounding()">Try Again</button>
            </div>
        </div>
    `;
    
    // Store completion data
    const completionData = {
        timestamp: new Date().toISOString(),
        data: groundingData
    };
    
    const existingData = JSON.parse(localStorage.getItem('groundingExercises') || '[]');
    existingData.push(completionData);
    localStorage.setItem('groundingExercises', JSON.stringify(existingData));
}

// Safety Plan Functions
function openSafetyPlan() {
    // Create a simple safety plan modal
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>📋 Safety Plan</h3>
                <button class="modal-close" onclick="this.closest('.modal').remove()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="safety-plan">
                    <h4>Warning Signs</h4>
                    <p>What are your personal warning signs that you're in crisis?</p>
                    <textarea class="input" placeholder="List your warning signs here..." rows="3"></textarea>
                    
                    <h4>Coping Strategies</h4>
                    <p>What can you do to help yourself feel better?</p>
                    <textarea class="input" placeholder="List your coping strategies here..." rows="3"></textarea>
                    
                    <h4>Support People</h4>
                    <p>Who can you reach out to for support?</p>
                    <textarea class="input" placeholder="List your support people and their contact info..." rows="3"></textarea>
                    
                    <h4>Professional Help</h4>
                    <p>What professional resources are available to you?</p>
                    <textarea class="input" placeholder="List professional resources..." rows="3"></textarea>
                    
                    <h4>Safe Environment</h4>
                    <p>What makes your environment safe? What can you remove or change?</p>
                    <textarea class="input" placeholder="Describe your safe environment..." rows="3"></textarea>
                </div>
                <div class="grounding-controls">
                    <button class="btn" onclick="saveSafetyPlan()">Save Plan</button>
                    <button class="btn outline" onclick="this.closest('.modal').remove()">Close</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function saveSafetyPlan() {
    const textareas = document.querySelectorAll('.safety-plan textarea');
    const planData = {};
    
    textareas.forEach((textarea, index) => {
        const labels = ['warningSigns', 'copingStrategies', 'supportPeople', 'professionalHelp', 'safeEnvironment'];
        planData[labels[index]] = textarea.value;
    });
    
    planData.timestamp = new Date().toISOString();
    
    localStorage.setItem('safetyPlan', JSON.stringify(planData));
    alert('Safety plan saved successfully!');
    
    // Close modal
    document.querySelector('.modal').remove();
    document.body.style.overflow = 'auto';
}

// Distraction Tools
function openDistractionTools() {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>🎯 Distraction Tools</h3>
                <button class="modal-close" onclick="this.closest('.modal').remove()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="distraction-tools">
                    <div class="tool-category">
                        <h4>🧮 Mental Math</h4>
                        <p>Count backwards from 100 by 7s, or do multiplication tables</p>
                        <button class="btn small" onclick="startMentalMath()">Start Math</button>
                    </div>
                    
                    <div class="tool-category">
                        <h4>🎨 Creative Visualization</h4>
                        <p>Imagine your favorite place in detail</p>
                        <button class="btn small" onclick="startVisualization()">Start Visualization</button>
                    </div>
                    
                    <div class="tool-category">
                        <h4>🎵 Music & Sounds</h4>
                        <p>Listen to calming music or nature sounds</p>
                        <button class="btn small" onclick="playCalmingSounds()">Play Sounds</button>
                    </div>
                    
                    <div class="tool-category">
                        <h4>📱 Simple Games</h4>
                        <p>Play simple games to distract your mind</p>
                        <button class="btn small" onclick="startSimpleGame()">Play Game</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

// Support Contact Functions
function addSupportContact() {
    const name = prompt('Enter the name of your support person:');
    if (name) {
        const phone = prompt('Enter their phone number:');
        if (phone) {
            const contact = { name, phone, type: 'support' };
            saveSupportContact(contact);
        }
    }
}

function addFacultyContact() {
    const name = prompt('Enter the name of your faculty member:');
    if (name) {
        const phone = prompt('Enter their phone number:');
        if (phone) {
            const contact = { name, phone, type: 'faculty' };
            saveSupportContact(contact);
        }
    }
}

function saveSupportContact(contact) {
    const contacts = JSON.parse(localStorage.getItem('supportContacts') || '[]');
    contacts.push(contact);
    localStorage.setItem('supportContacts', JSON.stringify(contacts));
    alert('Contact saved successfully!');
}

function loadSupportContacts() {
    const contacts = JSON.parse(localStorage.getItem('supportContacts') || '[]');
    // Could display contacts in the UI here
}

function callSupport() {
    const contacts = JSON.parse(localStorage.getItem('supportContacts') || '[]');
    if (contacts.length === 0) {
        alert('No support contacts saved. Please add a contact first.');
        return;
    }
    
    // For demo purposes, just show the first contact
    const contact = contacts[0];
    if (confirm(`Call ${contact.name} at ${contact.phone}?`)) {
        window.location.href = `tel:${contact.phone}`;
    }
}

function textSupport() {
    const contacts = JSON.parse(localStorage.getItem('supportContacts') || '[]');
    if (contacts.length === 0) {
        alert('No support contacts saved. Please add a contact first.');
        return;
    }
    
    // For demo purposes, just show the first contact
    const contact = contacts[0];
    const message = prompt('Enter your message:');
    if (message) {
        window.location.href = `sms:${contact.phone}&body=${encodeURIComponent(message)}`;
    }
}

// Utility Functions
function findNearestER() {
    // This would typically integrate with a maps API
    alert('This would open a map showing the nearest emergency rooms. For now, please call 911 or go to your nearest hospital.');
}

function contactRA() {
    alert('This would connect you with your Resident Advisor. Please check your dorm directory or contact your housing office.');
}

// Simple distraction tools
function startMentalMath() {
    const number = Math.floor(Math.random() * 100) + 1;
    const multiplier = Math.floor(Math.random() * 12) + 1;
    const answer = number * multiplier;
    
    const userAnswer = prompt(`What is ${number} × ${multiplier}?`);
    if (parseInt(userAnswer) === answer) {
        alert('Correct! Great job!');
    } else {
        alert(`The correct answer is ${answer}. Good try!`);
    }
}

function startVisualization() {
    alert('Close your eyes and imagine your favorite place. Think about what you see, hear, smell, and feel there. Take deep breaths and stay in this peaceful place for a few minutes.');
}

function playCalmingSounds() {
    alert('This would play calming nature sounds or music. For now, try listening to your favorite calming music or nature sounds on your device.');
}

function startSimpleGame() {
    const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
    const randomColor = colors[Math.floor(Math.random() * colors.length)];
    
    const userGuess = prompt(`I'm thinking of a color: red, blue, green, yellow, or purple. What is it?`);
    if (userGuess.toLowerCase() === randomColor) {
        alert('Correct! Great job!');
    } else {
        alert(`I was thinking of ${randomColor}. Good try!`);
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.remove();
        document.body.style.overflow = 'auto';
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.remove();
        });
        document.body.style.overflow = 'auto';
    }
});

