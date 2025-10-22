<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Session History</title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\sessionHistory.css">
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
               <li class="sidebar-item" ><a href="dashboard">📊 Dashboard</a></li>
                <li class="sidebar-item"><a href="calender">📅 Calendar</a></li>
                <li class="sidebar-item"><a href="appointmentmgt">🗓️ Appointment Management</a></li>
                <li class="sidebar-item active"><a href="#" style="color: #2563eb;">📋 Session History</a></li>
                <li class="sidebar-item"><a href="forum">💭 Forum</a></li>
                <li class="sidebar-item"><a href="resources">📚 Resource Hub</a></li>
                <li class="sidebar-item"><a href="counselor_profile">👤 Profile</a></li>
                <li class="sidebar-item">⚙️ Settings</li>
                <li class="sidebar-item logout-item"><a href="<?php echo BASE_URL; ?>/logout" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Sessions</div>
                            <div class="stat-value" id="totalSessions">248</div>
                        </div>
                        <div class="stat-icon">📊</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">This Month</div>
                            <div class="stat-value" id="monthSessions">32</div>
                        </div>
                        <div class="stat-icon">📅</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Completed</div>
                            <div class="stat-value" id="completedSessions">198</div>
                        </div>
                        <div class="stat-icon">✅</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Cancelled</div>
                            <div class="stat-value" id="cancelledSessions">12</div>
                        </div>
                        <div class="stat-icon">❌</div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">Patient Name/ID</label>
                        <input type="text" class="filter-input" id="patientFilter" placeholder="Search patient...">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Date From</label>
                        <input type="date" class="filter-input" id="dateFromFilter">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Date To</label>
                        <input type="date" class="filter-input" id="dateToFilter">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select class="filter-input" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no-show">No Show</option>
                            <option value="rescheduled">Rescheduled</option>
                            <option value="in-progress">In Progress</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <button class="filter-btn" onclick="applyFilters()">Filter</button>
                        <button class="clear-btn" onclick="clearFilters()">Clear</button>
                    </div>
                </div>
            </div>

            <!-- Session History Table -->
            <div class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Session History</h2>
                    <button class="export-btn" onclick="exportHistory()">Export CSV</button>
                </div>
                <div class="table-container">
                    <table class="history-table" id="historyTable">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Session Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Table content will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Detail Modal -->
    <div id="sessionDetailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="sessionDetailTitle">Session Details</h3>
                <button class="close" onclick="closeSessionDetail()">&times;</button>
            </div>
            <div class="modal-body" id="sessionDetailBody">
                <!-- Session details will be populated here -->
            </div>
        </div>
    </div>

    <script src="\MindHeaven\public\js\counselor\sessionHistory.js"></script>
</body>
</html>