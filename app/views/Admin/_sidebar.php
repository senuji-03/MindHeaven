<!-- Shared Admin Sidebar Partial -->
<?php
$activePage = $activePage ?? ''; // Default to empty if not set
?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h2>🧠 Mind Haven</h2>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin" class="nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item <?= $activePage === 'manage-users' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item <?= $activePage === 'moderate-forum' ? 'active' : '' ?>">
            <i class="fas fa-comments"></i> Moderate Forum
        </a>
        <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item <?= $activePage === 'appointments' ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i> Appointments
        </a>
        <a href="<?= BASE_URL ?>/admin/reports" class="nav-item <?= $activePage === 'reports' ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i> System Reports
        </a>
        <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item <?= $activePage === 'university-events' ? 'active' : '' ?>">
            <i class="fas fa-university"></i> University Events
        </a>
        <a href="<?= BASE_URL ?>/admin/donations" class="nav-item <?= $activePage === 'donations' ? 'active' : '' ?>">
            <i class="fas fa-hand-holding-usd"></i> Donation Logs
        </a>
        <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item <?= $activePage === 'resource-hub' ? 'active' : '' ?>">
            <i class="fas fa-book"></i> Resource Hub
        </a>
        <a href="<?= BASE_URL ?>/admin/add-resource" class="nav-item <?= $activePage === 'add-resource' ? 'active' : '' ?>">
            <i class="fas fa-plus-circle"></i> Add Resource
        </a>
        <a href="<?= BASE_URL ?>/EditPosts" class="nav-item <?= $activePage === 'edit-resources' ? 'active' : '' ?>">
            <i class="fas fa-edit"></i> Edit Resources
        </a>
        <a href="<?= BASE_URL ?>/admin/settings" class="nav-item <?= $activePage === 'settings' ? 'active' : '' ?>">
            <i class="fas fa-cog"></i> Settings
        </a>
    </nav>
</aside>
