<?php
$TITLE        = 'Call Responder — Crisis Dashboard';
$CURRENT_PAGE = 'responder_dashboard';
require BASE_PATH . '/app/views/layouts/header.php';
?>

<script crossorigin src="https://unpkg.com/@daily-co/daily-js"></script>

<!-- Notification ping sound (short, professional) -->
<audio id="notifSound" preload="auto">
	<source src="https://cdn.freesound.org/previews/352/352661_4019029-lq.mp3" type="audio/mpeg">
</audio>

<style>
/* ── PAGE LAYOUT ── */
.responder-page {
	max-width: 1200px;
	margin: 0 auto;
	padding: 40px 24px 100px;
}

.responder-page-header {
	margin-bottom: 48px;
}

.responder-page-header h1 {
	font-size: 2.2rem;
	font-weight: 700;
	color: var(--text-primary);
	margin: 0 0 12px;
	letter-spacing: -0.5px;
	display: flex;
	align-items: center;
	gap: 16px;
}

.responder-page-header h1 .pulse-icon {
	color: var(--crisis);
	animation: blink 1.5s infinite;
}

.responder-page-header p {
	font-size: 1rem;
	color: var(--text-secondary);
	max-width: 600px;
	line-height: 1.7;
	margin: 0;
}

@keyframes blink { 50% { opacity: 0.3; } }

.responder-layout {
	display: grid;
	grid-template-columns: 380px 1fr;
	gap: 32px;
	align-items: start;
}

@media (max-width: 1024px) {
	.responder-layout { grid-template-columns: 1fr; }
}

/* ── COMPONENT: PANEL (aligned with .card) ── */
.rp-panel {
	background: var(--surface);
	border: 1px solid var(--border);
	border-radius: var(--radius-lg);
	padding: 28px 24px;
	box-shadow: var(--shadow-sm);
	transition: all 0.3s ease;
}

.rp-panel:hover {
	box-shadow: var(--shadow-md);
}

.rp-panel-title {
	font-size: 1.05rem;
	font-weight: 600;
	color: var(--text-primary);
	margin: 0 0 24px;
	padding-bottom: 16px;
	border-bottom: 1px solid var(--border);
	display: flex;
	align-items: center;
	gap: 12px;
}

.rp-panel-title i {
	font-size: 1.1rem;
}

.rp-panel-title .badge {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 24px;
	height: 24px;
	padding: 0 8px;
	background: var(--crisis);
	color: #fff;
	border-radius: var(--radius-full);
	font-size: 0.75rem;
	font-weight: 700;
	margin-left: auto;
}

/* ── CALL QUEUE ITEMS ── */
.call-item {
	background: var(--bg-mid);
	border: 1.5px solid transparent;
	border-radius: var(--radius-md);
	padding: 16px 18px;
	margin-bottom: 12px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 16px;
	transition: all 0.25s ease;
}

.call-item:hover {
	background: var(--surface);
	border-color: var(--primary-light);
	box-shadow: var(--shadow-md);
	transform: translateX(4px);
}

.call-item:last-child { margin-bottom: 0; }

.call-item__info .name {
	font-size: 0.95rem;
	font-weight: 700;
	color: var(--text-primary);
	margin-bottom: 6px;
	display: flex;
	align-items: center;
	gap: 8px;
	flex-wrap: wrap;
}

.call-item__info .badge-emergency {
	font-size: 0.65rem;
	background: var(--crisis);
	color: #fff;
	padding: 2px 8px;
	border-radius: 4px;
	font-weight: 700;
	letter-spacing: 1px;
}

.call-item__info .wait-time {
	font-size: 0.8rem;
	color: var(--text-secondary);
	display: flex;
	align-items: center;
	gap: 5px;
}

/* ── WORKSPACE ── */
.rp-workspace {
	display: flex;
	flex-direction: column;
	min-height: 600px;
}

.rp-no-call {
	flex: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	color: var(--text-secondary);
	background: var(--bg-soft);
	border-radius: var(--radius-lg);
	border: 2px dashed var(--border);
	padding: 80px 24px;
	text-align: center;
	gap: 16px;
}

