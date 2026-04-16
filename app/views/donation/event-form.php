<?php
// app/views/donation/event-form.php
require BASE_PATH . '/app/views/layouts/header.php';

$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>

<main id="main" class="donation-main" style="padding: 60px 0; background: var(--bg-soft); min-height: calc(100vh - 200px);">
    <div class="container" style="max-width: 700px; margin: 0 auto;">
        
        <div class="card" style="padding: 40px; box-shadow: var(--shadow-md);">
            <div class="section-header" style="text-align: left; margin-bottom: 32px;">
                <span class="section-label">Fundraising Event</span>
                <h1 class="section-title" style="font-size: 2.2rem; margin: 8px 0;">Donate to: <?= htmlspecialchars($event['event_title']) ?></h1>
                <p class="section-subtitle" style="margin: 0; text-align: left;">Your contribution helps make this event possible and supports student wellness.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="form-error" style="background: rgba(214, 79, 79, 0.08); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/donation/payhere/start" method="POST" style="display: flex; flex-direction: column; gap: 24px;">
                <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">

                <?php if (!$isLoggedIn): ?>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="donor_name" class="form-label">Full Name *</label>
                            <input type="text" id="donor_name" name="donor_name" class="form-input" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="donor_email" class="form-label">Email Address *</label>
                            <input type="email" id="donor_email" name="donor_email" class="form-input" placeholder="john@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="donor_phone" class="form-label">Phone Number *</label>
                            <input type="text" id="donor_phone" name="donor_phone" class="form-input" placeholder="077XXXXXXX" required>
                        </div>
                    </div>
                <?php else: ?>
                    <div style="background: var(--bg-mid); padding: 16px 20px; border-radius: var(--radius-md); border-left: 4px solid var(--primary); margin-bottom: 8px;">
                        <p style="margin: 0; font-size: 0.95rem; color: var(--text-primary);">
                            <i class="fas fa-user-circle" style="margin-right: 8px; color: var(--primary);"></i>
                            Donating as <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></strong>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="amount" class="form-label">Donation Amount (LKR) *</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-weight: 600;">LKR</span>
                        <input type="number" id="amount" name="amount" class="form-input" required min="100" placeholder="1000" style="padding-left: 55px;">
                    </div>
                    <p class="form-helper">Minimum donation amount is LKR 100.</p>
                </div>

                <div class="form-group">
                    <label for="donor_message" class="form-label">Optional Message</label>
                    <textarea id="donor_message" name="donor_message" class="form-input" rows="4" placeholder="Leave a message for the organizers..."></textarea>
                </div>

                <div style="display: flex; align-items: center; gap: 16px; margin-top: 12px; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex: 1; min-width: 200px;">
                        <i class="fas fa-heart" style="margin-right: 8px;"></i>
                        Proceed to Checkout
                    </button>
                    <a href="<?= BASE_URL ?>/university-rep/events/view/<?= htmlspecialchars($event['id']) ?>" class="btn btn-outline" style="text-decoration: none;">
                        Back to Event
                    </a>
                </div>
            </form>
        </div>

        <div style="margin-top: 32px; text-align: center;">
            <p style="color: var(--text-secondary); font-size: 0.88rem;">
                <i class="fas fa-lock" style="margin-right: 6px;"></i>
                Secure checkout powered by <strong>PayHere</strong>
            </p>
        </div>
    </div>
</main>

<style>
/* Local overrides for event-form specifically */
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: inherit;
    font-size: 0.95rem;
    color: var(--text-primary);
    background: var(--surface);
    transition: all 0.25s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(61, 139, 110, 0.12);
}

.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-helper {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 6px;
}

.btn-lg {
    padding: 14px 32px;
    font-size: 1rem;
}

.btn-outline {
    background: transparent;
    color: var(--primary);
    border: 1.5px solid var(--border);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 22px;
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: 0.88rem;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    border-color: var(--primary);
    background: var(--bg-mid);
}
</style>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>