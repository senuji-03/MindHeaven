<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MindHeaven Crisis Hotline Responder Dashboard – manage incoming calls, escalations, and session notes.">
    <title>Crisis Hotline Responder Dashboard | MindHeaven</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/crisis/crisis_dashboard.css?v=<?= time() ?>">
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <span class="logo-icon">🧠</span>
        <span class="logo-text">MindHeaven</span>
    </div>

    <nav class="sidebar-nav">
        <a href="#" class="nav-item active" data-section="dashboard">
            <span class="nav-icon">📊</span>
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="#" class="nav-item" data-section="call-queue">
            <span class="nav-icon">📋</span>
            <span class="nav-label">Call Queue</span>
            <span class="nav-badge" id="queue-badge">3</span>
        </a>
        <a href="#" class="nav-item" data-section="active-calls">
            <span class="nav-icon">📞</span>
            <span class="nav-label">Active Calls</span>
            <span class="nav-badge live" id="active-badge">0</span>
        </a>
        <a href="#" class="nav-item" data-section="escalations">
            <span class="nav-icon">🚨</span>
            <span class="nav-label">Escalations</span>
            <span class="nav-badge danger" id="esc-badge">1</span>
        </a>
        <a href="#" class="nav-item" data-section="call-history">
            <span class="nav-icon">📁</span>
            <span class="nav-label">Call History</span>
        </a>
    </nav>

    <div class="sidebar-responder">
        <div class="responder-avatar">CR</div>
        <div class="responder-info">
            <span class="responder-name">Responder On Duty</span>
            <span class="responder-status-dot"></span>
            <span class="responder-status-text">Online</span>
        </div>
    </div>
</aside>

