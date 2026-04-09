<?php

function refactorFile($file) {
    echo "Refactoring $file...\n";
    $content = file_get_contents($file);

    // 1. Replace ?? with isset() ? ... : ...
    // This is hard with regex, so we'll do common cases.
    $content = preg_replace(
        '/\$(\w+)\s*\?\?\s*([^;,\)\s]+)/', 
        'isset($$1) ? $$1 : $2', 
        $content
    );
    // Specific case for $_SESSION['user_id'] ?? 0
    $content = str_replace("\$_SESSION['user_id'] ?? 0", "isset(\$_SESSION['user_id']) ? \$_SESSION['user_id'] : 0", $content);
    $content = str_replace("\$_SESSION['role'] ?? ''", "isset(\$_SESSION['role']) ? \$_SESSION['role'] : ''", $content);

    // 2. Replace [] with array()
    // This is the most complex one. We'll try to find array literals.
    // We already did some, but lets be more thorough.
    
    // 3. Replace Throwable with Exception
    $content = str_replace("Throwable", "Exception", $content);

    // 4. Replace float/int type hints in function params (if any)
    // $content = preg_replace('/\(int\)\s*\$/', '$', $content); // wait, (int) casting is fine.
    
    file_put_contents($file, $content);
}

$files = array(
    'app/models/Appointment.php',
    'app/models/Timeslot.php',
    'app/controllers/AppointmentApiControl.php'
);

foreach ($files as $f) {
    if (file_exists($f)) {
        refactorFile($f);
    }
}
echo "Refactor complete.\n";
