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
/* ═══ RESPONDER LAYOUT ═══════════════════════════════════════ */
.responder-page {
	max-width: 1280px;
	margin: 0 auto;
	padding: 32px 24px 80px;
}

.responder-page-header {
	margin-bottom: 28px;
}

.responder-page-header h1 {
	font-size: 1.75rem;
	font-weight: 700;
	color: var(--text-primary);
	margin: 0 0 4px;
	display: flex;
	align-items: center;
	gap: 12px;
}

.responder-page-header h1 .pulse-icon {
	color: var(--crisis, #D64F4F);
	animation: blink 1.5s infinite;
}

.responder-page-header p {
	font-size: 0.9rem;
	color: var(--text-secondary);
	margin: 0;
}

@keyframes blink { 50% { opacity: 0.3; } }

.responder-layout {
	display: grid;
	grid-template-columns: 360px 1fr;
	gap: 24px;
	align-items: start;
}

@media (max-width: 900px) {
	.responder-layout { grid-template-columns: 1fr; }
}

/* ═══ PANELS ═════════════════════════════════════════════════ */
.rp-panel {
	background: var(--surface);
	border: 1px solid var(--border);
	border-radius: var(--radius-lg);
	padding: 24px;
	box-shadow: var(--shadow-sm);
}

.rp-panel-title {
	font-size: 1rem;
	font-weight: 700;
	color: var(--text-primary);
	margin: 0 0 20px;
	padding-bottom: 14px;
	border-bottom: 1px solid var(--border);
	display: flex;
	align-items: center;
	gap: 10px;
}

.rp-panel-title .badge {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 22px;
	height: 22px;
	padding: 0 6px;
	background: var(--crisis, #D64F4F);
	color: #fff;
	border-radius: 999px;
	font-size: 0.72rem;
	font-weight: 700;
	margin-left: auto;
}

/* ═══ CALL QUEUE ITEMS ═══════════════════════════════════════ */
.call-item {
	background: var(--bg-mid);
	border: 1px solid var(--border);
	border-radius: var(--radius-md);
	padding: 14px 16px;
	margin-bottom: 10px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 12px;
	transition: border-color .2s, box-shadow .2s;
}

.call-item:hover {
	border-color: var(--success, #4CAF82);
	box-shadow: 0 2px 12px rgba(76,175,130,.12);
}

.call-item:last-child { margin-bottom: 0; }

.call-item__info .name {
	font-size: 0.95rem;
	font-weight: 700;
	color: var(--text-primary);
	margin-bottom: 4px;
	display: flex;
	align-items: center;
	gap: 6px;
	flex-wrap: wrap;
}

.call-item__info .badge-emergency {
	font-size: 0.65rem;
	background: var(--crisis, #D64F4F);
	color: #fff;
	padding: 2px 7px;
	border-radius: 4px;
	font-weight: 700;
	letter-spacing: 0.5px;
}

.call-item__info .wait-time {
	font-size: 0.78rem;
	color: var(--text-secondary);
}

.btn-answer {
	background: #22c55e;
	color: #fff;
	border: none;
	border-radius: var(--radius-full, 999px);
	padding: 9px 18px;
	font-size: 0.85rem;
	font-weight: 600;
	cursor: pointer;
	display: inline-flex;
	align-items: center;
	gap: 7px;
	transition: background .2s, transform .15s;
	white-space: nowrap;
	flex-shrink: 0;
}

.btn-answer:hover  { background: #16a34a; transform: translateY(-1px); }
.btn-answer:active { transform: translateY(0); }
.btn-answer:disabled { background: #6b7280; cursor: not-allowed; transform: none; }

/* ═══ ACTIVE CALL WORKSPACE ══════════════════════════════════ */
.rp-workspace {
	display: flex;
	flex-direction: column;
	min-height: 580px;
}

.rp-no-call {
	flex: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	color: var(--text-secondary);
	background: var(--bg-soft);
	border-radius: var(--radius-md);
	border: 2px dashed var(--border);
	padding: 60px 24px;
	text-align: center;
	gap: 12px;
}

.rp-no-call i {
	font-size: 3rem;
	opacity: 0.35;
	margin-bottom: 8px;
}

.rp-no-call p { margin: 0; font-size: 0.9rem; }

/* Active call state */
.rp-active-call { display: flex; flex-direction: column; flex: 1; gap: 20px; }

.rp-call-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	background: var(--bg-deep, #1C2B2A);
	border-radius: var(--radius-md);
	padding: 16px 20px;
	gap: 16px;
}

.rp-call-header__left {
	display: flex;
	align-items: center;
	gap: 12px;
}

.rp-caller-avatar {
	width: 42px;
	height: 42px;
	background: var(--crisis, #D64F4F);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #fff;
	font-size: 1.1rem;
	flex-shrink: 0;
}

.rp-caller-name {
	font-size: 1rem;
	font-weight: 700;
	color: #fff;
	margin: 0 0 2px;
}

.rp-call-duration {
	font-size: 0.82rem;
	color: #4ade80;
	display: flex;
	align-items: center;
	gap: 6px;
}

.rp-call-duration .dot {
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: #4ade80;
	animation: blink 1.5s infinite;
}

/* Daily iframe container */
.rp-iframe-wrap {
	width: 100%;
	height: 280px;
	background: #0d1117;
	border-radius: var(--radius-md);
	overflow: hidden;
}

/* Notes section */
.rp-notes-label {
	font-size: 0.85rem;
	font-weight: 600;
	color: var(--text-primary);
	margin-bottom: 8px;
	display: block;
}

.rp-notes-textarea {
	width: 100%;
	min-height: 140px;
	padding: 12px 16px;
	border: 1.5px solid var(--border);
	border-radius: var(--radius-md);
	background: var(--bg-mid);
	color: var(--text-primary);
	font-family: inherit;
	font-size: 0.88rem;
	resize: vertical;
	transition: border-color .2s;
	box-sizing: border-box;
}

.rp-notes-textarea:focus {
	outline: none;
	border-color: var(--primary, #3D8B6E);
}

.rp-actions {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 12px;
	flex-wrap: wrap;
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
				<i class="fas fa-bell" style="color:var(--crisis,#D64F4F);"></i>
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
				<i class="fas fa-phone-volume" style="color:var(--primary,#3D8B6E);"></i>
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
					<button class="mh-btn mh-btn--danger" onclick="endCall()" style="flex-shrink:0;">
						<i class="fas fa-phone-slash"></i> Wrap Up
					</button>
				</div>

				<!-- Daily.co iframe -->
				<div class="rp-iframe-wrap" id="dailyIframePlaceholder"></div>

				<!-- Intervention notes -->
				<div>
					<label class="rp-notes-label" for="callNotes">
						<i class="fas fa-file-medical" style="color:var(--primary);"></i>
						Intervention Notes <span style="font-weight:400;color:var(--text-secondary);">(Internal Only)</span>
					</label>
					<textarea id="callNotes" class="rp-notes-textarea"
						placeholder="Document risk level, coping strategies discussed, follow-up plan…"></textarea>
				</div>

				<!-- Actions row -->
				<div class="rp-actions">
					<p style="font-size:0.78rem;color:var(--text-secondary);margin:0;">
						<i class="fas fa-lock"></i> Notes are private and never shared with the caller
					</p>
					<button class="mh-btn mh-btn--primary" onclick="saveNotes()">
						<i class="fas fa-floppy-disk"></i> Save & Close Record
					</button>
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
					<i class="fas fa-check-circle" style="color:var(--success,#4CAF82);opacity:0.6;font-size:1.4rem;display:block;margin-bottom:8px;"></i>
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
				<button class="btn-answer" id="answerBtn-${c.id}"
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
	const bg = type === 'success' ? '#22c55e' : '#D64F4F';
	d.style.cssText = `
		position:fixed;top:24px;right:24px;z-index:99999;
		background:${bg};color:#fff;padding:12px 20px;
		border-radius:12px;font-weight:600;font-size:.88rem;
		box-shadow:0 8px 24px rgba(0,0,0,.2);max-width:340px;
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