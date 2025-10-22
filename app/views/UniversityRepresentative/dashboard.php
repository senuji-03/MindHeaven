<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Representative Dashboard - Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Representative</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item active">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <span class="icon">📅</span>
                Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/announcements" class="nav-item">
                <span class="icon">📰</span>
                Announcements
            </a>
            <a href="<?= BASE_URL ?>/university-rep/resources" class="nav-item">
                <span class="icon">📚</span>
                Resources
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span>
                University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/analytics" class="nav-item">
                <span class="icon">📈</span>
                Analytics
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <span class="icon">👤</span>
                My Profile
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
            <h1>Dashboard</h1>
            <div class="topbar-right">
                <div class="notification-icon">
                    🔔
                    <span class="badge">2</span>
                </div>
                <div class="user-profile">
                    <span>Rep Name</span>
                    <div class="avatar">R</div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="content-wrapper">
            <!-- Quick Action Buttons -->
            <div class="quick-actions">
                <a href="<?= BASE_URL ?>/university-rep/events/create" class="action-card blue">
                    <div class="action-icon">📅</div>
                    <div class="action-text">
                        <h3>Add Event</h3>
                        <p>Create new workshop or event</p>
                    </div>
                </a>
                <a href="<?= BASE_URL ?>/university-rep/announcements/create" class="action-card green">
                    <div class="action-icon">📰</div>
                    <div class="action-text">
                        <h3>Add Announcement</h3>
                        <p>Post important updates</p>
                    </div>
                </a>
                <a href="<?= BASE_URL ?>/university-rep/resources/create" class="action-card orange">
                    <div class="action-icon">📚</div>
                    <div class="action-text">
                        <h3>Add Resource</h3>
                        <p>Upload helpful materials</p>
                    </div>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">📅</div>
                    <div class="stat-details">
                        <h3>Total Events</h3>
                        <p class="stat-number">12</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">📰</div>
                    <div class="stat-details">
                        <h3>Total Announcements</h3>
                        <p class="stat-number">8</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">📚</div>
                    <div class="stat-details">
                        <h3>Uploaded Resources</h3>
                        <p class="stat-number">15</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple">👥</div>
                    <div class="stat-details">
                        <h3>Total Engagement</h3>
                        <p class="stat-number">254</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="section-card">
                <div class="section-header">
                    <h2>📋 Recent Activities</h2>
                    <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-sm btn-secondary">View All</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">📅</div>
                        <div class="activity-details">
                            <h4>Stress Relief Workshop 2025</h4>
                            <p>Workshop event published</p>
                            <div class="activity-time">2 hours ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">📰</div>
                        <div class="activity-details">
                            <h4>Mental Health Awareness Week</h4>
                            <p>Announcement posted</p>
                            <div class="activity-time">1 day ago</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">📚</div>
                        <div class="activity-details">
                            <h4>Counseling Services Guide</h4>
                            <p>Resource uploaded</p>
                            <div class="activity-time">3 days ago</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="section-card">
                <div class="section-header">
                    <h2>📅 Upcoming Events</h2>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">📅</div>
                        <div class="activity-details">
                            <h4>Mindfulness Meditation Session</h4>
                            <p>March 25, 2025 at 10:00 AM</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">📅</div>
                        <div class="activity-details">
                            <h4>Anxiety Management Talk</h4>
                            <p>March 30, 2025 at 2:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
</body>
</html>