<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Keywords - Admin | Mind Haven</title>
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
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; background:var(--bg-soft); }

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

        <?php include '_forum_styles.php'; ?>
    </style>
</head>

<body>
    <!-- Sidebar (Design System) -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item"><i class="fas fa-users"></i> Manage Users</a>
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active"><i class="fas fa-comments"></i> Moderate Forum</a>
                <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item"><i class="fas fa-calendar-check"></i> Appointments</a>
                <a href="<?= BASE_URL ?>/admin/reports" class="nav-item"><i class="fas fa-chart-bar"></i> System Reports</a>
                <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item"><i class="fas fa-university"></i> University Events</a>
                <a href="<?= BASE_URL ?>/admin/donations" class="nav-item"><i class="fas fa-hand-holding-usd"></i> Donation Logs</a>
                <a href="<?= BASE_URL ?>/EditPosts" class="nav-item"><i class="fas fa-edit"></i> Edit Resources</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/Moderator/resource-hub" class="nav-item"><i class="fas fa-book"></i> Resource Hub</a>
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active"><i class="fas fa-comments"></i> Moderate Forum</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Manage Keywords</h1>
            <div class="topbar-right">
                <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
                    <div class="admin-profile" style="cursor: pointer;">
                        <span>Admin User</span>
                        <div class="avatar">A</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="content-wrapper">
            <?php 
            $activeTab = 'keywords';
            include '_forum_tabs.php'; 
            ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="add-form">
                <h3>Add New Flag Keyword</h3>
                <form action="<?= BASE_URL ?>/admin/keywords/add" method="POST" class="add-form-inline">
                    <input type="text" name="keyword" class="form-input" placeholder="Enter keyword..." required
                        minlength="2">
                    <button type="submit" class="btn btn-primary">Add Keyword</button>
                </form>
                <?php if (isset($_SESSION['error'])): ?>
                    <div style="color:red; margin-top:10px;">
                        <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div style="color:green; margin-top:10px;">
                        <?= $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <h3>Existing Keywords</h3>
            <div class="keyword-list">
                <?php if (empty($keywords)): ?>
                    <p>No keywords defined.</p>
                <?php else: ?>
                    <?php foreach ($keywords as $k): ?>
                        <div class="keyword-item">
                            <span>
                                <?= htmlspecialchars($k['keyword']) ?>
                            </span>
                            <form action="<?= BASE_URL ?>/admin/keywords/delete" method="POST" style="margin:0;">
                                <input type="hidden" name="id" value="<?= $k['id'] ?>">
                                <button type="submit" class="btn danger"
                                    onclick="return confirm('Delete this keyword?')">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>

