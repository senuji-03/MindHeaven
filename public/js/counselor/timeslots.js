// MindHeaven — Counselor Timeslots JS
// Handles fixed slot selection, custom slot CRUD, day-picker, counter, edit modal.

'use strict';

const BASE = window.BASE_URL || '/MindHeaven/public';

// ── Fixed slot definitions (must match Timeslot::fixedSlots()) ─────────────
const FIXED_SLOTS = [
    { start: '17:00:00', end: '18:00:00', label: '5:00 PM – 6:00 PM' },
    { start: '18:00:00', end: '19:00:00', label: '6:00 PM – 7:00 PM' },
    { start: '19:00:00', end: '20:00:00', label: '7:00 PM – 8:00 PM' },
    { start: '20:00:00', end: '21:00:00', label: '8:00 PM – 9:00 PM' },
];

// ── State ───────────────────────────────────────────────────────────────────
let currentDate    = todayStr();
let allSlots       = [];   // raw DB rows
let fixedDefs      = [];   // server-side fixed definitions with selected state
let customSlots    = [];   // only custom type
let totalCount     = 0;
let editingSlotId  = null;

// ── Init ─────────────────────────────────────────────────────────────────────
function init() {
    const picker = document.getElementById('tsDatePicker');
    if (picker) {
        picker.value = currentDate;
        picker.addEventListener('change', () => {
            currentDate = picker.value;
            loadSlots();
        });
    }

    document.getElementById('btnSaveFixed')?.addEventListener('click', saveFixed);
    document.getElementById('btnAddCustom')?.addEventListener('click', addCustom);

    // Duration hints (create form)
    ['tsStartTime', 'tsEndTime'].forEach(id =>
        document.getElementById(id)?.addEventListener('change', updateDurationHint)
    );

    // Edit modal
    document.getElementById('btnCloseEditModal')?.addEventListener('click', closeEditModal);
    document.getElementById('btnCancelEdit')?.addEventListener('click', closeEditModal);
    document.getElementById('btnConfirmEdit')?.addEventListener('click', confirmEdit);

    // Duration hint (edit modal)
    ['editStartTime', 'editEndTime'].forEach(id =>
        document.getElementById(id)?.addEventListener('change', updateEditDurationHint)
    );

    // Close edit modal on overlay click
    document.getElementById('tsEditModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });

    // Keyboard – close modal on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeEditModal();
    });

    // Render 6 counter dots initially
    renderCounterDots(0, []);

    loadSlots();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

// ── Load all slots for selected date ─────────────────────────────────────────
async function loadSlots() {
    showFixedSkeleton();
    clearCustomList();

    try {
        const url = `${BASE}/api/counselor/timeslots?date=${encodeURIComponent(currentDate)}`;
        const res  = await fetch(url, { credentials: 'same-origin' });
        const data = await res.json();

        allSlots    = data.slots     || [];
        fixedDefs   = data.fixed_defs || [];
        totalCount  = data.total_count || 0;
        customSlots = allSlots.filter(s => s.slot_type === 'custom');

        renderFixedGrid(fixedDefs, allSlots);
        renderCustomList(customSlots);
        renderCounterDots(totalCount, allSlots);
        updateFixedHint();
    } catch (e) {
        showFixedError('Failed to load timeslots. Please refresh.');
        console.error(e);
    }
}

// ── Fixed Slots Grid ──────────────────────────────────────────────────────────
function showFixedSkeleton() {
    const g = document.getElementById('tsFixedGrid');
    if (!g) return;
    g.innerHTML = FIXED_SLOTS.map(() => `<div class="ts-skeleton"></div>`).join('');
}

function showFixedError(msg) {
    const g = document.getElementById('tsFixedGrid');
    if (g) g.innerHTML = `<p style="color:var(--ts-danger);font-size:.85rem;">${esc(msg)}</p>`;
}

