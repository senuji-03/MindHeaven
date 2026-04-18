<?php
// app/views/UniversityRepresentative/dashboard.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - University Representative | MindHaven</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #3D8B6E;
            --primary-light: #4A9F7E;
            --primary-dark: #2F6B54;
            --secondary: #1C2B2A;
            --bg-soft: #F4F7F5;
            --bg-mid: #E8F0ED;
            --surface: #FFFFFF;
            --text-primary: #1C2B2A;
            --text-secondary: #5C716E;
            --border: #D1DBD8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-full: 9999px;
            --shadow-sm: 0 2px 4px rgba(28, 43, 42, 0.05);
            --shadow-md: 0 8px 24px rgba(28, 43, 42, 0.08);
            --crisis: #D64F4F;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar Styles - Identical to management view for consistency */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--secondary);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 40px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary-light);
        }

        .sidebar-header p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 30px 20px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: var(--radius-sm);
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .nav-item.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(61, 139, 110, 0.3);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            padding: 30px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: #FFB3B3;
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: rgba(214, 79, 79, 0.1);
        }

        /* Main Content area */
        .main-content {
            margin-left: 280px;
            padding: 48px;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 48px;
        }

        .topbar h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.5px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 20px;
            background: var(--surface);
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: var(--surface);
            padding: 24px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-details h3 {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        /* Color variants for stats */
        .icon-funds {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .icon-active {
            background: #E3F2FD;
            color: #1565C0;
        }

        .icon-pending {
            background: #FFF3E0;
            color: #EF6C00;
        }

        .icon-donors {
            background: #F3E5F5;
            color: #7B1FA2;
        }

        /* Section Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .section-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .section-header {
            padding: 24px 32px;
            border-bottom: 1px solid var(--bg-mid);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .activity-item {
            padding: 20px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid var(--bg-soft);
            transition: background 0.2s ease;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item:hover {
            background: var(--bg-soft);
        }

        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--bg-mid);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .activity-details h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .activity-details p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .activity-badge {
            margin-left: auto;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: var(--radius-full);
        }

        .badge-upcoming {
            background: #E3F2FD;
            color: #1565C0;
        }

        .badge-completed {
            background: #F5F5F5;
            color: #616161;
        }

        .btn-view-all {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            background: var(--bg-mid);
            transition: all 0.2s;
        }

        .btn-view-all:hover {
            background: var(--primary);
            color: white;
        }

        .alert-container {
            margin-bottom: 32px;
        }

        .alert {
            padding: 16px 24px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #C8E6C9;
        }

        .alert-error {
            background: #FFEBEE;
            color: #C62828;
            border: 1px solid #FFCDD2;
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Rep</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item active">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <i class="fas fa-calendar-alt"></i> Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <i class="fas fa-university"></i> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <main class="main-content">
        <!-- Alerts -->
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
            <div class="alert-container">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Top Bar -->
        <div class="topbar">
            <?php
            $greetingName = isset($user['full_name']) ? trim($user['full_name']) : '';
            $greeting = $greetingName ? "Hello, " . htmlspecialchars($greetingName) : "Hello";
            ?>
            <h1><?= $greeting ?> 👋</h1>
            <div class="topbar-right">
                <div class="user-profile">
                    <span style="font-weight: 600; font-size: 0.9rem; color: var(--text-secondary);">
                        <?= htmlspecialchars(isset($_SESSION['university_name']) ? $_SESSION['university_name'] : 'Academic Institute') ?>
                    </span>
                    <div class="avatar">
                        <?= strtoupper(substr(isset($_SESSION['university_name']) ? $_SESSION['university_name'] : 'U', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-funds">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="stat-details">
                    <h3>Total Funds Raised</h3>
                    <p class="stat-number">LKR <?= number_format(isset($total_raised) ? $total_raised : 0, 2) ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-active">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-details">
                    <h3>Active Events</h3>
                    <p class="stat-number"><?= htmlspecialchars(isset($active_events) ? $active_events : 0) ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-details">
                    <h3>Pending Approval</h3>
                    <p class="stat-number"><?= htmlspecialchars(isset($pending_events) ? $pending_events : 0) ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-donors">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <h3>Total Donors</h3>
                    <p class="stat-number"><?= htmlspecialchars(isset($total_donors) ? $total_donors : 0) ?></p>
                </div>
            </div>
        </div>

        <!-- Activity Grid -->
        <div class="dashboard-grid">
            <!-- Upcoming Events -->
            <section class="section-card">
                <div class="section-header">
                    <h2><i class="far fa-calendar-alt" style="margin-right: 8px;"></i> Upcoming Events</h2>
                    <a href="<?= BASE_URL ?>/university-rep/events" class="btn-view-all">View All</a>
                </div>
                <div class="activity-list">
                    <?php if (!empty($upcoming_events_list)): ?>
                        <?php foreach ($upcoming_events_list as $event): ?>
                            <div class="activity-item">
                                <div class="activity-icon"><i class="fas fa-calendar-day"></i></div>
                                <div class="activity-details">
                                    <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                                    <p><?= date('M j, Y', strtotime($event['event_date'])) ?> at
                                        <?= date('g:i A', strtotime($event['start_time'])) ?></p>
                                </div>
                                <span class="activity-badge badge-upcoming">Upcoming</span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 60px 40px; text-align: center; color: var(--text-secondary);">
                            <i class="far fa-calendar"
                                style="font-size: 2.5rem; opacity: 0.2; margin-bottom: 16px; display: block;"></i>
                            <p>No upcoming events scheduled.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Completed Events -->
            <section class="section-card">
                <div class="section-header">
                    <h2><i class="fas fa-history" style="margin-right: 8px;"></i> Recently Completed</h2>
                    <a href="<?= BASE_URL ?>/university-rep/events" class="btn-view-all">View All</a>
                </div>
                <div class="activity-list">
                    <?php if (!empty($completed_events_list)): ?>
                        <?php foreach ($completed_events_list as $event): ?>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: var(--bg-soft); color: var(--text-secondary);"><i
                                        class="fas fa-check-double"></i></div>
                                <div class="activity-details">
                                    <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                                    <p><?= date('M j, Y', strtotime($event['event_date'])) ?></p>
                                </div>
                                <span class="activity-badge badge-completed">Archived</span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding: 60px 40px; text-align: center; color: var(--text-secondary);">
                            <i class="fas fa-check-circle"
                                style="font-size: 2.5rem; opacity: 0.2; margin-bottom: 16px; display: block;"></i>
                            <p>No history entries found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
</body>

</html>