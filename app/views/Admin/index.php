<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mind Haven</title>
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
            <a href="<?= BASE_URL ?>/admin" class="nav-item active">
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
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Admin Dashboard</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Dashboard Cards -->
            <section class="cards">
                <div class="card">Total Users: 150</div>
                <div class="card">Active Sessions: 12</div>
                <div class="card">Donations This Month: $1200</div>
                <div class="card">Upcoming Appointments: 5</div>
            </section>

            <!-- Calendar -->
            <section class="calendar-section">
                <h2>📅 Upcoming Appointments</h2>
                <div id="calendar">
                    <div class="appointment">
                        <span class="date">2025-08-20</span> — Counseling with Student A
                    </div>
                    <div class="appointment">
                        <span class="date">2025-08-22</span> — Counseling with Student B
                    </div>
                </div>
            </section>

            <!-- System Alerts -->
            <section class="alerts">
                <h2>⚠️ System Alerts</h2>
                <ul>
                    <li>🚨 Scheduled Maintenance on 2025-08-25</li>
                    <li>⚡ High server load detected</li>
                </ul>
            </section>

            <!-- Moderator Chat -->
            <section class="chat-box">
                <h2>💬 Moderator Chat (Complaint Resolution)</h2>
                <div class="messages">
                    <div class="msg moderator">Moderator: Complaint #12 needs urgent review.</div>
                    <div class="msg admin">Admin: Got it, I'll check the system logs.</div>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Type your response...">
                    <button>Send</button>
                </div>
            </section>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>