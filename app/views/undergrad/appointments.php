<?php
$TITLE = 'MindHeaven — Appointments';
$CURRENT_PAGE = 'appointments';
$PAGE_CSS = ["/MindHeaven/public/css/undergrad/appointments.css"];
$PAGE_JS = ["/MindHeaven/public/js/undergrad/appointments.js?v=" . time()];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<!-- ═══════════════════════════════════════════
	 BOOKING MODAL
═══════════════════════════════════════════ -->
<div id="bookingModal" class="mh-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle"
	style="display:none;">
	<div class="mh-modal">
		<!-- Modal Header -->
		<div class="mh-modal__header">
			<div class="mh-modal__header-left">
				<div class="mh-modal__icon">
					<i class="fas fa-calendar-plus"></i>
				</div>
				<div>
					<h2 id="modalTitle" class="mh-modal__title">Request an Appointment</h2>
					<p class="mh-modal__subtitle">Schedule your counseling session</p>
				</div>
			</div>
			<button type="button" class="mh-modal__close" onclick="closeBookingModal()" aria-label="Close">
				<i class="fas fa-times"></i>
			</button>
		</div>

		<!-- Modal Body -->
		<div class="mh-modal__body">
			<form id="appointmentForm" novalidate>
				<input type="hidden" id="appointmentId" name="appointmentId" />

				<!-- Row 1: Title + Type -->
				<div class="mh-form-row">
					<div class="mh-form-group mh-form-group--full">
						<label for="appointmentTitle" class="mh-label">
							<i class="fas fa-pen-clip"></i> Session Title <span class="mh-required">*</span>
						</label>
						<input type="text" id="appointmentTitle" name="title" class="mh-input"
							placeholder="e.g., Mental Health Check-in" required />
						<span class="mh-field-error" id="titleError"></span>
					</div>
				</div>

				<!-- Row 2: Type + Mode -->
				<div class="mh-form-row">
					<div class="mh-form-group">
						<label for="appointmentType" class="mh-label">
							<i class="fas fa-tag"></i> Session Type <span class="mh-required">*</span>
						</label>
						<select id="appointmentType" name="type" class="mh-input" required>
							<option value="">Loading types…</option>
						</select>
						<span class="mh-field-error" id="typeError"></span>
					</div>
					<div class="mh-form-group">
						<label for="appointmentMode" class="mh-label">
							<i class="fas fa-video"></i> Mode <span class="mh-required">*</span>
						</label>
						<select id="appointmentMode" name="mode" class="mh-input" required>
							<option value="">Select mode</option>
							<option value="audio_video">Audio / Video Call</option>
							<option value="chat">Chat</option>
						</select>
						<span class="mh-field-error" id="modeError"></span>
					</div>
				</div>

				<!-- Row 3: Counselor -->
				<div class="mh-form-row">
					<div class="mh-form-group mh-form-group--full">
						<label for="appointmentCounselor" class="mh-label">
							<i class="fas fa-user-doctor"></i> Counselor <span class="mh-required">*</span>
						</label>
						<select id="appointmentCounselor" name="counselor_user_id" class="mh-input" required>
							<option value="">Loading counselors…</option>
						</select>
						<span class="mh-field-error" id="counselorError"></span>
					</div>
				</div>

				<!-- Row 4: Date + Time Slot -->
				<div class="mh-form-row">
					<div class="mh-form-group">
						<label for="appointmentDate" class="mh-label">
							<i class="fas fa-calendar-days"></i> Date <span class="mh-required">*</span>
						</label>
						<select id="appointmentDate" name="date" class="mh-input" required disabled>
							<option value="">Select counselor first</option>
						</select>
						<span class="mh-field-error" id="dateError"></span>
					</div>
					<div class="mh-form-group">
						<label for="appointmentTime" class="mh-label">
							<i class="fas fa-clock"></i> Time Slot <span class="mh-required">*</span>
						</label>
						<select id="appointmentTime" name="time" class="mh-input" required disabled>
							<option value="">Select counselor &amp; date first</option>
						</select>
						<span class="mh-field-error" id="timeError"></span>
					</div>
				</div>

				<!-- Row 5: Notes -->
				<div class="mh-form-row">
					<div class="mh-form-group mh-form-group--full">
						<label for="appointmentNotes" class="mh-label">
							<i class="fas fa-note-sticky"></i> Notes <span class="mh-optional">(optional)</span>
						</label>
						<textarea id="appointmentNotes" name="notes" class="mh-input mh-textarea" rows="3"
							placeholder="Any specific concerns or topics you'd like to discuss…"></textarea>
					</div>
				</div>

				<!-- Actions -->
				<div class="mh-modal__actions">
					<button type="button" class="mh-btn mh-btn--outline" onclick="closeBookingModal()">
						<i class="fas fa-xmark"></i> Cancel
					</button>
					<button type="button" id="resetAppointmentForm" class="mh-btn mh-btn--ghost">
						<i class="fas fa-rotate-left"></i> Reset
					</button>
					<button type="submit" class="mh-btn mh-btn--primary" id="submitAppointmentBtn">
						<i class="fas fa-calendar-check"></i>
						<span id="submitBtnText">Save Appointment</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ═══════════════════════════════════════════
	 JOIN PREFERENCE MODAL