function renderFixedGrid(defs, allRows) {
    const g = document.getElementById('tsFixedGrid');
    if (!g) return;

    // Build maps from DB rows
    const bookedMap   = {};
    const selectedMap = {};
    allRows.forEach(r => {
        if (r.slot_type === 'fixed') {
            // Normalise start_time to HH:MM:SS
            const st = r.start_time.length === 5 ? r.start_time + ':00' : r.start_time;
            selectedMap[st] = true;
            if (r.is_booked == 1 || r.is_booked === '1') bookedMap[st] = true;
        }
    });

    g.innerHTML = FIXED_SLOTS.map(fs => {
        const isBooked   = !!bookedMap[fs.start];
        const isSelected = !!selectedMap[fs.start];

        let classes = 'ts-fixed-slot';
        if (isBooked)   classes += ' is-booked';
        else if (isSelected) classes += ' is-selected';

        const checkContent = (isBooked || isSelected) ? '✓' : '';
        const tag = isBooked
            ? `<span class="ts-fixed-slot__tag ts-fixed-slot__tag--booked">Booked</span>`
            : isSelected
                ? `<span class="ts-fixed-slot__tag ts-fixed-slot__tag--selected">Selected</span>`
                : `<span class="ts-fixed-slot__tag ts-fixed-slot__tag--free">Available</span>`;

        const clickAttr = isBooked ? '' : `onclick="toggleFixed('${fs.start}')"`;

        return `
            <div class="${classes}" id="fixed-${fs.start.replace(/:/g,'')}" ${clickAttr} data-start="${fs.start}" role="checkbox" aria-checked="${isSelected}" tabindex="${isBooked ? -1 : 0}">
                <div class="ts-fixed-slot__checkbox">${checkContent}</div>
                <span class="ts-fixed-slot__time">${esc(fs.label)}</span>
                ${tag}
            </div>`;
    }).join('');

    // Keyboard a11y
    g.querySelectorAll('.ts-fixed-slot:not(.is-booked)').forEach(el => {
        el.addEventListener('keydown', e => {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                toggleFixed(el.dataset.start);
            }
        });
    });
}

function toggleFixed(startTime) {
    const el = document.getElementById('fixed-' + startTime.replace(/:/g, ''));
    if (!el || el.classList.contains('is-booked')) return;

    const isSelected = el.classList.contains('is-selected');

    if (!isSelected) {
        // Check if adding this would exceed 6
        const currentSelected = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-selected').length;
        const bookedFixed     = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-booked').length;
        const customCount     = customSlots.length;
        const total           = currentSelected + bookedFixed + customCount;
        if (total >= 6) {
            toastWarn('Maximum 6 timeslots per day reached.');
            return;
        }
    }

    el.classList.toggle('is-selected');
    const nowSelected = el.classList.contains('is-selected');
    el.setAttribute('aria-checked', nowSelected);
    el.querySelector('.ts-fixed-slot__checkbox').textContent = nowSelected ? '✓' : '';

    // Update tag
    const tag = el.querySelector('.ts-fixed-slot__tag');
    if (tag) {
        tag.className = `ts-fixed-slot__tag ts-fixed-slot__tag--${nowSelected ? 'selected' : 'free'}`;
        tag.textContent = nowSelected ? 'Selected' : 'Available';
    }

    updateCounterFromDOM();
    updateFixedHint();
}

async function saveFixed() {
    const selectedEls = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-selected');
    const selected    = Array.from(selectedEls).map(el => el.dataset.start);

    const btn = document.getElementById('btnSaveFixed');
    setLoading(btn, true, 'Saving…');

    try {
        const res  = await fetch(`${BASE}/api/counselor/timeslots/save-fixed`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ date: currentDate, selected }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Server error');
        toastSuccess(data.message || 'Fixed slots saved!');
        loadSlots();
    } catch (e) {
        toastError(e.message);
    } finally {
        setLoading(btn, false, '<i class="fas fa-floppy-disk"></i> Save Fixed Slots');
    }
}

// ── Custom Slots ──────────────────────────────────────────────────────────────
function clearCustomList() {
    const list = document.getElementById('tsCustomList');
    if (list) list.innerHTML = '';
}

