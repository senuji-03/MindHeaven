<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --bg-soft:#F5F0E8; --bg-mid:#EEF6F2;
            --text-primary:#1E3A34; --text-secondary:#6B8C7E;
            --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px; --radius-lg:20px; --radius-full:9999px;
            --shadow-sm:0 1px 3px rgba(30,58,52,.06);
        }
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; }
        /* DS Sidebar */
        .sidebar {
            width:280px; height:100vh; background:var(--bg-deep);
            position:fixed; left:0; top:0;
            display:flex; flex-direction:column; z-index:1000;
        }
        .sidebar-header { padding:36px 28px 28px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-header h2 { font-size:1.4rem; font-weight:700; color:var(--primary-light); margin-bottom:6px; }
        .sidebar-header p  { font-size:.75rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-nav { flex:1; padding:24px 16px; overflow-y:auto; }
        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:rgba(255,255,255,.65);
            text-decoration:none; border-radius:var(--radius-sm);
            margin-bottom:4px; font-weight:500; font-size:.95rem;
            transition:all .25s ease;
        }
        .nav-item i { width:20px; text-align:center; font-size:1rem; }
        .nav-item:hover { background:rgba(255,255,255,.07); color:white; transform:translateX(3px); }
        .nav-item.active { background:var(--primary); color:white; box-shadow:0 4px 12px rgba(61,139,110,.3); }
        .sidebar-footer { padding:20px 16px; border-top:1px solid rgba(255,255,255,.08); }
        .logout-btn {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:#FFB3B3;
            text-decoration:none; border-radius:var(--radius-sm);
            font-weight:600; font-size:.9rem; transition:all .25s;
        }
        .logout-btn:hover { background:rgba(214,79,79,.1); }
        .section-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-secondary);
            margin: 24px 0 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
            opacity: 0.6;
        }
    </style>

<body>
    <!-- Sidebar (Design System) -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item active">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <i class="fas fa-users"></i> Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <i class="fas fa-comments"></i> Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <i class="fas fa-chart-bar"></i> System Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <i class="fas fa-university"></i> University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <i class="fas fa-hand-holding-usd"></i> Donation Logs
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <i class="fas fa-book"></i> Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/add-resource" class="nav-item">
                <i class="fas fa-plus-circle"></i> Add Resource
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <i class="fas fa-edit"></i> Edit Resources
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

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
            
            <!-- SECTION 1: USERS -->
            <h2 class="section-title">Users</h2>
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
            </section>

            <!-- SECTION 2: FORUM -->
            <h2 class="section-title">Forum</h2>
            <section class="stats-grid">
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
            </section>

            <!-- SECTION 3: RESOURCE HUB -->
            <h2 class="section-title">Resource Hub</h2>
            <section class="stats-grid">
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