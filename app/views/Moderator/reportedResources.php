<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<style>
    /* ── REPORTED RESOURCES UNIFIED STYLES ── */
    .report-page-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .report-page-header-text h1 {
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 12px;
        letter-spacing: -0.7px;
    }

    .report-page-header-text p {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 600px;
        line-height: 1.7;
        margin: 0;
    }

    /* ── TABLE / CARD WRAPPER ── */
    .report-table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .report-table th {
        background: var(--bg-mid);
        padding: 20px 24px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--text-secondary);
        border-bottom: 1.5px solid var(--border);
    }

    .report-table td {
        padding: 24px;
        font-size: 0.95rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .report-table tr:last-child td {
        border-bottom: none;
    }

    .report-table tr:hover {
        background: rgba(61, 139, 110, 0.02);
    }

    /* ── SEMANTIC BADGES ── */
    .reason-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(214, 79, 79, 0.08);
        color: var(--crisis);
        border: 1px solid rgba(214, 79, 79, 0.15);
    }

    .resource-link {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .resource-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .report-meta {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* ── ACTION BUTTON PILLS ── */
    .action-group {
        display: flex;
        gap: 10px;
    }

    .btn-res {
        padding: 10px 14px;
        border-radius: var(--radius-md);
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        border: 1px solid var(--border);
        background: #fff;
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-secondary);
    }

    /* Remove Action */
    .btn-res-danger:hover {
        border-color: var(--crisis);
        background: var(--crisis);
        color: white;
        box-shadow: 0 4px 12px rgba(214, 79, 79, 0.2);
    }

    /* Warn Action */
    .btn-res-warn:hover {
        border-color: var(--accent-warm);
        background: var(--accent-warm);
        color: #1a1a1a;
        box-shadow: 0 4px 12px rgba(232, 168, 124, 0.2);
    }

    /* Ignore Action */
    .btn-res-dim:hover {
        border-color: var(--primary);
        background: var(--bg-mid);
        color: var(--primary-dark);
    }

    /* ── ALERTS ── */
    .alert-box {
        padding: 16px 24px;
        border-radius: var(--radius-md);
        margin-bottom: 32px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 4px solid;
    }

    .alert-success {
        background: var(--bg-mid);
        color: #1e3a34;
        border-left-color: var(--success);
    }

    /* Responsive Empty State */
    .empty-reports {
        text-align: center;
        padding: 80px 40px;
        color: var(--text-secondary);
    }

    .empty-reports i {
        font-size: 3.5rem;
        margin-bottom: 24px;
        opacity: 0.2;
    }
</style>

<div class="main-content">
    <div class="report-page-header">
        <div class="report-page-header-text">
            <h1>Reported Resources</h1>
            <p>Review community flags and maintain the quality of the Resource Hub. Ensure content aligns with
                safe-usage guidelines.</p>
        </div>
    </div>

    <!-- Resolution Alerts -->
    <?php if (isset($_GET['resolved'])): ?>
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i>
            Report successfully resolved. Action has been recorded in the moderation logs.
        </div>
    <?php endif; ?>

    <div class="report-table-card">
        <?php if (empty($reports)): ?>
            <div class="empty-reports">
                <i class="fas fa-shield-check"></i>
                <h3>All Clear!</h3>
                <p>There are no pending reports in the queue at this moment.</p>
            </div>
        <?php else: ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th width="20%">Resource</th>
                        <th width="15%">Reporter</th>
                        <th width="15%">Reason</th>
                        <th width="25%">Description</th>
                        <th width="12%">Flagged Date</th>
                        <th width="13%">Resolution</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td>
                                <a href="<?= BASE_URL ?>/ug/viewResource?id=<?= $report['resource_id'] ?>" target="_blank"
                                    class="resource-link">
                                    <i class="fas fa-arrow-up-right-from-square" style="font-size: 0.8rem;"></i>
                                    <?= htmlspecialchars($report['resource_title'] ?: 'View Content') ?>
                                </a>
                                <div class="report-meta" style="margin-top:4px;">ID: #<?= $report['resource_id'] ?></div>
                            </td>
                            <td>
                                <div class="report-meta">
                                    <strong><?= htmlspecialchars($report['reported_by']) ?></strong><br>
                                    Student User
                                </div>
                            </td>
                            <td>
                                <span class="reason-badge">
                                    <i class="fas fa-flag-swallowtail" style="font-size: 0.7rem;"></i>
                                    <?= htmlspecialchars($report['reason']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="report-meta" style="font-style: italic;">
                                    "<?= htmlspecialchars($report['description']) ?>"
                                </div>
                            </td>
                            <td>
                                <div class="report-meta">
                                    <?= date('M j, Y', strtotime($report['created_at'])) ?><br>
                                    <span
                                        style="font-size: 0.75rem;"><?= date('H:i', strtotime($report['created_at'])) ?></span>
                                </div>
                            </td>
                            <td>
                                <form action="<?= BASE_URL ?>/Moderator/resolve-report" method="POST">
                                    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                    <div class="action-group">
                                        <button type="submit" name="action" value="removed" class="btn-res btn-res-danger"
                                            title="Remove & Archive"
                                            onclick="return confirm('Archive this resource and notify the creator?')">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                        <button type="submit" name="action" value="warning issued" class="btn-res btn-res-warn"
                                            title="Issue Warning">
                                            <i class="fas fa-triangle-exclamation"></i>
                                        </button>
                                        <button type="submit" name="action" value="ignored" class="btn-res btn-res-dim"
                                            title="Dismiss Report">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>