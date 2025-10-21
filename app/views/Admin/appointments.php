<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <span class="icon">📚</span>
                Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/counselors" class="nav-item">
                <span class="icon">👨‍⚕️</span>
                Manage Counselors
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item active">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/settings" class="nav-item">
                <span class="icon">⚙️</span>
                Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h1>Appointment History</h1>
            <div class="topbar-right">
                <div class="notification-icon">
                    🔔
                    <span class="badge">3</span>
                </div>
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="page-header">
                <h2>📅 Appointment History & Management</h2>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">📋</div>
                    <div class="stat-details">
                        <h3>Total Appointments</h3>
                        <p class="stat-number">1,245</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-details">
                        <h3>Completed</h3>
                        <p class="stat-number">1,089</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏳</div>
                    <div class="stat-details">
                        <h3>Upcoming</h3>
                        <p class="stat-number">45</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">❌</div>
                    <div class="stat-details">
                        <h3>Cancelled</h3>
                        <p class="stat-number">111</p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="section-card" style="margin-bottom: 20px;">
                <div class="filter-bar">
                    <input type="text" placeholder="Search by student or counselor..." class="search-input">
                    <select class="filter-select">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no_show">No Show</option>
                    </select>
                    <input type="date" class="filter-select">
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="section-card">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1245</td>
                            <td>John Doe</td>
                            <td>Dr. Sarah Johnson</td>
                            <td>Jan 20, 2025 - 10:00 AM</td>
                            <td><span class="badge role-counselor">In-Person</span></td>
                            <td><span class="badge status-active">Completed</span></td>
                            <td>
                                <button class="btn-icon" title="View Details">👁️</button>
                                <button class="btn-icon" title="Download Report">📄</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1244</td>
                            <td>Jane Smith</td>
                            <td>Dr. Emily Chen</td>
                            <td>Jan 22, 2025 - 2:00 PM</td>
                            <td><span class="badge role-moderator">Online</span></td>
                            <td><span class="badge" style="background:#fff3cd;color:#856404;">Upcoming</span></td>
                            <td>
                                <button class="btn-icon" title="View Details">👁️</button>
                                <button class="btn-icon" title="Reschedule">📅</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1243</td>
                            <td>Mike Johnson</td>
                            <td>Mr. David Silva</td>
                            <td>Jan 18, 2025 - 11:30 AM</td>
                            <td><span class="badge role-counselor">In-Person</span></td>
                            <td><span class="badge status-inactive">Cancelled</span></td>
                            <td>
                                <button class="btn-icon" title="View Details">👁️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1242</td>
                            <td>Sarah Lee</td>
                            <td>Dr. Sarah Johnson</td>
                            <td>Jan 23, 2025 - 3:00 PM</td>
                            <td><span class="badge role-moderator">Online</span></td>
                            <td><span class="badge" style="background:#fff3cd;color:#856404;">Upcoming</span></td>
                            <td>
                                <button class="btn-icon" title="View Details">👁️</button>
                                <button class="btn-icon" title="Reschedule">📅</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#1241</td>
                            <td>Alex Kumar</td>
                            <td>Dr. Emily Chen</td>
                            <td>Jan 19, 2025 - 9:00 AM</td>
                            <td><span class="badge role-counselor">In-Person</span></td>
                            <td><span class="badge status-active">Completed</span></td>
                            <td>
                                <button class="btn-icon" title="View Details">👁️</button>
                                <button class="btn-icon" title="Download Report">📄</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="padding: 20px; text-align: center;">
                    <button class="btn btn-secondary">Load More Appointments</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>