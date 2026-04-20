<!-- app/views/UniversityRepresentative/_topbar.php -->
<?php 
$topbarTitle = $topbarTitle ?? 'Dashboard'; 
$universityName = $_SESSION['university_name'] ?? 'University';
?>
<div class="topbar">
    <h1><?= htmlspecialchars($topbarTitle) ?></h1>
    <div class="topbar-right" style="display: flex; align-items: center; gap: 20px;">
        <div class="user-profile">
            <span><?= htmlspecialchars($universityName) ?></span>
            <div class="avatar"><?= strtoupper(substr($universityName, 0, 1)) ?></div>
        </div>
        <a href="<?= BASE_URL ?>/logout" class="btn-logout" title="Logout" style="color: var(--crisis); text-decoration: none; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: var(--radius-sm); transition: all 0.2s;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<style>
    .btn-logout:hover {
        background: rgba(214, 79, 79, 0.1);
        transform: translateY(-1px);
    }
</style>
