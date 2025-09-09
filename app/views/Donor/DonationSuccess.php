<!DOCTYPE html>
<html>
<head>
    <title>Donation Successful</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/Donor/Donor.css">
</head>
<body>
    <div class="success-container">
        <h1>🎉 Thank You <?= htmlspecialchars($data['name']); ?>!</h1>
        <p>Your donation of <strong>$<?= htmlspecialchars($data['amount']); ?></strong> has been received.</p>
        <a href="/">Return to Home</a>
    </div>
</body>
</html>
