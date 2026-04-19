<?php
$TITLE = 'My Donations';
$CURRENT_PAGE = 'donation'; // Highlight 'Donate' in sidebar
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="main-content">
    <div class="container" style="padding: 40px 24px;">
        
        <!-- Section Header -->
        <div class="section-header" style="text-align: left; margin-bottom: 40px;">
            <span class="section-label">Financial History</span>
            <h1 class="section-title">My Donations</h1>
            <p class="section-subtitle" style="margin: 0; max-width: 600px;">View and track all your contributions to university events and wellness causes.</p>
        </div>

        <?php if (empty($donations)): ?>
            <div class="card" style="text-align: center; padding: 60px 24px; border-style: dashed; border-width: 2px;">
                <div class="card-icon" style="margin: 0 auto 24px; background: var(--bg-mid); color: var(--primary); width: 64px; height: 64px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm);">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3 style="margin-bottom: 12px; color: var(--text-primary);">No Donations Found</h3>
                <p style="color: var(--text-secondary); margin-bottom: 24px; max-width: 450px; margin-left: auto; margin-right: auto;">Your kindness can make a real difference. Explore active fundraising events and start your contribution journey today.</p>
                <a href="<?= BASE_URL ?>/#fundraising-events" class="btn btn-donate">
                    <i class="fas fa-search"></i> Browse Events
                </a>
            </div>
        <?php else: ?>
            <div class="card" style="padding: 0; overflow: hidden; border-radius: var(--radius-lg); background: var(--surface); border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                <div style="overflow-x: auto;">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Event Title</th>
                                <th>Amount</th>
                                <th>Gateway</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $donation): ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <div style="font-weight: 700; color: var(--text-primary);"><?= date('M j, Y', strtotime($donation['created_at'])) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);"><?= date('H:i', strtotime($donation['created_at'])) ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--primary-dark);"><?= htmlspecialchars($donation['event_title'] ?? 'General Donation') ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text-primary);">
                                        <?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 0.85rem;">
                                        <i class="fas fa-credit-card"></i>
                                        <?= htmlspecialchars($donation['gateway'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $status = strtolower($donation['payment_status']);
                                        $statusClass = 'badge--' . ($status === 'completed' ? 'success' : ($status === 'pending' ? 'warning' : 'danger'));
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>">
                                        <?= ucfirst($status) ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="<?= BASE_URL ?>/donation/receipt/<?= $donation['id'] ?>" class="action-link" title="Download Receipt">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/donation/request-confirmation/<?= $donation['id'] ?>" class="action-link confirmation" title="Request Confirmation">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <div style="margin-top: 32px; text-align: left;">
            <a href="<?= BASE_URL ?>" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; border-radius: var(--radius-full); border: 1.5px solid var(--border); color: var(--text-secondary);">
                <i class="fas fa-arrow-left"></i> Return to Home
            </a>
        </div>
    </div>
</div>

<style>
    /* Table Enhancements */
    .history-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--surface);
    }

    .history-table th {
        background: var(--bg-mid);
        padding: 16px 24px;
        text-align: left;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border);
    }

    .history-table td {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        transition: background 0.2s;
    }

    .history-table tr:hover td {
        background: var(--bg-soft);
    }

    .history-table tr:last-child td {
        border-bottom: none;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .badge--success { background: rgba(76, 175, 130, 0.1); color: var(--success); }
    .badge--warning { background: rgba(232, 168, 124, 0.1); color: var(--accent-warm); }
    .badge--danger { background: rgba(214, 79, 79, 0.1); color: var(--crisis); }

    /* Action Links */
    .action-link {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-mid);
        color: var(--text-secondary);
        transition: all 0.25s ease;
        text-decoration: none;
        font-size: 1rem;
    }

    .action-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .action-link.confirmation:hover {
        background: var(--accent-warm);
    }

    /* Animation */
    .card {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