function renderCustomList(slots) {
    const list = document.getElementById('tsCustomList');
    if (!list) return;

    if (!slots.length) {
        list.innerHTML = `
            <div class="ts-empty">
                <i class="fas fa-clock"></i>
                No custom slots for this day yet.
            </div>`;
        return;
    }

    list.innerHTML = slots.map(s => {
        const isBooked = s.is_booked == 1 || s.is_booked === '1';
        const dur      = calcDuration(s.start_time, s.end_time);
        const startFmt = formatTime(s.start_time);
        const endFmt   = formatTime(s.end_time);

        return `
            <div class="ts-custom-item ${isBooked ? 'is-booked' : ''}" id="custom-${s.id}">
                <div class="ts-custom-item__icon">
                    <i class="fas fa-${isBooked ? 'lock' : 'clock'}"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="ts-custom-item__time">${esc(startFmt)} – ${esc(endFmt)}</div>
                    <div class="ts-custom-item__duration">${esc(dur)} duration</div>
                </div>
                <span class="ts-custom-item__status ts-custom-item__status--${isBooked ? 'booked' : 'free'}">
                    ${isBooked ? '🔒 Booked' : '✅ Free'}
                </span>
                <div class="ts-custom-item__actions">
                    ${isBooked ? '' : `
                        <button class="ts-icon-btn" title="Edit" onclick="openEditModal(${s.id})"><i class="fas fa-pen"></i></button>
                        <button class="ts-icon-btn ts-icon-btn--danger" title="Delete" onclick="deleteSlot(${s.id})"><i class="fas fa-trash"></i></button>
                    `}
                </div>
            </div>`;
    }).join('');
}

async function addCustom() {
    const startVal = document.getElementById('tsStartTime')?.value;
    const endVal   = document.getElementById('tsEndTime')?.value;
    const errEl    = document.getElementById('tsCustomError');
    if (errEl) errEl.textContent = '';

    if (!startVal || !endVal) {
        if (errEl) errEl.textContent = 'Please set both start and end time.';
        return;
    }

    // Client-side duration check
    const dur = durationMinutes(startVal, endVal);
    if (dur === null || dur < 0) {
        if (errEl) errEl.textContent = 'End time must be after start time.';
        return;
    }
    if (dur < 45) {
        if (errEl) errEl.textContent = `Slots must be at least 45 minutes (currently ${dur} min).`;
        return;
    }

    // Check max 6
    if (totalCount >= 6) {
        if (errEl) errEl.textContent = 'Maximum 6 timeslots per day reached.';
        return;
    }

    const btn = document.getElementById('btnAddCustom');
    setLoading(btn, true, 'Adding…');

    try {
        const res  = await fetch(`${BASE}/api/counselor/timeslots/create-custom`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ date: currentDate, start_time: startVal, end_time: endVal }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Server error');
        toastSuccess('Custom slot added!');
        document.getElementById('tsStartTime').value = '';
        document.getElementById('tsEndTime').value   = '';
        if (errEl) errEl.textContent = '';
        updateDurationHint();
        loadSlots();
    } catch (e) {
        if (errEl) errEl.textContent = e.message;
        toastError(e.message);
    } finally {
        setLoading(btn, false, '<i class="fas fa-plus"></i> Add Custom Slot');
    }
}

async function deleteSlot(id) {
    if (!confirm('Delete this timeslot? This cannot be undone.')) return;
    try {
        const res  = await fetch(`${BASE}/api/counselor/timeslots/delete`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ id }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Failed to delete');
        toastSuccess('Slot deleted.');
        loadSlots();
    } catch (e) {
        toastError(e.message);
    }
}