<!-- ===== MAIN CONTENT ===== -->
<main class="main-content">

    <!-- Top Header Bar -->
    <header class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">☰</button>
        <div class="topbar-title">
            <h1>Crisis Hotline Responder Dashboard</h1>
            <p class="topbar-subtitle">Real-time crisis support management</p>
        </div>
        <div class="topbar-meta">
            <div class="topbar-clock" id="liveClock">--:--:--</div>
            <div class="status-indicator">
                <span class="pulse-dot"></span>
                <span>System Live</span>
            </div>
        </div>
    </header>

    <!-- ===== STATS STRIP ===== -->
    <section class="stats-strip">
        <div class="stat-card">
            <span class="stat-icon">📞</span>
            <div>
                <p class="stat-value" id="stat-incoming">4</p>
                <p class="stat-label">Incoming</p>
            </div>
        </div>
        <div class="stat-card active-stat">
            <span class="stat-icon">🔴</span>
            <div>
                <p class="stat-value" id="stat-active">0</p>
                <p class="stat-label">Active Now</p>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">⏳</span>
            <div>
                <p class="stat-value" id="stat-queue">3</p>
                <p class="stat-label">In Queue</p>
            </div>
        </div>
        <div class="stat-card escalated-stat">
            <span class="stat-icon">🚨</span>
            <div>
                <p class="stat-value" id="stat-escalated">1</p>
                <p class="stat-label">Escalated</p>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon">✅</span>
            <div>
                <p class="stat-value" id="stat-handled">12</p>
                <p class="stat-label">Handled Today</p>
            </div>
        </div>
    </section>

    <!-- ===== MAIN GRID ===== -->
    <div class="dashboard-grid">

        <!-- LEFT COLUMN -->
        <div class="col-left">

            <!-- 1. INCOMING CALLS -->
            <div class="card" id="section-incoming">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">📲</span> Incoming Calls</h2>
                    <span class="badge badge-blue blink">LIVE</span>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="data-table" id="incoming-calls-table">
                            <thead>
                                <tr>
                                    <th>Caller ID</th>
                                    <th>Time Received</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="incoming-calls-body">
                                <tr data-call-id="CALL-0041" data-type="Audio" data-priority="high">
                                    <td><strong>#CALL-0041</strong></td>
                                    <td>23:47:12</td>
                                    <td><span class="type-badge audio">🎙 Audio</span></td>
                                    <td><span class="priority-badge high">🔴 High</span></td>
                                    <td><span class="badge badge-blue">Incoming</span></td>
                                    <td class="action-cell">
                                        <button class="btn btn-accept btn-sm" onclick="acceptCall(this)">✓ Accept</button>
                                        <button class="btn btn-decline btn-sm" onclick="declineCall(this)">✕ Decline</button>
                                    </td>
                                </tr>
                                <tr data-call-id="CALL-0042" data-type="Video" data-priority="medium">
                                    <td><strong>#CALL-0042</strong></td>
                                    <td>23:49:05</td>
                                    <td><span class="type-badge video">📹 Video</span></td>
                                    <td><span class="priority-badge medium">🟡 Medium</span></td>
                                    <td><span class="badge badge-blue">Incoming</span></td>
                                    <td class="action-cell">
                                        <button class="btn btn-accept btn-sm" onclick="acceptCall(this)">✓ Accept</button>
                                        <button class="btn btn-decline btn-sm" onclick="declineCall(this)">✕ Decline</button>
                                    </td>
                                </tr>
                                <tr data-call-id="CALL-0043" data-type="Audio" data-priority="low">
                                    <td><strong>#CALL-0043</strong></td>
                                    <td>23:51:30</td>
                                    <td><span class="type-badge audio">🎙 Audio</span></td>
                                    <td><span class="priority-badge low">🟢 Low</span></td>
                                    <td><span class="badge badge-blue">Incoming</span></td>
                                    <td class="action-cell">
                                        <button class="btn btn-accept btn-sm" onclick="acceptCall(this)">✓ Accept</button>
                                        <button class="btn btn-decline btn-sm" onclick="declineCall(this)">✕ Decline</button>
                                    </td>
                                </tr>
                                <tr data-call-id="CALL-0044" data-type="Video" data-priority="high">
                                    <td><strong>#CALL-0044</strong></td>
                                    <td>23:53:18</td>
                                    <td><span class="type-badge video">📹 Video</span></td>
                                    <td><span class="priority-badge high">🔴 High</span></td>
                                    <td><span class="badge badge-blue">Incoming</span></td>
                                    <td class="action-cell">
                                        <button class="btn btn-accept btn-sm" onclick="acceptCall(this)">✓ Accept</button>
                                        <button class="btn btn-decline btn-sm" onclick="declineCall(this)">✕ Decline</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="empty-state" id="no-incoming" style="display:none;">
                        ✅ No incoming calls at the moment.
                    </p>
                </div>
            </div>

            <!-- 2. ACTIVE CALL -->
            <div class="card" id="active-call-card">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">🔴</span> Active Call</h2>
                    <span class="badge badge-green" id="active-call-status-badge" style="display:none;">In Progress</span>
                </div>
                <div class="card-body">
                    <div class="empty-state" id="no-active-call">
                        <span style="font-size:2rem;">📵</span>
                        <p>No active call. Accept an incoming call to begin.</p>
                    </div>
                    <div id="active-call-panel" style="display:none;">
                        <div class="active-call-info">
                            <div class="caller-avatar" id="active-caller-avatar">--</div>
                            <div class="caller-details">
                                <h3 id="active-caller-id">--</h3>
                                <span id="active-call-type-badge" class="type-badge audio">🎙 Audio</span>
                                <p class="caller-meta">Call Duration: <strong id="call-duration">00:00</strong></p>
                                <p class="caller-meta">Priority: <strong id="active-priority">--</strong></p>
                            </div>
                            <div class="active-call-status">
                                <span class="badge badge-green pulse-badge">● In Progress</span>
                            </div>
                        </div>
                        <div class="active-call-actions">
                            <button class="btn btn-danger" id="end-call-btn" onclick="endCall()">📵 End Call</button>
                            <button class="btn btn-warning" id="escalate-btn" onclick="openEscalationModal()">🚨 Escalate</button>
                            <button class="btn btn-secondary" onclick="focusNotes()">📝 Add Notes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. CALL QUEUE -->
            <div class="card" id="section-queue">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">⏳</span> Call Queue</h2>
                    <span class="badge badge-grey" id="queue-count-badge">3 waiting</span>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="data-table" id="queue-table">
                            <thead>
                                <tr>
                                    <th>Caller ID</th>
                                    <th>Waiting</th>
                                    <th>Priority</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="queue-body">
                                <tr data-call-id="CALL-0038" data-type="Audio" data-priority="high">
                                    <td><strong>#CALL-0038</strong></td>
                                    <td><span class="wait-time">04:12</span></td>
                                    <td><span class="priority-badge high">🔴 High</span></td>
                                    <td><button class="btn btn-accept btn-sm" onclick="acceptFromQueue(this)">✓ Accept</button></td>
                                </tr>
                                <tr data-call-id="CALL-0039" data-type="Video" data-priority="medium">
                                    <td><strong>#CALL-0039</strong></td>
                                    <td><span class="wait-time">02:45</span></td>
                                    <td><span class="priority-badge medium">🟡 Medium</span></td>
                                    <td><button class="btn btn-accept btn-sm" onclick="acceptFromQueue(this)">✓ Accept</button></td>
                                </tr>
                                <tr data-call-id="CALL-0040" data-type="Audio" data-priority="low">
                                    <td><strong>#CALL-0040</strong></td>
                                    <td><span class="wait-time">01:03</span></td>
                                    <td><span class="priority-badge low">🟢 Low</span></td>
                                    <td><button class="btn btn-accept btn-sm" onclick="acceptFromQueue(this)">✓ Accept</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /col-left -->

        <!-- RIGHT COLUMN -->
        <div class="col-right">

            <!-- 4. SESSION NOTES -->
            <div class="card" id="section-notes">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">📝</span> Session Notes</h2>
                    <span class="badge badge-grey" id="notes-call-label">No active call</span>
                </div>
                <div class="card-body">
                    <div class="notes-timestamp" id="notes-timestamp">—</div>
                    <textarea
                        id="session-notes-textarea"
                        class="notes-textarea"
                        placeholder="Type your session notes here…&#10;&#10;E.g.: Caller is experiencing anxiety symptoms. Provided grounding techniques."
                        rows="6"
                    ></textarea>
                    <button class="btn btn-primary btn-block" id="save-notes-btn" onclick="saveNote()">💾 Save Notes</button>

                    <div class="notes-history-header">
                        <h3>Previous Notes</h3>
                        <span class="note-count" id="note-count">0 notes</span>
                    </div>
                    <ul class="notes-history" id="notes-history">
                        <li class="note-item">
                            <span class="note-time">10:42</span>
                            <span class="note-text">Caller experiencing panic symptoms upon initial contact.</span>
                        </li>
                        <li class="note-item">
                            <span class="note-time">10:45</span>
                            <span class="note-text">Provided 4-7-8 breathing exercise. Caller calming down.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 5. RISK ESCALATION PANEL -->
            <div class="card" id="section-escalation-panel">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">🚨</span> Risk Assessment</h2>
                </div>
                <div class="card-body">
                    <p class="card-desc">Assess the current caller and flag for escalation if needed.</p>
                    <div class="risk-selector">
                        <button class="risk-btn risk-low active-risk" id="risk-low" onclick="setRisk('low', this)">🟢 Low Risk</button>
                        <button class="risk-btn risk-medium" id="risk-medium" onclick="setRisk('medium', this)">🟡 Medium Risk</button>
                        <button class="risk-btn risk-high" id="risk-high" onclick="setRisk('high', this)">🔴 High Risk</button>
                    </div>

                    <div class="escalation-form" id="escalation-form" style="display:none;">
                        <div class="alert-banner">
                            ⚠️ <strong>High Risk Detected.</strong> Immediate action may be required.
                        </div>
                        <div class="form-group">
                            <label for="escalation-reason">Escalation Reason</label>
                            <select id="escalation-reason" class="form-control">
                                <option value="">— Select Reason —</option>
                                <option value="suicidal">Suicidal Ideation</option>
                                <option value="self-harm">Self-Harm Risk</option>
                                <option value="violence">Threat of Violence</option>
                                <option value="substance">Substance Abuse Crisis</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="escalation-notes">Additional Notes</label>
                            <textarea id="escalation-notes" class="form-control" rows="3" placeholder="Describe the situation…"></textarea>
                        </div>
                        <div class="escalation-actions">
                            <button class="btn btn-counselor" onclick="escalateToCounselor()">👩‍⚕️ Escalate to Counselor</button>
                            <button class="btn btn-emergency" onclick="markEmergency()">🆘 Mark Emergency</button>
                            <button class="btn btn-record" onclick="createEscalationRecord()">📋 Create Record</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. ESCALATION RECORDS -->
            <div class="card" id="section-escalation-records">
                <div class="card-header">
                    <h2 class="card-title"><span class="card-title-icon">📋</span> Escalation Records</h2>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="data-table" id="escalation-records-table">
                            <thead>
                                <tr>
                                    <th>Caller ID</th>
                                    <th>Risk Level</th>
                                    <th>Escalated By</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="escalation-records-body">
                                <tr>
                                    <td><strong>#CALL-0036</strong></td>
                                    <td><span class="priority-badge high">🔴 High</span></td>
                                    <td>Responder A</td>
                                    <td>22:15</td>
                                    <td><span class="badge badge-orange">Pending</span></td>
                                </tr>
                                <tr>
                                    <td><strong>#CALL-0031</strong></td>
                                    <td><span class="priority-badge medium">🟡 Medium</span></td>
                                    <td>Responder B</td>
                                    <td>21:48</td>
                                    <td><span class="badge badge-green">Handled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /col-right -->
    </div><!-- /dashboard-grid -->