.rp-no-call i {
	font-size: 3.5rem;
	opacity: 0.3;
	margin-bottom: 8px;
	color: var(--primary);
}

.rp-no-call p { margin: 0; font-size: 0.95rem; }

/* Active call state */
.rp-active-call { display: flex; flex-direction: column; flex: 1; gap: 24px; }

.rp-call-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	background: var(--bg-deep);
	border-radius: var(--radius-md);
	padding: 18px 24px;
	gap: 20px;
	box-shadow: var(--shadow-md);
}

.rp-call-header__left {
	display: flex;
	align-items: center;
	gap: 16px;
}

.rp-caller-avatar {
	width: 48px;
	height: 48px;
	background: var(--crisis);
	border-radius: var(--radius-full);
	display: flex;
	align-items: center;
	justify-content: center;
	color: #fff;
	font-size: 1.2rem;
	box-shadow: 0 4px 12px rgba(214, 79, 79, 0.3);
}

.rp-caller-name {
	font-size: 1.1rem;
	font-weight: 700;
	color: #fff;
	margin: 0 0 4px;
}

.rp-call-duration {
	font-size: 0.85rem;
	color: var(--primary-light);
	display: flex;
	align-items: center;
	gap: 8px;
	font-weight: 500;
}

.rp-call-duration .dot {
	width: 8px;
	height: 8px;
	border-radius: var(--radius-full);
	background: var(--primary-light);
	animation: blink 1.5s infinite;
}

/* Daily iframe container */
.rp-iframe-wrap {
	width: 100%;
	height: 320px;
	background: #0d1117;
	border-radius: var(--radius-md);
	overflow: hidden;
	box-shadow: var(--shadow-sm);
	border: 1px solid var(--border);
}

/* Notes section */
.rp-notes-label {
	font-size: 0.82rem;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 1px;
	color: var(--primary);
	margin-bottom: 10px;
	display: flex;
	align-items: center;
	gap: 8px;
}

.rp-notes-textarea {
	width: 100%;
	min-height: 160px;
	padding: 16px;
	border: 1.5px solid var(--border);
	border-radius: var(--radius-sm);
	background: var(--surface);
	color: var(--text-primary);
	font-family: inherit;
	font-size: 0.9rem;
	line-height: 1.6;
	resize: vertical;
	transition: all 0.25s ease;
	box-sizing: border-box;
}

.rp-notes-textarea:focus {
	outline: none;
	border-color: var(--primary);
	box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
	background: #fff;
}

.rp-actions {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 16px;
	flex-wrap: wrap;
	padding-top: 8px;
}

/* Global button override for consistency */
.btn-responder {
	border-radius: var(--radius-full);
	font-weight: 600;
	display: inline-flex;
	align-items: center;
	gap: 8px;
	transition: all 0.3s ease;
	cursor: pointer;
}
</style>

