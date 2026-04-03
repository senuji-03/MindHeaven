<?php
$_SERVER["REQUEST_METHOD"] = "POST";
$_SESSION["user_id"] = 1;
$_GET["action"] = "create";
// Fake input by writing json to a temp file and overriding php://input is hard.
// Instead, let's just configure HabitApiControl to read from a variable if we set it.
require "c:/xampp/htdocs/MindHeaven/app/controllers/HabitApiControl.php";
