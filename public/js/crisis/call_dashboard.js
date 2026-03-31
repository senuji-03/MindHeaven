/**
 * MindHeaven — Crisis Hotline Responder Dashboard
 * call_dashboard.js
 *
 * Pure UI simulation — no backend calls.
 * Ready for future integration with third-party calling APIs (Twilio, Agora, etc.)
 */

'use strict';

// ============================================================
//  STATE
// ============================================================
const state = {
  activeCall: null,        // { id, type, priority, startTime }
  durationInterval: null,  // setInterval ref for call timer
  noteCount: 2,            // starts with 2 seeded notes
  riskLevel: 'low',
  stats: {
    incoming: 4,
    active: 0,
    queue: 3,
    escalated: 1,
    handled: 12
  }
};

// ============================================================
//  CLOCK
// ============================================================
function startClock() {
  const el = document.getElementById('liveClock');
  if (!el) return;
  const tick = () => {
    const now = new Date();
    el.textContent = now.toLocaleTimeString('en-US', { hour12: false });
  };
  tick();
  setInterval(tick, 1000);
}

// ============================================================
//  ACCEPT CALL  (from Incoming Calls table)
// ============================================================
function acceptCall(btn) {
  if (state.activeCall) {
    showToast('⚠️ End the current active call before accepting a new one.', 'warning');
    return;
  }

  const row = btn.closest('tr');
  const callId = row.dataset.callId;
  const callType = row.dataset.type;
  const priority = row.dataset.priority;

  // Update this row's status badge
  const statusCell = row.cells[4];
  statusCell.innerHTML = '<span class="badge badge-green">Answered</span>';

  // Disable both action buttons on this row
  row.querySelectorAll('.btn').forEach(b => {
    b.disabled = true;
    b.style.opacity = '.4';
    b.style.cursor = 'not-allowed';
  });

  _activateCall(callId, callType, priority);

  // After transition delay, fade out row
  setTimeout(() => {
    row.style.transition = 'opacity .5s';
    row.style.opacity = '0';
    setTimeout(() => {
      row.remove();
      updateIncomingEmptyState();
      updateStat('incoming', -1);
      updateStat('active', 1);
    }, 500);
  }, 600);

  showToast(`✅ Call ${callId} accepted and moved to Active Call.`, 'success');
}

// ============================================================
//  DECLINE CALL
// ============================================================
function declineCall(btn) {
  const row = btn.closest('tr');
  const callId = row.dataset.callId;

  const statusCell = row.cells[4];
  statusCell.innerHTML = '<span class="badge badge-red">Declined</span>';

  row.classList.add('row-declined');
  row.querySelectorAll('.btn').forEach(b => {
    b.disabled = true;
    b.style.opacity = '.4';
    b.style.cursor = 'not-allowed';
  });

  updateStat('incoming', -1);
  updateStat('handled', 1);

  showToast(`❌ Call ${callId} declined.`, 'danger');

  // Remove row after 2.5s
  setTimeout(() => {
    row.style.transition = 'opacity .5s';
    row.style.opacity = '0';
    setTimeout(() => {
      row.remove();
      updateIncomingEmptyState();
    }, 500);
  }, 2500);
}

// ============================================================
//  ACCEPT FROM QUEUE
// ============================================================
function acceptFromQueue(btn) {
  if (state.activeCall) {
    showToast('⚠️ End the current active call before accepting a new one.', 'warning');
    return;
  }

  const row = btn.closest('tr');
  const callId = row.dataset.callId;
  const callType = row.dataset.type   || 'Audio';
  const priority  = row.dataset.priority || 'medium';

  _activateCall(callId, callType, priority);

  row.style.transition = 'opacity .4s';
  row.style.opacity = '0';
  setTimeout(() => {
    row.remove();
    updateQueueCount();
    updateStat('queue', -1);
    updateStat('active', 1);
  }, 400);

  showToast(`✅ Call ${callId} accepted from queue.`, 'success');
}

