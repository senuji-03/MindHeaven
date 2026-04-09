<?php
// app/views/donation/receipt.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Receipt</title>
    <style>
        .receipt { max-width: 600px; margin: 40px auto; font-family: sans-serif; border: 1px solid #ccc; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .receipt-header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 15px; margin-bottom: 15px; }
        .receipt-body p { margin: 10px 0; font-size: 1.1rem; }
        .print-btn { display: block; width: 100%; text-align: center; margin-top: 20px; padding: 10px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; cursor: pointer; border: none; }
        @media print {
            .print-btn, .back-btn { display: none; }
            body { background: white; }
            .receipt { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2>Donation Receipt</h2>
            <p><strong>Transaction ID:</strong> <?= htmlspecialchars($donation['transaction_id']) ?></p>
        </div>
        <div class="receipt-body">
            <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($donation['created_at'])) ?></p>
            <p><strong>Event:</strong> <?= htmlspecialchars($donation['event_title'] ?? 'N/A') ?></p>
            <p><strong>University:</strong> <?= htmlspecialchars($donation['university_name'] ?? 'N/A') ?></p>
            <p><strong>Amount:</strong> <?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?></p>
            <p><strong>Payment Status:</strong> <?= htmlspecialchars(ucfirst($donation['payment_status'])) ?></p>
            <p><strong>Return Status:</strong> <?= htmlspecialchars(ucfirst($donation['return_status'])) ?></p>
            <p><strong>Donor Message:</strong> <?= nl2br(htmlspecialchars($donation['donor_message'])) ?></p>
        </div>
        <button class="print-btn" onclick="window.print()">Print Receipt</button>
        <div style="text-align: center; margin-top: 15px;">
            <a href="<?= BASE_URL ?>/donation/history" class="back-btn">Back to History</a>
        </div>
    </div>
</body>
</html>
