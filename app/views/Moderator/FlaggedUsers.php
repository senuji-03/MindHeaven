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
    <title>Flagged Users - Moderator</title>
    <link rel="stylesheet" type="text/css" href="/MindHeaven/public/css/moderator/Moderator.css">
</head>
<body>
    <header>
        <h1>Flagged Users</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Moderator'); ?></p>
        <nav>
            <a href="/moderator/dashboard.php">Dashboard</a> |
            <a href="/logout.php">Logout</a>
        </nav>
    </header>

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
</body>
</html>
