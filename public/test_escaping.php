<?php
$resource = [
    'id' => 21,
    'title' => 'yyyy',
    'content' => "This is a test\nwith newlines\nand \"quotes\"",
    'content_type' => 'article',
    'file_path' => 'uploads/resources/test.jpg',
    'file_name' => 'test.jpg',
    'summary' => 'yyyy',
    'created_at' => '2026-03-28 15:00:00'
];
$json = json_encode($resource);
$html = htmlspecialchars($json);
echo "HTML Attribute Value:\n" . $html . "\n\n";
echo "Decoded JS String:\n" . htmlspecialchars_decode($html) . "\n";