<div class="responder-page">

	<!-- Page Header -->
	<div class="responder-page-header">
		<h1>
			<i class="fas fa-headset pulse-icon"></i>
			Crisis Responder Dashboard
		</h1>
		<p>Monitor incoming crisis calls and connect instantly. The queue refreshes every 3 seconds.</p>
	</div>

	<div class="responder-layout">

		<!-- ── LEFT PANEL: CALL QUEUE ── -->
		<div class="rp-panel">
			<h2 class="rp-panel-title">
				<i class="fas fa-bell" style="color:var(--crisis);"></i>
				Incoming Calls
				<span class="badge" id="queueCount" style="display:none;">0</span>
			</h2>
			<div id="waitingCallsList">
				<p style="color:var(--text-secondary);font-size:0.88rem;text-align:center;padding:24px 0;">
					<i class="fas fa-radar" style="opacity:0.4;"></i><br>Polling for incoming callers…
				</p>
			</div>
		</div>

		<!-- ── RIGHT PANEL: ACTIVE WORKSPACE ── -->
		<div class="rp-panel rp-workspace">
			<h2 class="rp-panel-title">
				<i class="fas fa-phone-volume" style="color:var(--primary);"></i>
				Active Call Workspace
			</h2>

			<!-- Empty state -->
			<div id="noCallState" class="rp-no-call">
				<i class="fas fa-headset"></i>
				<p>No active call.</p>
				<p style="font-size:0.82rem;">Answer a call from the queue to begin.</p>
			</div>

			<!-- Active call (hidden by default) -->
			<div id="activeCallContainer" class="rp-active-call" style="display:none;">

				<!-- Call header bar -->
				<div class="rp-call-header">
					<div class="rp-call-header__left">
						<div class="rp-caller-avatar"><i class="fas fa-user"></i></div>
						<div>
							<p class="rp-caller-name" id="currentCallerName">—</p>
							<p class="rp-call-duration">
								<span class="dot"></span>
								Connected &nbsp;<span id="callDuration">00:00</span>
							</p>
						</div>
					</div>
					<button class="btn btn-responder" style="background:var(--crisis); color:#fff; border:none;" onclick="endCall()">
						<i class="fas fa-phone-slash"></i> Wrap Up
					</button>
				</div>

				<!-- Daily.co iframe -->
				<div class="rp-iframe-wrap" id="dailyIframePlaceholder"></div>

				<!-- Intervention notes -->
				<div>
					<label class="rp-notes-label" for="callNotes">
						<i class="fas fa-file-medical"></i>
						Intervention Notes <span style="font-weight:400;color:var(--text-secondary); text-transform: none; letter-spacing: 0;">(Internal Only)</span>
					</label>
					<textarea id="callNotes" class="rp-notes-textarea"
						placeholder="Document risk level, coping strategies discussed, follow-up plan…"></textarea>
				</div>

				<!-- Actions row -->
				<div class="rp-actions">
					<p style="font-size:0.78rem;color:var(--text-secondary);margin:0;">
						<i class="fas fa-lock"></i> Notes are private and never shared
					</p>
					<div style="display:flex; gap:12px;">
						<button class="btn btn-responder btn-outline" style="border-color:var(--crisis); color:var(--crisis);" onclick="escalateCall()">
							<i class="fas fa-arrow-up"></i> Escalate to Counselor
						</button>
						<button class="btn btn-responder btn-primary" onclick="saveNotes()">
							<i class="fas fa-floppy-disk"></i> Save & Close Record
						</button>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

<script>
let currentCallId    = null;
let currentCallFrame = null;
let pollInterval     = null;
let callTimerInt     = null;
let callStartTs      = null;
let lastKnownCount   = 0;

// ── POLLING ───────────────────────────────────────────────────
async function fetchWaitingCalls() {
	try {
		const res  = await fetch('/MindHeaven/public/api/crisis/waiting');
		if (!res.ok) return;
		const data = await res.json();
		const calls = data.calls || [];

		// Audio notification when new caller arrives
		if (calls.length > lastKnownCount) {
			playNotification();
		}
		lastKnownCount = calls.length;

		// Update badge count
		const badge = document.getElementById('queueCount');
		if (calls.length > 0) {
			badge.textContent = calls.length;
			badge.style.display = 'inline-flex';
		} else {
			badge.style.display = 'none';
		}

		// Render list
		const list = document.getElementById('waitingCallsList');
		if (calls.length === 0) {
			list.innerHTML = `
				<p style="color:var(--text-secondary);font-size:0.88rem;text-align:center;padding:24px 0;">
					<i class="fas fa-check-circle" style="color:var(--success);opacity:0.6;font-size:1.4rem;display:block;margin-bottom:8px;"></i>
					No callers waiting right now.
				</p>`;
			return;
		}

		list.innerHTML = calls.map(c => {
			const waitSince = new Date(c.created_at);
			const ago = getTimeAgo(waitSince);
			return `
			<div class="call-item" id="call-${c.id}">
				<div class="call-item__info">
					<div class="name">
						${escapeHtml(c.caller_name || 'Anonymous Student')}
						<span class="badge-emergency">EMERGENCY</span>
					</div>
					<div class="wait-time"><i class="fas fa-clock"></i> Waiting ${ago}</div>
				</div>
				<button class="btn btn-responder btn-primary" style="padding: 8px 18px; font-size: 0.82rem;" id="answerBtn-${c.id}"
					onclick="answerCall(${c.id}, '${escapeAttr(c.caller_name || 'Anonymous')}', this)">
					<i class="fas fa-phone"></i> Answer
				</button>
			</div>`;
		}).join('');

	} catch (err) {
		console.error('Poll error:', err);
	}
}

