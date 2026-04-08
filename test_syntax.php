<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
try {
    require 'app/models/ResourceHub.php';
    echo "Require successful.";
} catch (Throwable $e) {
    echo "Throwable: " . $e->getMessage() . " on line " . $e->getLine();
}
