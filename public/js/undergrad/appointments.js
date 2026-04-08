// MindHeaven — Appointments JS

// ─── Constants ────────────────────────────────────────────────────────────────
const ALL_SLOTS = ['09:00', '13:00', '16:00'];
const BASE      = window.BASE_URL || '/MindHeaven/public';

const MODE_LABELS = {
    audio_video: '🎥 Audio/Video',
    chat:        '💬 Chat'
};

const STATUS_CLASS = {
    pending:   'pending',
    scheduled: 'scheduled',
    accepted:  'accepted',
    accept:    'accepted',
    completed: 'completed',
    cancelled: 'cancelled',
    rejected:  'rejected'
};

let _appointments = [];

// ─── Init ─────────────────────────────────────────────────────────────────────
function initAppointmentsPage() {
    loadCounselors();
    loadAppointmentTypes();
    setupFormSubmission();
    setupEventListeners();
    renderAppointments();

    // Min date = today
    const dateEl = document.getElementById('appointmentDate');
    if (dateEl) dateEl.min = new Date().toISOString().split('T')[0];

    // Close on backdrop click (only when clicking the dark overlay, not the card)
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeBookingModal();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeBookingModal();
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAppointmentsPage);
} else {
    initAppointmentsPage();
}

// ─── Modal Open ───────────────────────────────────────────────────────────────
function openBookingModal(appointment = null) {
    const modal     = document.getElementById('bookingModal');
    const title     = document.getElementById('modalTitle');
    const submitTxt = document.getElementById('submitBtnText');
    if (!modal) return;

    // Reset form and labels
    resetForm();
    if (appointment) {
        if (title)     title.textContent     = 'Edit Appointment';
        if (submitTxt) submitTxt.textContent = 'Update Appointment';
        prefillForm(appointment);
    } else {
        if (title)     title.textContent     = 'Book an Appointment';
        if (submitTxt) submitTxt.textContent = 'Save Appointment';
    }

    // Show the overlay (start transparent for fade-in)
    modal.style.cssText = 'display:flex; opacity:0; transition:opacity 0.2s ease;';
    document.body.style.overflow = 'hidden';

    // Animate the inner card
    const card = modal.querySelector('.mh-modal');
    if (card) {
        card.style.cssText = 'opacity:0; transform:scale(0.94) translateY(12px); transition:opacity 0.2s ease, transform 0.2s cubic-bezier(0.34,1.56,0.64,1);';
    }

    // Trigger transition on next frame
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            modal.style.opacity = '1';
            if (card) {
                card.style.opacity   = '1';
                card.style.transform = 'scale(1) translateY(0)';
            }
        });
    });

    // Focus first input
    setTimeout(() => document.getElementById('appointmentTitle')?.focus(), 220);
}

// ─── Modal Close ──────────────────────────────────────────────────────────────
// ONE function. Called from ✕ button, Cancel button, backdrop, Escape — everywhere.
function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    if (!modal || modal.style.display === 'none' || modal.style.display === '') return;

    const card = modal.querySelector('.mh-modal');

    // Fade out
    modal.style.transition = 'opacity 0.15s ease';
    modal.style.opacity    = '0';
    if (card) {
        card.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
        card.style.opacity    = '0';
        card.style.transform  = 'scale(0.96) translateY(6px)';
    }

    // Hide after transition completes
    setTimeout(() => {
        modal.style.cssText = 'display:none;';
        if (card) card.style.cssText = '';
        document.body.style.overflow = '';
        resetForm();
    }, 160);
}

// ─── Prefill (edit mode) ──────────────────────────────────────────────────────
function prefillForm(a) {
    document.getElementById('appointmentId').value        = a.id;
    document.getElementById('appointmentTitle').value     = a.title    || '';
    document.getElementById('appointmentType').value      = a.type     || '';
    document.getElementById('appointmentMode').value      = a.mode     || '';
    document.getElementById('appointmentDate').value      = a.date     || '';
    document.getElementById('appointmentCounselor').value = a.counselor_user_id || '';
    document.getElementById('appointmentNotes').value     = a.notes    || '';

    const timeSel = document.getElementById('appointmentTime');
    if (timeSel && a.time) {
        const slot = a.time.substring(0, 5);
        timeSel.innerHTML = `<option value="${slot}">${formatSlotLabel(slot)}</option>`;
        timeSel.disabled = false;
    }
}

