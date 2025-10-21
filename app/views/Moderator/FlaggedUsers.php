<?php
// Start session and check if moderator is logged in
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'moderator') {
    header("Location: /login.php");
    exit;
}

// --- Mock Data for now (replace with DB queries later) ---
$flaggedUsers = [
    ['id' => 101, 'username' => 'user123', 'strikes' => 2],
    ['id' => 102, 'username' => 'test_user', 'strikes' => 3],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flagged Users - Moderator</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <link rel="stylesheet" type="text/css" href="/MindHeaven/public/css/moderator/Moderator.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Moderator Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item active">
                <span class="icon">🚩</span>
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <span class="icon">⚠️</span>
                Warn Users
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
            <h1>Flagged Users</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Moderator</span>
                    <div class="avatar">M</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">

            <main>
                <section class="card">
                    <h2>List of Flagged Users</h2>

                    <?php if (empty($flaggedUsers)): ?>
                        <p>No flagged users at the moment 🎉</p>
                    <?php else: ?>
                        <table>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Strikes</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($flaggedUsers as $user): ?>
                            <tr>
                                <td><?= $user['id']; ?></td>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= $user['strikes']; ?></td>
                                <td>
                                    <a class="btn warn" href="/moderator/warnUser/<?= $user['id']; ?>">Send Warning</a>
                                    <a class="btn approve" href="/moderator/unflagUser.php?id=<?= $user['id']; ?>">Unflag</a>
                                    <a class="btn delete" href="/moderator/escalateUser.php?id=<?= $user['id']; ?>">Escalate to Admin</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
