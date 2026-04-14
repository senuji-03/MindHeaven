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
           
          
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span>
                University Profile
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
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="alert-container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <span class="alert-icon">✅</span>
                    <span class="alert-message"><?= htmlspecialchars($_SESSION['success']) ?></span>
                    <button class="alert-close">&times;</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">❌</span>
                    <span class="alert-message"><?= htmlspecialchars($_SESSION['error']) ?></span>
                    <button class="alert-close">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Top Bar -->
        <div class="topbar">
            <?php 
                $greetingName = trim($user['full_name'] ?? '');
                $greeting = $greetingName ? "Hello " . htmlspecialchars($greetingName) : "Hello";
            ?>
            <h1><?= $greeting ?></h1>
            <div class="topbar-right">
                <div class="user-profile">
                    <span><?= htmlspecialchars($_SESSION['university_name'] ?? 'University') ?></span>
                    <div class="avatar"><?= strtoupper(substr($_SESSION['university_name'] ?? 'U', 0, 1)) ?></div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="content-wrapper">
            <!-- Quick Actions Removed -->

            <!-- Stats Cards -->
            <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                <div class="stat-card">
                    <div class="stat-icon green" style="background: #dcfce7; color: #16a34a;">💰</div>
                    <div class="stat-details">
                        <h3>Total Funds Raised</h3>
                        <p class="stat-number">Rs <?= number_format($total_raised ?? 0, 2) ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue" style="background: #dbeafe; color: #1d4ed8;">✅</div>
                    <div class="stat-details">
                        <h3>Active Events</h3>
                        <p class="stat-number"><?= htmlspecialchars($active_events ?? 0) ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange" style="background: #fed7aa; color: #ea580c;">⏳</div>
                    <div class="stat-details">
                        <h3>Pending Events</h3>
                        <p class="stat-number"><?= htmlspecialchars($pending_events ?? 0) ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple" style="background: #fce7f3; color: #be185d;">❌</div>
                    <div class="stat-details">
                        <h3>Rejected Events</h3>
                        <p class="stat-number"><?= htmlspecialchars($rejected_events ?? 0) ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">👥</div>
                    <div class="stat-details">
                        <h3>Total Donors</h3>
                        <p class="stat-number"><?= htmlspecialchars($total_donors ?? 0) ?></p>
                    </div>
                </div>
            </div>

            <!-- Upcoming and Completed Events -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Upcoming Events -->
                <div class="section-card">
                    <div class="section-header">
                        <h2>📅 Upcoming Events</h2>
                        <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-sm btn-secondary">View All</a>
                    </div>
                    <div class="activity-list">
                        <?php if(!empty($upcoming_events_list)): ?>
                            <?php foreach($upcoming_events_list as $event): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">📅</div>
                                    <div class="activity-details">
                                        <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                                        <p><?= date('F j, Y', strtotime($event['event_date'])) ?> at <?= date('g:i A', strtotime($event['start_time'])) ?></p>
                                        <div class="activity-time" style="color: #2563eb; font-weight: 600;">Upcoming</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="padding: 20px; color: #64748b; text-align: center;">No upcoming events.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Completed Events -->
                <div class="section-card">
                    <div class="section-header">
                        <h2>✅ Completed Events</h2>
                        <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-sm btn-secondary">View All</a>
                    </div>
                    <div class="activity-list">
                        <?php if(!empty($completed_events_list)): ?>
                            <?php foreach($completed_events_list as $event): ?>
                                <div class="activity-item">
                                    <div class="activity-icon" style="background: #f1f5f9; color: #94a3b8;">✔</div>
                                    <div class="activity-details">
                                        <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                                        <p><?= date('F j, Y', strtotime($event['event_date'])) ?></p>
                                        <div class="activity-time" style="color: #64748b;">Completed</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="padding: 20px; color: #64748b; text-align: center;">No completed events.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
</body>
</html>