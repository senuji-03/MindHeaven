<!-- app/views/UniversityRepresentative/_sidebar.php -->
<?php $activePage = $activePage ?? ''; ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h2>🧠 Mind Haven</h2>
        <p>University Representative</p>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item <?= $activePage === 'events' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i> Manage Events
        </a>
        <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item <?= $activePage === 'university-profile' ? 'active' : '' ?>">
            <i class="fas fa-university"></i> University Profile
        </a>
        <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item <?= $activePage === 'profile' ? 'active' : '' ?>">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
    </nav>
</aside>
