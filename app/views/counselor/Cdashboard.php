<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Counselor Dashboard</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/counselor/Cdashboard.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/notifications.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">M</div>
                Mindheaven
            </div>
            <div class="nav-icons">
                <div class="nav-icon" onclick="showNotifications()">
                    🔔
                    <span class="badge">3</span>
                </div>
                <div class="nav-icon" onclick="showMessages()">
                    💬
                    <span class="badge">7</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>


        <!-- Main Content -->
        <div class="main-content">
            <!-- Stats Cards -->
            <?php $dashStats = isset($stats) ? $stats : array('totalPatients' => 0, 'todaysSessions' => 0, 'avgRating' => 0.0); ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Patients</div>
                            <div class="stat-value"><?php echo (int) $dashStats['totalPatients']; ?></div>
                        </div>
                        <div class="stat-icon">👥</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Today's Sessions</div>
                            <div class="stat-value"><?php echo (int) $dashStats['todaysSessions']; ?></div>
                        </div>
                        <div class="stat-icon">📅</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Average Rating</div>
                            <div class="stat-value"><?php echo number_format($dashStats['avgRating'], 1); ?></div>
                        </div>
                        <div class="stat-icon">⭐</div>
                    </div>
                </div>
            </div>

            <!-- Active Sessions (In Progress) -->
            <?php $inProgressAppointments = isset($inProgressAppointments) ? $inProgressAppointments : array(); ?>
            <?php if (!empty($inProgressAppointments)): ?>
                <div class="section-card active-sessions-card" style="border-left: 4px solid #10b981; background: #f0fdf4;">
                    <div class="section-header">
                        <h2 class="section-title" style="color: #15803d; display: flex; align-items: center; gap: 8px;">
                            <span class="live-indicator"></span> Active Session
                        </h2>
                        <span class="badge"
                            style="background: #10b981; color: white; border-radius: 4px; padding: 2px 8px; font-size: 0.75rem;">LIVE</span>
                    </div>
                    <?php foreach ($inProgressAppointments as $appt): ?>
                        <?php
                        $studentNameSafe = htmlspecialchars(isset($appt['student_name']) ? $appt['student_name'] : 'Student');
                        $titleSafe = htmlspecialchars(isset($appt['title']) ? $appt['title'] : 'Appointment');
                        $apptMode = strtolower(isset($appt['mode']) && $appt['mode'] ? (string) $appt['mode'] : 'audio_video');
                        ?>
                        <div class="appointment-row" style="background: transparent; border-bottom: 1px solid #dcfce7;">
                            <div class="patient-info">
                                <h4 style="color: #166534;"><?php echo $studentNameSafe; ?></h4>
                                <p style="color: #15803d;">Topic: <?php echo $titleSafe; ?></p>
                            </div>
                            <div class="badges-group"
                                style="display: flex; flex-direction: column; gap: 6px; justify-self: center;">
                                <div class="media-type <?php echo ($apptMode === 'chat') ? 'audio-call' : 'video-call'; ?>"
                                    style="margin: 0;">
                                    <?php echo ($apptMode === 'chat') ? '💬 Chat' : '🎥 Audio/Video'; ?>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <?php if (!empty($appt['meeting_link'])): ?>
                                    <button
                                        onclick="joinMeeting(<?php echo (int) $appt['id']; ?>, '<?php echo addslashes($appt['meeting_link']); ?>')"
                                        class="btn btn-start" style="background: #10b981; border: none; cursor: pointer;">🎥 Join
                                        Meeting</button>
                                <?php endif; ?>
                                <button class="btn btn-feedback"
                                    onclick="sendFeedback(<?php echo (int) $appt['id']; ?>, '<?php echo addslashes($studentNameSafe); ?>', '<?php echo addslashes($titleSafe); ?>')">Session
                                    Notes</button>
                                <button class="btn btn-completed"
                                    onclick="markSessionStatus(<?php echo (int) $appt['id']; ?>, 'completed', '<?php echo addslashes($studentNameSafe); ?>')">&#10003;
                                    Completed</button>
                                <button class="btn btn-noshow"
                                    onclick="markSessionStatus(<?php echo (int) $appt['id']; ?>, 'no_show', '<?php echo addslashes($studentNameSafe); ?>')">&#10007;
                                    No Show</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Upcoming Appointments -->

            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Appointments</h2>
                </div>
                <?php
                $upcomingAppointments = isset($upcomingAppointments) ? $upcomingAppointments : array();
                if (empty($upcomingAppointments)):
                    ?>
                    <div class="feedback-empty-state">
                        <p class="feedback-empty-text">No upcoming appointments yet. Appointments booked by undergraduates
                            will appear here.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($upcomingAppointments as $appt): ?>
                        <?php
                        $studentNameSafe = htmlspecialchars(isset($appt['student_name']) ? $appt['student_name'] : 'Student');
                        $titleSafe = htmlspecialchars(isset($appt['title']) ? $appt['title'] : 'Appointment');
                        $type = strtolower(isset($appt['type']) ? (string) $appt['type'] : '');

                        $dateStr = isset($appt['date']) ? (string) $appt['date'] : '';
                        $timeStr = isset($appt['time']) ? (string) $appt['time'] : '';

                        $labelDate = $dateStr;
                        try {
                            $apptDate = new DateTime($dateStr);
                            $today = new DateTime(date('Y-m-d'));
                            $tomorrow = new DateTime(date('Y-m-d', strtotime('+1 day')));
                            if ($apptDate->format('Y-m-d') === $today->format('Y-m-d')) {
                                $labelDate = 'Today';
                            } elseif ($apptDate->format('Y-m-d') === $tomorrow->format('Y-m-d')) {
                                $labelDate = 'Tomorrow';
                            } else {
                                $labelDate = $apptDate->format('M j');
                            }
                        } catch (Exception $e) {
                        }

                        $labelTime = $timeStr;
                        $parsedTime = strtotime($timeStr);
                        if ($parsedTime) {
                            $labelTime = date('g:i A', $parsedTime);
                        }

                        $apptMode = strtolower(isset($appt['mode']) && $appt['mode'] ? (string) $appt['mode'] : 'audio_video');

                        // Session Mode Badge
                        $modeBadgeClass = ($apptMode === 'chat') ? 'audio-call' : 'video-call';
                        $modeBadgeText = ($apptMode === 'chat') ? '💬 Chat' : '🎥 Audio/Video';

                        // Session Type Badge
                        $typeFormatted = ucfirst(str_replace('_', ' ', $type));
                        if (empty($typeFormatted)) {
                            $typeFormatted = 'Standard';
                        }
                        ?>
                        <div class="appointment-row">
                            <div class="patient-info">
                                <h4><?php echo $studentNameSafe; ?></h4>
                                <p>Topic: <?php echo $titleSafe; ?></p>
                            </div>
                            <div class="time-slot">
                                <div class="date"><?php echo htmlspecialchars($labelDate); ?></div>
                                <div class="time"><?php echo htmlspecialchars($labelTime); ?></div>
                            </div>
                            <div class="badges-group"
                                style="display: flex; flex-direction: column; gap: 6px; justify-self: center;">
                                <div class="media-type <?php echo $modeBadgeClass; ?>" style="margin: 0;">
                                    <?php echo $modeBadgeText; ?>
                                </div>
                                <div class="media-type" style="margin: 0; background: #f1f5f9; color: #475569;">
                                    🏷️ <?php echo htmlspecialchars($typeFormatted); ?>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <?php if (!empty($appt['meeting_link'])): ?>
                                    <button
                                        onclick="joinMeeting(<?php echo (int) $appt['id']; ?>, '<?php echo addslashes($appt['meeting_link']); ?>')"
                                        class="btn btn-start"
                                        style="display:inline-flex;align-items:center;justify-content:center;">🎥 Join
                                        Meeting</button>
                                <?php else: ?>
                                    <button class="btn btn-start"
                                        onclick="startMeeting(<?php echo (int) $appt['id']; ?>, '<?php echo addslashes($studentNameSafe); ?>', <?php echo (int) $appt['student_user_id']; ?>, '<?php echo $apptMode; ?>')">Start
                                        Session</button>
                                <?php endif; ?>
                                <!-- <button class="btn btn-reschedule"
                                    onclick="reschedule('<?php echo addslashes($studentNameSafe); ?>', '<?php echo addslashes($titleSafe); ?>')">Reschedule</button> -->
                                <button class="btn btn-feedback"
                                    onclick="sendFeedback(<?php echo (int) $appt['id']; ?>, '<?php echo addslashes($studentNameSafe); ?>', '<?php echo addslashes($titleSafe); ?>')">Session
                                    Notes</button>
                                <button class="btn btn-completed"
                                    onclick="markSessionStatus(<?php echo (int) $appt['id']; ?>, 'completed', '<?php echo addslashes($studentNameSafe); ?>')">&#10003;
                                    Completed</button>
                                <button class="btn btn-noshow"
                                    onclick="markSessionStatus(<?php echo (int) $appt['id']; ?>, 'no_show', '<?php echo addslashes($studentNameSafe); ?>')">&#10007;
                                    No Show</button>
                                <button class="btn btn-primary"
                                    style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; margin-top: 5px;"
                                    onclick="viewStudentHistory(<?php echo (int) $appt['student_user_id']; ?>, '<?php echo addslashes($studentNameSafe); ?>')">📋
                                    History</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Escalated Emergency Calls -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title"><span style="color:#D64F4F;">🚨</span> Escalated Urgent Calls</h2>
                </div>
                <?php
                $escalatedCalls = isset($escalatedCalls) ? $escalatedCalls : array();
                if (empty($escalatedCalls)):
                    ?>
                    <div class="feedback-empty-state">
                        <p class="feedback-empty-text">No escalated calls at the moment. Urgent escalations from responders
                            will appear here.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($escalatedCalls as $call): ?>
                        <div class="appointment-row"
                            style="background:#fffafa; border-left: 4px solid #D64F4F; margin-bottom: 12px; padding: 12px 16px; border-radius: 6px;">
                            <div class="patient-info">
                                <h4 style="margin:0 0 4px 0;"><?php echo htmlspecialchars($call['caller_name']); ?></h4>
                                <p style="color:#D64F4F; font-weight:bold; margin:0; font-size:0.85rem;">Emergency Escalation
                                </p>
                            </div>
                            <div class="time-slot" style="flex:2;">
                                <div class="date" style="font-size:0.85rem; color:#666;">Responder Notes:</div>
                                <div class="time" style="font-size:0.9rem; font-style:italic; cursor:pointer; color:#000;"
                                    onclick="showFullNotes(`<?php echo addslashes(htmlspecialchars($call['notes'])); ?>`, `<?php echo htmlspecialchars($call['caller_name']); ?>`)">
                                    <?php echo htmlspecialchars(substr($call['notes'], 0, 100)) . (strlen($call['notes']) > 100 ? '...' : ''); ?>
                                    <?php if (strlen($call['notes']) > 100): ?>
                                        <span style="color:var(--primary); font-size:0.75rem; font-weight:bold;"> (Click to read
                                            more)</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <?php if (!empty($call['daily_room_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($call['daily_room_url']); ?>" target="_blank"
                                        class="btn btn-start"
                                        style="text-decoration:none;display:inline-flex;align-items:center;justify-content:center; background:#D64F4F; color:#fff; padding:6px 14px; border-radius:4px; font-weight:600; font-size:0.9rem;">📞
                                        Connect</a>
                                <?php endif; ?>
                                <button class="btn btn-feedback" style="margin-top: 5px; border-color: #D64F4F; color: #D64F4F;"
                                    onclick="sendCrisisFeedback(<?php echo (int) $call['id']; ?>, '<?php echo addslashes(htmlspecialchars($call['caller_name'])); ?>')">📝
                                    Session Notes</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Recent Student Feedbacks (counselor feedback from undergraduates) -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Recent Student Feedbacks</h2>
                    <?php if (!empty($counselorFeedback)): ?>
                        <a href="<?php echo BASE_URL; ?>/counselor/feedback" class="view-all-btn"
                            style="text-decoration: none;">View All</a>
                    <?php endif; ?>
                </div>
                <?php
                $counselorFeedback = isset($counselorFeedback) ? $counselorFeedback : array();
                if (empty($counselorFeedback)):
                    ?>
                    <div class="feedback-empty-state">
                        <p class="feedback-empty-text">No counselor feedback from students yet. Feedback given by
                            undergraduates about your sessions will appear here.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($counselorFeedback as $fb): ?>
                        <div class="feedback-item">
                            <div class="feedback-header">
                                <span
                                    class="student-name"><?php echo !empty($fb['is_anonymous']) ? 'Anonymous' : htmlspecialchars(isset($fb['user_name']) ? $fb['user_name'] : 'Student'); ?></span>
                                <div class="rating"
                                    title="Rating: <?php echo (int) (isset($fb['rating']) ? $fb['rating'] : 0); ?>/5">
                                    <?php
                                    $rating = (int) (isset($fb['rating']) ? $fb['rating'] : 0);
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo '<span class="star">' . ($i <= $rating ? '★' : '☆') . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <p class="feedback-text">
                                <?php echo nl2br(htmlspecialchars(isset($fb['content']) ? $fb['content'] : 'No feedback content provided.')); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Session Status Confirmation Modal -->
    <div id="sessionStatusModal" class="modal">
        <div class="modal-content" style="max-width:420px;">
            <div class="modal-header">
                <h3 class="modal-title" id="sessionStatusModalTitle">Confirm Action</h3>
                <button class="close" onclick="closeSessionStatusModal()">&times;</button>
            </div>
            <div class="modal-body" id="sessionStatusModalBody">
                <p id="sessionStatusModalMsg" style="color:#334155;font-size:1rem;line-height:1.6;"></p>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeSessionStatusModal()">Cancel</button>
                <button class="btn-primary" id="sessionStatusConfirmBtn"
                    onclick="confirmSessionStatus()">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <!-- <div id="rescheduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Reschedule Appointment</h3>
                <button class="close" onclick="closeModal('rescheduleModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="reschedulePatientInfo" class="patient-info-card"> -->
    <!-- Patient info will be populated here -->
    <!-- </div>
                <form id="rescheduleForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="newDate">New Date</label>
                            <input type="date" id="newDate" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="newTime">New Time</label>
                            <select id="newTime" class="form-input" required>
                                <option value="">Select Time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="09:30">9:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="14:30">2:30 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="15:30">3:30 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="16:30">4:30 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="rescheduleReason">Reason for Rescheduling</label>
                        <textarea id="rescheduleReason" class="form-textarea"
                            placeholder="Please provide a reason for rescheduling..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
                <button class="btn-primary" onclick="submitReschedule()">Reschedule Appointment</button>
            </div>
        </div>
    </div> -->

    <!-- Session Notes Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Session Notes</h3>
                <button class="close" onclick="closeModal('feedbackModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="feedbackPatientInfo" class="patient-info-card">
                    <!-- Patient info will be populated here -->
                </div>
                <form id="feedbackForm">
                    <input type="hidden" id="feedbackAppointmentId" name="id">
                    <div class="form-group">
                        <label class="form-label" for="feedbackMessage">Write your notes about the session...</label>
                        <textarea id="feedbackMessage" class="form-textarea"
                            placeholder="Type your session notes here..." style="min-height: 200px;"
                            required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('feedbackModal')">Cancel</button>
                <button class="btn-primary" id="submitFeedbackBtn" onclick="submitFeedback()">Save Session
                    Notes</button>
            </div>
        </div>
    </div>

    <!-- Notes Modal -->
    <div id="notesModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Responder Intervention Notes</h3>
                <button class="close" onclick="closeModal('notesModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="patient-info-card">
                    <h4 id="notesCallerName">Caller Name</h4>
                    <p style="color:#D64F4F; font-weight:600; font-size:0.85rem; margin-top:4px;">Emergency Escalation
                        Record</p>
                </div>
                <div
                    style="background:#f8fafc; padding:20px; border-radius:8px; border:1px solid #e2e8f0; margin-top:16px;">
                    <p id="fullNotesContent" style="white-space:pre-wrap; line-height:1.6; color:#000;"></p>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-primary" onclick="closeModal('notesModal')">Close View</button>
            </div>
        </div>
    </div>

    <!-- Student Note History Modal -->
    <div id="studentHistoryModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header"
                style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white;">
                <h3 class="modal-title" id="historyModalTitle">Student Session History</h3>
                <button class="close" onclick="closeModal('studentHistoryModal')" style="color: white;">&times;</button>
            </div>
            <div class="modal-body" style="background: #f8fafc; padding: 20px;">
                <div id="historyStudentInfo"
                    style="margin-bottom: 20px; padding: 15px; background: white; border-radius: 12px; border-left: 5px solid #4f46e5; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <h4 id="historyStudentName" style="color: #1e293b; margin: 0; font-size: 1.2rem;">Patient Name</h4>
                    <p style="color: #64748b; margin: 5px 0 0; font-size: 0.9rem;">Complete chronological history of
                        session notes.</p>
                </div>

                <div id="historyList" style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                    <!-- History items will be populated here -->
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('studentHistoryModal')">Close History</button>
            </div>
        </div>
    </div>

    <style>
        .history-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: left;
        }

        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .history-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .history-date {
            font-weight: 600;
            color: #4f46e5;
            font-size: 0.95rem;
        }

        .history-counselor {
            font-size: 0.85rem;
            color: #64748b;
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .history-topic {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .history-content {
            color: #475569;
            line-height: 1.6;
            font-size: 0.95rem;
            white-space: pre-wrap;
        }

        .history-empty {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }
    </style>
    <script>
        window.BASE_URL = '<?php echo htmlspecialchars(BASE_URL); ?>';

        function showFullNotes(notes, callerName) {
            document.getElementById('notesCallerName').textContent = callerName;
            document.getElementById('fullNotesContent').textContent = notes || 'No detailed notes provided.';
            document.getElementById('notesModal').style.display = 'block';
        }
    </script>
    <script src="<?php echo BASE_URL; ?>/js/counselor/Cdashboard.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/notifications.js"></script>
</body>

</html>