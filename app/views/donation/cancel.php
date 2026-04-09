<?php
// app/views/donation/cancel.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Cancelled</title>
</head>
<body>
    <div style="max-width: 600px; margin: 40px auto; font-family: sans-serif; text-align: center;">
        <h1 style="color: red;">Donation Cancelled</h1>
        <p>Your payment process was cancelled or interrupted.</p>
        <?php if ($transactionId): ?>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($transactionId) ?></p>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>" style="display:inline-block; margin-top:20px; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none;">Return to Home</a>
    </div>
</body>
</html>
