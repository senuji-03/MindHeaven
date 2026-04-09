<?php
// app/views/UniversityRepresentative/donations.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Donations - University Representative | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
</head>
<body>
    <div class="main-content">
        <div class="content-wrapper" style="max-width: 1000px; margin: 40px auto; padding: 20px;">
            <h2>📊 Donations for Your Events</h2>
            <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <?php if (empty($donations)): ?>
                    <p>No donations found for your events yet.</p>
                <?php else: ?>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #eee;">
                                <th style="text-align: left; padding: 10px;">Date</th>
                                <th style="text-align: left; padding: 10px;">Event</th>
                                <th style="text-align: left; padding: 10px;">Amount</th>
                                <th style="text-align: left; padding: 10px;">Transaction ID</th>
                                <th style="text-align: left; padding: 10px;">Status</th>
                                <th style="text-align: left; padding: 10px;">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $donation): ?>
                                <tr style="border-bottom: 1px solid #f5f5f5;">
                                    <td style="padding: 10px;"><?= date('M j, Y', strtotime($donation['created_at'])) ?></td>
                                    <td style="padding: 10px;"><?= htmlspecialchars($donation['event_title']) ?></td>
                                    <td style="padding: 10px;"><?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?></td>
                                    <td style="padding: 10px;"><?= htmlspecialchars($donation['transaction_id']) ?></td>
                                    <td style="padding: 10px;"><?= htmlspecialchars(ucfirst($donation['payment_status'])) ?></td>
                                    <td style="padding: 10px; font-style: italic; font-size: 0.9em;"><?= htmlspecialchars($donation['donor_message']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            <div style="margin-top: 20px;">
                <a href="<?= BASE_URL ?>/university-rep/dashboard" style="color: #6b7280; text-decoration: none;">&larr; Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
