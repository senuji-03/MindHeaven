<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Appointment Management</title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\appoinmentmgt.css">
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
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="sidebar-item"><a href="dashboard">📊 Dashboard</a></li>
                <li class="sidebar-item"><a href="calender">📅 Calendar</a></li>
                <li class="sidebar-item active"><a href="#" style="color: #2563eb;">🗓️ Appointment Management</a></li>
                <li class="sidebar-item"><a href="sessionHistory">📋 Session History</a></li>
                <li class="sidebar-item"><a href="forum">💭 Forum</a></li>
                <li class="sidebar-item"><a href="resources">📚 Resource Hub</a></li>
                <li class="sidebar-item"><a href="counselor_profile">👤 Profile</a></li>
                <li class="sidebar-item"><a href="#">⚙️ Settings</a></li>
                <li class="sidebar-item logout-item"><a href="<?php echo BASE_URL; ?>/logout" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
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
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Filter by Date</label>
                        <input type="date" class="filter-input" id="dateFilter" onchange="filterAppointments()">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Search Patient</label>
                        <input type="text" class="filter-input" id="patientSearch" placeholder="Search by name..." onkeyup="filterAppointments()">
                    </div>
                </div>
            </div>

            <!-- Appointment Requests -->
            <div id="appointmentsList">
                <!-- Appointment cards will be generated here -->
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
                        <textarea id="rescheduleReason" class="form-textarea" placeholder="Please provide a reason for rescheduling..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
                <button class="btn-primary" onclick="submitReschedule()">Reschedule Appointment</button>
            </div>
        </div>
    </div>

    <script src="\MindHeaven\public\js\counselor\appoinmentmgt.js"></script>
</body>
</html>