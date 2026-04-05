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
           
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
           
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
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
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">👤</div>
                    <div class="stat-details">
                        <h3>Total Users</h3>
                        <div class="stat-number"><?= $totalUsers ?? 0 ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">🌐</div>

                    <div class="stat-details">
                        <h3>Active Sessions</h3>
                        <div class="stat-number">12</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">💰</div>
                    <div class="stat-details">
                        <h3>Donations (Month)</h3>

                        <div class="stat-number">$1,200</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">📅</div>
                    <div class="stat-details">
                        <h3>Upcoming Appointments</h3>
                        <div class="stat-number">5</div>
                    </div>
                </div>
            </section>

            <!-- Calendar -->
            <section class="section-card">
                <div class="section-header">
                    <h2>📅 Upcoming Appointments</h2>
                </div>
                <div class="appointments-list">
                    <div class="appointment-item">
                        <span class="date">2025-08-20</span>
                        <span class="details">Counseling with Student A</span>
                    </div>
                    <div class="appointment-item">
                        <span class="date">2025-08-22</span>
                        <span class="details">Counseling with Student B</span>
                    </div>
                </div>
            </section>

            <!-- System Alerts -->
            <section class="section-card">
                <div class="section-header">
                    <h2>⚠️ System Alerts</h2>
                </div>
                <div class="alert-item danger">
                    <span class="alert-icon">🚨</span>
                    <span>Scheduled Maintenance on 2025-08-25</span>
                </div>
                <div class="alert-item warning">

                    <span class="alert-icon">⚡</span>
                    <span>High server load detected</span>
                </div>
            </section>

            <!-- Moderator Chat -->
            <section class="section-card">
                <div class="section-header">
                    <h2>💬 Moderator Chat (Complaint Resolution)</h2>
                </div>
                <div class="chat-container">
                    <div class="chat-message moderator">
                        <strong>Moderator:</strong> Complaint #12 needs urgent review.
                    </div>
                    <div class="chat-message admin">
                        <strong>Admin:</strong> Got it, I'll check the system logs.
                    </div>

                    <div class="chat-input-area">
                        <input type="text" class="chat-input" placeholder="Type your response...">
                        <button class="send-btn">Send</button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>

</html>