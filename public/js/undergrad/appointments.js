

// MindHeaven — Appointments JS

// â”€â”€â”€ Constants â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
const ALL_SLOTS = ['09:00', '13:00', '16:00'];
const BASE = window.BASE_URL || '/MindHeaven/public';

const MODE_LABELS = {
    audio_video: 'ðŸŽ¥ Audio/Video',
    chat: 'ðŸ’¬ Chat'
};

const STATUS_CLASS = {
    pending: 'pending',
    scheduled: 'scheduled',
    accepted: 'accepted',
    accept: 'accepted',
    completed: 'completed',
    cancelled: 'cancelled',
    rejected: 'rejected',
    rescheduled: 'pending'
};

let _appointments = [];

// â”€â”€â”€ Init â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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
    const modal = document.getElementById('bookingModal');
    const title = document.getElementById('modalTitle');
    const submitTxt = document.getElementById('submitBtnText');
    if (!modal) return;

    // Reset form and labels
    resetForm();
    if (appointment) {
        if (title) title.textContent = 'Edit Appointment';
        if (submitTxt) submitTxt.textContent = 'Update Appointment';
        prefillForm(appointment);
    } else {
        if (title) title.textContent = 'Book an Appointment';
        if (submitTxt) submitTxt.textContent = 'Save Appointment';
    }

    // Show the overlay (start transparent for fade-in)
    modal.setAttribute('data-open', 'true');
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
                card.style.opacity = '1';
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
    modal.style.opacity = '0';
    if (card) {
        card.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.96) translateY(6px)';
    }

    // Hide after transition completes
    setTimeout(() => {
        modal.setAttribute('data-open', 'false');
        modal.style.cssText = 'display:none;';
        if (card) card.style.cssText = '';
        document.body.style.overflow = '';
        resetForm();
    }, 160);
}

// ─── Prefill (edit mode) ──────────────────────────────────────────────────────
function prefillForm(a) {
    document.getElementById('appointmentId').value = a.id;
    document.getElementById('appointmentTitle').value = a.title || '';
    document.getElementById('appointmentType').value = a.type || '';
    document.getElementById('appointmentMode').value = a.mode || '';
    document.getElementById('appointmentDate').value = a.date || '';
    document.getElementById('appointmentCounselor').value = a.counselor_user_id || '';
    document.getElementById('appointmentNotes').value = a.notes || '';

    const timeSel = document.getElementById('appointmentTime');
    if (timeSel && a.time) {
        const slot = a.time.substring(0, 5);
        timeSel.innerHTML = `<option value="${slot}">${formatSlotLabel(slot)}</option>`;
        timeSel.disabled = false;
    }
}

// â”€â”€â”€ Counselors â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
async function loadCounselors() {
    const sel = document.getElementById('appointmentCounselor');
    if (!sel) return;
    try {
        const res = await fetch(`${BASE}/api/counselors`, { credentials: 'same-origin' });
        const data = await res.json();
        if (!Array.isArray(data) || !data.length) {
            sel.innerHTML = '<option value="">No counselors available</option>';
            return;
        }
        sel.innerHTML = '<option value="">Select a counselorâ€¦</option>' +
            data.map(c => {
                const name = (c.full_name || c.username) + (c.specialization ? ` (${c.specialization})` : '');
                return `<option value="${c.id}">${escHtml(name)}</option>`;
            }).join('');
    } catch {
        sel.innerHTML = '<option value="">Error loading counselors</option>';
    }
}

// â”€â”€â”€ Appointment Types â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function loadAppointmentTypes() {
    const sel = document.getElementById('appointmentType');
    if (!sel) return;
    const types = [
        { value: 'individual', label: 'Individual Therapy' },
        { value: 'group', label: 'Group Therapy' },
        { value: 'crisis', label: 'Crisis Intervention' },
        { value: 'assessment', label: 'Assessment' },
        { value: 'follow_up', label: 'Follow-up Session' }
    ];
    sel.innerHTML = '<option value="">Select typeâ€¦</option>' +
        types.map(t => `<option value="${t.value}">${t.label}</option>`).join('');
}

// â”€â”€â”€ Time Slots â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function formatSlotLabel(time) {
    if (!time) return 'â€”';
    const [h, m] = time.split(':').map(Number);
    const ampm = h >= 12 ? 'PM' : 'AM';
    return `${h % 12 || 12}:${m.toString().padStart(2, '0')} ${ampm}`;
}