// ── NOTIFICATION SOUND ────────────────────────────────────────
function playNotification() {
	const audio = document.getElementById('notifSound');
	if (audio) {
		audio.currentTime = 0;
		audio.play().catch(() => {}); // Browser may block until user interacts
	}
}

// ── ANSWER CALL ───────────────────────────────────────────────
async function answerCall(callId, callerName, btn) {
	if (currentCallId) {
		alert('You are already on a call. Please wrap it up first.');
		return;
	}

	// Show loading state on button
	const origHTML = btn.innerHTML;
	btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Connecting…';
	btn.disabled   = true;

	try {
		const res  = await fetch('/MindHeaven/public/api/crisis/answer', {
			method:  'POST',
			headers: { 'Content-Type': 'application/json' },
			body:    JSON.stringify({ call_id: callId })
		});
		const data = await res.json();

		if (data.error) {
			alert(data.error);
			btn.innerHTML = origHTML;
			btn.disabled  = false;
			return;
		}

		if (!data.url) {
			alert('Could not retrieve call room. Please try again.');
			btn.innerHTML = origHTML;
			btn.disabled  = false;
			return;
		}

		// ── Transition to workspace ──
		currentCallId = callId;
		document.getElementById('currentCallerName').textContent = callerName;
		document.getElementById('noCallState').style.display        = 'none';
		document.getElementById('activeCallContainer').style.display = 'flex';

		// Launch Daily.co iframe
		const placeholder = document.getElementById('dailyIframePlaceholder');
		placeholder.innerHTML = '';

		currentCallFrame = window.DailyIframe.createFrame(placeholder, {
			iframeStyle: {
				width:           '100%',
				height:          '100%',
				border:          '0',
				borderRadius:    '12px',
				backgroundColor: '#0d1117'
			},
			dailyConfig: {
				startVideoOff: true,  // Audio-only
				startAudioOff: false
			}
		});

		currentCallFrame.on('joined-meeting', ()  => startCallTimer());
		currentCallFrame.on('left-meeting',   ()  => endCallUI());
		currentCallFrame.on('error',          (e) => console.error('Daily error:', e));

		await currentCallFrame.join({ url: data.url });

		// Refresh queue to remove answered call
		fetchWaitingCalls();

	} catch (err) {
		console.error('Answer error:', err);
		alert('Failed to connect to the call. Please try again.');
		btn.innerHTML = origHTML;
		btn.disabled  = false;
	}
}

// ── TIMER HELPERS ─────────────────────────────────────────────
function startCallTimer() {
	callStartTs  = Date.now();
	callTimerInt = setInterval(() => {
		const s   = Math.floor((Date.now() - callStartTs) / 1000);
		const m   = String(Math.floor(s / 60)).padStart(2, '0');
		const sec = String(s % 60).padStart(2, '0');
		document.getElementById('callDuration').textContent = `${m}:${sec}`;
	}, 1000);
}

function stopCallTimer() {
	if (callTimerInt) { clearInterval(callTimerInt); callTimerInt = null; }
	const el = document.getElementById('callDuration');
	if (el) el.textContent = '00:00';
}

// ── END CALL ──────────────────────────────────────────────────
function endCallUI() {
	if (currentCallFrame) {
		try { currentCallFrame.leave();   } catch(e) {}
		try { currentCallFrame.destroy(); } catch(e) {}
		currentCallFrame = null;
	}
	stopCallTimer();
}

function endCall() {
	endCallUI();
	// Notes area stays open for the responder to write — "Save & Close" finalises
}

