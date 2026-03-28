<?php
// c:\xampp\htdocs\MindHeaven\migrate_forum_view.php

$undergrad_path = 'c:\xampp\htdocs\MindHeaven\app\views\undergrad\forum.php';
$dashboard_path = 'c:\xampp\htdocs\MindHeaven\app\views\counselor\Cdashboard.php';
$target_path = 'c:\xampp\htdocs\MindHeaven\app\views\counselor\forum.php';

$forum_content = file_get_contents($undergrad_path);
$dashboard_content = file_get_contents($dashboard_path);

// Extract the dashboard header and sidebar up to "<!-- Main Content -->"
$dashboard_end_pos = strpos($dashboard_content, '<!-- Main Content -->');
if ($dashboard_end_pos === false)
    die("Could not find Main Content in dashboard.\n");
$dashboard_header = substr($dashboard_content, 0, $dashboard_end_pos);

// Make the forum item active in sidebar, removing active from dashboard
$dashboard_header = str_replace('<li class="sidebar-item active"><a href="<?php echo BASE_URL; ?>/counselor/dashboard" style="color: #2563eb;">📊 Dashboard</a></li>', '<li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/counselor/dashboard">📊 Dashboard</a></li>', $dashboard_header);

$dashboard_header = str_replace('<li class="sidebar-item"><a href="<?php echo BASE_URL; ?>/counselor/forum">💭 Forum</a></li>', '<li class="sidebar-item active"><a href="<?php echo BASE_URL; ?>/counselor/forum" style="color: #2563eb;">💭 Forum</a></li>', $dashboard_header);

// Adjust the title
$dashboard_header = str_replace('<title>Mindheaven - Counselor Dashboard</title>', '<title>Mindheaven - Counselor Forum</title>', $dashboard_header);

// Extract the undergrad forum content (everything from <main id="main"... to </script>)
$forum_start_pos = strpos($forum_content, '<main id="main"');
if ($forum_start_pos === false)
    die("Could not find <main> in undergrad forum.\n");

$forum_end_pos = strpos($forum_content, '<?php include BASE_PATH');
if ($forum_end_pos === false) {
    // maybe check for </script>
    $forum_end_pos = strrpos($forum_content, '</script>') + 9;
}
$forum_body = substr($forum_content, $forum_start_pos, $forum_end_pos - $forum_start_pos);

$final_content = $dashboard_header . "\n        <!-- Main Content -->\n        <div class=\"main-content\">\n" . $forum_body . "\n        </div>\n    </div>\n</body>\n</html>";

file_put_contents($target_path, $final_content);

echo "Successfully created $target_path\n";
