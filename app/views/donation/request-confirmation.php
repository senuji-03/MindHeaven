<?php
$TITLE = 'Request Confirmation';
$CURRENT_PAGE = 'donation';
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="main-content">
    <div class="container" style="padding: 40px 24px;">
        
        <!-- Section Header -->
        <div class="section-header" style="text-align: left; margin-bottom: 40px;">
            <span class="section-label">Manual Verification</span>
            <h1 class="section-title">Request Confirmation</h1>
            <p class="section-subtitle" style="margin: 0; max-width: 600px;">Follow the instructions below to finalize your donation via manual bank transfer or verify a pending payment.</p>
        </div>

        <div class="grid-2" style="grid-template-columns: 1.5fr 1fr; align-items: start; gap: 32px;">
            <div class="card" style="padding: 32px; border-radius: var(--radius-lg); background: var(--surface); border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                <?php if ($donation): ?>
                    <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--bg-mid);">
                        <h3 style="font-size: 1.25rem; margin-bottom: 16px; color: var(--text-primary);">
                            <i class="fas fa-file-invoice-dollar" style="color: var(--primary); margin-right: 12px;"></i>
                            Donation Summary
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-secondary);">Donation to:</span>
                                <span style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($donation['event_title'] ?? 'General Event') ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-secondary);">Amount:</span>
                                <span style="font-weight: 700; color: var(--primary-dark); font-size: 1.1rem;">
                                    <?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?>
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-secondary);">Current Status:</span>
                                <?php 
                                    $status = strtolower($donation['payment_status']);
                                    $badgeClass = ($status === 'completed' ? 'success' : ($status === 'pending' ? 'warning' : 'danger'));
                                ?>
                                <span class="status-badge badge--<?= $badgeClass ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 1.1rem; margin-bottom: 16px; color: var(--text-primary); display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--bg-mid); color: var(--primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                <i class="fas fa-university"></i>
                            </div>
                            Bank Details: <?= htmlspecialchars($donation['university_name'] ?? 'The University') ?>
                        </h3>
                        
                        <div style="background: var(--bg-soft); padding: 20px; border-radius: var(--radius-md); border-left: 4px solid var(--primary);">
                            <?php if (!empty($donation['account_number'])): ?>
                                <div style="margin-bottom: 12px;">
                                    <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.5px;">Account Number</label>
                                    <div style="font-size: 1.1rem; font-weight: 700; font-family: monospace; letter-spacing: 1px; color: var(--text-primary);"><?= htmlspecialchars($donation['account_number']) ?></div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.5px;">Bank Name</label>
                                        <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($donation['bank_name'] ?? 'N/A') ?></div>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.5px;">Branch</label>
                                        <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($donation['bank_branch'] ?? 'N/A') ?></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p style="color: var(--text-secondary); font-style: italic; margin: 0;">
                                    Bank details are managed by the University Representative. Please contact them directly or use the automated PayHere gateway for immediate processing.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Confirmation request sent!'); window.location.href='<?= BASE_URL ?>/donation/history';">
                        <button type="submit" class="btn btn-donate" style="width: 100%; padding: 14px; font-size: 1rem; border-radius: var(--radius-md);">
                            <i class="fas fa-paper-plane"></i> Send Manual Confirmation Memo
                        </button>
                    </form>

                <?php else: ?>
                    <div style="text-align: center; padding: 20px 0;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--accent-warm); opacity: 0.5; margin-bottom: 16px;"></i>
                        <h3>Record Not Found</h3>
                        <p style="color: var(--text-secondary);">We couldn't locate the donation record you requested.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="info-sidebar">
                <div class="card" style="padding: 24px; background: var(--bg-deep); color: white; border-radius: var(--radius-lg); border: none;">
                    <h4 style="margin-bottom: 16px; display: flex; align-items: center; gap: 10px; color: var(--accent-calm);">
                        <i class="fas fa-lightbulb"></i> Important Note
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px; font-size: 0.9rem; line-height: 1.6;">
                        <li style="display: flex; gap: 12px;">
                            <i class="fas fa-check-circle" style="color: var(--primary-light); margin-top: 4px;"></i>
                            <span>Include your <strong>Transaction ID</strong> in the bank transfer reference.</span>
                        </li>
                        <li style="display: flex; gap: 12px;">
                            <i class="fas fa-check-circle" style="color: var(--primary-light); margin-top: 4px;"></i>
                            <span>The Manual Confirmation Memo notifies the university to verify your payment.</span>
                        </li>
                        <li style="display: flex; gap: 12px;">
                            <i class="fas fa-check-circle" style="color: var(--primary-light); margin-top: 4px;"></i>
                            <span>Verification usually takes 1-2 business days.</span>
                        </li>
                    </ul>
                </div>

                <div style="margin-top: 24px; text-align: center;">
                    <a href="<?= BASE_URL ?>/donation/history" class="btn btn-outline" style="width: 100%; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-history"></i> Back to History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .badge--success { background: rgba(76, 175, 130, 0.1); color: #4CAF82; }
    .badge--warning { background: rgba(232, 168, 124, 0.1); color: #E8A87C; }
    .badge--danger { background: rgba(214, 79, 79, 0.1); color: #D64F4F; }

    @media (max-width: 900px) {
        .grid-2 { grid-template-columns: 1fr !important; }
    }

    .card {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
