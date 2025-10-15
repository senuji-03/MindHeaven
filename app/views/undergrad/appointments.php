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
						<input type="hidden" id="appointmentId" />
						<div class="form-grid">
							<div class="form-group">
								<label for="appointmentTitle" class="label">Appointment Title *</label>
								<input type="text" id="appointmentTitle" class="input" placeholder="e.g., Dr. Smith - Therapy Session" required />
								<div class="error-message" id="titleError"></div>
							</div>
							<div class="form-group">
								<label for="appointmentType" class="label">Appointment Type *</label>
								<select id="appointmentType" class="input" required>
									<option value="">Select appointment type</option>
									<option value="individual">Individual Counseling</option>
									<option value="group">Group Therapy</option>
									<option value="crisis">Crisis Support</option>
									<option value="assessment">Assessment</option>
									<option value="follow-up">Follow-up Session</option>
								</select>
								<div class="error-message" id="typeError"></div>
							</div>
							<div class="form-group">
								<label for="appointmentDate" class="label">Date *</label>
								<input type="date" id="appointmentDate" class="input" required />
								<div class="error-message" id="dateError"></div>
							</div>
							<div class="form-group">
								<label for="appointmentTime" class="label">Time *</label>
								<input type="time" id="appointmentTime" class="input" required />
								<div class="error-message" id="timeError"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="appointmentNotes" class="label">Notes (Optional)</label>
							<textarea id="appointmentNotes" class="input" rows="3" placeholder="Any specific concerns or topics you'd like to discuss..."></textarea>
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
							<span class="btn-icon">🖥️</span>
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
function initializePage() {
	// Populate types
	const types = window.MindHeaven.constants.appointmentTypes || {};
	const select = document.getElementById('appointmentType');
	select.innerHTML = Object.keys(types).map(t => `<option value="${t}">${t}</option>`).join('');

	// Wire events
	document.getElementById('appointmentForm').addEventListener('submit', onAppointmentSubmit);
	document.getElementById('resetAppointmentForm').addEventListener('click', resetAppointmentForm);
	document.getElementById('importDemoAppointments').addEventListener('click', importDemoAppointments);
	document.getElementById('exportAppointmentsCsv').addEventListener('click', exportAppointmentsCsv);

	renderAppointments();
}

function getAppointments() { return window.MindHeaven.getStorageItem('appointments', []); }
function saveAppointments(list) { window.MindHeaven.setStorageItem('appointments', list); }

function onAppointmentSubmit(e) {
	e.preventDefault();
	const form = e.target;
	if (!window.MindHeaven.validateForm(form)) return;

	const id = document.getElementById('appointmentId').value;
	const title = document.getElementById('appointmentTitle').value.trim();
	const type = document.getElementById('appointmentType').value;
	const date = document.getElementById('appointmentDate').value;
	const time = document.getElementById('appointmentTime').value;

	const list = getAppointments();
	if (id) {
		const idx = list.findIndex(a => String(a.id) === String(id));
		if (idx !== -1) {
			list[idx].title = title;
			list[idx].type = type;
			list[idx].date = date;
			list[idx].time = time;
		}
		window.MindHeaven.showAlert('Appointment updated!', 'success');
	} else {
		list.push({ id: Date.now(), title, type, date, time, status: 'scheduled' });
		window.MindHeaven.showAlert('Appointment booked!', 'success');
	}
	saveAppointments(list);
	resetAppointmentForm();
	renderAppointments();
}

function resetAppointmentForm() {
	document.getElementById('appointmentId').value = '';
	document.getElementById('appointmentForm').reset();
}

function renderAppointments() {
	const tbody = document.getElementById('appointmentsTableBody');
	const empty = document.getElementById('appointmentsEmptyState');
	const list = getAppointments();
	if (!list.length) {
		empty.style.display = 'block';
		tbody.innerHTML = '';
		return;
	}
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
	const list = getAppointments();
	const a = list.find(x => String(x.id) === String(id));
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
	if (idx !== -1) {
		list[idx].status = status;
		saveAppointments(list);
	}
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
	btn.innerHTML = `<span class="btn-icon">🖥️</span><span>${isSharing ? 'Stop Sharing' : 'Share Screen'}</span>`;
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
</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>