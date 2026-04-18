<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Flags - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>

<body>
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
            <a href="<?= BASE_URL ?>/admin/add-resource" class="nav-item">
                <span class="icon">➕</span>
                Add Resource
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
                System Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/keywords" class="nav-item">
                <span class="icon">🔑</span>
                Keywords
            </a>
            <a href="<?= BASE_URL ?>/admin/system-flags" class="nav-item active">
                <span class="icon">🚩</span>
                Automated Flags
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/settings" class="nav-item">
                <span class="icon">⚙️</span>
                Settings
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

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="flag-list">
                <?php if (empty($flags)): ?>
                    <p>No content currently flagged.</p>
                <?php else: ?>
                    <?php foreach ($flags as $flag): ?>
                        <?php
                        $contentType = $flag['content_type'] ?? '';
                        $contentId = $flag['content_id'] ?? '';
                        $username = $flag['username'] ?? ('User #' . ($flag['user_id'] ?? 'Unknown'));
                        $matchedKeyword = $flag['matched_keyword'] ?? '';
                        $createdAt = $flag['created_at'] ?? '';
                        $flagId = $flag['id'] ?? '';

                        $link = '#';
                        if ($contentType === 'thread' && !empty($contentId)) {
                            $link = BASE_URL . '/forum/thread/' . $contentId;
                        } elseif (in_array($contentType, ['post', 'reply', 'reply_reply']) && !empty($contentId)) {
                            $link = BASE_URL . '/forum';
                        }

                        $displayType = !empty($contentType) ? $contentType : 'unknown';
                        ?>
                        <div class="flag-item">
                            <div class="flag-header">
                                <span>
                                    <span class="chip">Type:
                                        <?= htmlspecialchars($displayType) ?>
                                    </span>
                                    <span class="chip">User:
                                        <?= htmlspecialchars($username) ?>
                                    </span>
                                </span>
                                <span style="font-size:0.9em; color:#888;">
                                    <?= htmlspecialchars($createdAt) ?>
                                </span>
                            </div>

                            <div class="flag-content">
                                <p>
                                    Matched Keyword:
                                    <span class="match-highlight">
                                        <?= htmlspecialchars($matchedKeyword) ?>
                                    </span>
                                </p>
                                <p>
                                    Content ID:
                                    <?= htmlspecialchars((string) $contentId) ?>
                                </p>

                                <?php if ($link !== '#'): ?>
                                    <a href="<?= $link ?>" target="_blank" style="color:#2563eb; text-decoration:underline;">
                                        View Content Context (New Tab)
                                    </a>
                                <?php else: ?>
                                    <span style="color:#6b7280;">Content context link unavailable.</span>
                                <?php endif; ?>
                            </div>

                            <div class="flag-actions" style="display:flex; gap:10px;">
                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $flagId) ?>">
                                    <input type="hidden" name="status" value="dismissed">
                                    <button type="submit" class="btn btn-secondary">Dismiss (Ignore)</button>
                                </form>

                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $flagId) ?>">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="btn btn-primary">Mark Reviewed</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>