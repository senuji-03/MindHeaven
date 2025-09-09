<!DOCTYPE html>
<html>
<head>
    <title>Make a Donation</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/Donor/Donor.css">
</head>
<body>
    <div class="donation-container">
        <h1>Make a Donation</h1>
        <form method="POST" action="/donor/processDonation">
            <label for="name">Full Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="amount">Donation Amount (USD)</label>
            <input type="number" name="amount" step="0.01" required>

            <label for="card">Card Details (Simulation)</label>
            <input type="text" name="card" placeholder="**** **** **** 1234" required>

            <button type="submit" class="btn">Donate Now</button>
        </form>
    </div>
</body>
</html>
