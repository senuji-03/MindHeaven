<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Flags - Admin | Mind Haven</title>
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
            <a href="<?= BASE_URL ?>/admin/keywords" class="nav-item">
                <span class="icon">🔑</span>
                Keywords
            </a>
            <a href="<?= BASE_URL ?>/admin/system-flags" class="nav-item active">
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
            <h1>Automated Flags Queue</h1>
            <div class="topbar-right">
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

            <div class="flag-list">
                <?php if (empty($flags)): ?>
                    <p>No content currently flagged.</p>
                <?php else: ?>
                    <?php foreach ($flags as $flag): ?>
                        <div class="flag-item">
                            <div class="flag-header">
                                <span>
                                <span class="chip">Type: <?= htmlspecialchars($flag['content_type']) ?></span>
                                <span class="chip">User: <?= htmlspecialchars($flag['username']) ?></span>
                                </span>
                                <span style="font-size:0.9em; color:#888;">
                                    <?= $flag['created_at'] ?>
                                </span>
                            </div>

                            <div class="flag-content">
                                <p>Matched Keyword: <span class="match-highlight">
                                        <?= htmlspecialchars($flag['matched_keyword']) ?>
                                    </span></p>
                                <p>Content ID:
                                    <?= $flag['content_id'] ?>
                                </p>

                                <?php
                                // Determine link to content based on type
                                $link = '#';
                                if ($flag['content_type'] === 'thread') {
                                    $link = BASE_URL . '/forum/thread/' . $flag['content_id'];
                                } elseif ($flag['content_type'] === 'post' || $flag['content_type'] === 'reply' || $flag['content_type'] === 'reply_reply') {
                                    // For posts, we need the thread ID to link properly. 
                                    // Ideally, we'd fetch this. accessible via manual lookup or link to forum home.
                                    // For now, let's just link to forum home or maybe implement a direct lookup later.
                                    // Or simplified: Link to forum home
                                    $link = BASE_URL . '/forum';
                                }
                                ?>
                                <a href="<?= $link ?>" target="_blank" style="color:#2563eb; text-decoration:underline;">View
                                    Content Context (New Tab)</a>
                            </div>

                            <div class="flag-actions" style="display:flex; gap:10px;">
                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                                    <input type="hidden" name="status" value="dismissed">
                                    <button type="submit" class="btn btn-secondary">Dismiss (Ignore)</button>
                                </form>

                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="btn btn-primary">Mark Reviewed</button>
                                </form>

                                <!-- Deletion should be handled via standard moderation tools if needed -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>