<!-- Shared Admin Topbar Partial -->
<div class="topbar">
    <h1><?= $topbarTitle ?? 'Admin Dashboard' ?></h1>
    <div class="topbar-right">
        <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
            <div class="admin-profile" style="cursor: pointer;">
                <span>Admin User</span>
                <div class="avatar">A</div>
            </div>
        </a>
        <a href="<?= BASE_URL ?>/logout" class="logout-topbar-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="logout-text">Logout</span>
        </a>
    </div>
</div>

<style>
    .logout-topbar-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(214, 79, 79, 0.1);
        color: var(--crisis, #D64F4F);
        text-decoration: none;
        border-radius: var(--radius-sm, 8px);
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s;
        border: 1px solid rgba(214, 79, 79, 0.2);
    }

    .logout-topbar-btn:hover {
        background: var(--crisis, #D64F4F);
        color: white;
        box-shadow: 0 4px 12px rgba(214, 79, 79, 0.2);
    }

    @media (max-width: 600px) {
        .logout-text {
            display: none;
        }
        .logout-topbar-btn {
            padding: 8px;
        }
    }
</style>
