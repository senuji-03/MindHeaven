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

        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <span class="icon">📚</span>
                Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/counselors" class="nav-item">
                <span class="icon">👨‍⚕️</span>
                Manage Counselors
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/keywords" class="nav-item active">
                <span class="icon">🔑</span>
                Keywords
            </a>
            <a href="<?= BASE_URL ?>/admin/system-flags" class="nav-item">
                <span class="icon">🚩</span>
                Automated Flags
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
        <div class="topbar">
            <h1>Manage Keywords</h1>
            <div class="topbar-right">
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="tab-link">
                    ← Back to Moderation
                </a>
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
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