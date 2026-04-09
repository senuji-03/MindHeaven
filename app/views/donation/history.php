<?php
// app/views/donation/history.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Donations</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 40px auto; font-family: sans-serif;">
        <h1>My Donations History</h1>
        <?php if (empty($donations)): ?>
            <p>You have not made any donations yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Amount</th>
                        <th>Gateway</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?= date('Y-m-d H:i', strtotime($donation['created_at'])) ?></td>
                        <td><?= htmlspecialchars($donation['event_title'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?></td>
                        <td><?= htmlspecialchars($donation['gateway'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars(ucfirst($donation['payment_status'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/donation/receipt/<?= $donation['id'] ?>">Receipt</a>
                            | <a href="<?= BASE_URL ?>/donation/request-confirmation/<?= $donation['id'] ?>">Confirmation</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <a href="<?= BASE_URL ?>">Return to Home</a>
    </div>
</body>
</html>
