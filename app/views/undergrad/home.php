<?php
// index.php
$TITLE = 'MindHeaven — Dashboard';
$CURRENT_PAGE = 'dashboard';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/dashboard.css'];
$PAGE_JS  = ['/MindHeaven/public/js/undergrad/dashboard.js'];

require BASE_PATH.'/app/views/layouts/header.php'; // requires header, nav, and CSS/JS
require BASE_PATH.'/app/views/layouts/undergrad/dashboard.php';    // requires main dashboard content
require BASE_PATH.'/app/views/layouts/footer.php'; // requires footer and JS
?>
