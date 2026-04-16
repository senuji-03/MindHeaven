// ============================================================
// sessionHistory.js  – fetches real data from the PHP backend
// ============================================================

let sessionHistory  = [];   // full dataset returned from the API
let filteredHistory = [];   // currently displayed subset

// ── Bootstrap ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    setDateDefaults();
    loadSessionHistory();   // initial load – all history statuses

    // Patient name: real-time search
    document.getElementById('patientFilter').addEventListener('input', function () {
        if (this.value.length > 2 || this.value.length === 0) {
            applyFilters();
        }
    });

    // Date range: re-filter on change
    document.getElementById('dateFromFilter').addEventListener('change', applyFilters);
    document.getElementById('dateToFilter').addEventListener('change', applyFilters);

    // Status dropdown: re-fetch from server with the selected status
    document.getElementById('statusFilter').addEventListener('change', function () {
        loadSessionHistory(this.value);
    });

    console.log('Mindheaven Session History loaded successfully!');
});

// ── API fetch ────────────────────────────────────────────────
/**
 * Fetch sessions from the server.
 * @param {string} statusFilter  completed | cancelled | no_show | no-show | rescheduled | '' (all)
 */
function loadSessionHistory(statusFilter) {
    statusFilter = statusFilter || '';

    let url = '/MindHeaven/public/api/counselor/session-history';
    if (statusFilter !== '') {
        url += '?status=' + encodeURIComponent(statusFilter);
    }

    // Show loading indicator
    const tbody = document.getElementById('historyTableBody');
    tbody.innerHTML = '<tr><td colspan="5" class="loading"><div class="loading-spinner"></div><div>Loading sessions&hellip;</div></td></tr>';

    fetch(url, { credentials: 'same-origin' })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.error) {
                tbody.innerHTML = '<tr><td colspan="5" class="empty-state"><div class="empty-icon"><i class="fa-solid fa-triangle-exclamation"></i></div><div>' + escHtml(data.error) + '</div></td></tr>';
                return;
            }

            sessionHistory  = data.sessions || [];
            filteredHistory = sessionHistory.slice();

            // Stats come from server (always covers the full history, not just the filtered subset)
            if (data.stats) {
                updateStatsFromServer(data.stats);
            } else {
                updateStats();
            }

            // Then apply patient / date filters client-side
            applyClientFilters();
        })
        .catch(function (err) {
            console.error('Failed to load session history:', err);
            tbody.innerHTML = '<tr><td colspan="5" class="empty-state"><div class="empty-icon"><i class="fa-solid fa-triangle-exclamation"></i></div><div>Could not load session history. Please try refreshing the page.</div></td></tr>';
        });
}

// ── Stat cards ───────────────────────────────────────────────

function updateStatsFromServer(stats) {
    document.getElementById('totalSessions').textContent     = stats.total      || 0;
    document.getElementById('monthSessions').textContent     = stats.this_month || 0;
    document.getElementById('completedSessions').textContent = stats.completed  || 0;
    document.getElementById('cancelledSessions').textContent = stats.cancelled  || 0;
    if (document.getElementById('overdueSessions')) {
        document.getElementById('overdueSessions').textContent = stats.overdue || 0;
    }
}

function updateStats() {
    var today = new Date();
    var thisMonth = sessionHistory.filter(function (s) {
        var d = new Date(s.date);
        return d.getMonth() === today.getMonth() && d.getFullYear() === today.getFullYear();
    }).length;

    var overdue = sessionHistory.filter(function (s) {
        var isPendingStatus = ['scheduled', 'confirmed', 'accept', 'accepted', 'pending'].includes(s.status);
        var sessionFullDate = new Date(s.date + ' ' + (s.rawTime || '00:00:00'));
        return isPendingStatus && sessionFullDate < today;
    }).length;

    document.getElementById('totalSessions').textContent     = sessionHistory.length;
    document.getElementById('monthSessions').textContent     = thisMonth;
    document.getElementById('completedSessions').textContent = sessionHistory.filter(function (s) { return s.status === 'completed'; }).length;
    document.getElementById('cancelledSessions').textContent = sessionHistory.filter(function (s) { return s.status === 'cancelled'; }).length;
    if (document.getElementById('overdueSessions')) {
        document.getElementById('overdueSessions').textContent = overdue;
    }
}

