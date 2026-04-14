<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';

$pdo = Database::getConnection();

// 1. Insert call responder user
$hash = password_hash('Responder@123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("
    INSERT INTO users 
        (username, full_name, email, password, role, status, is_active, is_frozen, email_verified, 
         strike_count, is_deleted, account_status, password_reset_required)
    VALUES 
        ('responder1', 'Call Responder User', 'responder@mindheaven.com', ?, 'call_responder', 
         'active', 1, 0, 1, 0, 0, 'active', 0)
    ON DUPLICATE KEY UPDATE 
        password = VALUES(password),
        role = 'call_responder',
        status = 'active',
        account_status = 'active',
        is_active = 1
");
$stmt->execute([$hash]);
echo "User upserted. Rows affected: " . $stmt->rowCount() . PHP_EOL;

// 2. Verify login works
$stmt2 = $pdo->query("SELECT id, username, full_name, role, password FROM users WHERE username='responder1'");
$user = $stmt2->fetch(PDO::FETCH_ASSOC);
if ($user) {
    $match = password_verify('Responder@123', $user['password']);
    echo "User ID: {$user['id']}, Role: {$user['role']}" . PHP_EOL;
    echo "Password verify: " . ($match ? 'OK ✓' : 'FAIL ✗') . PHP_EOL;
} else {
    echo "User NOT found!" . PHP_EOL;
}

// 3. Create crisis_calls table if not exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS crisis_calls (
        id                INT AUTO_INCREMENT PRIMARY KEY,
        caller_user_id    INT UNSIGNED NOT NULL,
        responder_user_id INT UNSIGNED DEFAULT NULL,
        daily_room_url    VARCHAR(255) NOT NULL,
        status            ENUM('waiting','in_progress','completed','missed') DEFAULT 'waiting',
        notes             TEXT DEFAULT NULL,
        created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (caller_user_id)    REFERENCES users(id),
        FOREIGN KEY (responder_user_id) REFERENCES users(id)
    )
");
echo "crisis_calls table ready." . PHP_EOL;

// 4. Create meeting_logs table for appointment session recordings
$pdo->exec("
    CREATE TABLE IF NOT EXISTS meeting_logs (
        id               INT AUTO_INCREMENT PRIMARY KEY,
        appointment_id   INT NOT NULL,
        room_url         VARCHAR(255) NOT NULL,
        participant_name VARCHAR(150) DEFAULT NULL,
        participant_role ENUM('counselor','student','unknown') DEFAULT 'unknown',
        joined_at        DATETIME DEFAULT NULL,
        left_at          DATETIME DEFAULT NULL,
        duration_seconds INT DEFAULT 0,
        event_type       VARCHAR(80) DEFAULT NULL,
        raw_payload      TEXT DEFAULT NULL,
        created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
echo "meeting_logs table ready." . PHP_EOL;

echo PHP_EOL . "=== All done! ===" . PHP_EOL;
