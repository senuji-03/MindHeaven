<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspended Users - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        .badge-suspended {
            background-color: #fce8e8;
            color: #d93025;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .btn-action {
            padding: 4px 8px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.8em;
            margin-right: 4px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 4px;
        }

        .btn-unsuspend {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .action-forms {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .action-forms form {
            margin: 0;
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
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item active">
                <span class="icon">👥</span> Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <span class="icon">📚</span> Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span> Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/counselors" class="nav-item">
                <span class="icon">👨‍⚕️</span> Manage Counselors
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span> Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span> Reports
                        </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/settings" class="nav-item">
                <span class="icon">⚙️</span> Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Suspended Users</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Success/Error Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Header with Actions -->
            <div class="page-header">
                <h2>Suspended Users (
                    <?= count($suspendedUsers ?? []) ?>)
                </h2>
                <div style="display: flex; gap: 10px;">
                    <a href="<?= BASE_URL ?>/admin/manage-users" class="btn btn-secondary">
                        <span class="icon">⬅️</span> Back to All Users
                    </a>
                </div>
            </div>

            <!-- Suspended Users Table -->
            <div class="section-card">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Suspended Until</th>
                            <th>Strikes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($suspendedUsers) && !empty($suspendedUsers)): ?>
                            <?php foreach ($suspendedUsers as $user): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($user['id']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['username']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['full_name']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['email']) ?>
                                    </td>
                                    <td>
                                        <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                    </td>
                                    <td>
                                        <span class="badge-suspended">
                                            <?= $user['suspended_until'] ? date('Y-m-d H:i', strtotime($user['suspended_until'])) : 'Indefinite' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($user['strike_count']) ?>
                                    </td>
                                    <td>
                                        <div class="action-forms">
                                            <form action="<?= BASE_URL ?>/admin/manage-users/unsuspend" method="POST"
                                                style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <button type="submit" class="btn-action btn-unsuspend"
                                                    title="Unsuspend">Unsuspend</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #6b7280;">
                                    No suspended users found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

