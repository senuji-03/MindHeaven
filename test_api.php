<?php
if (!defined("BASE_PATH")) define("BASE_PATH", "c:/xampp/htdocs/MindHeaven");
require "c:/xampp/htdocs/MindHeaven/app/models/Habit.php";
$model = new Habit();
try {
    $id = $model->create(1, "Test", "Test", "other", "daily", 1, "#000", "ico");
    echo "SUCCESS: " . $id;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
