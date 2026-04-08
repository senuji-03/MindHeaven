<?php
$TITLE = 'MindHeaven — Reported Resources';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $TITLE ?></title>
    <link href="/MindHeaven/public/css/style.css" rel="stylesheet">
    <!-- Include any necessary moderator CSS here -->
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f1f5f9; color: #334155; font-weight: 600; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-secondary { background: #64748b; color: white; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Reported Resources</h1>
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <?php if (isset($_GET['resolved'])): ?>
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                Report successfully resolved!
            </div>
        <?php endif; ?>

        <div class="card">
            <?php if (empty($reports)): ?>
                <p style="text-align: center; color: #64748b; padding: 2rem 0;">No pending reports at this time.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Resource</th>
                            <th>Reported By</th>
                            <th>Reason</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL ?>/ug/viewResource?id=<?= $report['resource_id'] ?>" target="_blank" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                                        <?= htmlspecialchars($report['resource_title'] ?: 'View Resource') ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($report['reported_by']) ?></td>
                                <td><span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;"><?= htmlspecialchars($report['reason']) ?></span></td>
                                <td><?= htmlspecialchars($report['description']) ?></td>
                                <td><?= date('M j, Y H:i', strtotime($report['created_at'])) ?></td>
                                <td>
                                    <form action="<?= BASE_URL ?>/Moderator/resolve-report" method="POST" style="display: flex; gap: 0.5rem;">
                                        <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                        
                                        <button type="submit" name="action" value="removed" class="btn btn-danger" title="Remove the resource" onclick="return confirm('Are you sure you want to completely remove/archive this resource?')">Remove</button>
                                        <button type="submit" name="action" value="warning issued" class="btn btn-warning" title="Keep resource but issue warning to creator">Warn User</button>
                                        <button type="submit" name="action" value="ignored" class="btn btn-secondary" title="Dismiss this report">Ignore</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
