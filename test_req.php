<?php
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'undergraduate';
$_SESSION['username'] = 'Test';
require 'config/config.php';
require 'core/Database.php';
require 'core/view.php';
require 'core/Auth.php';

$_GET['category'] = 'Sleep & Wellness';
require 'app/controllers/UGControl.php';
$c = new UGControl();
ob_start();
$c->categoryResources();
$output = ob_get_clean();

if (empty($output)) {
   echo "No Output! Headers: "; print_r(headers_list());
} else {
   echo "Output Length: " . strlen($output);
}