// ── Client-side filters (patient name + date range) ──────────

function applyClientFilters() {
    var patientFilter  = document.getElementById('patientFilter').value.toLowerCase().trim();
    var dateFromFilter = document.getElementById('dateFromFilter').value;
    var dateToFilter   = document.getElementById('dateToFilter').value;

    filteredHistory = sessionHistory.filter(function (session) {
        var matchesPatient = patientFilter === '' ||
            session.patientName.toLowerCase().indexOf(patientFilter) !== -1 ||
            String(session.userId).toLowerCase().indexOf(patientFilter) !== -1;

        var matchesDateFrom = dateFromFilter === '' || session.date >= dateFromFilter;
        var matchesDateTo   = dateToFilter   === '' || session.date <= dateToFilter;

        return matchesPatient && matchesDateFrom && matchesDateTo;
    });

    renderSessionHistory();
}

/** Called by the Filter button. */
function applyFilters() {
    applyClientFilters();
}

/** Clear all filters + reload unfiltered data from server. */
function clearFilters() {
    document.getElementById('patientFilter').value  = '';
    document.getElementById('dateFromFilter').value = '';
    document.getElementById('dateToFilter').value   = '';
    document.getElementById('statusFilter').value   = '';
    loadSessionHistory('');
}

// ── Default date range (last 30 days) ────────────────────────
function setDateDefaults() {
    var today       = new Date();
    var thirtyAgo   = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
    document.getElementById('dateFromFilter').value = thirtyAgo.toISOString().split('T')[0];
    document.getElementById('dateToFilter').value   = today.toISOString().split('T')[0];
}

// ── Table rendering ──────────────────────────────────────────
function renderSessionHistory() {
    var tbody = document.getElementById('historyTableBody');

    if (filteredHistory.length === 0) {
        tbody.innerHTML =
            '<tr><td colspan="5" class="empty-state">' +
            '<div class="empty-icon"><i class="fa-regular fa-clipboard"></i></div>' +
            '<div>No sessions found matching your criteria</div>' +
            '</td></tr>';
        return;
    }

    tbody.innerHTML = filteredHistory.map(function (session) {
        var sid = String(session.id);
        var notesHtml = escHtml(session.notes || '');

        var toggleBtn = notesHtml.length > 150
            ? '<div class="notes-toggle" onclick="toggleNotes(\'' + sid + '\')">' +
              '<span id="toggle-text-' + sid + '">Show more</span></div>'
            : '';

        var isPendingStatus = ['scheduled', 'confirmed', 'accept', 'accepted', 'pending'].includes(session.status);
        var sessionFullDate = new Date(session.date + ' ' + (session.rawTime || '00:00:00'));
        var now = new Date();
        
        var statusBadge = '';
        if (isPendingStatus && sessionFullDate < now) {
            statusBadge = '<span class="status-badge status-overdue">Overdue</span>';
        } else {
            statusBadge = '<span class="status-badge status-' + escHtml(session.status) + '">' +
                session.status.replace('-', ' ') +
                '</span>';
        }

        return '<tr>' +
            '<td><div class="patient-info">' +
                '<div class="patient-name">' + escHtml(session.patientName) + '</div>' +
                '<div class="patient-id">ID: ' + escHtml(session.userId) + '</div>' +
            '</div></td>' +
            '<td><div class="session-datetime">' +
                '<div class="session-date">'     + formatDate(session.date)    + '</div>' +
                '<div class="session-time">'     + escHtml(session.time)       + '</div>' +
                '<div class="session-duration">' + escHtml(session.duration)   + '</div>' +
            '</div></td>' +
            '<td>' + statusBadge + '</td>' +
            '<td><div class="session-notes">' +
                '<div class="notes-preview" id="notes-preview-' + sid + '">' + notesHtml + '</div>' +
                '<div class="notes-full"    id="notes-full-'    + sid + '">' + notesHtml + '</div>' +
                toggleBtn +
            '</div></td>' +
            '<td><div class="action-buttons">' +
                '<button class="btn-small btn-view"   onclick="viewSessionDetail(\'' + sid + '\')"><i class="fa-regular fa-eye"></i> View</button>' +
                '<button class="btn-small btn-report" onclick="generateReport(\''    + sid + '\')"><i class="fa-solid fa-download"></i> Report</button>' +
            '</div></td>' +
            '</tr>';
    }).join('');
}

