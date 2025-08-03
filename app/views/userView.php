<?php
function renderUser($user) {
    echo "<h2>User Profile</h2>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($user->getName()) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($user->getEmail()) . "</p>";
}
?>