async function loadTimeSlots() {
    const counselorId = document.getElementById('appointmentCounselor')?.value;
    const date = document.getElementById('appointmentDate')?.value;
    const timeSel = document.getElementById('appointmentTime');
    if (!timeSel) return;

    if (!counselorId || !date) {
        timeSel.innerHTML = '<option value="">Select counselor &amp; date first</option>';
        timeSel.disabled = true;
        return;
    }

    timeSel.innerHTML = '<option value="">Loading slots...</option>';
    timeSel.disabled = true;

    try {
        const url = `${BASE}/api/appointments/slots?counselor_id=${encodeURIComponent(counselorId)}&date=${encodeURIComponent(date)}`;
        const res = await fetch(url, { credentials: 'same-origin' });
        const data = await res.json();
        const slots = Array.isArray(data.slots) ? data.slots : [];

        if (!slots.length) {
            timeSel.innerHTML = '<option value="">No timeslots set by counselor for this date</option>';
            timeSel.disabled = true;
            return;
        }

        timeSel.innerHTML = '<option value="">Choose a time slot</option>' +
            slots.map(s => {
                const startFmt = formatSlotLabel(s.start_time);
                const endFmt = formatSlotLabel(s.end_time);
                const label = `${startFmt} \u2013 ${endFmt}`;
                const isBooked = s.is_booked == 1 || s.is_booked === '1';
                const isFrozen = s.is_frozen == 1 || s.is_frozen === '1';
                const isUnavailable = isBooked || isFrozen;
                return `<option value="${s.start_time}"${isUnavailable ? ' disabled' : ''}>${label}${isUnavailable ? ' \u2014 \uD83D\uDD12 Booked' : ''}</option>`;
            }).join('');
        timeSel.disabled = false;
    } catch {
        timeSel.innerHTML = '<option value="">Failed to load slots. Try again.</option>';
        timeSel.disabled = false;
    }
}

// â”€â”€â”€ Form Submit â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function setupFormSubmission() {
    document.getElementById('appointmentForm')?.addEventListener('submit', onFormSubmit);
}