</main>

<!-- ===== ESCALATION MODAL ===== -->
<div class="modal-overlay" id="escalation-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal">
        <div class="modal-header">
            <h2 id="modal-title">🚨 Escalate Call</h2>
            <button class="modal-close" onclick="closeEscalationModal()" aria-label="Close modal">✕</button>
        </div>
        <div class="modal-body">
            <div class="alert-banner">
                ⚠️ You are escalating an active call. Please provide all required information.
            </div>
            <div class="form-group">
                <label for="modal-caller-id">Caller ID</label>
                <input type="text" id="modal-caller-id" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="modal-risk-level">Risk Level <span class="required">*</span></label>
                <select id="modal-risk-level" class="form-control">
                    <option value="low">🟢 Low Risk</option>
                    <option value="medium">🟡 Medium Risk</option>
                    <option value="high" selected>🔴 High Risk</option>
                </select>
            </div>
            <div class="form-group">
                <label for="modal-escalation-reason">Escalation Reason <span class="required">*</span></label>
                <select id="modal-escalation-reason" class="form-control">
                    <option value="">— Select Reason —</option>
                    <option value="suicidal">Suicidal Ideation</option>
                    <option value="self-harm">Self-Harm Risk</option>
                    <option value="violence">Threat of Violence</option>
                    <option value="substance">Substance Abuse Crisis</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="modal-escalation-notes">Additional Notes</label>
                <textarea id="modal-escalation-notes" class="form-control" rows="4" placeholder="Describe the situation in detail…"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeEscalationModal()">Cancel</button>
            <button class="btn btn-counselor" onclick="submitEscalation()">🚨 Submit Escalation</button>
        </div>
    </div>
</div>

<!-- ===== TOAST NOTIFICATION ===== -->
<div class="toast" id="toast" role="alert" aria-live="polite"></div>

<script src="<?= BASE_URL ?>/js/crisis/call_dashboard.js?v=<?= time() ?>"></script>
</body>
</html>
