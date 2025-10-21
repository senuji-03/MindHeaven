<?php
$TITLE = 'MindHeaven — Appointments';
$CURRENT_PAGE = 'appointments';
$PAGE_CSS = ["/MindHeaven/public/css/undergrad/appointments.css"];
$PAGE_JS  = ["/MindHeaven/public/js/undergrad/appointments.js"];

require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="container appointments">
	<!-- Appointments Hero Section -->
	<section class="hero appointments-hero">
		<div class="hero-content">
			<h1>📅 Appointments</h1>
			<p class="hero-subtitle">Schedule and manage your counseling sessions with ease.</p>
		</div>
	</section>

	<!-- Appointment Booking Section -->
	<section class="appointment-booking">
		<div class="grid">
			<div class="card col-6 booking-form-card">
				<div class="card-header">
					<h2>📝 Book / Edit Appointment</h2>
					<p class="card-subtitle">Schedule your counseling session</p>
				</div>
				<div class="card-body">
					<form id="appointmentForm" class="appointment-form" novalidate>
    <input type="hidden" id="appointmentId" name="appointmentId" />
    <div class="form-grid">
        <div class="form-group">
            <label for="appointmentTitle" class="label">Appointment Title *</label>
            <input type="text" id="appointmentTitle" name="title" class="input" placeholder="e.g., Dr. Smith - Therapy Session" required />
            <div class="error-message" id="titleError"></div>
        </div>
        <div class="form-group">
            <label for="appointmentType" class="label">Appointment Type *</label>
            <select id="appointmentType" name="type" class="input" required>
                <option value="">Loading types...</option>
            </select>
            <div class="error-message" id="typeError"></div>
        </div>
        <div class="form-group">
            <label for="appointmentCounselor" class="label">Select Counselor *</label>
            <select id="appointmentCounselor" name="counselor_user_id" class="input" required>
                <option value="">Loading counselors...</option>
            </select>
            <div class="error-message" id="counselorError"></div>
        </div>
        <div class="form-group">
            <label for="appointmentDate" class="label">Date *</label>
            <input type="date" id="appointmentDate" name="date" class="input" required />
            <div class="error-message" id="dateError"></div>
        </div>
        <div class="form-group">
            <label for="appointmentTime" class="label">Time *</label>
            <input type="time" id="appointmentTime" name="time" class="input" required />
            <div class="error-message" id="timeError"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="appointmentNotes" class="label">Notes (Optional)</label>
        <textarea id="appointmentNotes" name="notes" class="input" rows="3" placeholder="Any specific concerns or topics you'd like to discuss..."></textarea>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn primary">
            <span class="btn-icon">💾</span>
            <span class="btn-text">Save Appointment</span>
        </button>
        <button type="button" id="resetAppointmentForm" class="btn outline">
            <span class="btn-icon">🔄</span>
            <span class="btn-text">Reset Form</span>
        </button>
    </div>
</form>
				</div>
			</div>

			<!-- Quick Stats -->
			<div class="card col-6 stats-card">
				<div class="card-header">
					<h2>📊 Your Appointment Stats</h2>
					<p class="card-subtitle">Overview of your counseling sessions</p>
				</div>
				<div class="card-body">
					<div class="stats-grid">
						<div class="stat-item">
							<div class="stat-icon">📅</div>
							<div class="stat-content">
								<h3 id="totalAppointments">0</h3>
								<p>Total Appointments</p>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">✅</div>
							<div class="stat-content">
								<h3 id="completedAppointments">0</h3>
								<p>Completed</p>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">⏰</div>
							<div class="stat-content">
								<h3 id="upcomingAppointments">0</h3>
								<p>Upcoming</p>
							</div>
						</div>
						<div class="stat-item">
							<div class="stat-icon">📈</div>
							<div class="stat-content">
								<h3 id="attendanceRate">0%</h3>
								<p>Attendance Rate</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Appointments List Section -->
	<section class="appointments-list">
		<div class="card">
			<div class="card-header">
				<h2>📋 Your Appointments</h2>
				<p class="card-subtitle">Manage your scheduled counseling sessions</p>
				<div class="card-tools">
					<button id="startAppointmentBtn" class="btn primary" onclick="startAppointment()">
						<span class="btn-icon">🎥</span>
						<span class="btn-text">Start Appointment</span>
					</button>
					<button id="importDemoAppointments" class="btn small outline">
						<span class="btn-icon">📊</span>
						<span class="btn-text">Load Demo Data</span>
					</button>
					<button id="exportAppointmentsCsv" class="btn small outline">
						<span class="btn-icon">📤</span>
						<span class="btn-text">Export CSV</span>
					</button>
				</div>
			</div>
			<div class="card-body">
				<div id="appointmentsEmptyState" class="empty-state" style="display:none;">
					<div class="empty-state-content">
						<div class="empty-state-icon">📅</div>
						<h3>No appointments yet</h3>
						<p>Book your first counseling session using the form above.</p>
						<button class="btn" onclick="document.getElementById('appointmentTitle').focus()">Get Started</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="appointments-table">
						<thead>
							<tr>
								<th>Title</th>
								<th>Type</th>
								<th>Date</th>
								<th>Time</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="appointmentsTableBody"></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</main>

