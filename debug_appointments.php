<?php
require_once 'config/config.php';
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    
    echo "Current Server Time: " . date('Y-m-d H:i:s') . "\n";
    
    echo "\nAll Accepted/Scheduled/Confirmed appointments:\n";
    $stmt = $pdo->query("SELECT id, student_user_id, counselor_user_id, date, time, status, title FROM appointments WHERE status IN ('accept', 'accepted', 'scheduled', 'confirmed')");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rows);
    
    echo "\nUpcoming conditions check for counselor ID (pick one from above if exists):\n";
    // I'll just check all and show why they might be filtered
    foreach ($rows as $row) {
        $is_future_date = ($row['date'] > date('Y-m-d'));
        $is_today = ($row['date'] == date('Y-m-d'));
        $is_future_time = ($row['time'] >= date('H:i:s'));
        
        echo "ID {$row['id']}: Date={$row['date']}, Time={$row['time']}, Status={$row['status']}\n";
        echo "  Future Date: " . ($is_future_date ? "YES" : "NO") . "\n";
        echo "  Today: " . ($is_today ? "YES" : "NO") . "\n";
        echo "  Future Time (if today): " . ($is_future_time ? "YES" : "NO") . "\n";
        echo "  Will show on dashboard: " . (($is_future_date || ($is_today && $is_future_time)) ? "YES" : "NO") . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
