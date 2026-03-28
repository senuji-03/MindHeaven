<?php
try {
    echo "(1/4) Connecting to MySQL server...<br>";
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "(1.5/4) Clearing database cleanly via SQL...<br>";
    $pdo->exec("DROP DATABASE IF EXISTS `mind_heaven`;");

    echo "(2/4) Creating 'mind_heaven' database...<br>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `mind_heaven` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $pdo->exec("USE `mind_heaven`;");

    echo "(3/4) Loading SQL schema files...<br>";
    $sqlFiles = [
        __DIR__ . "/database/mindheaven_complete_schema.sql",       // The core original structure
        __DIR__ . "/database/undergraduate_students.sql",           // Table
        __DIR__ . "/database/create_university_representatives_table.sql", // Table
        __DIR__ . "/database/resource_hub_table.sql",               // Table
        __DIR__ . "/database/events_table.sql",                     // Table
        __DIR__ . "/database/create_university_rep_events_table.sql", // Table
        __DIR__ . "/database/create_feedback_table.sql",            // Table
        __DIR__ . "/database/create_habits_table.sql",              // Table
        __DIR__ . "/database/password_reset_tokens.sql",            // Table
        __DIR__ . "/database/create_forum_tables.sql"               // The new forum tables
    ];

    echo "(4/4) Executing schema statements:<br>";
    foreach ($sqlFiles as $file) {
        if (file_exists($file)) {
            echo "- Running: " . basename($file) . "... ";
            $sql = file_get_contents($file);
            // Wait, we cannot split blindly by ';' because of triggers and procedures.
            // A better way is using the command line mysql directly.
            $cmd = 'C:\xampp\mysql\bin\mysql.exe -u root mind_heaven < "' . $file . '" 2>&1';
            $output = []; // Clear previous output
            exec($cmd, $output, $returnVar);

            if ($returnVar === 0) {
                echo "<span style='color:green;'>Success</span><br>";
            } else {
                echo "<span style='color:red;'>Failed: " . implode(" ", $output) . "</span><br>";
            }
        } else {
            echo "<span style='color:red;'>ERROR: File not found: " . basename($file) . "</span><br>";
        }
    }

    echo "<br><b><span style='color:green; font-size:20px'>DATABASE REBUILT SUCCESSFULLY!</span></b><br>";
    echo "You are now ready to begin the DISCARD and IMPORT process for your .ibd files in phpMyAdmin.";

} catch (PDOException $e) {
    echo "<br><b><span style='color:red;'>FATAL ERROR:</span></b> " . $e->getMessage();
}
?>