<!-- Video/Audio Appointment Modal -->
<div id="appointmentModal" class="modal" style="display: none;">
	<div class="modal-content appointment-modal">
		<div class="modal-header">
			<h3 class="modal-title">🎥 Live Counseling Session</h3>
			<button class="modal-close" onclick="closeAppointment()">&times;</button>
		</div>
		<div class="modal-body">
			<div class="appointment-container">
				<div class="video-section">
					<div class="video-container">
						<div class="video-placeholder">
							<div class="video-icon">📹</div>
							<p>Video feed will appear here</p>
							<div class="connection-status">
								<span class="status-dot connecting"></span>
								<span>Connecting to counselor...</span>
							</div>
						</div>
					</div>
					<div class="video-controls">
						<button class="control-btn" id="toggleVideo" onclick="toggleVideo()">
							<span class="btn-icon">📹</span>
							<span>Video On</span>
						</button>
						<button class="control-btn" id="toggleAudio" onclick="toggleAudio()">
							<span class="btn-icon">🎤</span>
							<span>Audio On</span>
						</button>
						<button class="control-btn" id="toggleScreen" onclick="toggleScreenShare()">
							<span class="btn-icon">🖥</span>
							<span>Share Screen</span>
						</button>
						<button class="control-btn danger" onclick="endAppointment()">
							<span class="btn-icon">📞</span>
							<span>End Call</span>
						</button>
					</div>
				</div>
				
				<div class="chat-section">
					<div class="chat-header">
						<h4>💬 Session Chat</h4>
					</div>
					<div class="chat-messages" id="chatMessages">
						<div class="message counselor">
							<div class="message-content">
								<p>Hello! I'm Dr. Smith. How are you feeling today?</p>
								<span class="message-time">2:30 PM</span>
							</div>
						</div>
					</div>
					<div class="chat-input">
						<input type="text" id="chatInput" placeholder="Type your message..." onkeypress="handleChatKeyPress(event)">
						<button onclick="sendMessage()">Send</button>
					</div>
				</div>
			</div>
			
			<div class="session-info">
				<div class="info-item">
					<span class="info-label">Counselor:</span>
					<span class="info-value">Dr. Emily Smith</span>
				</div>
				<div class="info-item">
					<span class="info-label">Session Type:</span>
					<span class="info-value">Individual Counseling</span>
				</div>
				<div class="info-item">
					<span class="info-label">Duration:</span>
					<span class="info-value" id="sessionDuration">00:00</span>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
.modal {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.8);
	z-index: 1000;
	display: flex;
	align-items: center;
	justify-content: center;
}

.appointment-modal {
	width: 95%;
	max-width: 1200px;
	height: 90vh;
	background: white;
	border-radius: 12px;
	overflow: hidden;
}

.modal-header {
	padding: 1rem 1.5rem;
	background: #4f46e5;
	color: white;
	display: flex;
	justify-content: space-between;
	align-items: center;
}

.modal-title {
	margin: 0;
	font-size: 1.2rem;
}

