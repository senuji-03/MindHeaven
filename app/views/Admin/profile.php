<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: #ffffff;
            color: #4f46e5;
            font-size: 40px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-name {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .profile-role {
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            text-transform: capitalize;
        }

        .profile-body {
            padding: 30px;
        }

        .info-group {
            margin-bottom: 25px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .info-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
            text-transform: none;
        }

        .role-value {
            text-transform: capitalize;
        }

        .back-btn {
            display: inline-block;
            margin: 20px;
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
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
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
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
                Donation logs
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>My Profile</h1>
            <div class="topbar-right">
                <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
                    <div class="admin-profile" style="cursor: pointer;">
                        <span><?= htmlspecialchars($user['full_name'] ?? $user['username']) ?></span>
                        <div class="avatar"><?= strtoupper(substr($user['username'] ?? 'A', 0, 1)) ?></div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <a href="<?= BASE_URL ?>/admin" class="back-btn">← Back to Dashboard</a>

            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?= strtoupper(substr($user['username'] ?? 'A', 0, 1)) ?>
                    </div>
                    <h2 class="profile-name"><?= htmlspecialchars($user['full_name'] ?? 'Admin User') ?></h2>
                    <div class="profile-role"><?= htmlspecialchars(str_replace('_', ' ', $user['role'] ?? 'Admin')) ?></div>
                </div>

                <div class="profile-body">
                    <div class="info-group">
                        <span class="info-label">Full Name</span>
                        <div class="info-value"><?= htmlspecialchars($user['full_name'] ?? 'N/A') ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Username</span>
                        <div class="info-value">@<?= htmlspecialchars($user['username'] ?? 'N/A') ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Email Address</span>
                        <div class="info-value"><?= htmlspecialchars($user['email'] ?? 'N/A') ?></div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Role</span>
                        <div class="info-value role-value"><?= htmlspecialchars(str_replace('_', ' ', $user['role'] ?? 'Admin')) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