// ─── Counselors ───────────────────────────────────────────────────────────────
async function loadCounselors() {
    const sel = document.getElementById('appointmentCounselor');
    if (!sel) return;
    try {
        const res  = await fetch(`${BASE}/api/counselors`, { credentials: 'same-origin' });
        const data = await res.json();
        if (!Array.isArray(data) || !data.length) {
            sel.innerHTML = '<option value="">No counselors available</option>';
            return;
        }
        sel.innerHTML = '<option value="">Select a counselor…</option>' +
            data.map(c => {
                const name = (c.full_name || c.username) + (c.specialization ? ` (${c.specialization})` : '');
                return `<option value="${c.id}">${escHtml(name)}</option>`;
            }).join('');
    } catch {
        sel.innerHTML = '<option value="">Error loading counselors</option>';
    }
}

// ─── Appointment Types ────────────────────────────────────────────────────────
function loadAppointmentTypes() {
    const sel = document.getElementById('appointmentType');
    if (!sel) return;
    const types = [
        { value: 'individual', label: 'Individual Therapy' },
        { value: 'group',      label: 'Group Therapy' },
        { value: 'crisis',     label: 'Crisis Intervention' },
        { value: 'assessment', label: 'Assessment' },
        { value: 'follow_up',  label: 'Follow-up Session' }
    ];
    sel.innerHTML = '<option value="">Select type…</option>' +
        types.map(t => `<option value="${t.value}">${t.label}</option>`).join('');
}

// ─── Time Slots ───────────────────────────────────────────────────────────────
function formatSlotLabel(time) {
    if (!time) return '—';
    const [h, m] = time.split(':').map(Number);
    const ampm = h >= 12 ? 'PM' : 'AM';
    return `${h % 12 || 12}:${m.toString().padStart(2,'0')} ${ampm}`;
}

async function loadTimeSlots() {
    const counselorId = document.getElementById('appointmentCounselor')?.value;
    const date        = document.getElementById('appointmentDate')?.value;
    const timeSel     = document.getElementById('appointmentTime');
    if (!timeSel) return;

    if (!counselorId || !date) {
        timeSel.innerHTML = '<option value="">Select counselor &amp; date first</option>';
        timeSel.disabled = true;
        return;
    }

    timeSel.innerHTML = '<option value="">Loading slots…</option>';
    timeSel.disabled  = true;

    try {
        const url  = `${BASE}/api/appointments/slots?counselor_id=${encodeURIComponent(counselorId)}&date=${encodeURIComponent(date)}`;
        const res  = await fetch(url, { credentials: 'same-origin' });
        const data = await res.json();
        const booked = Array.isArray(data.booked) ? data.booked : [];

        timeSel.innerHTML = '<option value="">Choose a time slot</option>' +
            ALL_SLOTS.map(s => {
                const taken = booked.includes(s);
                return `<option value="${s}"${taken ? ' disabled' : ''}>${formatSlotLabel(s)}${taken ? ' — Booked' : ''}</option>`;
            }).join('');
        timeSel.disabled = false;
    } catch {
        timeSel.innerHTML = '<option value="">Choose a time slot</option>' +
            ALL_SLOTS.map(s => `<option value="${s}">${formatSlotLabel(s)}</option>`).join('');
        timeSel.disabled = false;
    }
}

// ─── Form Submit ──────────────────────────────────────────────────────────────
function setupFormSubmission() {
    document.getElementById('appointmentForm')?.addEventListener('submit', onFormSubmit);
}

