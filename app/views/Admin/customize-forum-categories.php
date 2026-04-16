<!DOCTYPE html>
<html lang="en">
<?php
$currentMode = $mode ?? 'forum';
$pageTitle = $currentMode === 'resource' ? 'Manage Resource Hub Categories' : ($currentMode === 'report' ? 'Manage Report Categories' : 'Manage Forum Thread Categories');
$actionBase = $currentMode === 'resource' ? '/resource-categories' : ($currentMode === 'report' ? '/admin/report-categories' : '/admin/forum-categories');
?>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --bg-soft:#F5F0E8; --bg-mid:#EEF6F2;
            --text-primary:#1E3A34; --text-secondary:#6B8C7E;
            --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px; --radius-lg:20px; --radius-full:9999px;
            --shadow-sm:0 1px 3px rgba(30,58,52,.06);
        }
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; background:var(--bg-soft); }

        /* DS Sidebar */
        .sidebar {
            width:280px; height:100vh; background:var(--bg-deep);
            position:fixed; left:0; top:0;
            display:flex; flex-direction:column; z-index:1000;
        }
        .sidebar-header { padding:36px 28px 28px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-header h2 { font-size:1.4rem; font-weight:700; color:var(--primary-light); margin-bottom:6px; }
        .sidebar-header p  { font-size:.75rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-nav { flex:1; padding:24px 16px; overflow-y:auto; }
        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:rgba(255,255,255,.65);
            text-decoration:none; border-radius:var(--radius-sm);
            margin-bottom:4px; font-weight:500; font-size:.95rem;
            transition:all .25s ease;
        }
        .nav-item i { width:20px; text-align:center; font-size:1rem; }
        .nav-item:hover { background:rgba(255,255,255,.07); color:white; transform:translateX(3px); }
        .nav-item.active { background:var(--primary); color:white; box-shadow:0 4px 12px rgba(61,139,110,.3); }
        .sidebar-footer { padding:20px 16px; border-top:1px solid rgba(255,255,255,.08); }
        .logout-btn {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:#FFB3B3;
            text-decoration:none; border-radius:var(--radius-sm);
            font-weight:600; font-size:.9rem; transition:all .25s;
        }
        .logout-btn:hover { background:rgba(214,79,79,.1); }

        <?php include '_forum_styles.php'; ?>
    </style>
</head>

<body>
    <!-- Sidebar (Design System) -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item"><i class="fas fa-users"></i> Manage Users</a>
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active"><i class="fas fa-comments"></i> Moderate Forum</a>
                <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item"><i class="fas fa-calendar-check"></i> Appointments</a>
                <a href="<?= BASE_URL ?>/admin/reports" class="nav-item"><i class="fas fa-chart-bar"></i> System Reports</a>
                <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item"><i class="fas fa-university"></i> University Events</a>
                <a href="<?= BASE_URL ?>/admin/donations" class="nav-item"><i class="fas fa-hand-holding-usd"></i> Donation Logs</a>
                <a href="<?= BASE_URL ?>/EditPosts" class="nav-item"><i class="fas fa-edit"></i> Edit Resources</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/AddResource" class="nav-item"><i class="fas fa-plus-circle"></i> Add Resource</a>
                <a href="<?= BASE_URL ?>/EditPosts" class="nav-item active"><i class="fas fa-edit"></i> Edit Resources</a>
                <a href="<?= BASE_URL ?>/Moderator/reported-resources" class="nav-item"><i class="fas fa-exclamation-triangle"></i> Reported Resources</a>
                <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item"><i class="fas fa-user-slash"></i> Flagged Users</a>
                <a href="<?= BASE_URL ?>/WarnForm" class="nav-item"><i class="fas fa-exclamation-circle"></i> Warn Users</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1><?= $pageTitle ?></h1>
            <div class="topbar-right">
                <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
                    <div class="admin-profile" style="cursor: pointer;">
                        <span>Admin User</span>
                        <div class="avatar">A</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="content-wrapper">
            <?php 
            $activeTab = ($currentMode === 'report') ? 'report-categories' : 'forum-categories';
            $rightContent = '<button class="btn" onclick="openModal(\'addCategoryModal\')">+ Add Category</button>';
            include '_forum_tabs.php'; 
            ?>

            <!-- Categories List -->
            <section class="list">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" style="padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 8px; margin-bottom: 20px;">
                        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" style="padding: 15px; background: #ffebee; color: #c62828; border-radius: 8px; margin-bottom: 20px;">
                        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <div id="categoriesList">
                    <?php if (empty($categories)): ?>
                        <p>No categories found.</p>
                    <?php else: ?>
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <?php if($currentMode === 'resource'): ?>
                                    <th style="width: 80px;">Image</th>
                                    <?php endif; ?>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <?php if($currentMode === 'resource'): ?>
                                        <td>
                                            <?php if(!empty($category['thumbnail'])): ?>
                                                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($category['thumbnail']) ?>" 
                                                     style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                        <td style="font-weight: 600;">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </td>
                                        <td style="color: #64748b; font-size: 0.9rem;">
                                            <?= htmlspecialchars($category['description']) ?>
                                        </td>
                                        <td>
                                            <?php if ($category['is_active']): ?>
                                                <span class="badge status-active" style="background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem;">Active</span>
                                            <?php else: ?>
                                                <span class="badge status-inactive" style="background: #f1f5f9; color: #64748b; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem;">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn-icon btn-edit" title="Edit"
                                                onclick="editCategory(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['name'])) ?>', '<?= htmlspecialchars(addslashes($category['description'])) ?>')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($category['is_active']): ?>
                                                <button class="btn-icon btn-delete" title="Deactivate"
                                                    onclick="deleteCategory(<?= $category['id'] ?>)">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn-icon btn-activate" title="Reactivate"
                                                    onclick="activateCategory(<?= $category['id'] ?>)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Add New Category</h3>
                <button class="close-btn" onclick="closeModal('addCategoryModal')">&times;</button>
            </div>
            <form action="<?= BASE_URL ?><?= $actionBase ?>/create" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category Name</label>
                    <input type="text" name="name" class="form-input" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                    <textarea name="description" class="form-input" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; min-height: 80px;"></textarea>
                </div>
                <?php if($currentMode === 'resource'): ?>
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 10px; border: 1px dashed #d1d5db; border-radius: 8px;">
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Recommended: Square image, max 2MB.</p>
                </div>
                <?php endif; ?>
                <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn secondary" onclick="closeModal('addCategoryModal')" style="background: #f1f5f9; color: #64748b;">Cancel</button>
                    <button type="submit" class="btn" style="background: #3D8B6E; color: white;">Create Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editCategoryModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Edit Category</h3>
                <button class="close-btn" onclick="closeModal('editCategoryModal')">&times;</button>
            </div>
            <form action="<?= BASE_URL ?><?= $actionBase ?>/update" method="POST" enctype="multipart/form-data" style="padding: 20px;">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category Name</label>
                    <input type="text" name="name" id="edit_name" class="form-input" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                    <textarea name="description" id="edit_description" class="form-input" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; min-height: 80px;"></textarea>
                </div>
                <?php if($currentMode === 'resource'): ?>
                <div class="form-row" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Replace Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" style="width: 100%; padding: 10px; border: 1px dashed #d1d5db; border-radius: 8px;">
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Leave blank to keep the current image.</p>
                </div>
                <?php endif; ?>
                <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn secondary" onclick="closeModal('editCategoryModal')" style="background: #f1f5f9; color: #64748b;">Cancel</button>
                    <button type="submit" class="btn" style="background: #3D8B6E; color: white;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Action Forms -->
    <form id="deleteForm" action="<?= BASE_URL ?><?= $actionBase ?>/delete" method="POST" style="display:none;"><input type="hidden" name="id" id="delete_id"></form>
    <form id="activateForm" action="<?= BASE_URL ?><?= $actionBase ?>/activate" method="POST" style="display:none;"><input type="hidden" name="id" id="activate_id"></form>

    <style>
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: white; border-radius: 12px; width: 90%; }
        .modal-header { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .close-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b; }
        .btn-icon { background: none; border: none; padding: 8px; cursor: pointer; font-size: 1rem; color: #3D8B6E; transition: opacity 0.2s; }
        .btn-icon:hover { opacity: 0.7; }
        .btn-delete { color: #dc2626; }
    </style>

    <script>
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        function editCategory(id, name, description) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            openModal('editCategoryModal');
        }
        function deleteCategory(id) { if (confirm('Deactivate this category? It will no longer appear in the Resource Hub.')) { document.getElementById('delete_id').value = id; document.getElementById('deleteForm').submit(); } }
        function activateCategory(id) { document.getElementById('activate_id').value = id; document.getElementById('activateForm').submit(); }
    </script>
</body>
</html>