═══════════════════════════════════════════ -->
<div id="joinPreferenceModal" class="mh-modal-overlay" style="display:none;z-index:9999;">
	<div class="mh-modal" style="max-width:380px;text-align:center;padding:30px;">
		<div style="font-size:3rem;color:var(--primary);margin-bottom:15px;">
			<i class="fas fa-headset"></i>
		</div>
		<h3 style="margin-bottom:10px;font-size:1.4rem;">Choose Call Mode</h3>
		<p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:25px;">
			How would you like to join your counseling session today?
		</p>

		<div style="display:flex;flex-direction:column;gap:12px;margin-bottom:20px;">
			<button class="mh-btn mh-btn--primary" id="btnJoinVideo" style="width:100%;justify-content:center;">
				<i class="fas fa-video"></i> Audio & Video Call
			</button>
			<button class="mh-btn mh-btn--outline" id="btnJoinAudio" style="width:100%;justify-content:center;">
				<i class="fas fa-microphone"></i> Audio Only
			</button>
		</div>

		<button class="mh-btn mh-btn--ghost" onclick="document.getElementById('joinPreferenceModal').style.display='none'" style="font-size:0.85rem;color:var(--text-secondary);">
			Go Back
		</button>
	</div>
</div>

<!-- ═══════════════════════════════════════════
	 COUNSELOR NO-SHOW MODAL
═══════════════════════════════════════════ -->
<div id="noShowModal" class="mh-modal-overlay" style="display:none;z-index:9999;">
	<div class="mh-modal" style="max-width:500px;">
		<div class="mh-modal__header">
			<h2 class="mh-modal__title" style="color:var(--crisis);">
				<i class="fas fa-user-slash"></i> Report Counselor Absence
			</h2>
			<button class="mh-modal__close" onclick="closeNoShowModal()">&times;</button>
		</div>
		<div class="mh-modal__body">
			<form id="noShowForm" onsubmit="event.preventDefault(); submitNoShowReport();">
				<input type="hidden" id="noShowAppointmentId" value="">
				
				<p style="font-size:0.92rem; color:var(--text-secondary); margin-bottom:1.5rem; line-height:1.5;">
					We're sorry the counselor hasn't joined the session. Please provide any feedback or details below. This will mark the session as a "No-Show" and our administrators will review the report.
				</p>

				<div class="mh-form-group">
					<label for="noShowFeedback" class="mh-label">Feedback / Details <span class="mh-required">*</span></label>
					<textarea id="noShowFeedback" class="mh-input mh-textarea" rows="4" required 
						placeholder="E.g., I waited for 30 minutes but the counselor never joined the video call..."></textarea>
				</div>

				<div class="mh-modal__actions" style="margin-top:2rem;">
					<button type="button" class="mh-btn mh-btn--outline" onclick="closeNoShowModal()">Cancel</button>
					<button type="submit" class="mh-btn mh-btn--danger" id="submitNoShowBtn">
						<i class="fas fa-flag"></i> Submit Report
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ═══════════════════════════════════════════
	 MAIN PAGE
