<?php
// Security check
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'moderator') {
//     header("Location: /login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/MindHeaven/public/css/moderator/Moderator.css">
</head>
<body>
    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Moderator</h2>
            <nav>
                <ul>
                    <li><a href="/moderator/dashboard">🏠 Dashboard</a></li>
                    <li><a href="/moderator/dashboard#flagged-posts">🚩 Flagged Posts</a></li>
                    <li><a href="/moderator/dashboard#pending-posts">⏳ Pending Posts</a></li>
                    <li><a href="/moderator/flaggedUsers">👥 Flagged Users</a></li>
                    <li><a href="/logout.php">🚪 Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <h1>Moderator Dashboard</h1>
                <p>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Moderator'); ?>!</p>
            </header>

            <!-- Flagged Posts -->
            <section id="flagged-posts" class="card">
                <h2>🚩 Flagged Posts</h2>
                <?php if (empty($data['flaggedPosts'])): ?>
                    <p>No flagged posts at the moment 🎉</p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['flaggedPosts'] as $post): ?>
                        <tr>
                            <td><?= $post['id']; ?></td>
                            <td><?= htmlspecialchars($post['content']); ?></td>
                            <td>
                                <a class="btn approve" href="/moderator/approvePost/<?= $post['id']; ?>">Approve</a>
                                <a class="btn delete" href="/moderator/deletePost/<?= $post['id']; ?>">Delete</a>
                                <a class="btn edit" href="/moderator/editPost/<?= $post['id']; ?>">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </section>

            <!-- Pending Posts -->
            <section id="pending-posts" class="card">
                <h2>⏳ Pending Posts</h2>
                <?php if (empty($data['pendingPosts'])): ?>
                    <p>No pending posts awaiting review ✅</p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($data['pendingPosts'] as $post): ?>
                        <tr>
                            <td><?= $post['id']; ?></td>
                            <td><?= htmlspecialchars($post['content']); ?></td>
                            <td>
                                <a class="btn approve" href="/moderator/approvePost/<?= $post['id']; ?>">Approve</a>
                                <a class="btn delete" href="/moderator/deletePost/<?= $post['id']; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </section>

            <!-- Flagged Users (quick overview) -->
            <section id="flagged-users" class="card">
                <h2>👥 Flagged Users</h2>
                <?php if (empty($data['flaggedUsers'])): ?>
                    <p>No flagged users right now 🎉</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($data['flaggedUsers'] as $user): ?>
                        <li>
                            <?= htmlspecialchars($user['username']); ?> (Strikes: <?= $user['strikes']; ?>)
                            <a class="btn warn" href="/moderator/warnUser/<?= $user['id']; ?>">Warn</a>
                            <a class="btn approve" href="/moderator/unflagUser/<?= $user['id']; ?>">Unflag</a>
                            <a class="btn delete" href="/moderator/escalateUser/<?= $user['id']; ?>">Escalate</a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <p><a href="/moderator/flaggedUsers" class="btn">View All</a></p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
