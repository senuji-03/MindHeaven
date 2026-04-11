<?php
$current_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
?>
<div class="sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item <?php echo (strpos($current_url, '/counselor/dashboard') !== false || rtrim($current_url, '/') == BASE_URL . '/counselor') ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/dashboard" <?php echo (strpos($current_url, '/counselor/dashboard') !== false || rtrim($current_url, '/') == BASE_URL . '/counselor') ? 'style="color: #2563eb;"' : ''; ?>>📊 Dashboard</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/calender') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/calender" <?php echo strpos($current_url, '/counselor/calender') !== false ? 'style="color: #2563eb;"' : ''; ?>>📅 Calendar</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/appointmentmgt') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/appointmentmgt" <?php echo strpos($current_url, '/counselor/appointmentmgt') !== false ? 'style="color: #2563eb;"' : ''; ?>>🗓️ Appointment Management</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/timeslots') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/timeslots" <?php echo strpos($current_url, '/counselor/timeslots') !== false ? 'style="color: #2563eb;"' : ''; ?>>⏰ Timeslots</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/sessionHistory') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/sessionHistory" <?php echo strpos($current_url, '/counselor/sessionHistory') !== false ? 'style="color: #2563eb;"' : ''; ?>>📋 Session History</a>
        </li>
        <li class="sidebar-item <?php echo (strpos($current_url, '/chat') !== false && strpos($current_url, '/counselor') === false) ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/chat" <?php echo (strpos($current_url, '/chat') !== false && strpos($current_url, '/counselor') === false) ? 'style="color: #2563eb;"' : ''; ?>>💬 Chat</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/forum') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/forum" <?php echo strpos($current_url, '/counselor/forum') !== false ? 'style="color: #2563eb;"' : ''; ?>>💭 Forum</a>
        </li>
        <li class="sidebar-item <?php echo (strpos($current_url, '/counselor/Cresource_hub') !== false || strpos($current_url, '/counselor/resources') !== false)  ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/Cresource_hub" <?php echo (strpos($current_url, '/counselor/Cresource_hub') !== false || strpos($current_url, '/counselor/resources') !== false) ? 'style="color: #2563eb;"' : ''; ?>>📚 Resource Hub</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/EditPosts') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/EditPosts" <?php echo strpos($current_url, '/EditPosts') !== false ? 'style="color: #2563eb;"' : ''; ?>>✏️ Edit Resources</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/resource-categories') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/resource-categories" <?php echo strpos($current_url, '/resource-categories') !== false ? 'style="color: #2563eb;"' : ''; ?>>⚙️ Resource Categories</a>
        </li>
        <li class="sidebar-item">
            <a href="<?php echo BASE_URL; ?>/donation">💰 Donate</a>
        </li>
        <li class="sidebar-item <?php echo strpos($current_url, '/counselor/counselor_profile') !== false ? 'active' : ''; ?>">
            <a href="<?php echo BASE_URL; ?>/counselor/counselor_profile" <?php echo strpos($current_url, '/counselor/counselor_profile') !== false ? 'style="color: #2563eb;"' : ''; ?>>👤 Profile</a>
        </li>
        <li class="sidebar-item logout-item">
            <a href="<?php echo BASE_URL; ?>/logout" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a>
        </li>
    </ul>
</div>
