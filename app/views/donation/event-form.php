<?php
// app/views/donation/event-form.php
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donate to
        <?= htmlspecialchars($event['event_title']) ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body>
    <div style="max-width: 600px; margin: 40px auto; font-family: sans-serif;">
        <h1>Donate to:
            <?= htmlspecialchars($event['event_title']) ?>
        </h1>
        <p>Your contribution helps make this event possible.</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div style="color: red; margin-bottom: 20px;">
                <?= htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/donation/payhere/start" method="POST">
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">

            <?php if (!$isLoggedIn): ?>
                <div style="margin-bottom: 15px;">
                    <label>Your Name:</label><br>
                    <input type="text" name="donor_name" required style="width: 100%; padding: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Your Email:</label><br>
                    <input type="email" name="donor_email" required style="width: 100%; padding: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Your Phone:</label><br>
                    <input type="text" name="donor_phone" required style="width: 100%; padding: 8px;">
                </div>
            <?php endif; ?>

            <div style="margin-bottom: 15px;">
                <label>Donation Amount (LKR):</label><br>
                <input type="number" name="amount" required min="100" style="width: 100%; padding: 8px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Message (Optional):</label><br>
                <textarea name="donor_message" style="width: 100%; padding: 8px;" rows="4"></textarea>
            </div>

            <button type="submit"
                style="padding: 10px 20px; background: #3b82f6; color: white; border: none; cursor: pointer;">
                Proceed to Checkout
            </button>
            <a href="<?= BASE_URL ?>/university-rep/events/view/<?= htmlspecialchars($event['id']) ?>"
                style="margin-left: 10px;">Back to Event</a>
        </form>
    </div>
</body>

</html>