// ── Edit Modal ────────────────────────────────────────────────────────────────
function openEditModal(id) {
    const slot = customSlots.find(s => String(s.id) === String(id));
    if (!slot) return;

    editingSlotId = id;
    document.getElementById('editSlotId').value   = id;
    document.getElementById('editStartTime').value = slot.start_time.substring(0, 5);
    document.getElementById('editEndTime').value   = slot.end_time.substring(0, 5);
    document.getElementById('tsEditError').textContent = '';
    updateEditDurationHint();

    document.getElementById('tsEditModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('tsEditModal').style.display = 'none';
    document.body.style.overflow = '';
    editingSlotId = null;
}

async function confirmEdit() {
    const id       = editingSlotId;
    const startVal = document.getElementById('editStartTime')?.value;
    const endVal   = document.getElementById('editEndTime')?.value;
    const errEl    = document.getElementById('tsEditError');
    if (errEl) errEl.textContent = '';

    if (!startVal || !endVal) {
        if (errEl) errEl.textContent = 'Both times are required.';
        return;
    }

    const dur = durationMinutes(startVal, endVal);
    if (dur === null || dur < 0) {
        if (errEl) errEl.textContent = 'End time must be after start time.';
        return;
    }
    if (dur < 45) {
        if (errEl) errEl.textContent = `Minimum 45 minutes (currently ${dur} min).`;
        return;
    }

    const btn = document.getElementById('btnConfirmEdit');
    setLoading(btn, true, 'Saving…');

    try {
        const res  = await fetch(`${BASE}/api/counselor/timeslots/update`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ id, date: currentDate, start_time: startVal, end_time: endVal }),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Server error');
        toastSuccess('Timeslot updated!');
        closeEditModal();
        loadSlots();
    } catch (e) {
        if (errEl) errEl.textContent = e.message;
        toastError(e.message);
    } finally {
        setLoading(btn, false, '<i class="fas fa-floppy-disk"></i> Save Changes');
    }
}

// ── Counter ───────────────────────────────────────────────────────────────────
function renderCounterDots(count, slots) {
    const container = document.getElementById('tsCounterDots');
    const textEl    = document.getElementById('tsUsedCount');
    if (!container) return;

    const bookedIds = new Set(slots.filter(s => s.is_booked == 1 || s.is_booked === '1').map(s => s.id));
    const slotArr   = slots.slice(0, 6);
    let html = '';
    for (let i = 0; i < 6; i++) {
        const s = slotArr[i];
        if (!s) {
            html += `<div class="ts-dot"></div>`;
        } else if (s.is_booked == 1 || s.is_booked === '1') {
            html += `<div class="ts-dot ts-dot--used-booked" title="Booked"></div>`;
        } else {
            html += `<div class="ts-dot ts-dot--used" title="Slot available"></div>`;
        }
    }
    container.innerHTML = html;
    if (textEl) textEl.textContent = count;
}

function updateCounterFromDOM() {
    const selectedFixed = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-selected').length;
    const bookedFixed   = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-booked').length;
    const custom        = customSlots.length;
    const total         = selectedFixed + bookedFixed + custom;
    const textEl        = document.getElementById('tsUsedCount');
    if (textEl) textEl.textContent = total;

    const container = document.getElementById('tsCounterDots');
    if (!container) return;
    let html = '';
    for (let i = 0; i < 6; i++) {
        if (i < total) html += `<div class="ts-dot ts-dot--used"></div>`;
        else           html += `<div class="ts-dot"></div>`;
    }
    container.innerHTML = html;
}

// ── Duration Helpers ──────────────────────────────────────────────────────────
function updateDurationHint() {
    const s   = document.getElementById('tsStartTime')?.value;
    const e   = document.getElementById('tsEndTime')?.value;
    const el  = document.getElementById('tsDurationHint');
    const txt = document.getElementById('tsDurationText');
    if (!el || !txt) return;

    if (!s || !e) {
        el.className = 'ts-duration-hint';
        txt.textContent = 'Set start and end time to calculate duration';
        return;
    }
    const dur = durationMinutes(s, e);
    if (dur === null || dur <= 0) {
        el.className = 'ts-duration-hint invalid';
        txt.textContent = 'End time must be after start time';
        return;
    }
    const valid = dur >= 45;
    el.className = `ts-duration-hint ${valid ? 'valid' : 'invalid'}`;
    txt.textContent = `Duration: ${formatMinutes(dur)} ${valid ? '✅' : '⚠️ (min 45 min)'}`;
}

