<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Keywords - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active">
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
        <?php else: ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/AddResource" class="nav-item">
                <span class="icon">➕</span>
                Add Resource
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item active">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/Moderator/reported-resources" class="nav-item">
                <span class="icon">🚨</span>
                Reported Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <span class="icon">🚩</span>
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <span class="icon">⚠️</span>
                Warn Users
            </a>
        </nav>
        <?php endif; ?>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

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
            <div class="toolbar">
                <div class="tabs">
                    <a href="<?= BASE_URL ?>/admin/moderate-forum" class="tab-link" style="text-decoration:none; display:flex; align-items:center;">Preview</a>
                    <a href="<?= BASE_URL ?>/admin/moderate-forum" class="tab-link" style="text-decoration:none; display:flex; align-items:center; margin-left:10px;">Flagged Queue</a>
                    <a href="<?= BASE_URL ?>/admin/moderate-forum" class="tab-link" style="text-decoration:none; display:flex; align-items:center; margin-left:10px;">Automated Flags</a>
                    <a href="<?= BASE_URL ?>/admin/forum-categories" class="tab-link"
                        style="text-decoration:none; display:flex; align-items:center; margin-left:10px;">
                        Manage Thread Categories
                    </a>
                    <a href="<?= BASE_URL ?>/admin/keywords" class="tab active"
                        style="text-decoration:none; display:flex; align-items:center; margin-left:10px;">
                        Manage Keywords
                    </a>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/admin/report-categories" class="btn" style="margin-left: 10px;">Categories</a>
                </div>
            </div>
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

