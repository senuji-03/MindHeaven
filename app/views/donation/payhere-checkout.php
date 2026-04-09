<?php
$actionUrl = !empty($checkoutData['sandbox'])
    ? 'https://sandbox.payhere.lk/pay/checkout'
    : 'https://www.payhere.lk/pay/checkout';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Redirecting to PayHere...</title>
</head>

<body>
    <p>Redirecting to PayHere...</p>

    <form id="payhere-form" method="POST" action="<?= htmlspecialchars($actionUrl) ?>">
        <input type="hidden" name="merchant_id" value="<?= htmlspecialchars($checkoutData['merchant_id']) ?>">
        <input type="hidden" name="return_url" value="<?= htmlspecialchars($checkoutData['return_url']) ?>">
        <input type="hidden" name="cancel_url" value="<?= htmlspecialchars($checkoutData['cancel_url']) ?>">
        <input type="hidden" name="notify_url" value="<?= htmlspecialchars($checkoutData['notify_url']) ?>">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($checkoutData['order_id']) ?>">
        <input type="hidden" name="items" value="<?= htmlspecialchars($checkoutData['items']) ?>">
        <input type="hidden" name="currency" value="<?= htmlspecialchars($checkoutData['currency']) ?>">
        <input type="hidden" name="amount" value="<?= htmlspecialchars($checkoutData['amount']) ?>">
        <input type="hidden" name="first_name" value="<?= htmlspecialchars($checkoutData['first_name']) ?>">
        <input type="hidden" name="last_name" value="<?= htmlspecialchars($checkoutData['last_name']) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($checkoutData['email']) ?>">
        <input type="hidden" name="phone" value="<?= htmlspecialchars($checkoutData['phone']) ?>">
        <input type="hidden" name="address" value="<?= htmlspecialchars($checkoutData['address']) ?>">
        <input type="hidden" name="city" value="<?= htmlspecialchars($checkoutData['city']) ?>">
        <input type="hidden" name="country" value="<?= htmlspecialchars($checkoutData['country']) ?>">
        <input type="hidden" name="hash" value="<?= htmlspecialchars($checkoutData['hash']) ?>">

        <?php if (!empty($checkoutData['custom_1'])): ?>
            <input type="hidden" name="custom_1" value="<?= htmlspecialchars($checkoutData['custom_1']) ?>">
        <?php endif; ?>

        <?php if (!empty($checkoutData['custom_2'])): ?>
            <input type="hidden" name="custom_2" value="<?= htmlspecialchars($checkoutData['custom_2']) ?>">
        <?php endif; ?>
    </form>

    <script>
        document.getElementById('payhere-form').submit();
    </script>
</body>

</html>