.modal-close {
	background: none;
	border: none;
	color: white;
	font-size: 1.5rem;
	cursor: pointer;
	padding: 0.5rem;
	border-radius: 4px;
}

.modal-close:hover {
	background: rgba(255,255,255,0.2);
}

.modal-body {
	padding: 1.5rem;
	height: calc(100% - 60px);
	display: flex;
	flex-direction: column;
}

.appointment-container {
	display: grid;
	grid-template-columns: 2fr 1fr;
	gap: 1.5rem;
	height: 100%;
}

.video-section {
	display: flex;
	flex-direction: column;
}

.video-container {
	flex: 1;
	background: #1a1a1a;
	border-radius: 8px;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 1rem;
}

.video-placeholder {
	text-align: center;
	color: white;
}

.video-icon {
	font-size: 3rem;
	margin-bottom: 1rem;
}

.connection-status {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	margin-top: 1rem;
}

.status-dot {
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: #ef4444;
	animation: pulse 2s infinite;
}

.status-dot.connected {
	background: #10b981;
}

@keyframes pulse {
	0%, 100% { opacity: 1; }
	50% { opacity: 0.5; }
}

.video-controls {
	display: flex;
	gap: 0.5rem;
	justify-content: center;
}

.control-btn {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	padding: 0.75rem 1rem;
	background: #f3f4f6;
	border: 1px solid #d1d5db;
	border-radius: 6px;
	cursor: pointer;
	transition: all 0.3s ease;
}

.control-btn:hover {
	background: #e5e7eb;
}

.control-btn.danger {
	background: #ef4444;
	color: white;
	border-color: #ef4444;
}

.control-btn.danger:hover {
	background: #dc2626;
}

.chat-section {
	display: flex;
	flex-direction: column;
	border: 1px solid #e5e7eb;
	border-radius: 8px;
	overflow: hidden;
}

.chat-header {
	padding: 1rem;
	background: #f9fafb;
	border-bottom: 1px solid #e5e7eb;
}

.chat-header h4 {
	margin: 0;
	color: #1f2937;
}

.chat-messages {
	flex: 1;
	padding: 1rem;
	overflow-y: auto;
	max-height: 300px;
}

.message {
	margin-bottom: 1rem;
}

.message-content {
	background: #f3f4f6;
	padding: 0.75rem;
	border-radius: 8px;
	max-width: 80%;
}

.message.counselor .message-content {
	background: #e0e7ff;
	margin-right: auto;
}

.message-time {
	font-size: 0.75rem;
	color: #6b7280;
	display: block;
	margin-top: 0.25rem;
}

.chat-input {
	display: flex;
	padding: 1rem;
	border-top: 1px solid #e5e7eb;
	gap: 0.5rem;
}

.chat-input input {
	flex: 1;
	padding: 0.75rem;
	border: 1px solid #d1d5db;
	border-radius: 6px;
}

.chat-input button {
	padding: 0.75rem 1rem;
	background: #4f46e5;
	color: white;
	border: none;
	border-radius: 6px;
	cursor: pointer;
}

.session-info {
	display: flex;
	gap: 2rem;
	margin-top: 1rem;
	padding-top: 1rem;
	border-top: 1px solid #e5e7eb;
}

.info-item {
	display: flex;
	flex-direction: column;
	gap: 0.25rem;
}

.info-label {
	font-size: 0.875rem;
	color: #6b7280;
	font-weight: 500;
}

.info-value {
	font-weight: 600;
	color: #1f2937;
}
</style>

<script>
// ----------------------
// JS FUNCTIONS
// ----------------------

// ----------------------
// MindHeaven Utility Object
// ----------------------
window.MindHeaven = window.MindHeaven || {};

window.MindHeaven.getStorageItem = function(key, defaultValue = []) {
    try {
        const item = localStorage.getItem(key);
        return item ? JSON.parse(item) : defaultValue;
    } catch (e) {
        console.error('Error reading from storage', e);
        return defaultValue;
    }
};

window.MindHeaven.setStorageItem = function(key, value) {
    try {
        localStorage.setItem(key, JSON.stringify(value));
    } catch (e) {
        console.error('Error writing to storage', e);
    }
};

