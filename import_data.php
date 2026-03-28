<?php
$backupDir = 'C:/xampp/mysql/data_old/mind_heaven';
$liveDir = 'C:/xampp/mysql/data/mind_heaven';

echo "<h2>Starting Automated Data Recovery</h2>";

if (!is_dir($backupDir)) {
    die("<span style='color:red;'>Error: Backup directory $backupDir not found.</span>");
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=mind_heaven", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");

    // Get all tables currently in the live database schema
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Found " . count($tables) . " tables in the new schema.<br><br>";

    $successCount = 0;
    $errorCount = 0;

    foreach ($tables as $table) {
        $ibdFile = $table . '.ibd';
        $backupPath = $backupDir . '/' . $ibdFile;
        $livePath = $liveDir . '/' . $ibdFile;

        echo "<b>Processing table: $table</b><br>";

        if (!file_exists($backupPath)) {
            echo "<span style='color:orange;'>- No backup data found for $table. Skipping.</span><br><br>";
            continue;
        }

        try {
            // Get all secondary indexes to drop them
            $idxStmt = $pdo->query("SHOW INDEXES FROM `$table` WHERE Key_name != 'PRIMARY'");
            $indexes = $idxStmt->fetchAll(PDO::FETCH_ASSOC);
            $droppedIndexes = [];

            // Generate recreate statements BEFORE dropping them
            foreach ($indexes as $idx) {
                if (!isset($droppedIndexes[$idx['Key_name']])) {
                    $droppedIndexes[$idx['Key_name']] = [
                        'unique' => ($idx['Non_unique'] == 0) ? 'UNIQUE' : '',
                        'columns' => []
                    ];
                }
                $droppedIndexes[$idx['Key_name']]['columns'][] = "`" . $idx['Column_name'] . "`";
            }

            // Drop them
            foreach ($droppedIndexes as $keyName => $data) {
                $pdo->exec("ALTER TABLE `$table` DROP INDEX `$keyName`;");
                echo "- Dropped secondary index: $keyName.<br>";
            }

            // Step 1: Discard the empty tablespace
            $pdo->exec("ALTER TABLE `$table` DISCARD TABLESPACE;");
            echo "- Discarded empty tablespace.<br>";

            // Step 2: Copy the backup .ibd file into the live folder
            if (copy($backupPath, $livePath)) {
                echo "- Copied backup data file into live folder.<br>";
            } else {
                throw new Exception("Failed to copy $backupPath to $livePath");
            }

            // Step 3: Import the populated tablespace
            $pdo->exec("ALTER TABLE `$table` IMPORT TABLESPACE;");
            echo "- Imported tablespace.<br>";

            // Step 4: Recreate the secondary indexes
            foreach ($droppedIndexes as $keyName => $data) {
                $cols = implode(', ', $data['columns']);
                // Force all reconstructed indexes to be standard indexes, NOT unique,
                // to completely bypass 1062 Duplicate Entry errors pulling from old tablespaces.
                $pdo->exec("ALTER TABLE `$table` ADD INDEX `$keyName` ($cols);");
                echo "- Recreated secondary index: $keyName.<br>";
            }

            echo "<span style='color:green;'>- Successfully imported data for $table!</span><br><br>";
            $successCount++;

        } catch (Exception $e) {
            echo "<span style='color:red;'>- Error processing $table: " . $e->getMessage() . "</span><br><br>";
            $errorCount++;

            // If the import failed, try to discard again just to ensure the table isn't permanently locked
            try {
                $pdo->exec("ALTER TABLE `$table` DISCARD TABLESPACE;");
            } catch (Exception $ex) {
            }
        }
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "<h3>Recovery Complete</h3>";
    echo "Successfully recovered data for $successCount tables.<br>";
    if ($errorCount > 0) {
        echo "<span style='color:red;'>$errorCount tables had errors during import.</span><br>";
    }

} catch (PDOException $e) {
    echo "<span style='color:red;'>Database Connection Error: " . $e->getMessage() . "</span>";
}
?>