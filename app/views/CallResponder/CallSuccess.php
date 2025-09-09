<!DOCTYPE html>
<html>
<head>
    <title>Call Ended</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/call-responder/call-responder.css">
</head>
<body>
    <div class="success-container">
        <h1>✅ Call Ended</h1>
        <p>The call has been recorded successfully.</p>
        <a href="<?= htmlspecialchars($data['recording']); ?>" download>Download Recording</a>
        <br><br>
        <a href="/">Return to Home</a>
    </div>
</body>
</html>
