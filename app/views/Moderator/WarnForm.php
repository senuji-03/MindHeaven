<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Warning - Moderator</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/moderator/Moderator.css">
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
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <span class="icon">🚩</span>
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item active">
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
            <h1>Send Warning</h1>
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
                    <h2>Send Warning to User #<?= $data['userId'] ?? 'Unknown'; ?></h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="message">Warning Message</label>
                            <textarea name="message" id="message" rows="5" cols="50" placeholder="Enter warning message..." required></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn warn">Send Warning</button>
                            <a href="<?= BASE_URL ?>/FlaggedUsers" class="btn btn-outline">Cancel</a>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