async function onFormSubmit(e) {
    e?.preventDefault();

    const id          = document.getElementById('appointmentId')?.value?.trim();
    const title       = document.getElementById('appointmentTitle')?.value?.trim();
    const type        = document.getElementById('appointmentType')?.value;
    const mode        = document.getElementById('appointmentMode')?.value;
    const date        = document.getElementById('appointmentDate')?.value;
    const time        = document.getElementById('appointmentTime')?.value;
    const notes       = document.getElementById('appointmentNotes')?.value?.trim() || '';
    const counselorId = document.getElementById('appointmentCounselor')?.value;

    // Clear previous errors
    document.querySelectorAll('.mh-field-error').forEach(el => el.textContent = '');

    // Validate
    let valid = true;
    const err = (elId, msg) => {
        const el = document.getElementById(elId);
        if (el) el.textContent = msg;
        valid = false;
    };

    if (!title)       err('titleError',     'Please enter a session title.');
    if (!type)        err('typeError',      'Please select a session type.');
    if (!mode)        err('modeError',      'Please select a mode.');
    if (!counselorId) err('counselorError', 'Please choose a counselor.');
    if (!date)        err('dateError',      'Please pick a date.');
    if (!time)        err('timeError',      'Please choose a time slot.');
    if (!valid) return;

    const submitBtn = document.getElementById('submitAppointmentBtn');
    const submitTxt = document.getElementById('submitBtnText');
    if (submitBtn) submitBtn.disabled = true;
    if (submitTxt) submitTxt.textContent = 'Saving…';

    const isUpdate = !!id;
    const endpoint = `${BASE}/api/appointments/${isUpdate ? 'update' : 'create'}`;
    const method   = isUpdate ? 'PUT' : 'POST';
    const payload  = isUpdate
        ? { id: parseInt(id), title, type, mode, date, time, notes }
        : { counselor_user_id: parseInt(counselorId), title, type, mode, date, time, notes };

    try {
        const res  = await fetch(endpoint, {
            method,
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.detail || json.error || 'Server error');

        toastSuccess(isUpdate ? 'Appointment updated!' : 'Appointment booked successfully!');
        closeBookingModal();
        setTimeout(() => renderAppointments(), 180);

    } catch (err) {
        toastError('Could not save: ' + err.message);
        if (submitBtn) submitBtn.disabled = false;
        if (submitTxt) submitTxt.textContent = isUpdate ? 'Update Appointment' : 'Save Appointment';
    }
}

// ─── Event Listeners ─────────────────────────────────────────────────────────
function setupEventListeners() {
    document.getElementById('appointmentCounselor')?.addEventListener('change', loadTimeSlots);
    document.getElementById('appointmentDate')?.addEventListener('change', loadTimeSlots);
    document.getElementById('resetAppointmentForm')?.addEventListener('click', resetForm);
    document.getElementById('importDemoAppointments')?.addEventListener('click', () =>
        toastInfo('Use the Book Appointment button to add sessions.'));
    document.getElementById('exportAppointmentsCsv')?.addEventListener('click', exportCsv);
}

// ─── Render Appointments ──────────────────────────────────────────────────────
async function renderAppointments() {
    const tbody = document.getElementById('appointmentsTableBody');
    const empty = document.getElementById('appointmentsEmptyState');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading">
        <span class="mh-spinner"></span> Loading appointments…</td></tr>`;
    if (empty) empty.style.display = 'none';

    try {
        const res  = await fetch(`${BASE}/api/appointments/mine`, { credentials: 'same-origin' });
        const rows = await res.json();
        _appointments = Array.isArray(rows) ? rows : [];
        _renderRows(_appointments);
        _updateStats(_appointments);
    } catch {
        tbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading" style="color:var(--crisis)">
            Failed to load appointments.</td></tr>`;
    }
}