// ── SAVE NOTES & CLOSE ────────────────────────────────────────
async function saveNotes() {
	if (!currentCallId) {
		alert('No active call record to save.');
		return;
	}

	const notes = document.getElementById('callNotes').value.trim();

	try {
		const res  = await fetch('/MindHeaven/public/api/crisis/update', {
			method:  'POST',
			headers: { 'Content-Type': 'application/json' },
			body:    JSON.stringify({ call_id: currentCallId, status: 'completed', notes })
		});
		const data = await res.json();

		if (data.success) {
			// Reset workspace
			document.getElementById('callNotes').value = '';
			document.getElementById('activeCallContainer').style.display = 'none';
			document.getElementById('noCallState').style.display          = 'flex';
			currentCallId = null;
			fetchWaitingCalls();

			// Success toast
			showToast('Call record saved successfully.', 'success');
		} else {
			alert(data.error || 'Failed to save record.');
		}
	} catch (err) {
		alert('Network error while saving. Please try again.');
	}
}

// ── ESCALATE CALL ─────────────────────────────────────────────
async function escalateCall() {
	if (!currentCallId) {
		alert('No active call record to escalate.');
		return;
	}

	const notes = document.getElementById('callNotes').value.trim();

	if (!confirm("Are you sure you want to escalate this call to an available counselor?")) {
		return;
	}

	try {
        // We set status to escalated. The back-end handles placing it in the Counselor queue.
		const res  = await fetch('/MindHeaven/public/api/crisis/update', {
			method:  'POST',
			headers: { 'Content-Type': 'application/json' },
			body:    JSON.stringify({ call_id: currentCallId, status: 'escalated', notes })
		});
		const data = await res.json();

		if (data.success) {
			// Update UI to show escalated state instead of closing
			const callerNameEl = document.getElementById('currentCallerName');
			if (callerNameEl && !callerNameEl.innerHTML.includes('Escalated')) {
				callerNameEl.innerHTML += ' <span style="font-size:0.75rem; color:var(--accent-warm); font-weight:600; vertical-align:middle; margin-left:8px;">(Escalated to Counselor)</span>';
			}

			const durationEl = document.querySelector('.rp-call-duration');
			if (durationEl) {
				durationEl.innerHTML = '<span class="dot" style="background:var(--accent-warm)"></span> Waiting for Counselor to join...';
			}

			// Disable the escalate button to prevent double-click
			const escBtn = document.querySelector('button[onclick="escalateCall()"]');
			if (escBtn) {
				escBtn.disabled = true;
				escBtn.style.opacity = '0.6';
				escBtn.style.cursor = 'not-allowed';
				escBtn.innerHTML = '<i class="fas fa-check"></i> Escalated';
			}

			// Success toast
			showToast('Call escalated successfully! Please stay on the line until a counselor joins.', 'success');
			
			// Refresh queue in background
			fetchWaitingCalls();
		} else {
			alert(data.error || 'Failed to escalate record.');
		}
	} catch (err) {
		alert('Network error while saving. Please try again.');
	}
}

// ── UTILITY ───────────────────────────────────────────────────
function getTimeAgo(date) {
	const secs = Math.floor((Date.now() - date.getTime()) / 1000);
	if (secs < 60)  return `${secs}s`;
	if (secs < 3600) return `${Math.floor(secs/60)}m ${secs%60}s`;
	return `${Math.floor(secs/3600)}h ${Math.floor((secs%3600)/60)}m`;
}

function escapeHtml(str) {
	return String(str)
		.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
		.replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

function escapeAttr(str) {
	return String(str).replace(/'/g, "\\'");
}

function showToast(msg, type = 'success') {
	const d = document.createElement('div');
	const bg = type === 'success' ? 'var(--success)' : 'var(--crisis)';
	d.style.cssText = `
		position:fixed;top:24px;right:24px;z-index:99999;
		background:${bg};color:#fff;padding:12px 20px;
		border-radius:var(--radius-md);font-weight:600;font-size:.88rem;
		box-shadow:var(--shadow-lg);max-width:340px;
		display:flex;align-items:center;gap:10px;
	`;
	d.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i><span>${escapeHtml(msg)}</span>`;
	document.body.appendChild(d);
	setTimeout(() => d.remove(), 5000);
}

// ── BOOT POLLING ──────────────────────────────────────────────
pollInterval = setInterval(fetchWaitingCalls, 3000);
fetchWaitingCalls(); // Initial call immediately
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>