function updateEditDurationHint() {
    const s   = document.getElementById('editStartTime')?.value;
    const e   = document.getElementById('editEndTime')?.value;
    const el  = document.getElementById('editDurationHint');
    const txt = document.getElementById('editDurationText');
    if (!el || !txt) return;

    if (!s || !e) {
        el.className = 'ts-duration-hint';
        txt.textContent = 'Set start and end time';
        return;
    }
    const dur = durationMinutes(s, e);
    if (dur === null || dur <= 0) {
        el.className = 'ts-duration-hint invalid';
        txt.textContent = 'End time must be after start time';
        return;
    }
    const valid = dur >= 45;
    el.className = `ts-duration-hint ${valid ? 'valid' : 'invalid'}`;
    txt.textContent = `Duration: ${formatMinutes(dur)} ${valid ? '✅' : '⚠️ (min 45 min)'}`;
}

// ── Fixed Hint ────────────────────────────────────────────────────────────────
function updateFixedHint() {
    const el       = document.getElementById('tsFixedHint');
    if (!el) return;
    const selected = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-selected').length;
    const booked   = document.querySelectorAll('#tsFixedGrid .ts-fixed-slot.is-booked').length;
    el.textContent = `${selected} selected, ${booked} booked`;
}

// ── Utilities ─────────────────────────────────────────────────────────────────
function durationMinutes(start, end) {
    if (!start || !end) return null;
    const [sh, sm] = start.split(':').map(Number);
    const [eh, em] = end.split(':').map(Number);
    return (eh * 60 + em) - (sh * 60 + sm);
}

function formatMinutes(m) {
    if (m < 60) return `${m} min`;
    const h = Math.floor(m / 60);
    const r = m % 60;
    return r ? `${h}h ${r}min` : `${h} hr`;
}

function calcDuration(s, e) {
    // s and e are HH:MM or HH:MM:SS
    const start = s.substring(0, 5);
    const end   = e.substring(0, 5);
    const m = durationMinutes(start, end);
    if (m === null) return '—';
    return formatMinutes(m);
}

function formatTime(t) {
    if (!t) return '—';
    const parts = t.substring(0, 5).split(':');
    let h = parseInt(parts[0]);
    const m   = parts[1];
    const ap  = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    return `${h}:${m} ${ap}`;
}

function todayStr() {
    return new Date().toISOString().split('T')[0];
}

function esc(str) {
    return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function setLoading(btn, loading, label) {
    if (!btn) return;
    btn.disabled = loading;
    btn.innerHTML = loading ? `<span class="ts-spinner-inline"></span> ${label}` : label;
}

// ── Toast ─────────────────────────────────────────────────────────────────────
function toastSuccess(msg) { showToast(msg, '#3D8B6E', '✅'); }
function toastError(msg)   { showToast(msg, '#D64F4F', '❌'); }
function toastWarn(msg)    { showToast(msg, '#F0B429', '⚠️'); }

function showToast(msg, color, icon) {
    document.querySelectorAll('.ts-toast').forEach(t => t.remove());
    const div = document.createElement('div');
    div.className = 'ts-toast';
    div.style.background = color;
    div.innerHTML = `<span>${icon}</span><span>${esc(msg)}</span>`;
    document.body.appendChild(div);
    setTimeout(() => { div.style.opacity='0'; div.style.transition='opacity .3s'; setTimeout(()=>div.remove(), 300); }, 3500);
}

// Inline spinner style (injected once)
(function() {
    if (document.getElementById('ts-spinner-style')) return;
    const s = document.createElement('style');
    s.id = 'ts-spinner-style';
    s.textContent = `.ts-spinner-inline{display:inline-block;width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:ts-spin .65s linear infinite;vertical-align:middle;}@keyframes ts-spin{to{transform:rotate(360deg)}}`;
    document.head.appendChild(s);
})();