window.MindHeaven.showAlert = function(message, type = 'info') {
     // Better visual feedback
    const alertClass = type === 'error' ? 'alert-danger' : 
                      type === 'success' ? 'alert-success' : 'alert-info';
    
    console.log(`[${type.toUpperCase()}] ${message}`);
    alert(message); // You can replace this with a nicer toast notification
};

window.MindHeaven.validateForm = function(form) {
    let valid = true;
    form.querySelectorAll('[required]').forEach(input => {
        const value = input.value ? input.value.trim() : '';
        if (!value || value === '') {
            valid = false;
            input.classList.add('input-error');
            const errorDiv = input.parentElement.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.textContent = 'This field is required';
            }
        } else {
            input.classList.remove('input-error');
            const errorDiv = input.parentElement.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.textContent = '';
            }
        }
    });
    return valid;
};

window.MindHeaven.formatDate = function(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString();
};

window.MindHeaven.formatTime = function(timeStr) {
    const t = new Date('1970-01-01T' + timeStr + 'Z');
    return t.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
};

window.MindHeaven.getDemoData = function(type) {
    if (type === 'appointments') {
        return [
            { title: "Demo Session 1", type: "individual", date: "2025-10-20", time: "10:00", status: "scheduled" },
            { title: "Demo Session 2", type: "group", date: "2025-10-21", time: "14:00", status: "scheduled" }
        ];
    }
    return [];
};

window.MindHeaven.exportToCSV = function(data, filename) {
    if (!data.length) return;
    const csvRows = [];
    const headers = Object.keys(data[0]);
    csvRows.push(headers.join(','));
    for (const row of data) {
        csvRows.push(headers.map(h => `"${row[h]}"`).join(','));
    }
    const blob = new Blob([csvRows.join('\n')], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
};

function getAppointments() { return window.MindHeaven.getStorageItem('appointments', []); }
function saveAppointments(list) { window.MindHeaven.setStorageItem('appointments', list); }

function onAppointmentSubmit(e) {
	e.preventDefault();
	console.log("Form submitted!"); 
	const form = e.target;
	//Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    
	  // Validate form
    if (!window.MindHeaven.validateForm(form)) {
        window.MindHeaven.showAlert('Please fill in all required fields', 'error');
        return;
    }

	const id = document.getElementById('appointmentId').value;
	const title = document.getElementById('appointmentTitle').value.trim();
	const type = document.getElementById('appointmentType').value;
	const date = document.getElementById('appointmentDate').value;
	const time = document.getElementById('appointmentTime').value;
    const notes = document.getElementById('appointmentNotes').value;
    const counselorId = document.getElementById('appointmentCounselor').value;

	
    // Additional validation
    if (!id) {
        // Create new appointment in backend DB
        fetch('/MindHeaven/public/api/appointments/create', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ 
                counselor_user_id: counselorId, 
                title, 
                type, 
                date, 
                time, 
                notes 
            })
        })
        .then(async response => {
            console.log("Response status:", response.status);
            const text = await response.text();
            console.log("Response text:", text);
            
            let json;
            try {
                json = JSON.parse(text);
            } catch (e) {
                throw new Error('Invalid JSON response: ' + text);
            }
            
            if (!response.ok) {
                throw new Error(json.detail || json.error || 'Failed to create appointment');
            }
            return json;
        })
        .then(json => {
            console.log("Success response:", json);
            window.MindHeaven.showAlert(`Appointment booked successfully! ID: ${json.id}`, 'success');
            
            // Store locally for display
            const list = getAppointments();
            list.push({ 
                id: json.id, 
                title, 
                type, 
                date, 
                time, 
                status: 'pending',
                counselor_user_id: counselorId,
                notes
            });
            saveAppointments(list);
            
            resetAppointmentForm();
            renderAppointments();
        })
        .catch(err => {
            console.error("Error creating appointment:", err);
            window.MindHeaven.showAlert('Error: ' + err.message, 'error');
        });
    } else {
	const list = getAppointments();
		const idx = list.findIndex(a => String(a.id) === String(id));
		if (idx !== -1) {
			list[idx].title = title;
			list[idx].type = type;
			list[idx].date = date;
			list[idx].time = time;
		}
        saveAppointments(list);
		window.MindHeaven.showAlert('Appointment updated!', 'success');
	resetAppointmentForm();
	renderAppointments();
    }
}

