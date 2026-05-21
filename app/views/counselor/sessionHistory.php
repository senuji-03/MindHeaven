<?php
$TITLE = 'Mindheaven - Session History';
$CURRENT_PAGE = 'sessionHistory';
$PAGE_CSS = ['/MindHeaven/public/css/counselor/sessionHistory.css'];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="main-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Sessions</div>
                            <div class="stat-value" id="totalSessions">0</div>
                        </div>
                        <div class="stat-icon"><i class="fa-solid fa-chart-simple"></i></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">This Month</div>
                            <div class="stat-value" id="monthSessions">0</div>
                        </div>
                        <div class="stat-icon"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                </div>
                <div class="stat-card completed">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Completed</div>
                            <div class="stat-value" id="completedSessions">0</div>
                        </div>
                        <div class="stat-icon"><i class="fa-solid fa-check"></i></div>
                    </div>
                </div>
                <div class="stat-card cancelled">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Cancelled</div>
                            <div class="stat-value" id="cancelledSessions">0</div>
                        </div>
                        <div class="stat-icon"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                </div>
                <!-- Overdue Card -->
                <!-- <div class="stat-card overdue">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Overdue</div>
                            <div class="stat-value" id="overdueSessions">0</div>
                        </div>
                        <div class="stat-icon"><i class="fa-regular fa-clock"></i></div>
                    </div>
                </div> -->
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
                            <option value="overdue">Overdue (Past Active)</option>
                            <option value="in-progress">In Progress</option>
                        </select>
                    </div>
                    <div class="filter-group filter-btn-group">
                        <button class="filter-btn" onclick="applyFilters()">Filter</button>
                        <button class="clear-btn" onclick="clearFilters()">Clear</button>
                    </div>
                </div>
            </div>

            <!-- Session History Table -->
            <div class="history-section">
                <div class="section-header">
                    <h2 class="section-title">Session History</h2>
                    <button class="export-btn" onclick="exportHistory()"><i class="fa-solid fa-file-csv"></i> Export CSV</button>
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

    <script src="/MindHeaven/public/js/counselor/sessionHistory.js"></script>
    

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
