<!DOCTYPE html>
<html lang="en">
<?php
$currentMode = $mode ?? 'forum';
$pageTitle = $currentMode === 'resource' ? 'Manage Resource Hub Categories' : ($currentMode === 'report' ? 'Manage Report Categories' : 'Manage Forum Thread Categories');
$actionBase = $currentMode === 'resource' ? '/resource-categories' : ($currentMode === 'report' ? '/admin/report-categories' : '/admin/forum-categories');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                System Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon">💰</span>
                Donation Logs
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
        </nav>
        <?php else: ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/AddResource" class="nav-item">
                <span class="icon">➕</span>
                Add Resource
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item active">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/Moderator/reported-resources" class="nav-item">
                <span class="icon">🚨</span>
                Reported Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <span class="icon">🚩</span>
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <span class="icon">⚠️</span>
                Warn Users
            </a>
        </nav>
        <?php endif; ?>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

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
            <div class="toolbar">
                <div class="tabs">
                    <a href="<?= BASE_URL ?>/admin/moderate-forum" class="tab-link" style="text-decoration:none;">Preview</a>
                    <a href="<?= BASE_URL ?>/admin/forum-categories" class="<?= $currentMode === 'forum' ? 'tab active' : 'tab-link' ?>"
                        style="text-decoration:none; margin-left:10px;">
                        Forum Categories
                    </a>
                    <a href="<?= BASE_URL ?>/resource-categories" class="<?= $currentMode === 'resource' ? 'tab active' : 'tab-link' ?>"
                        style="text-decoration:none; margin-left:10px;">
                        Resource Hub Categories
                    </a>
                </div>
                <div>
                    <button class="btn" onclick="openModal('addCategoryModal')">+ Add Category</button>
                </div>
            </div>

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
