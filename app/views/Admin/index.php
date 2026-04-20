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
    <?php 
    $activePage = 'dashboard';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Admin Dashboard';
        include '_topbar.php'; 
        ?>

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