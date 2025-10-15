<?php include 'app/views/layouts/header.php'; ?>

<h2>Contact Moderator</h2>
<form method="POST" action="">
  <label>Your Message:</label><br>
  <textarea name="message" rows="5" cols="40" required></textarea><br>
  <button type="submit">Send</button>
</form>

<?php include 'app/views/layouts/footer.php'; ?>