function resetAppointmentForm() {
	document.getElementById('appointmentId').value = '';
	document.getElementById('appointmentForm').reset();
}

function renderAppointments() {
	const tbody = document.getElementById('appointmentsTableBody');
	const empty = document.getElementById('appointmentsEmptyState');
	const list = getAppointments();
    if (!list.length) { empty.style.display = 'block'; tbody.innerHTML = ''; return; }
	empty.style.display = 'none';
	tbody.innerHTML = list.map(a => `
		<tr>
			<td>${a.title}</td>
			<td>${a.type}</td>
			<td>${window.MindHeaven.formatDate(a.date)}</td>
			<td>${window.MindHeaven.formatTime(a.time)}</td>
			<td>
				<select onchange="updateStatus(${a.id}, this.value)">
					<option value="scheduled" ${a.status==='scheduled'?'selected':''}>Scheduled</option>
					<option value="completed" ${a.status==='completed'?'selected':''}>Completed</option>
					<option value="cancelled" ${a.status==='cancelled'?'selected':''}>Cancelled</option>
				</select>
			</td>
			<td>
				<button class="btn btn-xs" onclick="editAppointment(${a.id})"><i class="fas fa-edit"></i></button>
				<button class="btn btn-xs btn-danger" onclick="deleteAppointment(${a.id})"><i class="fas fa-trash"></i></button>
			</td>
		</tr>
	`).join('');
}

function editAppointment(id) {
    const a = getAppointments().find(x => String(x.id) === String(id));
	if (!a) return;
	document.getElementById('appointmentId').value = a.id;
	document.getElementById('appointmentTitle').value = a.title;
	document.getElementById('appointmentType').value = a.type;
	document.getElementById('appointmentDate').value = a.date;
	document.getElementById('appointmentTime').value = a.time;
}

function deleteAppointment(id) {
	const list = getAppointments().filter(a => String(a.id) !== String(id));
	saveAppointments(list);
	window.MindHeaven.showAlert('Appointment deleted', 'success');
	renderAppointments();
}

function updateStatus(id, status) {
	const list = getAppointments();
	const idx = list.findIndex(a => String(a.id) === String(id));
    if (idx !== -1) { list[idx].status = status; saveAppointments(list); }
}

function importDemoAppointments() {
	const demo = (window.MindHeaven.getDemoData('appointments') || []).map(d => ({ ...d, id: Date.now() + Math.random() }));
	saveAppointments(demo);
	renderAppointments();
	window.MindHeaven.showAlert('Demo appointments loaded', 'success');
}

function exportAppointmentsCsv() { window.MindHeaven.exportToCSV(getAppointments(), 'appointments.csv'); }

// Appointment UI Functions
let sessionTimer;
let sessionStartTime;

function startAppointment() {
	document.getElementById('appointmentModal').style.display = 'flex';
	sessionStartTime = new Date();
	startSessionTimer();
	
	// Simulate connection
	setTimeout(() => {
		const statusDot = document.querySelector('.status-dot');
		statusDot.classList.remove('connecting');
		statusDot.classList.add('connected');
		statusDot.nextElementSibling.textContent = 'Connected to Dr. Emily Smith';
	}, 2000);
}

function closeAppointment() {
	document.getElementById('appointmentModal').style.display = 'none';
	stopSessionTimer();
}

function endAppointment() {
	if (confirm('Are you sure you want to end this session?')) {
		closeAppointment();
		alert('Session ended. Thank you for your time!');
	}
}