// ============================================================
//  INTERNAL — START ACTIVE CALL
// ============================================================
function _activateCall(callId, callType, priority) {
  state.activeCall = { id: callId, type: callType, priority, startTime: Date.now() };

  // Populate Active Call panel
  document.getElementById('active-caller-id').textContent = '#' + callId;
  document.getElementById('active-caller-avatar').textContent = callId.slice(-2);
  document.getElementById('active-priority').textContent = priority.charAt(0).toUpperCase() + priority.slice(1);

  const typeBadge = document.getElementById('active-call-type-badge');
  if (callType === 'Video') {
    typeBadge.className = 'type-badge video';
    typeBadge.textContent = '📹 Video';
  } else {
    typeBadge.className = 'type-badge audio';
    typeBadge.textContent = '🎙 Audio';
  }

  document.getElementById('no-active-call').style.display = 'none';
  document.getElementById('active-call-panel').style.display = 'block';
  document.getElementById('active-call-status-badge').style.display = 'inline-flex';

  // Update notes panel label
  document.getElementById('notes-call-label').textContent = '#' + callId;

  // Update nav badge
  document.getElementById('active-badge').textContent = '1';

  // Start duration timer
  clearInterval(state.durationInterval);
  state.durationInterval = setInterval(_updateDuration, 1000);
  _updateDuration();

  // Scroll to active call card
  document.getElementById('active-call-card').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function _updateDuration() {
  if (!state.activeCall) return;
  const elapsed = Math.floor((Date.now() - state.activeCall.startTime) / 1000);
  const m = String(Math.floor(elapsed / 60)).padStart(2, '0');
  const s = String(elapsed % 60).padStart(2, '0');
  const el = document.getElementById('call-duration');
  if (el) el.textContent = `${m}:${s}`;
}

// ============================================================
//  END CALL
// ============================================================
function endCall() {
  if (!state.activeCall) return;

  const callId = state.activeCall.id;
  clearInterval(state.durationInterval);
  state.durationInterval = null;
  state.activeCall = null;

  // Hide active panel
  document.getElementById('active-call-panel').style.display = 'none';
  document.getElementById('no-active-call').style.display = 'flex';
  document.getElementById('active-call-status-badge').style.display = 'none';

  // Reset notes label
  document.getElementById('notes-call-label').textContent = 'No active call';

  // Update stats
  updateStat('active', -1);
  updateStat('handled', 1);
  document.getElementById('active-badge').textContent = '0';

  // Reset risk level
  setRisk('low', document.getElementById('risk-low'));

  showToast(`📵 Call ${callId} ended. Session complete.`, 'success');
}

// ============================================================
//  SAVE NOTES
// ============================================================
function saveNote() {
  const textarea = document.getElementById('session-notes-textarea');
  const text = textarea.value.trim();

  if (!text) {
    showToast('⚠️ Please write a note before saving.', 'warning');
    textarea.focus();
    return;
  }

  const now = new Date();
  const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });

  const list = document.getElementById('notes-history');
  const item = document.createElement('li');
  item.className = 'note-item new-note';
  item.innerHTML = `<span class="note-time">${timeStr}</span><span class="note-text">${escapeHtml(text)}</span>`;
  list.prepend(item);

  // Remove new-note animation class after it plays
  setTimeout(() => item.classList.remove('new-note'), 1000);

  state.noteCount++;
  document.getElementById('note-count').textContent = `${state.noteCount} notes`;

  textarea.value = '';
  document.getElementById('notes-timestamp').textContent = `Last saved: ${timeStr}`;

  showToast('💾 Note saved successfully.', 'success');
}

function focusNotes() {
  const textarea = document.getElementById('session-notes-textarea');
  textarea.focus();
  textarea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// ============================================================
//  RISK LEVEL
// ============================================================
function setRisk(level, btn) {
  state.riskLevel = level;

  // Reset all buttons
  document.querySelectorAll('.risk-btn').forEach(b => b.classList.remove('active-risk'));
  btn.classList.add('active-risk');

  // Show or hide escalation form
  const form = document.getElementById('escalation-form');
  form.style.display = (level === 'high') ? 'block' : 'none';

  if (level === 'high') {
    form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    showToast('🚨 High risk selected. Complete the escalation form.', 'warning');
  }
}

// ============================================================
//  ESCALATION
// ============================================================
function escalateToCounselor() {
  const reason = document.getElementById('escalation-reason').value;
  if (!reason) {
    showToast('⚠️ Please select an escalation reason.', 'warning');
    return;
  }
  _addEscalationRecord(state.activeCall?.id || 'UNKNOWN', 'High', 'Counselor');
  showToast('👩‍⚕️ Call escalated to Counselor successfully.', 'success');
  updateStat('escalated', 1);
}

function markEmergency() {
  _addEscalationRecord(state.activeCall?.id || 'UNKNOWN', 'High', 'Emergency');
  showToast('🆘 Call marked as EMERGENCY.', 'danger');
  updateStat('escalated', 1);
}

function createEscalationRecord() {
  const reason = document.getElementById('escalation-reason').value;
  if (!reason) {
    showToast('⚠️ Please select an escalation reason.', 'warning');
    return;
  }
  _addEscalationRecord(state.activeCall?.id || 'UNKNOWN', state.riskLevel, 'Record');
  showToast('📋 Escalation record created.', 'success');
}

function _addEscalationRecord(callId, riskLevel, type) {
  const tbody = document.getElementById('escalation-records-body');
  const now = new Date();
  const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });

  const riskBadge = riskLevel === 'High' || riskLevel === 'high'
    ? '<span class="priority-badge high">🔴 High</span>'
    : riskLevel === 'Medium' || riskLevel === 'medium'
      ? '<span class="priority-badge medium">🟡 Medium</span>'
      : '<span class="priority-badge low">🟢 Low</span>';

  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td><strong>#${callId}</strong></td>
    <td>${riskBadge}</td>
    <td>Responder (You)</td>
    <td>${timeStr}</td>
    <td><span class="badge badge-orange">Pending</span></td>
  `;
  tbody.prepend(tr);

  // Highlight new row briefly
  tr.style.background = '#fef9c3';
  setTimeout(() => { tr.style.transition = 'background 1s'; tr.style.background = ''; }, 1500);

  // Update escalation badge in sidebar
  const escBadge = document.getElementById('esc-badge');
  if (escBadge) escBadge.textContent = parseInt(escBadge.textContent || 0) + 1;
}

// ============================================================
//  MODAL  (quick escalation from active call)
// ============================================================
function openEscalationModal() {
  if (!state.activeCall) {
    showToast('⚠️ No active call to escalate.', 'warning');
    return;
  }
  document.getElementById('modal-caller-id').value = '#' + state.activeCall.id;
  document.getElementById('escalation-modal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeEscalationModal() {
  document.getElementById('escalation-modal').classList.remove('active');
  document.body.style.overflow = '';
}

function submitEscalation() {
  const reason = document.getElementById('modal-escalation-reason').value;
  const level  = document.getElementById('modal-risk-level').value;

  if (!reason) {
    showToast('⚠️ Please select an escalation reason.', 'warning');
    return;
  }

  const levelLabel = level === 'high' ? 'High' : level === 'medium' ? 'Medium' : 'Low';
  _addEscalationRecord(state.activeCall?.id || 'UNKNOWN', levelLabel, 'Modal');

  updateStat('escalated', 1);
  showToast(`🚨 Escalation submitted for #${state.activeCall?.id}`, 'success');
  closeEscalationModal();

  // Reset modal form
  document.getElementById('modal-escalation-reason').value = '';
  document.getElementById('modal-escalation-notes').value = '';
}

