<?php
$TITLE = 'Mindheaven - Appointment Management';
$CURRENT_PAGE = 'appointmentmgt';
$PAGE_CSS = [BASE_URL . '/css/counselor/appoinmentmgt.css'];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Appointment Management</h1>
                <p class="page-subtitle">Manage incoming appointment requests and schedule confirmations</p>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="success-message"></div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Filter by Status</label>
                        <select class="filter-input" id="statusFilter" onchange="filterAppointments()">
                            <option value="all">All Requests</option>
                            <option value="pending">Pending</option>
                            <option value="accepted">Accepted</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="no_show">No Show</option>
                            <option value="rescheduled">Rescheduled</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Filter by Date</label>
                        <input type="date" class="filter-input" id="dateFilter" onchange="filterAppointments()">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Search Patient</label>
                        <input type="text" class="filter-input" id="patientSearch" placeholder="Search by name..."
                            onkeyup="filterAppointments()">
                    </div>
                </div>
                <div class="filter-row" style="margin-top: 15px;">
                    <div class="filter-group">
                        <label class="filter-label">Filter by Mode</label>
                        <select class="filter-input" id="modeFilter" onchange="filterAppointments()">
                            <option value="all">All Modes</option>
                            <option value="chat">Chat</option>
                            <option value="audio_video">Audio / Video</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Filter by Session Type</label>
                        <select class="filter-input" id="typeFilter" onchange="filterAppointments()">
                            <option value="all">All Types</option>
                            <option value="individual">Individual</option>
                            <option value="group">Group</option>
                            <option value="crisis">Crisis</option>
                            <option value="assessment">Assessment</option>
                            <option value="follow_up">Follow Up</option>
                        </select>
                    </div>
                    <div class="filter-group" style="visibility: hidden;">
                        <!-- Placeholder to keep the 3-column layout consistent -->
                        <input class="filter-input">
                    </div>
                </div>
            </div>

            <!-- Appointment Requests -->
            <div id="appointmentsList">
                <!-- Appointment cards will be generated here -->
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Reject Appointment</h3>
                <button class="close" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 1.5rem; color: var(--text-secondary);">Please select a reason for rejecting this appointment. This reason will be visible to the student.</p>
                <div class="form-group">
                    <label class="form-label" for="rejectReason">Reason for Rejection</label>
                    <select id="rejectReason" class="form-input" onchange="toggleOtherReason()">
                        <option value="">Select a reason</option>
                        <option value="Emergency situation">Emergency situation</option>
                        <option value="Fully booked / workload limit reached">Fully booked / workload limit reached</option>
                        <option value="Requires different specialization">Requires different specialization</option>
                        <option value="Not suitable for this session type">Not suitable for this session type</option>
                        <option value="Duplicate or conflicting booking">Duplicate or conflicting booking</option>
                        <option value="Requires urgent support">Requires urgent support</option>
                        <option value="Other">Other (please specify)</option>
                    </select>
                </div>
                <div id="otherReasonGroup" class="form-group" style="display: none; margin-top: 15px;">
                    <label class="form-label" for="otherReason">Specify Reason</label>
                    <textarea id="otherReason" class="form-textarea" placeholder="Please specify the reason..."></textarea>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('rejectModal')">Cancel</button>
                <button class="btn btn-reject" onclick="submitReject()">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div id="rescheduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Reschedule Appointment</h3>
                <button class="close" onclick="closeModal('rescheduleModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="reschedulePatientInfo" class="patient-info-card">
                    <!-- Patient info will be populated here -->
                </div>
                <form id="rescheduleForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="newDate">New Date</label>
                            <input type="date" id="newDate" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="newTime">New Time</label>
                            <select id="newTime" class="form-input" required disabled>
                                <option value="">Select date first</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="rescheduleReason">Reason</label>
                        <textarea id="rescheduleReason" class="form-textarea"
                            placeholder="Please provide a reason for rescheduling..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
                <button class="btn btn-primary" onclick="submitReschedule()">Reschedule</button>
            </div>
        </div>
    </div>

    <!-- Student Note History Modal -->
    <div id="studentHistoryModal" class="modal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h3 class="modal-title" id="historyModalTitle">Student Session History</h3>
                <button class="close" onclick="closeModal('studentHistoryModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="historyStudentInfo" class="patient-info-card">
                    <h4 id="historyStudentName">Patient Name</h4>
                    <p>Complete chronological history of session notes.</p>
                </div>
                
                <div id="historyList" style="max-height: 450px; overflow-y: auto; padding-right: 5px;">
                    <!-- History items will be populated here -->
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('studentHistoryModal')">Close</button>
            </div>
        </div>
    </div>

    <style>
        .history-item {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }
        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .history-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed var(--border);
        }
        .history-date {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.95rem;
        }
        .history-counselor {
            font-size: 0.85rem;
            color: var(--text-secondary);
            background: var(--bg-mid);
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-weight: 600;
        }
        .history-topic {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 1.05rem;
        }
        .history-content {
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: 0.95rem;
            white-space: pre-wrap;
        }
        .history-empty {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
        }
        .history-empty i {
            font-size: 3rem;
            display: block;
            margin-bottom: 15px;
            color: var(--border);
        }
    </style>

    <script>
        // Expose BASE_URL to JavaScript so we can call APIs reliably
        window.BASE_URL = '<?php echo BASE_URL; ?>';

        function toggleOtherReason() {
            const reasonSelect = document.getElementById('rejectReason');
            const otherReasonGroup = document.getElementById('otherReasonGroup');
            if (otherReasonGroup) {
                otherReasonGroup.style.display = reasonSelect.value === 'Other' ? 'block' : 'none';
            }
        }
    </script>
    <script src="<?php echo BASE_URL; ?>/js/counselor/appoinmentmgt.js?v=<?php echo time(); ?>"></script>
    

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