function startSessionTimer() {
	sessionTimer = setInterval(() => {
		const now = new Date();
		const duration = Math.floor((now - sessionStartTime) / 1000);
		const minutes = Math.floor(duration / 60);
		const seconds = duration % 60;
		document.getElementById('sessionDuration').textContent = 
			`${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
	}, 1000);
}

function stopSessionTimer() {
	if (sessionTimer) {
		clearInterval(sessionTimer);
	}
}

function toggleVideo() {
	const btn = document.getElementById('toggleVideo');
	const isOn = btn.textContent.includes('On');
	btn.innerHTML = `<span class="btn-icon">${isOn ? '📹' : '📹'}</span><span>Video ${isOn ? 'Off' : 'On'}</span>`;
	btn.style.background = isOn ? '#ef4444' : '#10b981';
	btn.style.color = 'white';
}

function toggleAudio() {
	const btn = document.getElementById('toggleAudio');
	const isOn = btn.textContent.includes('On');
	btn.innerHTML = `<span class="btn-icon">${isOn ? '🎤' : '🎤'}</span><span>Audio ${isOn ? 'Off' : 'On'}</span>`;
	btn.style.background = isOn ? '#ef4444' : '#10b981';
	btn.style.color = 'white';
}

function toggleScreenShare() {
	const btn = document.getElementById('toggleScreen');
	const isSharing = btn.textContent.includes('Stop');
	btn.innerHTML = `<span class="btn-icon">🖥</span><span>${isSharing ? 'Stop Sharing' : 'Share Screen'}</span>`;
	btn.style.background = isSharing ? '#f3f4f6' : '#4f46e5';
	btn.style.color = isSharing ? '#374151' : 'white';
}

function sendMessage() {
	const input = document.getElementById('chatInput');
	const message = input.value.trim();
	if (!message) return;
	
	const chatMessages = document.getElementById('chatMessages');
	const messageDiv = document.createElement('div');
	messageDiv.className = 'message';
	messageDiv.innerHTML = `
		<div class="message-content" style="margin-left: auto; background: #4f46e5; color: white;">
			<p>${message}</p>
			<span class="message-time">${new Date().toLocaleTimeString()}</span>
		</div>
	`;
	chatMessages.appendChild(messageDiv);
	chatMessages.scrollTop = chatMessages.scrollHeight;
	
	input.value = '';
	
	// Simulate counselor response
	setTimeout(() => {
		const responseDiv = document.createElement('div');
		responseDiv.className = 'message counselor';
		responseDiv.innerHTML = `
			<div class="message-content">
				<p>Thank you for sharing that. Can you tell me more about how that makes you feel?</p>
				<span class="message-time">${new Date().toLocaleTimeString()}</span>
			</div>
		`;
		chatMessages.appendChild(responseDiv);
		chatMessages.scrollTop = chatMessages.scrollHeight;
	}, 1500);
}

function handleChatKeyPress(event) {
	if (event.key === 'Enter') {
		sendMessage();
	}
}

function loadCounselors() {
    fetch('/MindHeaven/public/api/counselors', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(rows => {
            const cSel = document.getElementById('appointmentCounselor');
            if (!rows || !rows.length) { cSel.innerHTML = '<option value="">No counselors</option>'; return; }
            cSel.innerHTML = '<option value="">Select counselor</option>' + rows.map(c => `<option value="${c.id}">${c.full_name || c.username}</option>`).join('');
        })
        .catch(() => { document.getElementById('appointmentCounselor').innerHTML = '<option value="">Failed to load counselors</option>'; });
}

// ----------------------
// INITIALIZE PAGE
// ----------------------
document.addEventListener('DOMContentLoaded', function initializePage() {
    // populate types
    const types = ["individual","group","crisis","assessment","follow-up"];
    const select = document.getElementById('appointmentType');
    select.innerHTML = '<option value="">Select appointment type</option>' + 
        types.map(t => `<option value="${t}">${t.charAt(0).toUpperCase() + t.slice(1)}</option>`).join('');

    // load counselors from backend
    loadCounselors();

    // attach event listeners
    const form = document.getElementById('appointmentForm');
    form.addEventListener('submit', onAppointmentSubmit);
    document.getElementById('resetAppointmentForm').addEventListener('click', resetAppointmentForm);
    document.getElementById('importDemoAppointments').addEventListener('click', importDemoAppointments);
    document.getElementById('exportAppointmentsCsv').addEventListener('click', exportAppointmentsCsv);

    renderAppointments();
});

</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>
