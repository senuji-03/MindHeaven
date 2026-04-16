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
                System Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon">💰</span>
                Donation Logs
            </a>
                    <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
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
                <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
                    <div class="admin-profile" style="cursor: pointer;">
                        <span>Admin User</span>
                        <div class="avatar">A</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Dashboard Cards -->
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">👥</div>
                    <div class="stat-details">
                        <h3>Total Users</h3>
                        <div class="stat-number"><?= $totalUsers ?? 0 ?></div>
                    </div>
                </div>

                <?php foreach ($roleCounts ?? [] as $role => $count): ?>
                    <?php 
                    $roleKey = strtolower($role);
                    $icons = [
                        'admin' => '👑',
                        'moderator' => '🛡️',
                        'counselor' => '👨‍⚕️',
                        'undergraduate' => '🎓',
                        'student' => '🎓',
                        'call_responder' => '📞',
                        'crisis_responder' => '📞',
                        'university_representative' => '🏛️'
                    ];
                    $colors = [
                        'admin' => 'gray',
                        'moderator' => 'orange',
                        'counselor' => 'green',
                        'undergraduate' => 'blue',
                        'student' => 'blue',
                        'call_responder' => 'red',
                        'crisis_responder' => 'red',
                        'university_representative' => 'purple'
                    ];
                    $displayNames = [
                        'admin' => 'Admins',
                        'moderator' => 'Moderators',
                        'counselor' => 'Counselors',
                        'undergraduate' => 'Undergraduates',
                        'student' => 'Students',
                        'call_responder' => 'Crisis Responders',
                        'crisis_responder' => 'Crisis Responders',
                        'university_representative' => 'Univ. Reps'
                    ];
                    
                    $icon = $icons[$roleKey] ?? '👤';
                    $color = $colors[$roleKey] ?? 'blue';
                    $name = $displayNames[$roleKey] ?? ucfirst($role);
                    ?>
                    <div class="stat-card">
                        <div class="stat-icon <?= $color ?>"><?= $icon ?></div>
                        <div class="stat-details">
                            <h3><?= htmlspecialchars($name) ?></h3>
                            <div class="stat-number"><?= htmlspecialchars((string) $count) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="stat-card">
                    <div class="stat-icon purple">💬</div>
                    <div class="stat-details">
                        <h3>Forum Threads</h3>
                        <div class="stat-number"><?= htmlspecialchars((string) ($totalThreads ?? 0)) ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon red">🚨</div>
                    <div class="stat-details">
                        <h3>Flagged Queue</h3>
                        <div class="stat-number"><?= htmlspecialchars((string) ($totalReports ?? 0)) ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon green">📚</div>
                    <div class="stat-details">
                        <h3>Total Resources</h3>
                        <div class="stat-number"><?= htmlspecialchars((string) ($totalResources ?? 0)) ?></div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>

</html>