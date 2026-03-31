<?php
/**
 * TEMPORARY DEBUG FILE — DELETE AFTER DEBUGGING
 * Access at: http://localhost:8080/MindHeaven/public/debug_upload.php
 */
require_once __DIR__ . '/../config/config.php';

echo '<h2>Upload Debug Info</h2><pre>';

// 1. PHP Upload settings
echo "=== PHP Upload Settings ===\n";
echo "file_uploads: "        . ini_get('file_uploads')        . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: "       . ini_get('post_max_size')       . "\n";
echo "upload_tmp_dir: "      . ini_get('upload_tmp_dir')      . "\n\n";

// 2. Directory info
$dirs = [
    BASE_PATH . '/public/uploads/',
    BASE_PATH . '/public/uploads/resources/',
    BASE_PATH . '/public/uploads/images/',
    BASE_PATH . '/public/uploads/videos/',
    BASE_PATH . '/public/uploads/audio/',
];
echo "=== Upload Directories ===\n";
foreach ($dirs as $d) {
    $exists   = is_dir($d)     ? 'EXISTS'      : 'MISSING';
    $writable = is_writable($d) ? 'writable'   : 'NOT WRITABLE';
    echo "$exists  $writable  $d\n";
}
echo "\n";

// 3. If a test file was posted, show $_FILES
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "=== \$_FILES Dump ===\n";
    var_dump($_FILES);
    echo "\n=== \$_POST Keys ===\n";
    var_dump(array_keys($_POST));

    // Try to move the test file
    if (!empty($_FILES['test_file']) && $_FILES['test_file']['error'] === 0) {
        $dest = BASE_PATH . '/public/uploads/resources/TEST_' . basename($_FILES['test_file']['name']);
        $ok   = move_uploaded_file($_FILES['test_file']['tmp_name'], $dest);
        echo "\nmove_uploaded_file result: " . ($ok ? "SUCCESS → $dest" : "FAILED") . "\n";
        if ($ok) {
            echo "View at: " . BASE_URL . "/uploads/resources/TEST_" . basename($_FILES['test_file']['name']) . "\n";
        }
    } else if (!empty($_FILES['test_file'])) {
        $codes = [
            1 => 'UPLOAD_ERR_INI_SIZE – file exceeds upload_max_filesize',
            2 => 'UPLOAD_ERR_FORM_SIZE',
            3 => 'UPLOAD_ERR_PARTIAL',
            4 => 'UPLOAD_ERR_NO_FILE – no file selected',
            6 => 'UPLOAD_ERR_NO_TMP_DIR',
            7 => 'UPLOAD_ERR_CANT_WRITE',
        ];
        $code = $_FILES['test_file']['error'];
        echo "Upload error code $code: " . ($codes[$code] ?? 'unknown') . "\n";
    }
}
echo '</pre>';
?>

<h3>Test Upload Form</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file"><br><br>
    <button type="submit">Upload Test File</button>
</form>
