<?php
$conn = mysqli_connect('localhost', 'root', '', 'mindheaven_merged');
if (!$conn) die('Connection failed');

$res = mysqli_query($conn, 'DESCRIBE notifications');
echo "Column | Type | Null | Key | Default | Extra\n";
echo "--------------------------------------------------\n";
while ($row = mysqli_fetch_assoc($res)) {
    printf("%-12s | %-12s | %-4s | %-4s | %-7s | %s\n", 
        $row['Field'], $row['Type'], $row['Null'], $row['Key'], $row['Default'] ?? 'NULL', $row['Extra']);
}
