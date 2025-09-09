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
</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>