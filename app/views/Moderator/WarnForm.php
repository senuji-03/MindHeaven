<!DOCTYPE html>
<html>
<head>
    <title>Send Warning</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/moderator/Moderator.css">
</head>
<body>
    <h2>Send Warning to User #<?= $data['userId']; ?></h2>
    <form method="POST" action="">
        <textarea name="message" rows="5" cols="50" placeholder="Enter warning message..."></textarea><br><br>
        <button type="submit" class="btn warn">Send Warning</button>
    </form>
</body>
</html>
