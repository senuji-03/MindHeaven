<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Events - Admin | Mind Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --bg-soft:#F5F0E8; --bg-mid:#EEF6F2;
            --text-primary:#1E3A34; --text-secondary:#6B8C7E;
            --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px; --radius-lg:20px; --radius-full:9999px;
            --shadow-sm:0 1px 3px rgba(30,58,52,.06);
        }
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; background:var(--bg-soft); }

        /* DS Sidebar */
        .sidebar {
            width:280px; height:100vh; background:var(--bg-deep);
            position:fixed; left:0; top:0;
            display:flex; flex-direction:column; z-index:1000;
        }
        .sidebar-header { padding:36px 28px 28px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-header h2 { font-size:1.4rem; font-weight:700; color:var(--primary-light); margin-bottom:6px; }
        .sidebar-header p  { font-size:.75rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-nav { flex:1; padding:24px 16px; overflow-y:auto; }
        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:rgba(255,255,255,.65);
            text-decoration:none; border-radius:var(--radius-sm);
            margin-bottom:4px; font-weight:500; font-size:.95rem;
            transition:all .25s ease;
        }
        .nav-item i { width:20px; text-align:center; font-size:1rem; }
        .nav-item:hover { background:rgba(255,255,255,.07); color:white; transform:translateX(3px); }
        .nav-item.active { background:var(--primary); color:white; box-shadow:0 4px 12px rgba(61,139,110,.3); }
        .sidebar-footer { padding:20px 16px; border-top:1px solid rgba(255,255,255,.08); }
        .logout-btn {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:#FFB3B3;
            text-decoration:none; border-radius:var(--radius-sm);
            font-weight:600; font-size:.9rem; transition:all .25s;
        }
        .logout-btn:hover { background:rgba(214,79,79,.1); }

        .main-content { margin-left: 280px; width: calc(100% - 280px); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    </style>

<body>
    <!-- Sidebar (Design System §1,§15) -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item"><i class="fas fa-users"></i> Manage Users</a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item"><i class="fas fa-comments"></i> Moderate Forum</a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item"><i class="fas fa-calendar-check"></i> Appointments</a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item"><i class="fas fa-chart-bar"></i> System Reports</a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item active"><i class="fas fa-university"></i> University Events</a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item"><i class="fas fa-hand-holding-usd"></i> Donation Logs</a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item"><i class="fas fa-book"></i> Resource Hub</a>
            <a href="<?= BASE_URL ?>/admin/add-resource" class="nav-item"><i class="fas fa-plus-circle"></i> Add Resource</a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item"><i class="fas fa-edit"></i> Edit Resources</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Pending University Events</h1>
            <div class="topbar-right">
                <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
                    <div class="admin-profile" style="cursor: pointer;">
                        <span>Admin User</span>
                        <div class="avatar">A</div>
                    </div>
                </a>
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
                                                        <?php if ($evt['status'] === 'approved'): ?>
                                                            <form action="<?= BASE_URL ?>/admin/university-events/remove" method="POST"
                                                                style="margin: 0; display: inline-block;"
                                                                onsubmit="return confirm('Are you sure you want to remove this approved event? This will change its status to cancelled.');">
                                                                <input type="hidden" name="event_id" value="<?= $evt['id'] ?>">
                                                                <button type="submit" class="btn-danger"
                                                                    style="padding: 0.25rem 0.75rem; border-radius: 4px; border: none; background: #dc2626; color: white; cursor: pointer; font-size: 0.875rem; font-weight: 500;">Remove</button>
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