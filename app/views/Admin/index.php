<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Use BASE_PATH so paths work in any environment -->
    <link rel="stylesheet" href="../../public/css/Admin/style.css">
</head>
<body>

    <!-- Topbar -->
    <header class="topbar">
        <h1>Admin Dashboard</h1>
        <div class="icons">
            🔔 <span class="count">3</span>
        </div>
    </header>

    <!-- Container for sidebar + main content -->
    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin</h2>
            <ul>
                <li><a href="<?php echo BASE_PATH; ?>/admin" class="active">Dashboard</a></li>
                <li><a href="<?php echo BASE_PATH; ?>/admin/manage-users">Manage Users</a></li>
                <li><a href="<?php echo BASE_PATH; ?>/admin/resource-hub">Resource Hub</a></li>
                <li><a href="#">Moderate Forum</a></li>
                <li><a href="#">Manage Counselors</a></li>
                <li><a href="#">Appointment History</a></li>
                <li><a href="#">Donation History</a></li>
                <li><a href="#">Awareness Programs</a></li>
                <li><a href="#">System Monitoring</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

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
                    <div class="msg admin">Admin: Got it, I’ll check the system logs.</div>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Type your response...">
                    <button>Send</button>
                </div>
            </section>

        </main>
    </div>

    <script src="<?php echo BASE_PATH; ?>/public/js/admin/script.js"></script>
</body>
</html>