═══════════════════════════════════════════ -->
<main id="main" class="mh-appointments-page">

	<!-- Page Header -->
	<div class="mh-page-header">
		<div class="mh-page-header__inner">
			<div class="mh-page-header__text">
				<span class="mh-section-label">WELLNESS PORTAL</span>
				<h1 class="mh-page-title">Your Appointments</h1>
				<p class="mh-page-desc">Schedule and manage your confidential counseling sessions.</p>
			</div>
		</div>
	</div>

	<!-- Stats Row -->
	<div class="mh-stats-row">
		<div class="mh-stat-card mh-stat-card--teal">
			<div class="mh-stat-card__icon"><i class="fas fa-calendar-days"></i></div>
			<div class="mh-stat-card__body">
				<div class="mh-stat-card__value" id="totalAppointments">—</div>
				<div class="mh-stat-card__label">Total Sessions</div>
			</div>
		</div>
		<div class="mh-stat-card mh-stat-card--apricot">
			<div class="mh-stat-card__icon"><i class="fas fa-clock"></i></div>
			<div class="mh-stat-card__body">
				<div class="mh-stat-card__value" id="upcomingAppointments">—</div>
				<div class="mh-stat-card__label">Upcoming</div>
			</div>
		</div>
		<div class="mh-stat-card mh-stat-card--mint">
			<div class="mh-stat-card__icon"><i class="fas fa-circle-check"></i></div>
			<div class="mh-stat-card__body">
				<div class="mh-stat-card__value" id="completedAppointments">—</div>
				<div class="mh-stat-card__label">Completed</div>
			</div>
		</div>
		<div class="mh-stat-card mh-stat-card--sky">
			<div class="mh-stat-card__icon"><i class="fas fa-chart-line"></i></div>
			<div class="mh-stat-card__body">
				<div class="mh-stat-card__value" id="attendanceRate">—</div>
				<div class="mh-stat-card__label">Attendance Rate</div>
			</div>
		</div>
	</div>

	<!-- Daily.co JS -->
	<script crossorigin src="https://unpkg.com/@daily-co/daily-js"></script>

	<!-- Daily Call Fullscreen Container -->
	<div id="dailyCallContainer"
		style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; z-index:999999; background:#000;">
		<div style="position:absolute; top:20px; left:20px; z-index:100;">
			<button class="mh-btn mh-btn--danger" onclick="leaveDailyCall()"
				style="box-shadow:0 4px 12px rgba(0,0,0,0.5);">
				<i class="fas fa-phone-slash"></i> Leave Session
			</button>
		</div>
		<div id="dailyIframePlaceholder" style="width:100%; height:100%;"></div>
	</div>

	<!-- Active Session Component (Populated by JS) -->
	<div id="activeSessionContainer"></div>

	<!-- Upcoming Appointments Table Card -->

	<div class="mh-table-card" style="margin-bottom: 24px; border-top: 4px solid var(--apricot);">
		<div class="mh-table-card__header">
			<div>
				<h2 class="mh-table-card__title" style="color: var(--apricot);"><i class="fas fa-clock"></i> Upcoming
					Sessions</h2>
				<p class="mh-table-card__sub">Your next scheduled counseling appointments</p>
			</div>
		</div>

		<!-- Upcoming Table -->
		<div class="mh-table-wrap">
			<table class="mh-table">
				<thead>
					<tr>
						<th>Session</th>
						<th>Type</th>
						<th>Mode</th>
						<th>Counselor</th>
						<th>Date</th>
						<th>Time</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="upcomingAppointmentsTableBody">
					<tr>
						<td colspan="8" class="mh-table__loading">
							No upcoming sessions right now. Let's book one!
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Booking Call-to-Action -->
	<div class="mh-booking-cta-section">
		<div class="mh-booking-cta">
			<div class="mh-booking-cta__content">
				<h3 class="mh-booking-cta__title">Need someone to talk to?</h3>
				<p class="mh-booking-cta__text">Meet our volunteering experienced professional counselor session free. We are here to support you.</p>
			</div>
			<button class="mh-btn mh-btn--primary mh-btn--lg" onclick="openBookingModal()">
				<i class="fas fa-calendar-check"></i> Request a Session
			</button>
		</div>
	</div>

	<!-- Our Counselors Card -->
	<div class="mh-table-card" style="margin-bottom: 24px; border-top: 4px solid var(--primary);">
		<div class="mh-table-card__header">
			<div>
				<h2 class="mh-table-card__title" style="color: var(--primary);"><i class="fas fa-user-doctor"></i> Our Counselors</h2>
				<p class="mh-table-card__sub">Meet our dedicated counseling team</p>
			</div>
		</div>

		<div class="mh-counselor-grid">
			<?php if (!empty($counselors)): ?>
				<?php foreach ($counselors as $c): 
					$fullName = htmlspecialchars($c['full_name'] ?: $c['username']);
					$spec = htmlspecialchars($c['specialization'] ?: 'General Counseling');
					$rating = !empty($c['avg_rating']) ? number_format((float)$c['avg_rating'], 1) : null;
					$exp = !empty($c['years_experience']) ? (int)$c['years_experience'] . ' Years Exp.' : '';
					$bio = !empty($c['bio']) ? htmlspecialchars($c['bio']) : 'A dedicated professional ready to help you navigate your mental health journey.';
					$quals = !empty($c['qualifications']) ? htmlspecialchars($c['qualifications']) : '';
					
					$picStr = !empty($c['profile_picture']) ? $c['profile_picture'] : '';
					$pic = $picStr ? (strpos($picStr, 'http') === 0 ? htmlspecialchars($picStr) : BASE_URL . '/' . htmlspecialchars(ltrim($picStr, '/'))) : BASE_URL . '/public/images/default-avatar.png';
				?>
				<div class="mh-counselor-card">
					<img src="<?= $pic ?>" alt="<?= $fullName ?>" class="mh-counselor-img" onerror="this.src='<?= BASE_URL ?>/public/images/default-avatar.png'">
					<div class="mh-counselor-info">
						<div style="display:flex; justify-content:space-between; align-items:flex-start;">
							<h3 class="mh-counselor-name"><?= $fullName ?></h3>
						</div>
						<div class="mh-counselor-spec" style="margin-bottom: 2px;">
							<?= $spec ?><?= $exp ? " &bull; $exp" : '' ?>
						</div>
						<div class="mh-counselor-quals" style="font-size: 0.78rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 500; display: flex; align-items: center; gap: 5px;">
							<i class="fas fa-certificate" style="color: var(--primary-light); font-size: 0.7rem;"></i>
							<?= $quals ?: 'Licensed Professional' ?>
						</div>
						
						<div class="mh-counselor-availability">
							<span class="mh-availability-label"><i class="far fa-clock"></i> Next Available:</span>
							<div class="mh-slot-pills">
								<?php 
								if (!empty($c['available_slots'])):
									$slotsArr = explode(';', $c['available_slots']);
									$maxSlots = 3;
									for ($i = 0; $i < min(count($slotsArr), $maxSlots); $i++):
										$slotParts = explode('|', $slotsArr[$i]);
										if (count($slotParts) === 2):
											$sDate = $slotParts[0];
											$sTime = $slotParts[1];
											$displayTime = date('g:i A', strtotime($sTime));
											$displayDate = date('M j', strtotime($sDate));
								?>
									<button class="mh-slot-pill" onclick="openBookingModalWithSlot(<?= (int)$c['user_id'] ?>, '<?= htmlspecialchars($sDate) ?>', '<?= htmlspecialchars($sTime) ?>')" title="Quick book for <?= $displayDate ?> at <?= $displayTime ?>">
										<?= $displayDate ?>, <?= $displayTime ?>
									</button>
								<?php 
										endif;
									endfor; 
								?>
								<?php if (count($slotsArr) > $maxSlots): ?>
									<span class="mh-slot-more" title="Click 'Book Session' to see all available times">+<?= count($slotsArr) - $maxSlots ?> more</span>
								<?php endif; ?>
								<?php else: ?>
									<span class="mh-no-slots">No upcoming slots found</span>
								<?php endif; ?>
							</div>
						</div>

						<p class="mh-counselor-bio"><?= strlen($bio) > 100 ? substr($bio, 0, 97) . '...' : $bio ?></p>
						
						<!-- Open Booking Modal and pre-select this counselor -->
						<button class="mh-btn mh-btn--primary mh-btn--sm" style="width:100%;margin-top:auto;" onclick="openBookingModalForCounselor(<?= $c['user_id'] ?>)">
							Book Session
						</button>
					</div>
				</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="mh-empty-state" style="padding: 2rem; width: 100%; grid-column: 1 / -1; border-radius: 0 0 var(--radius-lg) var(--radius-lg); border-top: 1px solid var(--border);">
					<p>No counselors available at the moment.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- All Appointments Table Card -->
	<div class="mh-table-card">
		<div class="mh-table-card__header">
			<div>
				<h2 class="mh-table-card__title"><i class="fas fa-list-ul"></i> All Appointments</h2>
				<p class="mh-table-card__sub">Your complete counseling history</p>
			</div>
			<div class="mh-table-card__actions">
				<button id="exportAppointmentsCsv" class="mh-btn mh-btn--outline mh-btn--sm">
					<i class="fas fa-file-csv"></i> Export CSV
				</button>
			</div>
		</div>

		<!-- Empty State -->
		<div id="appointmentsEmptyState" class="mh-empty-state" style="display:none;">
			<div class="mh-empty-state__icon"><i class="fas fa-calendar-xmark"></i></div>
			<h3 class="mh-empty-state__title">No appointments yet</h3>
			<p class="mh-empty-state__desc">Book your first counseling session to get started on your wellness journey.
			</p>
			<button class="mh-btn mh-btn--primary" onclick="openBookingModal()">
				<i class="fas fa-plus"></i> Request Now
			</button>
		</div>

		<!-- Table -->
		<div class="mh-table-wrap">
			<table class="mh-table">
				<thead>
					<tr>
						<th>Session</th>
						<th>Type</th>
						<th>Mode</th>
						<th>Counselor</th>
						<th>Date</th>
						<th>Time</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="appointmentsTableBody">
					<tr>
						<td colspan="8" class="mh-table__loading">
							<span class="mh-spinner"></span> Loading appointments…
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</main>

<!-- Hidden helpers for demo/import kept for backward compat -->
<button id="importDemoAppointments" style="display:none;"></button>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>