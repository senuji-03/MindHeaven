<?php
$files = [
    'users' => 'C:/xampp/mysql/data_old/mind_heaven/users.frm',
    'forum_posts' => 'C:/xampp/mysql/data_old/mind_heaven/forum_posts.frm',
    'reports' => 'C:/xampp/mysql/data_old/mind_heaven/reports.frm'
];

foreach ($files as $name => $path) {
    if (!file_exists($path))
        continue;

    echo "<h2>Extracting SCHEMA strings from: $name</h2>";
    $binaryData = file_get_contents($path);

    // Extract strings that look like column names or ENUMs (alphanumeric with underscores)
    $pattern = '/[a-zA-Z_][a-zA-Z0-9_]{2,50}/';
    preg_match_all($pattern, $binaryData, $matches);

    $uniqueStrings = array_unique($matches[0]);
    $filteredStrings = [];

    // Filter out obvious binary noise
    foreach ($uniqueStrings as $str) {
        if (strlen($str) > 2 && $str !== 'InnoDB' && $str !== 'utf8mb4_general_ci') {
            $filteredStrings[] = $str;
        }
    }

    echo "<pre>" . implode(", ", $filteredStrings) . "</pre>";
    echo "<hr>";
}
?>