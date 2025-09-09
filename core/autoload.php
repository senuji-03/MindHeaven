<?php
spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/controllers/api/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../core/'
    ];

    $triedPaths = [];
    $foundFile = null;

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        $triedPaths[] = $file;

        if (file_exists($file)) {
            require_once $file;
            $foundFile = $file;
            break;
        }
    }

    // If no file was found
    if (!$foundFile) {
        http_response_code(500);
        echo "<h1>Autoloader Error</h1>";
        echo "<p>Class <strong>{$className}</strong> not found.</p>";
        echo "<p>Expected file name: <code>{$className}.php</code></p>";
        echo "<p>Paths checked:</p><ul>";
        foreach ($triedPaths as $path) {
            echo "<li>{$path}</li>";
        }
        echo "</ul>";
        echo "<p><strong>Tip:</strong> Make sure your file name matches the class name exactly (case-sensitive) and is in one of the above folders.</p>";
        exit;
    }

    // If file exists but class is missing
    if (!class_exists($className, false)) {
        http_response_code(500);
        echo "<h1>Class Declaration Error</h1>";
        echo "<p>File <code>{$foundFile}</code> was found, but it does not declare a class named <strong>{$className}</strong>.</p>";
        echo "<p><strong>Tip:</strong> Check that your class name matches the file name exactly, including case.</p>";
        exit;
    }
});