<?php
$TITLE      = 'MindHeaven — Crisis Support';
$CURRENT_PAGE = 'crisis';
$PAGE_CSS   = ['/MindHeaven/public/css/undergrad/crisis.css'];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<!-- Daily.co JS (audio-only hotline) -->
<script crossorigin src="https://unpkg.com/@daily-co/daily-js"></script>

<div class="mh-crisis-page">

	<!-- ════ PAGE HEADER ════ -->
	<header class="mh-crisis-header">
		<div class="mh-crisis-header__inner">
			<div>
				<span class="mh-crisis-header__label">EMERGENCY SUPPORT</span>
				<h1 class="mh-crisis-header__title">Crisis Support</h1>
				<p class="mh-crisis-header__desc">
					You're not alone. Immediate help is available 24 hours a day, 7 days a week.
				</p>
			</div>
			<div class="mh-crisis-header__actions">
				<a href="tel:988" class="mh-btn mh-btn--crisis mh-btn--lg">
					<i class="fas fa-phone-alt"></i> Call 988
				</a>
				<a href="tel:119" class="mh-btn mh-btn--ghost-light mh-btn--lg">
					<i class="fas fa-truck-medical"></i> Call 119
				</a>
			</div>
		</div>
	</header>

	<div class="mh-crisis-content">

		<!-- ════ MINDHEAVEN AUDIO HOTLINE BANNER ════ -->
		<div class="mh-hotline-banner" id="hotlineBanner">
			<div class="mh-hotline-banner__left">
				<div class="mh-hotline-icon">
					<i class="fas fa-headset"></i>
				</div>
				<div>
					<h2 class="mh-hotline-banner__title">MindHeaven Live Crisis Hotline</h2>
					<p class="mh-hotline-banner__desc">
						Connect instantly with a trained MindHeaven Crisis Responder via secure audio call. Completely private — no camera, no video.
					</p>
					<div class="mh-hotline-status">
						<span class="mh-status-dot"></span>
						Responders Available &nbsp;·&nbsp; Avg. wait &lt; 1 min
					</div>
				</div>
			</div>
			<button class="mh-btn mh-btn--crisis mh-btn--lg" id="connectBtn" onclick="requestCrisisAudioCall()">
				<i class="fas fa-phone-volume"></i> Connect Now
			</button>
		</div>

		<!-- ════ CRISIS CALL POPUP MODAL ════ -->
		<div class="mh-crisis-modal-backdrop" id="crisisModalBackdrop" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Crisis Audio Call">
			<div class="mh-crisis-modal" id="crisisAudioContainer">

				<!-- Modal Header -->
				<div class="mh-crisis-modal__header">
					<div class="mh-crisis-modal__status">
						<span class="mh-status-dot mh-status-dot--live"></span>
						<h3 class="mh-crisis-modal__title">Crisis Audio Call</h3>
						<span class="mh-call-badge"><i class="fas fa-circle"></i> LIVE</span>
					</div>
					<div class="mh-crisis-modal__meta">
						<span class="mh-call-timer" id="callTimer">00:00</span>
						<button class="mh-btn mh-btn--danger-soft mh-btn--sm" id="endCallBtn" onclick="endCrisisCall()">
							<i class="fas fa-phone-slash"></i> End Call
						</button>
					</div>
				</div>

				<!-- Connecting State -->
				<div id="crisisConnectingState" class="mh-connecting-state">
					<div class="mh-loading-pulse" id="crisisLoadingIcon">
						<i class="fas fa-headset" id="crisisLoadingIco"></i>
					</div>
					<h4 class="mh-connecting-state__title" id="crisisConnectingTitle">Connecting you to a responder…</h4>
					<p class="mh-connecting-state__sub" id="crisisConnectingSub">Please stay on the line. A trained professional will be with you shortly.</p>
					<div class="mh-connecting-dots" id="crisisConnectingDots">
						<span></span><span></span><span></span>
					</div>
				</div>

				<!-- Connected State (audio-only, shown only after responder joins) -->
				<div class="mh-call-workspace" id="crisisWorkspace" style="display:none;">
					<div class="mh-audio-call-ui">
						<!-- Responder connected badge -->
						<div class="mh-responder-badge">
							<i class="fas fa-check-circle"></i>
							<span>Responder Connected</span>
						</div>
						<!-- Animated audio waveform -->
						<div class="mh-audio-indicator">
							<div class="mh-audio-wave" id="crisisWave">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<p class="mh-audio-label">Your responder is listening — speak freely.</p>
						</div>
						<!-- Mute toggle -->
						<button class="mh-btn mh-btn--outline mh-btn--sm" id="muteBtn" onclick="toggleMute()">
							<i class="fas fa-microphone" id="muteIcon"></i>
							<span id="muteLabel">Mute</span>
						</button>
					</div>
					<div class="mh-call-connected-msg">
						<i class="fas fa-shield-halved"></i>
						You are connected securely. Your call is private and encrypted.
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="mh-crisis-modal__footer">
					<p><i class="fas fa-lock"></i> End-to-end encrypted &nbsp;·&nbsp; No recording &nbsp;·&nbsp; Anonymous</p>
				</div>
			</div>
		</div>

		<!-- ════ RESOURCES GRID ════ -->
		<div class="mh-crisis-grid">

			<!-- Card 1 — Immediate Help -->
			<div class="mh-crisis-card">
				<div class="mh-crisis-card__icon mh-crisis-card__icon--crisis">
					<i class="fas fa-circle-exclamation"></i>
				</div>
				<h3 class="mh-crisis-card__title">Immediate Help</h3>
				<div class="mh-resource-list">
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">📞</div>
						<div>
							<p class="mh-resource-item__label">988 Suicide &amp; Crisis Lifeline</p>
							<p class="mh-resource-item__sub">Free, confidential, 24/7</p>
						</div>
						<a href="tel:988" class="mh-btn mh-btn--sm mh-btn--crisis" style="margin-left:auto;flex-shrink:0;">Call</a>
					</div>
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">💬</div>
						<div>
							<p class="mh-resource-item__label">Crisis Text Line</p>
							<p class="mh-resource-item__sub">Text HOME to 741741</p>
						</div>
						<a href="sms:741741" class="mh-btn mh-btn--sm mh-btn--outline" style="margin-left:auto;flex-shrink:0;">Text</a>
					</div>
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">🏥</div>
						<div>
							<p class="mh-resource-item__label">Emergency Services</p>
							<p class="mh-resource-item__sub">Sri Lanka ambulance &amp; rescue</p>
						</div>
						<a href="tel:119" class="mh-btn mh-btn--sm mh-btn--outline" style="margin-left:auto;flex-shrink:0;">119</a>
					</div>
				</div>
			</div>

			<!-- Card 2 — Campus Resources -->
			<div class="mh-crisis-card">
				<div class="mh-crisis-card__icon mh-crisis-card__icon--warm">
					<i class="fas fa-building-columns"></i>
				</div>
				<h3 class="mh-crisis-card__title">Campus Resources</h3>
				<div class="mh-resource-list">
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">👥</div>
						<div>
							<p class="mh-resource-item__label">University Counseling Centre</p>
							<p class="mh-resource-item__sub">Professional on-campus support</p>
						</div>
					</div>
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">🏠</div>
						<div>
							<p class="mh-resource-item__label">Resident Advisor (RA)</p>
							<p class="mh-resource-item__sub">24/7 trained student staff</p>
						</div>
					</div>
					<div class="mh-resource-item">
						<div class="mh-resource-item__icon">👨‍⚕️</div>
						<div>
							<p class="mh-resource-item__label">Student Health Services</p>
							<p class="mh-resource-item__sub">Medical &amp; mental health support</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Card 3 — Self-Help Tools -->
			<div class="mh-crisis-card">
				<div class="mh-crisis-card__icon mh-crisis-card__icon--teal">
					<i class="fas fa-spa"></i>
				</div>
				<h3 class="mh-crisis-card__title">Coping Techniques</h3>
				<div class="mh-tool-list">
					<button class="mh-tool-btn" onclick="openTool('breathing')">
						<span class="mh-tool-icon">🫁</span>
						<span>Breathing Exercise</span>
						<i class="fas fa-chevron-right" style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);"></i>
					</button>
					<button class="mh-tool-btn" onclick="openTool('grounding')">
						<span class="mh-tool-icon">🌍</span>
						<span>5-4-3-2-1 Grounding</span>
						<i class="fas fa-chevron-right" style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);"></i>
					</button>
					<button class="mh-tool-btn" onclick="openTool('safety')">
						<span class="mh-tool-icon">📋</span>
						<span>My Safety Plan</span>
						<i class="fas fa-chevron-right" style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);"></i>
					</button>
					<button class="mh-tool-btn" onclick="openTool('distraction')">
						<span class="mh-tool-icon">🎯</span>
						<span>Distraction Activities</span>
						<i class="fas fa-chevron-right" style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);"></i>
					</button>
				</div>
			</div>

		</div><!-- /mh-crisis-grid -->

		<!-- ════ WARNING SIGNS ════ -->
		<div class="mh-warning-card">
			<h3 class="mh-warning-card__title">
				<i class="fas fa-triangle-exclamation"></i>
				Warning Signs to Watch For
			</h3>
			<div class="mh-warning-grid">
				<div class="mh-warning-col">
					<h4>In Yourself</h4>
					<ul class="mh-warning-list">
						<li>Thoughts of suicide or self-harm</li>
						<li>Feeling hopeless, helpless, or trapped</li>
						<li>Extreme or unusual mood swings</li>
						<li>Withdrawing from friends and family</li>
						<li>Major changes in sleep or appetite</li>
						<li>Increased use of alcohol or substances</li>
					</ul>
				</div>
				<div class="mh-warning-col">
					<h4>In Others</h4>
					<ul class="mh-warning-list">
						<li>Talking about wanting to die or disappear</li>
						<li>Giving away meaningful possessions</li>
						<li>Saying goodbye as if for the last time</li>
						<li>Sudden calm after a period of depression</li>
						<li>Isolation and withdrawal from loved ones</li>
						<li>Engaging in reckless or risky behaviour</li>
					</ul>
				</div>
			</div>
			<div class="mh-warning-reminder">
				<strong>Remember:</strong> It is always okay to ask for help. Reaching out is a sign of courage and strength — not weakness. You matter.
			</div>
		</div>

	</div><!-- /mh-crisis-content -->
