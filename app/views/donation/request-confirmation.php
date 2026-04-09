<?php
// app/views/donation/request-confirmation.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Confirmation</title>
    <style>
        .box { max-width: 600px; margin: 40px auto; font-family: sans-serif; padding: 20px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Donation Confirmation Request Scaffold</h2>
        <?php if ($donation): ?>
            <p>Your donation of <strong><?= htmlspecialchars($donation['currency']) ?> <?= htmlspecialchars($donation['amount']) ?></strong> to <strong><?= htmlspecialchars($donation['event_title'] ?? 'Event') ?></strong> is currently <strong><?= htmlspecialchars($donation['payment_status']) ?></strong>.</p>
            
            <hr style="margin: 20px 0;">
            <h3>Bank Details for University: <?= htmlspecialchars($donation['university_name'] ?? 'N/A') ?></h3>
            <p>If you need to make an offline transfer or confirm your pending online payment, here are the bank details.</p>
            <p><em>(Bank details from DB could go here based on university table joins)</em></p>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Confirmation request sent!'); window.location.href='<?= BASE_URL ?>/donation/history';">
                <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border:none; border-radius: 5px; cursor: pointer;">Send Manual Confirmation Memo</button>
            </form>
        <?php else: ?>
            <p>Donation not found.</p>
        <?php endif; ?>
        <br>
        <a href="<?= BASE_URL ?>/donation/history">Back to History</a>
    </div>
</body>
</html>
