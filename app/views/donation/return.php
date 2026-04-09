<?php
// app/views/donation/return.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Successful</title>
</head>
<body>
    <div style="max-width: 600px; margin: 40px auto; font-family: sans-serif; text-align: center;">
        <h1 style="color: green;">Thank You for Your Donation!</h1>
        <p>Your payment process has been returned from the gateway successfully.</p>
        <?php if ($transactionId): ?>
            <p><strong>Transaction ID:</strong> <?= htmlspecialchars($transactionId) ?></p>
            <a href="<?= BASE_URL ?>/donation/request-confirmation/<?= htmlspecialchars($donation['id'] ?? $transactionId) ?>" style="display:inline-block; margin-top:20px; padding: 10px 20px; background: #10b981; color: white; text-decoration: none;">Request Confirmation / View Pending</a>
        <?php endif; ?>
        <br><br>
        <a href="<?= BASE_URL ?>">Return to Home</a>
    </div>
</body>
</html>
