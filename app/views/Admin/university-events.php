<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Events - Admin | Mind Haven</title>
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
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item active">
                <span class="icon">🏛️</span>
                University Events
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
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Pending University Events</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">

            <?php if (isset($_SESSION['success'])): ?>
                <div
                    style="background-color: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div
                    style="background-color: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php
            $statusLabels = [
                'pending' => 'Pending Events',
                'approved' => 'Approved Events',
                'rejected' => 'Rejected Events'
            ];
            foreach (['pending', 'approved', 'rejected'] as $statusGrp):
                $uniGroups = $groupedEvents[$statusGrp] ?? [];
                ?>
                <div class="section-card"
                    style="margin-bottom: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem;">
                    <div class="section-header"
                        style="border-bottom: 2px solid #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem;">
                        <h2 style="color: #1e293b; font-size: 1.5rem; margin: 0;"><?= $statusLabels[$statusGrp] ?></h2>
                    </div>
                    <?php if (empty($uniGroups)): ?>
                        <p style="padding: 1rem; color: #64748b;">No <?= $statusGrp ?> events found.</p>
                    <?php else: ?>
                        <?php foreach ($uniGroups as $uniName => $events): ?>
                            <div class="university-group" style="padding: 1rem 0;">
                                <h3
                                    style="margin: 0 0 1rem 0; color: #475569; border-left: 4px solid #3b82f6; padding-left: 0.75rem; font-size: 1.25rem;">
                                    🏫 <?= htmlspecialchars($uniName) ?></h3>
                                <div class="reports-table-container">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background: #f8fafc; text-align: left; border-bottom: 1px solid #e2e8f0;">
                                                <th style="padding: 0.75rem;">University</th>
                                                <th style="padding: 0.75rem;">Event Title</th>
                                                <th style="padding: 0.75rem;">Short Description</th>
                                                <th style="padding: 0.75rem;">Created Date</th>
                                                <th style="padding: 0.75rem;">Status</th>
                                                <th style="padding: 0.75rem;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($events as $evt): ?>
                                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                                    <td style="padding: 0.75rem;"><?= htmlspecialchars($evt['university_name']) ?></td>
                                                    <td style="padding: 0.75rem; font-weight: 500; color: #1e293b;">
                                                        <?= htmlspecialchars($evt['event_title']) ?>
                                                    </td>
                                                    <?php
                                                    $descText = !empty($evt['short_description']) ? $evt['short_description'] : $evt['description'];
                                                    $truncDesc = strlen($descText) > 50 ? substr($descText, 0, 50) . '...' : $descText;
                                                    ?>
                                                    <td style="padding: 0.75rem; color: #64748b; font-size: 0.9rem;">
                                                        <?= htmlspecialchars($truncDesc) ?>
                                                    </td>
                                                    <td style="padding: 0.75rem; color: #64748b;">
                                                        <?= date('M j, Y', strtotime($evt['created_at'])) ?>
                                                    </td>
                                                    <td style="padding: 0.75rem;">
                                                        <span
                                                            class="status-badge <?= $evt['status'] === 'approved' ? 'resolved' : ($evt['status'] === 'closed' ? 'dismissed' : 'pending') ?>"
                                                            style="padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75em; font-weight: 600; text-transform: uppercase;">
                                                            <?= ucfirst($evt['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td style="padding: 0.75rem; display: flex; gap: 0.5rem; align-items: center;">
                                                        <a href="<?= BASE_URL ?>/university-rep/events/view/<?= $evt['id'] ?>"
                                                            class="btn-view" target="_blank"
                                                            style="text-decoration: none; padding: 0.25rem 0.75rem; border-radius: 4px; background: #e0e7ff; color: #4f46e5; font-size: 0.875rem; font-weight: 500;">View</a>
                                                        <?php if ($evt['status'] === 'pending' || $evt['status'] === 'rejected'): ?>
                                                            <form action="<?= BASE_URL ?>/admin/university-events/approve" method="POST"
                                                                style="margin: 0; display: inline-block;">
                                                                <input type="hidden" name="event_id" value="<?= $evt['id'] ?>">
                                                                <button type="submit" class="btn-primary"
                                                                    style="padding: 0.25rem 0.75rem; border-radius: 4px; border: none; background: #10b981; color: white; cursor: pointer; font-size: 0.875rem; font-weight: 500;">Approve</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php if ($evt['status'] === 'pending'): ?>
                                                            <form action="<?= BASE_URL ?>/admin/university-events/reject" method="POST"
                                                                style="margin: 0; display: inline-block;"
                                                                onsubmit="return confirm('Are you sure you want to reject this event?');">
                                                                <input type="hidden" name="event_id" value="<?= $evt['id'] ?>">
                                                                <button type="submit" class="btn-danger"
                                                                    style="padding: 0.25rem 0.75rem; border-radius: 4px; border: none; background: #ef4444; color: white; cursor: pointer; font-size: 0.875rem; font-weight: 500;">Reject</button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>