function _renderRows(list) {
    const tbody = document.getElementById('appointmentsTableBody');
    const empty = document.getElementById('appointmentsEmptyState');

    if (!list.length) {
        if (empty) empty.style.display = 'block';
        tbody.innerHTML = '';
        return;
    }
    if (empty) empty.style.display = 'none';

    tbody.innerHTML = list.map(a => {
        const statusKey   = (a.status || 'pending').toLowerCase();
        const statusClass = STATUS_CLASS[statusKey] || 'pending';
        const modeLabel   = MODE_LABELS[a.mode] || (a.mode ? a.mode.replace('_',' ') : '—');
        const typeLabel   = a.type ? a.type.replace('_',' ').replace(/\b\w/g, c => c.toUpperCase()) : '—';
        const counselor   = a.counselor_name || '—';

        return `<tr>
            <td>
                <strong style="font-weight:600;font-size:.9rem;">${escHtml(a.title)}</strong>
                ${a.notes ? `<div style="font-size:.78rem;color:var(--text-secondary);margin-top:2px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${escHtml(a.notes)}</div>` : ''}
            </td>
            <td><span class="mh-type-badge">${escHtml(typeLabel)}</span></td>
            <td><span class="mh-mode-badge">${modeLabel}</span></td>
            <td style="font-size:.88rem;color:var(--text-secondary);">${escHtml(counselor)}</td>
            <td style="font-size:.88rem;white-space:nowrap;">${formatDate(a.date)}</td>
            <td style="font-size:.88rem;font-weight:600;white-space:nowrap;">${formatSlotLabel(a.time?.substring(0,5))}</td>
            <td><span class="mh-status-pill mh-status-pill--${statusClass}">${escHtml(a.status || 'pending')}</span></td>
            <td>
                <div style="display:flex;gap:6px;">
                    <button class="mh-action-btn" onclick="editAppointment(${a.id})" title="Edit">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button class="mh-action-btn mh-action-btn--danger" onclick="deleteAppointment(${a.id})" title="Cancel">
                        <i class="fas fa-trash-can"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

function _updateStats(list) {
    const today     = new Date().toISOString().split('T')[0];
    const total     = list.length;
    const completed = list.filter(a => a.status === 'completed').length;
    const upcoming  = list.filter(a =>
        ['scheduled','accepted','accept','pending'].includes(a.status) && a.date >= today
    ).length;
    const rate = total > 0 ? Math.round((completed / total) * 100) : 0;

    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
    set('totalAppointments',     total);
    set('upcomingAppointments',  upcoming);
    set('completedAppointments', completed);
    set('attendanceRate',        rate + '%');
}

// ─── Edit / Delete ────────────────────────────────────────────────────────────
function editAppointment(id) {
    const a = _appointments.find(x => String(x.id) === String(id));
    if (!a) return;
    openBookingModal(a);
}

async function deleteAppointment(id) {
    if (!confirm('Cancel this appointment? This cannot be undone.')) return;

    try {
        const res  = await fetch(`${BASE}/api/appointments/delete`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ id })
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.error || 'Failed');

        toastSuccess('Appointment cancelled.');
        closeBookingModal();
        setTimeout(() => renderAppointments(), 180);

    } catch (err) {
        toastError('Could not cancel: ' + err.message);
    }
}

// ─── Helpers ──────────────────────────────────────────────────────────────────
function resetForm() {
    const form = document.getElementById('appointmentForm');
    if (form) form.reset();

    const idEl = document.getElementById('appointmentId');
    if (idEl) idEl.value = '';

    const timeSel = document.getElementById('appointmentTime');
    if (timeSel) {
        timeSel.innerHTML = '<option value="">Select counselor &amp; date first</option>';
        timeSel.disabled = true;
    }

    document.querySelectorAll('.mh-field-error').forEach(el => el.textContent = '');

    const submitBtn = document.getElementById('submitAppointmentBtn');
    const submitTxt = document.getElementById('submitBtnText');
    if (submitBtn) submitBtn.disabled = false;
    if (submitTxt) submitTxt.textContent = 'Save Appointment';
}

function exportCsv() {
    if (!_appointments.length) { toastInfo('No appointments to export.'); return; }
    const rows = [
        ['ID','Title','Type','Mode','Counselor','Date','Time','Status','Notes'],
        ..._appointments.map(a => [a.id, a.title, a.type, a.mode, a.counselor_name, a.date, a.time, a.status, a.notes || ''])
    ];
    const csv  = rows.map(r => r.map(f => `"${String(f??'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href = url; a.download = 'appointments.csv'; a.click();
    URL.revokeObjectURL(url);
}

function formatDate(dateString) {
    if (!dateString) return '—';
    const d = new Date(dateString + 'T00:00:00');
    return d.toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
}

function escHtml(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ─── Toast Notifications ──────────────────────────────────────────────────────
function toastSuccess(msg) { toast(msg, '#4CAF82', '✅'); }
function toastError(msg)   { toast(msg, '#D64F4F', '❌'); }
function toastInfo(msg)    { toast(msg, '#3D8B6E', 'ℹ️'); }

function toast(msg, color, icon) {
    document.querySelectorAll('.mh-toast').forEach(t => t.remove());

    const div = document.createElement('div');
    div.className = 'mh-toast';
    div.style.cssText = `
        position:fixed; bottom:28px; right:28px; z-index:99999;
        background:${color}; color:#fff;
        padding:12px 20px; border-radius:12px;
        font-family:'DM Sans','Inter',sans-serif; font-size:.88rem; font-weight:600;
        box-shadow:0 8px 24px rgba(0,0,0,.18);
        display:flex; align-items:center; gap:8px;
        animation:mh-toast-in .3s cubic-bezier(.34,1.56,.64,1);
        max-width:340px;
    `;
    div.innerHTML = `<span>${icon}</span><span>${msg}</span>`;

    if (!document.getElementById('mh-toast-style')) {
        const s = document.createElement('style');
        s.id = 'mh-toast-style';
        s.textContent = '@keyframes mh-toast-in{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}';
        document.head.appendChild(s);
    }

    document.body.appendChild(div);
    setTimeout(() => { div.style.opacity = '0'; div.style.transition = 'opacity .3s'; setTimeout(() => div.remove(), 300); }, 3500);
}
