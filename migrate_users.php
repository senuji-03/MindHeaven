<?php
require __DIR__ . '/config/config.php';
require __DIR__ . '/core/Database.php';

try {
    $db = Database::getConnection();

    // Add columns if they don't exist
    $sql = "
        ALTER TABLE users 
        ADD COLUMN IF NOT EXISTS email VARCHAR(255) NULL AFTER username,
        ADD COLUMN IF NOT EXISTS status ENUM('active','inactive','suspended') DEFAULT 'active' AFTER role,
        ADD COLUMN IF NOT EXISTS suspended_until DATETIME NULL AFTER strike_count,
        ADD COLUMN IF NOT EXISTS is_deleted BOOLEAN DEFAULT FALSE AFTER suspended_until;
    ";

    $db->exec($sql);
    echo "Columns added successfully!\n";

    // Migrate existing emails from specific role tables to the main users table
    $sql_migrate_ug = "
        UPDATE users u
        INNER JOIN undergraduate_students us ON u.id = us.user_id
        SET u.email = us.email
        WHERE u.role = 'undergraduate' AND u.email IS NULL;
    ";
    $db->exec($sql_migrate_ug);

    $sql_migrate_counselor = "
        UPDATE users u
        INNER JOIN counselors c ON u.id = c.user_id
        SET u.email = c.email
        WHERE u.role = 'counselor' AND u.email IS NULL;
    ";
    $db->exec($sql_migrate_counselor);
    echo "Emails migrated successfully!\n";

    // Migrate existing account statuses to the new generic status
    $sql_migrate_status = "
        UPDATE users
        SET status = CASE 
            WHEN account_status = 'suspended' THEN 'suspended'
            WHEN account_status = 'banned' THEN 'inactive'
            ELSE 'active'
        END;
    ";
    $db->exec($sql_migrate_status);
    echo "Statuses migrated successfully!\n";

    // Migrate suspension_until to suspended_until
    $sql_migrate_suspension = "
        UPDATE users
        SET suspended_until = suspension_until
        WHERE suspension_until IS NOT NULL;
    ";
    $db->exec($sql_migrate_suspension);
    echo "Suspensions migrated successfully!\n";

} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