</div><!-- /mh-crisis-page -->


<style>
/* ── Crisis modal states: simple display toggle (no overlap needed) ──
   The two panels (connecting vs connected) are mutually exclusive,
   so we just show/hide them — no absolute positioning required.    */
#crisisConnectingState {
	min-height: 220px;          /* keeps modal tall while in waiting state */
}

/* ── Audio call UI (shown after joined-meeting fires) ───────── */
.mh-audio-call-ui {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 24px;
	gap: 8px;
}
.mh-audio-indicator {
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 12px;
}
.mh-audio-label {
	font-size: 0.92rem;
	color: var(--text-secondary);
	margin: 0;
	text-align: center;
}
/* Animated waveform bars */
.mh-audio-wave {
	display: flex;
	align-items: center;
	gap: 5px;
	height: 48px;
}
.mh-audio-wave span {
	display: block;
	width: 6px;
	border-radius: 3px;
	background: var(--primary, #3d8b6e);
	animation: audioWave 1.2s ease-in-out infinite;
}
.mh-audio-wave span:nth-child(1) { height: 18px; animation-delay: 0s;    }
.mh-audio-wave span:nth-child(2) { height: 32px; animation-delay: 0.1s;  }
.mh-audio-wave span:nth-child(3) { height: 44px; animation-delay: 0.2s;  }
.mh-audio-wave span:nth-child(4) { height: 32px; animation-delay: 0.3s;  }
.mh-audio-wave span:nth-child(5) { height: 18px; animation-delay: 0.4s;  }
@keyframes audioWave {
	0%, 100% { transform: scaleY(0.5); opacity: 0.6; }
	50%       { transform: scaleY(1);   opacity: 1;   }
}
.mh-audio-wave.muted span {
	background: var(--text-secondary, #9ca3af);
	animation: none;
	height: 6px !important;
}
/* ── Responder connected badge ──────────────────────────────── */
.mh-responder-badge {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	background: rgba(16, 185, 129, 0.12);
	color: var(--success, #10b981);
	border: 1px solid rgba(16, 185, 129, 0.3);
	padding: 7px 18px;
	border-radius: 100px;
	font-size: 0.85rem;
	font-weight: 600;
	margin-bottom: 8px;
}
.mh-responder-badge i {
	font-size: 1rem;
}
</style>

<script>
let currentCrisisFrame = null;  // Daily.co Call Object
let currentCrisisCallId = null;
let callTimerInterval   = null;
let callStartTime       = null;
let isMuted             = false;

// ── Open the modal ────────────────────────────────────────────
function openCrisisModal() {
	const backdrop = document.getElementById('crisisModalBackdrop');
	backdrop.classList.add('active');
	backdrop.setAttribute('aria-hidden', 'false');
	document.body.style.overflow = 'hidden';
	// Connecting overlay visible; workspace hidden until joined
	document.getElementById('crisisConnectingState').style.display = 'flex';
	document.getElementById('crisisWorkspace').style.display       = 'none';
}

// ── Close the modal ───────────────────────────────────────────
function closeCrisisModal() {
	const backdrop = document.getElementById('crisisModalBackdrop');
	backdrop.classList.remove('active');
	backdrop.setAttribute('aria-hidden', 'true');
	document.body.style.overflow = '';
	// Reset connecting state for next session
	document.getElementById('crisisConnectingState').style.display = 'flex';
	document.getElementById('crisisWorkspace').style.display       = 'none';
	document.getElementById('crisisConnectingTitle').textContent   = 'Connecting you to a responder…';
	document.getElementById('crisisConnectingSub').textContent     = 'Please stay on the line. A trained professional will be with you shortly.';
	document.getElementById('crisisConnectingDots').style.display  = 'flex';
	const ico = document.getElementById('crisisLoadingIco');
	if (ico) { ico.className = 'fas fa-headset'; }
	isMuted = false;
	updateMuteUI();
}

// ── Mute / unmute toggle ──────────────────────────────────────
function toggleMute() {
	if (!currentCrisisFrame) return;
	isMuted = !isMuted;
	currentCrisisFrame.setLocalAudio(!isMuted);   // true = audio ON
	updateMuteUI();
}
function updateMuteUI() {
	const icon  = document.getElementById('muteIcon');
	const label = document.getElementById('muteLabel');
	const wave  = document.querySelector('.mh-audio-wave');
	if (!icon || !label) return;
	if (isMuted) {
		icon.className  = 'fas fa-microphone-slash';
		label.textContent = 'Unmute';
		if (wave) wave.classList.add('muted');
	} else {
		icon.className  = 'fas fa-microphone';
		label.textContent = 'Mute';
		if (wave) wave.classList.remove('muted');
	}
}

// ── Student clicks "Connect Now" ──────────────────────────────
async function requestCrisisAudioCall() {
	const btn      = document.getElementById('connectBtn');
	const origHTML = btn.innerHTML;

	btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connecting…';
	btn.disabled  = true;

	try {
		const res  = await fetch('/MindHeaven/public/api/crisis/connect', { method: 'POST' });
		const data = await res.json();

		if (data.error || !data.url) {
			showCrisisAlert(data.error || 'No responders available. Please call 988 immediately.');
			btn.innerHTML = origHTML;
			btn.disabled  = false;
			return;
		}

		currentCrisisCallId = data.call_id || null;
		openCrisisModal();

		// ── Use Call Object API (NOT createFrame) ──────────────
		// createFrame() uses the Daily.co prebuilt iframe which shows
		// a haircheck/pre-join screen. The student must click
		// "Join Meeting" inside that iframe before joined-meeting
		// fires — but our overlay blocks that click forever.
		//
		// createCallObject() has NO UI and NO haircheck screen.
		// It joins audio programmatically, and joined-meeting fires
		// immediately once the WebRTC connection is established.
		currentCrisisFrame = DailyIframe.createCallObject();

		// ── STEP 1: Student joined the room ──────────────────────
		// Keep "Connecting" overlay visible but update the text
		// to "Waiting for responder" — the student is in the
		// Daily.co room but the responder hasn't answered yet.
		currentCrisisFrame.on('joined-meeting', () => {
			document.getElementById('crisisConnectingTitle').textContent = 'Waiting for a responder to join…';
			document.getElementById('crisisConnectingSub').textContent    = 'You are in the queue. A trained professional will join shortly.';
			// Ensure mic is live so responder hears student when they join
			currentCrisisFrame.setLocalAudio(true);
		});

		// ── STEP 2: Responder joins the same room ─────────────────
		// participant-joined fires for EVERY remote participant.
		// The first non-local join = the responder answered.
		currentCrisisFrame.on('participant-joined', (evt) => {
			if (evt.participant.local) return; // ignore self
			// Responder is in the room — show connected state
			document.getElementById('crisisConnectingState').style.display = 'none';
			document.getElementById('crisisWorkspace').style.display       = 'flex';
			startCallTimer();
		});

		// ── STEP 3: Responder leaves ──────────────────────────────
		// If the responder disconnects mid-call, revert to waiting
		currentCrisisFrame.on('participant-left', (evt) => {
			if (evt.participant.local) return; // ignore self
			// Check if any non-local participants remain
			const others = Object.values(currentCrisisFrame.participants())
				.filter(p => !p.local);
			if (others.length === 0) {
				// Responder left — go back to waiting state
				stopCallTimer();
				document.getElementById('crisisWorkspace').style.display       = 'none';
				document.getElementById('crisisConnectingState').style.display = 'flex';
				document.getElementById('crisisConnectingTitle').textContent   = 'Responder disconnected.';
				document.getElementById('crisisConnectingSub').textContent     = 'Reconnecting you to another responder… Please stay on the line.';
				document.getElementById('crisisConnectingDots').style.display  = 'flex';
				// Update icon to alert
				const ico = document.getElementById('crisisLoadingIco');
				if (ico) ico.className = 'fas fa-exclamation-circle';
			}
		});

		// ── Student leaves via Daily internally ───────────────────
		currentCrisisFrame.on('left-meeting', () => endCrisisCall());

		// ── Error handler ─────────────────────────────────────────
		currentCrisisFrame.on('error', (e) => {
			console.error('Daily.co error:', e);
			showCrisisAlert('Audio connection error. Please call 988 directly if this is a crisis.');
			endCrisisCall();
			btn.innerHTML = origHTML;
			btn.disabled  = false;
		});

		// Join the room — no haircheck, audio starts immediately
		await currentCrisisFrame.join({
			url:            data.url,
			startVideoOff:  true,    // audio-only hotline
			startAudioOff:  false
		});

		btn.innerHTML = '<i class="fas fa-headset"></i> Call Active…';

	} catch (err) {
		console.error(err);
		showCrisisAlert('Connection failed. Please call 988 directly if this is a crisis.');
		closeCrisisModal();
		btn.innerHTML = origHTML;
		btn.disabled  = false;
	}
}

// ── Timer helpers ─────────────────────────────────────────────
function startCallTimer() {
	callStartTime = Date.now();
	callTimerInterval = setInterval(() => {
		const elapsed = Math.floor((Date.now() - callStartTime) / 1000);
		const m = String(Math.floor(elapsed / 60)).padStart(2, '0');
		const s = String(elapsed % 60).padStart(2, '0');
		const el = document.getElementById('callTimer');
		if (el) el.textContent = `${m}:${s}`;
	}, 1000);
}
function stopCallTimer() {
	if (callTimerInterval) {
		clearInterval(callTimerInterval);
		callTimerInterval = null;
	}
	const el = document.getElementById('callTimer');
	if (el) el.textContent = '00:00';
}

// ── Student ends call ─────────────────────────────────────────
function endCrisisCall() {
	if (currentCrisisFrame) {
		try { currentCrisisFrame.leave();   } catch(e) {}
		try { currentCrisisFrame.destroy(); } catch(e) {}
		currentCrisisFrame = null;
	}
	stopCallTimer();
	closeCrisisModal();
	const btn = document.getElementById('connectBtn');
	if (btn) {
		btn.innerHTML = '<i class="fas fa-phone-volume"></i> Connect Now';
		btn.disabled  = false;
	}
}

// ── Close modal by clicking backdrop ─────────────────────────
document.getElementById('crisisModalBackdrop').addEventListener('click', function(e) {
	if (e.target === this && !currentCrisisFrame) {
		closeCrisisModal();
	}
});

// ── Coping tools ──────────────────────────────────────────────
function openTool(tool) {
	alert('Opening ' + tool + ' tool…');
}

// ── Toast alert for errors ────────────────────────────────────
function showCrisisAlert(msg) {
	const d = document.createElement('div');
	d.style.cssText = `
		position:fixed;top:24px;right:24px;z-index:999999;
		background:#D64F4F;color:#fff;padding:14px 20px;
		border-radius:12px;font-weight:600;font-size:.9rem;
		box-shadow:0 8px 24px rgba(0,0,0,.25);max-width:360px;
		display:flex;align-items:center;gap:10px;
	`;
	d.innerHTML = `<i class="fas fa-triangle-exclamation"></i><span>${msg}</span>`;
	document.body.appendChild(d);
	setTimeout(() => d.remove(), 7000);
}
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>