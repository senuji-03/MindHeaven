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

// ── Generate PDF Report ───────────────────────────────────────
function generateReport(sessionId) {
    var session = null;
    for (var i = 0; i < sessionHistory.length; i++) {
        if (String(sessionHistory[i].id) === String(sessionId)) { session = sessionHistory[i]; break; }
    }
    if (!session) return;

    // Determine status label & colour
    var statusColors = {
        'completed':  { bg: '#d1fae5', color: '#065f46', label: 'Completed' },
        'cancelled':  { bg: '#fee2e2', color: '#991b1b', label: 'Cancelled' },
        'no-show':    { bg: '#fef3c7', color: '#92400e', label: 'No Show'   },
        'rescheduled':{ bg: '#ede9fe', color: '#5b21b6', label: 'Rescheduled'},
        'overdue':    { bg: '#ffedd5', color: '#9a3412', label: 'Overdue'   },
    };
    var sc = statusColors[session.status] || { bg: '#e0e7ef', color: '#374151', label: session.status };

    // Build notes section HTML
    var notesSection = '';
    if (session.counselorNotes) {
        notesSection +=
            '<div class="section">' +
                '<div class="section-title">Counselor Session Notes</div>' +
                '<div class="notes-box counselor-notes">' + escHtml(session.counselorNotes).replace(/\n/g, '<br>') + '</div>' +
            '</div>';
    }
    if (session.notes) {
        notesSection +=
            '<div class="section">' +
                '<div class="section-title">Student Booking Notes</div>' +
                '<div class="notes-box">' + escHtml(session.notes).replace(/\n/g, '<br>') + '</div>' +
            '</div>';
    }
    if (!notesSection) {
        notesSection =
            '<div class="section">' +
                '<div class="section-title">Session Notes</div>' +
                '<p style="color:#6b7280; font-style:italic;">No notes recorded for this session.</p>' +
            '</div>';
    }

    // Cancellation / reschedule reason
    var extraSection = '';
    if (session.status === 'cancelled' && session.rejectionReason) {
        extraSection =
            '<div class="section">' +
                '<div class="section-title">Cancellation Reason</div>' +
                '<div class="notes-box" style="border-left-color:#ef4444;">' + escHtml(session.rejectionReason) + '</div>' +
            '</div>';
    } else if (session.status === 'rescheduled' && session.rescheduleReason) {
        extraSection =
            '<div class="section">' +
                '<div class="section-title">Reschedule Reason</div>' +
                '<div class="notes-box" style="border-left-color:#8b5cf6;">' + escHtml(session.rescheduleReason) + '</div>' +
            '</div>';
    }

    var reportDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

    var html =
        '<!DOCTYPE html>' +
        '<html lang="en"><head><meta charset="UTF-8">' +
        '<title>Session Report – ' + escHtml(session.patientName) + '</title>' +
        '<style>' +
            '@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");' +
            '*{margin:0;padding:0;box-sizing:border-box;}' +
            'body{font-family:"Inter",sans-serif;font-size:13px;color:#1a1a2e;background:#fff;padding:40px 48px;}' +
            '.header{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:2px solid #3D8B6E;padding-bottom:18px;margin-bottom:28px;}' +
            '.brand{display:flex;align-items:center;gap:12px;}' +
            '.brand-dot{width:36px;height:36px;border-radius:50%;background:#3D8B6E;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;font-weight:700;}' +
            '.brand-name{font-size:22px;font-weight:700;color:#2A6B52;}' +
            '.report-meta{text-align:right;font-size:11px;color:#6b7280;}' +
            '.report-meta strong{display:block;font-size:13px;color:#1a1a2e;margin-bottom:2px;}' +
            'h1{font-size:18px;font-weight:700;color:#2A6B52;margin-bottom:4px;}' +
            '.subtitle{font-size:12px;color:#6b7280;margin-bottom:24px;}' +
            '.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:24px;}' +
            '.info-card{background:#f8faf9;border:1px solid #d6e4dd;border-radius:8px;padding:14px 16px;}' +
            '.info-card .label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#6B8C7E;margin-bottom:5px;}' +
            '.info-card .value{font-size:13px;font-weight:600;color:#1a1a2e;}' +
            '.status-badge{display:inline-block;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:700;background:' + sc.bg + ';color:' + sc.color + ';}' +
            '.section{margin-bottom:20px;}' +
            '.section-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#6B8C7E;margin-bottom:8px;padding-bottom:6px;border-bottom:1px solid #e5e7eb;}' +
            '.notes-box{background:#f8faf9;border-left:4px solid #3D8B6E;border-radius:4px;padding:12px 16px;font-size:12.5px;line-height:1.7;color:#374151;}' +
            '.counselor-notes{background:#f0fdf4;border-left-color:#16a34a;}' +
            '.divider{border:none;border-top:1px solid #e5e7eb;margin:24px 0;}' +
            '.footer{margin-top:32px;padding-top:16px;border-top:1px solid #d6e4dd;display:flex;justify-content:space-between;font-size:10px;color:#9ca3af;}' +
            '@media print{' +
                'body{padding:20px 28px;}' +
                '@page{size:A4;margin:15mm 18mm;}' +
                '.no-print{display:none!important;}' +
            '}' +
        '</style></head><body>' +

        // Print button (hidden during print)
        '<div class="no-print" style="text-align:right;margin-bottom:20px;">' +
            '<button onclick="window.print()" style="background:#3D8B6E;color:#fff;border:none;border-radius:6px;padding:9px 22px;font-size:13px;font-weight:600;cursor:pointer;">⬇ Download / Print PDF</button>' +
        '</div>' +

        // Header
        '<div class="header">' +
            '<div class="brand">' +
                '<div class="brand-dot">M</div>' +
                '<span class="brand-name">MindHeaven</span>' +
            '</div>' +
            '<div class="report-meta"><strong>Session Report</strong>Generated: ' + reportDate + '<br>Report ID: #' + escHtml(String(session.id)) + '</div>' +
        '</div>' +

        // Title
        '<h1>Session Summary Report</h1>' +
        '<p class="subtitle">Confidential — For authorised clinical use only</p>' +

        // Info grid
        '<div class="info-grid">' +
            '<div class="info-card"><div class="label">Patient Name</div><div class="value">' + escHtml(session.patientName) + '</div></div>' +
            '<div class="info-card"><div class="label">Patient ID</div><div class="value">' + escHtml(session.userId) + '</div></div>' +
            '<div class="info-card"><div class="label">Session Date</div><div class="value">' + formatDate(session.date) + '</div></div>' +
            '<div class="info-card"><div class="label">Session Time</div><div class="value">' + escHtml(session.time) + ' &nbsp;(' + escHtml(session.duration) + ')</div></div>' +
            '<div class="info-card"><div class="label">Session Type</div><div class="value">' + escHtml(session.sessionType) + '</div></div>' +
            '<div class="info-card"><div class="label">Status</div><div class="value"><span class="status-badge">' + sc.label + '</span></div></div>' +
        '</div>' +

        // Reason for session
        '<div class="section">' +
            '<div class="section-title">Reason for Session / Appointment Title</div>' +
            '<div class="notes-box" style="border-left-color:#6BB89A;">' + (session.reason ? escHtml(session.reason) : '<em style="color:#9ca3af;">Not specified</em>') + '</div>' +
        '</div>' +

        extraSection +
        notesSection +

        '<div class="footer">' +
            '<span>MindHeaven Counseling Platform &mdash; Confidential</span>' +
            '<span>Session ID: #' + escHtml(String(session.id)) + '</span>' +
        '</div>' +

        '</body></html>';

    var win = window.open('', '_blank', 'width=860,height=960');
    if (!win) {
        alert('Please allow pop-ups for this site to download the report.');
        return;
    }
    win.document.open();
    win.document.write(html);
    win.document.close();

    // Auto-trigger print dialog after fonts load
    win.onload = function () {
        setTimeout(function () { win.print(); }, 400);
    };
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