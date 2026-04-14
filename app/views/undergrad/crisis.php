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
					<div class="mh-loading-pulse">
						<i class="fas fa-headset"></i>
					</div>
					<h4 class="mh-connecting-state__title">Connecting you to a responder…</h4>
					<p class="mh-connecting-state__sub">Please stay on the line. A trained professional will be with you shortly.</p>
					<div class="mh-connecting-dots">
						<span></span><span></span><span></span>
					</div>
				</div>

				<!-- Daily.co iframe container (hidden until joined) -->
				<div class="mh-call-workspace" id="crisisWorkspace" style="display:none;">
					<div class="mh-call-frame" id="dailyIframePlaceholder"></div>
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


<script>
let currentCrisisFrame = null;
let currentCrisisCallId = null;
let callTimerInterval  = null;
let callStartTime      = null;

// ── Open the modal popup ──────────────────────────────────────
function openCrisisModal() {
	const backdrop = document.getElementById('crisisModalBackdrop');
	backdrop.classList.add('active');
	backdrop.setAttribute('aria-hidden', 'false');
	document.body.style.overflow = 'hidden'; // Prevent background scroll
	// Show connecting state, hide workspace
	document.getElementById('crisisConnectingState').style.display = 'flex';
	document.getElementById('crisisWorkspace').style.display = 'none';
}

// ── Close the modal popup ─────────────────────────────────────
function closeCrisisModal() {
	const backdrop = document.getElementById('crisisModalBackdrop');
	backdrop.classList.remove('active');
	backdrop.setAttribute('aria-hidden', 'true');
	document.body.style.overflow = '';
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
			const msg = data.error || 'No responders available right now. Please call 988 immediately.';
			showCrisisAlert(msg);
			btn.innerHTML = origHTML;
			btn.disabled  = false;
			return;
		}

		// Store the call ID so we can reference it later if needed
		currentCrisisCallId = data.call_id || null;

		// Pop the modal open (connecting state)
		openCrisisModal();

		// Initialise Daily Prebuilt — AUDIO ONLY
		const placeholder = document.getElementById('dailyIframePlaceholder');
		placeholder.innerHTML = '';

		currentCrisisFrame = window.DailyIframe.createFrame(placeholder, {
			iframeStyle: {
				width:  '100%',
				height: '100%',
				border: '0',
				borderRadius: '12px',
				backgroundColor: '#0d1117'
			},
			dailyConfig: {
				startVideoOff: true,   // ← AUDIO ONLY hotline
				startAudioOff: false
			}
		});

		// When actually joined → switch from "connecting" to live workspace
		currentCrisisFrame.on('joined-meeting', () => {
			document.getElementById('crisisConnectingState').style.display = 'none';
			document.getElementById('crisisWorkspace').style.display       = 'flex';
			startCallTimer();
		});

		// Auto-close if the student leaves via Daily UI
		currentCrisisFrame.on('left-meeting', () => endCrisisCall());

		await currentCrisisFrame.join({ url: data.url });

		// Update the connect button while in call
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
		document.getElementById('callTimer').textContent = `${m}:${s}`;
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
		try { currentCrisisFrame.leave(); } catch(e) {}
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
	// Only close if clicking the backdrop itself, not the modal content
	if (e.target === this && !currentCrisisFrame) {
		closeCrisisModal();
	}
});

// ── Coping tools ──────────────────────────────────────────────
function openTool(tool) {
	// Placeholder — wire up to your modal system
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
		animation:mh-toast-in .3s ease;
	`;
	d.innerHTML = `<i class="fas fa-triangle-exclamation"></i><span>${msg}</span>`;
	document.body.appendChild(d);
	setTimeout(() => d.remove(), 7000);
}
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>