// ── Helpers ──────────────────────────────────────────────────
function escHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;');
}

function formatDate(dateString) {
    if (!dateString) return '';
    var date    = new Date(dateString);
    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function formatTime(timeStr) {
    if (!timeStr) return '';
    // timeStr is HH:MM:SS
    var parts = timeStr.split(':');
    var hour = parseInt(parts[0]);
    var ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12;
    hour = hour ? hour : 12; // the hour '0' should be '12'
    return hour + ':' + parts[1] + ' ' + ampm;
}

function toggleNotes(sessionId) {
    var preview    = document.getElementById('notes-preview-' + sessionId);
    var full       = document.getElementById('notes-full-'    + sessionId);
    var toggleText = document.getElementById('toggle-text-'   + sessionId);

    if (preview.style.display !== 'none') {
        preview.style.display = 'none';
        full.style.display    = 'block';
        toggleText.textContent = 'Show less';
    } else {
        preview.style.display = 'block';
        full.style.display    = 'none';
        toggleText.textContent = 'Show more';
    }
}

// ── Session detail modal ─────────────────────────────────────
function viewSessionDetail(sessionId) {
    var session = null;
    for (var i = 0; i < sessionHistory.length; i++) {
        if (String(sessionHistory[i].id) === String(sessionId)) {
            session = sessionHistory[i];
            break;
        }
    }
    if (!session) return;

    document.getElementById('sessionDetailTitle').textContent = 'Session Details – ' + session.patientName;

    var extraInfo = '';
    if (session.status === 'cancelled' && session.rejectionReason) {
        extraInfo = '<div class="detail-card" style="border-left-color: var(--text-secondary);">' +
            '<div class="detail-label">Cancellation Reason</div>' +
            '<div class="detail-value">' + escHtml(session.rejectionReason) + '</div>' +
            '</div>';
    } else if (session.status === 'rescheduled' && session.rescheduleReason) {
        extraInfo = '<div class="detail-card" style="border-left-color: #5b21b6;">' +
            '<div class="detail-label">Reschedule Reason</div>' +
            '<div class="detail-value">' + escHtml(session.rescheduleReason) + '</div>' +
            '</div>';
    }

    var scheduleInfo = '<div class="detail-card"><div class="detail-label">Date &amp; Time</div>' +
        '<div class="detail-value">' + formatDate(session.date) + '<br>' + escHtml(session.time) + ' <span style="color:var(--text-secondary); font-size:0.85em;">(' + escHtml(session.duration) + ')</span></div></div>';

    if (session.originalDate) {
        scheduleInfo = '<div class="detail-card" style="border-left-color: var(--accent-warm);">' +
            '<div class="detail-label">Initial Booking Request</div>' +
            '<div class="detail-value" style="color: var(--text-secondary);">' + formatDate(session.originalDate) + ' — ' + formatTime(session.originalTime) + '</div>' +
            '</div>' +
            '<div class="detail-card" style="border-left-color: var(--success);">' +
            '<div class="detail-label">Final Schedule</div>' +
            '<div class="detail-value">' + formatDate(session.date) + ' — ' + escHtml(session.time) + '</div>' +
            '</div>';
    }

    document.getElementById('sessionDetailBody').innerHTML =
        '<div class="session-detail-grid">' +
            '<div class="detail-card"><div class="detail-label">Patient Information</div>' +
                '<div class="detail-value"><strong>' + escHtml(session.patientName) + '</strong><br><span style="font-size:0.85em;color:var(--text-secondary);">User ID: ' + escHtml(session.userId) + '</span></div></div>' +
            '<div class="detail-card"><div class="detail-label">Session Information</div>' +
                '<div class="detail-value">Session ID: #' + escHtml(String(session.id)) + '<br>Type: ' + escHtml(session.sessionType) + '</div></div>' +
            scheduleInfo +
            '<div class="detail-card"><div class="detail-label">Status</div>' +
                '<div class="detail-value"><span class="status-badge status-' + escHtml(session.status) + '">' + session.status.replace('-', ' ') + '</span></div></div>' +
            '<div class="detail-card"><div class="detail-label">Reason for Session</div>' +
                '<div class="detail-value">' + escHtml(session.reason) + '</div></div>' +
            '<div class="detail-card"><div class="detail-label">Next Appointment</div>' +
                '<div class="detail-value">' + escHtml(session.nextAppointment) + '</div></div>' +
            extraInfo +
        '</div>' +
        (session.counselorNotes ? 
        '<div class="detail-card" style="margin-top:1rem; border-left: 4px solid var(--success); background: #f0fdf4;">' +
            '<div class="detail-label" style="color: #166534;"><i class="fa-solid fa-clipboard-check"></i> Counselor Session Notes</div>' +
            '<div class="detail-value" style="white-space:pre-wrap;line-height:1.6; color: #15803d; font-size:0.95em;">' + escHtml(session.counselorNotes) + '</div>' +
        '</div>' : '') +
        '<div class="detail-card" style="margin-top:1rem; border-left-color: var(--primary-light);">' +
            '<div class="detail-label"><i class="fa-regular fa-comment-dots"></i> Student\'s Booking Notes & Reasons</div>' +
            '<div class="detail-value" style="white-space:pre-wrap;line-height:1.6; font-size:0.95em; color:var(--text-secondary);">' + (session.notes ? escHtml(session.notes) : 'No additional notes provided.') + '</div>' +
        '</div>';

    document.getElementById('sessionDetailModal').style.display = 'block';
}

function closeSessionDetail() {
    document.getElementById('sessionDetailModal').style.display = 'none';
}

// ── Generate report (placeholder) ───────────────────────────
function generateReport(sessionId) {
    var session = null;
    for (var i = 0; i < sessionHistory.length; i++) {
        if (String(sessionHistory[i].id) === String(sessionId)) { session = sessionHistory[i]; break; }
    }
    if (!session) return;
    alert('Generating report for ' + session.patientName + '…\nThis would typically create a PDF with session details and progress notes.');
}

// ── Export to CSV ────────────────────────────────────────────
function exportHistory() {
    var header = 'Session ID,Patient Name,User ID,Date,Time,Duration,Status,Session Type,Reason,Notes,Next Appointment\n';
    var rows = filteredHistory.map(function (s) {
        return [s.id, s.patientName, s.userId, s.date, s.time, s.duration,
                s.status, s.sessionType, s.reason,
                s.notes.replace(/"/g, '""'), s.nextAppointment]
            .map(function (v) { return '"' + v + '"'; }).join(',');
    }).join('\n');

    var encodedUri = encodeURI('data:text/csv;charset=utf-8,' + header + rows);
    var link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'session_history_' + new Date().toISOString().split('T')[0] + '.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ── Auto-refresh every 5 minutes ─────────────────────────────
setInterval(function () {
    var currentStatus = document.getElementById('statusFilter').value || '';
    loadSessionHistory(currentStatus);
}, 300000);

// ── Close modal on outside click ─────────────────────────────
window.onclick = function (event) {
    var modal = document.getElementById('sessionDetailModal');
    if (event.target === modal) {
        closeSessionDetail();
    }
};