async function onFormSubmit(e) {
    e?.preventDefault();

    const id = document.getElementById('appointmentId')?.value?.trim();
    const title = document.getElementById('appointmentTitle')?.value?.trim();
    const type = document.getElementById('appointmentType')?.value;
    const mode = document.getElementById('appointmentMode')?.value;
    const date = document.getElementById('appointmentDate')?.value;
    const time = document.getElementById('appointmentTime')?.value;
    const notes = document.getElementById('appointmentNotes')?.value?.trim() || '';
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

    if (!title) err('titleError', 'Please enter a session title.');
    if (!type) err('typeError', 'Please select a session type.');
    if (!mode) err('modeError', 'Please select a mode.');
    if (!counselorId) err('counselorError', 'Please choose a counselor.');
    if (!date) err('dateError', 'Please pick a date.');
    if (!time) err('timeError', 'Please choose a time slot.');
    if (!valid) return;

    const submitBtn = document.getElementById('submitAppointmentBtn');
    const submitTxt = document.getElementById('submitBtnText');

    if (submitBtn) { submitBtn.disabled = true; }
    if (submitTxt) { submitTxt.textContent = 'Savingâ€¦'; }


    const isUpdate = !!id;
    const endpoint = `${BASE}/api/appointments/${isUpdate ? 'update' : 'create'}`;
    const method = isUpdate ? 'PUT' : 'POST';
    const payload = isUpdate
        ? { id: parseInt(id), title, type, mode, date, time, notes }
        : { counselor_user_id: parseInt(counselorId), title, type, mode, date, time, notes };

    try {
        const res = await fetch(endpoint, {
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

// â”€â”€â”€ Event Listeners â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function setupEventListeners() {
    document.getElementById('appointmentCounselor')?.addEventListener('change', loadTimeSlots);
    document.getElementById('appointmentDate')?.addEventListener('change', loadTimeSlots);
    document.getElementById('resetAppointmentForm')?.addEventListener('click', resetForm);
    document.getElementById('importDemoAppointments')?.addEventListener('click', () =>
        toastInfo('Use the Book Appointment button to add sessions.'));
    document.getElementById('exportAppointmentsCsv')?.addEventListener('click', exportCsv);
}

// â”€â”€â”€ Render Appointments â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
async function renderAppointments() {
    const tbody = document.getElementById('appointmentsTableBody');
    const empty = document.getElementById('appointmentsEmptyState');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading">
        <span class="mh-spinner"></span> Loading appointmentsâ€¦</td></tr>`;
    if (empty) empty.style.display = 'none';

    try {
        const res = await fetch(`${BASE}/api/appointments/mine`, { credentials: 'same-origin' });
        const rows = await res.json();
        _appointments = Array.isArray(rows) ? rows : [];
        _renderRows(_appointments);
        _updateStats(_appointments);
    } catch {
        tbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading" style="color:var(--crisis)">
            Failed to load appointments.</td></tr>`;
    }
}

function _generateRowsHtml(list) {
    if (!list.length) return '';
    return list.map(a => {
        const statusKey = (a.status || 'pending').toLowerCase();
        const statusClass = STATUS_CLASS[statusKey] || 'pending';
        const modeLabel = MODE_LABELS[a.mode] || (a.mode ? a.mode.replace('_', ' ') : '—');
        const typeLabel = a.type ? a.type.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase()) : '—';
        const counselor = a.counselor_name || '—';

        return `<tr>
            <td>
                <strong style="font-weight:600;font-size:.9rem;">${escHtml(a.title)}</strong>
                ${a.notes ? `<div style="font-size:.78rem;color:var(--text-secondary);margin-top:2px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${escHtml(a.notes)}</div>` : ''}
            </td>
            <td><span class="mh-type-badge">${escHtml(typeLabel)}</span></td>
            <td><span class="mh-mode-badge">${modeLabel}</span></td>
            <td style="font-size:.88rem;color:var(--text-secondary);">${escHtml(counselor)}</td>
            <td style="font-size:.88rem;white-space:nowrap;">${formatDate(a.date)}</td>
            <td style="font-size:.88rem;font-weight:600;white-space:nowrap;">${formatSlotLabel(a.time?.substring(0, 5))}</td>
            <td>
                <span class="mh-status-pill mh-status-pill--${statusClass}">${escHtml(a.status || 'pending')}</span>
                ${statusKey === 'rejected' && a.rejection_reason ? `<div style="font-size:.7rem;color:var(--crisis);margin-top:4px;max-width:150px;">Reason: ${escHtml(a.rejection_reason)}</div>` : ''}
                ${statusKey === 'rescheduled' && a.reschedule_reason ? `<div style="font-size:.7rem;color:var(--primary);margin-top:4px;max-width:150px;font-style:italic;">New Time Proposed: ${escHtml(a.reschedule_reason)}</div>` : ''}
            </td>
            <td>
                <div style="display:flex;gap:6px;">
                    ${statusKey === 'rescheduled' ? `
                        <button class="mh-action-btn" style="background:var(--primary);color:white;width:auto;padding:0 8px;font-size:.75rem;" onclick="acceptReschedule(${a.id})" title="Accept New Time">
                            Accept
                        </button>
                    ` : `
                        <button class="mh-action-btn" onclick="editAppointment(${a.id})" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                    `}
                    ${a.meeting_link && (statusKey === 'accepted' || statusKey === 'accept') ? `
                        <button type="button" onclick="promptJoin('${escHtml(a.meeting_link)}')" class="mh-action-btn" style="background:var(--primary);color:white;width:auto;padding:0 12px;font-size:.8rem;display:inline-flex;align-items:center;line-height:30px;border-radius:6px;" title="Join Video Call">
                            <i class="fas fa-video" style="margin-right:6px;"></i> Join Call
                        </button>
                    ` : ''}
                    <button class="mh-action-btn mh-action-btn--danger" onclick="deleteAppointment(${a.id})" title="Cancel">
                        <i class="fas fa-trash-can"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

function _renderRows(list) {
    const tbody = document.getElementById('appointmentsTableBody');
    const upcomingTbody = document.getElementById('upcomingAppointmentsTableBody');
    const empty = document.getElementById('appointmentsEmptyState');

    if (!list.length) {
        if (empty) empty.style.display = 'block';
        if (tbody) tbody.innerHTML = '';
        if (upcomingTbody) upcomingTbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading">No upcoming sessions right now. Let's book one!</td></tr>`;
        return;
    }
    if (empty) empty.style.display = 'none';

    const todayVal = new Date().toISOString().split('T')[0];
    const upcomingList = list.filter(a => ['accepted', 'accept'].includes((a.status || '').toLowerCase()) && a.date >= todayVal);
    
    if (upcomingTbody) {
        if (upcomingList.length) {
            upcomingTbody.innerHTML = _generateRowsHtml(upcomingList);
        } else {
            upcomingTbody.innerHTML = `<tr><td colspan="8" class="mh-table__loading">No upcoming sessions right now. Let's book one!</td></tr>`;
        }
    }

    if (tbody) {
        tbody.innerHTML = _generateRowsHtml(list);
    }
}

function _updateStats(list) {
    const today = new Date().toISOString().split('T')[0];
    const total = list.length;
    const completed = list.filter(a => a.status === 'completed').length;
    const upcoming = list.filter(a =>
        ['scheduled', 'accepted', 'accept', 'pending'].includes(a.status) && a.date >= today
    ).length;
    const rate = total > 0 ? Math.round((completed / total) * 100) : 0;

    const set = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
    set('totalAppointments', total);
    set('upcomingAppointments', upcoming);
    set('completedAppointments', completed);
    set('attendanceRate', rate + '%');
}

// â”€â”€â”€ Edit / Delete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function editAppointment(id) {
    const a = _appointments.find(x => String(x.id) === String(id));
    if (!a) return;
    openBookingModal(a);
}

async function deleteAppointment(id) {
    if (!confirm('Cancel this appointment? This cannot be undone.')) return;

    try {
        const res = await fetch(`${BASE}/api/appointments/delete`, {
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

async function acceptReschedule(id) {
    if (!confirm('Accept this new proposed time for your appointment?')) return;
    try {
        const res = await fetch(`${BASE}/api/appointments/status`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ id, status: 'accepted' })
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.error || 'Failed to accept');
        toastSuccess('Appointment accepted successfully!');
        renderAppointments();
    } catch (err) {
        toastError('Error: ' + err.message);
    }
}

// â”€â”€â”€ Helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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
        ['ID', 'Title', 'Type', 'Mode', 'Counselor', 'Date', 'Time', 'Status', 'Notes'],
        ..._appointments.map(a => [a.id, a.title, a.type, a.mode, a.counselor_name, a.date, a.time, a.status, a.notes || ''])
    ];
    const csv = rows.map(r => r.map(f => `"${String(f ?? '').replace(/"/g, '""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = 'appointments.csv'; a.click();
    URL.revokeObjectURL(url);
}

function formatDate(dateString) {
    if (!dateString) return 'â€”';
    const d = new Date(dateString + 'T00:00:00');
    return d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
}

function escHtml(str) {
    return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// â”€â”€â”€ Toast Notifications â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function toastSuccess(msg) { toast(msg, '#4CAF82', 'âœ…'); }
function toastError(msg) { toast(msg, '#D64F4F', 'âŒ'); }
function toastInfo(msg) { toast(msg, '#3D8B6E', 'â„¹ï¸'); }

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

// ─── Join Preference Logic ──────────────────────────────────────────────────
let activeJoinUrl = '';
let currentCallFrame = null;

function promptJoin(url) {
    activeJoinUrl = url;
    document.getElementById('joinPreferenceModal').style.display = 'flex';
}

function launchDailyCall(audioOnly) {
    document.getElementById('joinPreferenceModal').style.display = 'none';
    if (!activeJoinUrl) return;

    // Show Fullscreen container
    const container = document.getElementById('dailyCallContainer');
    const placeholder = document.getElementById('dailyIframePlaceholder');
    container.style.display = 'block';

    // Clear any existing frame
    placeholder.innerHTML = '';
    if (currentCallFrame) {
        currentCallFrame.destroy();
    }

    try {
        currentCallFrame = window.DailyIframe.createFrame(placeholder, {
            iframeStyle: {
                width: '100%',
                height: '100%',
                border: '0',
                backgroundColor: '#111'
            },
            dailyConfig: {
                startVideoOff: audioOnly,
                startAudioOff: false
            }
        });

        currentCallFrame.join({ url: activeJoinUrl });

        // Listen for user manually ending the call from Daily's internal UI
        currentCallFrame.on('left-meeting', (event) => {
            leaveDailyCall();
        });
    } catch (err) {
        toastError('Failed to initialize video call: ' + err.message);
        leaveDailyCall();
    }
}

function leaveDailyCall() {
    if (currentCallFrame) {
        currentCallFrame.leave();
        currentCallFrame.destroy();
        currentCallFrame = null;
    }
    document.getElementById('dailyCallContainer').style.display = 'none';
    activeJoinUrl = '';
}

document.getElementById('btnJoinVideo')?.addEventListener('click', () => {
    launchDailyCall(false); // Audio & Video
});

document.getElementById('btnJoinAudio')?.addEventListener('click', () => {
    launchDailyCall(true); // Audio Only (disables video initially)
});
