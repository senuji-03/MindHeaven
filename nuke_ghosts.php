<?php
$dbDir = 'C:/xampp/mysql/data/mind_heaven';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0777, true);
}

$tables = [
    'users',
    'undergraduate_students',
    'counselors',
    'forum_categories',
    'forum_threads',
    'forum_posts',
    'forum_post_likes',
    'forum_moderation_log',
    'mood_records',
    'appointments',
    'counselor_availability',
    'resource_categories',
    'resources',
    'feedback',
    'crisis_calls',
    'crisis_response_log',
    'donations',
    'events',
    'event_participants',
    'event_proof_uploads',
    'universities',
    'university_representatives',
    'user_sessions',
    'system_settings',
    'report_categories',
    'reports',
    'flag_keywords',
    'system_flags',
    'password_resets',
    'habits',
    'habit_completions',
    'habit_streaks'
];

$dummyFrm = 'C:/xampp/mysql/data/mysql/user.frm';

foreach ($tables as $t) {
    copy($dummyFrm, "$dbDir/$t.frm");
}
echo "Dummy .frm files injected!\n";
?>