// Close modal on overlay click
document.getElementById('escalation-modal')?.addEventListener('click', function (e) {
  if (e.target === this) closeEscalationModal();
});

// ============================================================
//  SIDEBAR TOGGLE
// ============================================================
function initSidebarToggle() {
  const btn = document.getElementById('sidebarToggle');
  if (!btn) return;

  btn.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      document.body.classList.toggle('sidebar-open');
    } else {
      document.body.classList.toggle('sidebar-collapsed');
    }
  });
}

// ============================================================
//  SIDEBAR NAV  (highlight active items)
// ============================================================
function initSidebarNav() {
  document.querySelectorAll('.nav-item[data-section]').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      document.querySelectorAll('.nav-item').forEach(l => l.classList.remove('active'));
      link.classList.add('active');
    });
  });
}

// ============================================================
//  QUEUE WAIT TIME COUNTER
// ============================================================
function startQueueTimers() {
  setInterval(() => {
    document.querySelectorAll('#queue-body .wait-time').forEach(el => {
      const parts = el.textContent.split(':').map(Number);
      let total = parts[0] * 60 + parts[1] + 1;
      const m = String(Math.floor(total / 60)).padStart(2, '0');
      const s = String(total % 60).padStart(2, '0');
      el.textContent = `${m}:${s}`;
    });
  }, 1000);
}

// ============================================================
//  HELPERS
// ============================================================
function updateIncomingEmptyState() {
  const tbody = document.getElementById('incoming-calls-body');
  const noEl  = document.getElementById('no-incoming');
  if (!tbody || !noEl) return;
  const visibleRows = tbody.querySelectorAll('tr:not([style*="opacity: 0"])').length;
  noEl.style.display = tbody.children.length === 0 ? 'flex' : 'none';
}

function updateQueueCount() {
  const tbody = document.getElementById('queue-body');
  const badge = document.getElementById('queue-count-badge');
  const navBadge = document.getElementById('queue-badge');
  if (!tbody || !badge) return;
  const count = tbody.children.length;
  badge.textContent = `${count} waiting`;
  if (navBadge) navBadge.textContent = count;
}

function updateStat(key, delta) {
  state.stats[key] = Math.max(0, (state.stats[key] || 0) + delta);
  const el = document.getElementById(`stat-${key}`);
  if (el) {
    el.textContent = state.stats[key];
    // Brief pop animation
    el.style.transform = 'scale(1.35)';
    el.style.transition = 'transform .15s';
    setTimeout(() => { el.style.transform = 'scale(1)'; }, 150);
  }
}

let toastTimeout;
function showToast(message, type = '') {
  const toast = document.getElementById('toast');
  if (!toast) return;

  toast.textContent = message;
  toast.className = `toast show ${type}`;

  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => {
    toast.className = 'toast';
  }, 3500);
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.appendChild(document.createTextNode(str));
  return div.innerHTML;
}

// ============================================================
//  INIT
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
  startClock();
  initSidebarToggle();
  initSidebarNav();
  startQueueTimers();

  // Set initial note count label
  document.getElementById('note-count').textContent = `${state.noteCount} notes`;

  console.info('🧠 MindHeaven Crisis Dashboard loaded — UI simulation mode active.');
  console.info('   Ready for third-party calling API integration (Twilio / Agora).');
});
