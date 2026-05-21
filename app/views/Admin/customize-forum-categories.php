<?php
/**
 * Shared view for managing Categories:
 * - Forum Thread Categories (mode = forum)
 * - Report Categories (mode = report)
 * - Resource Hub Categories (mode = resource)
 */
$currentMode = $mode ?? 'forum';
$pageTitle = $currentMode === 'resource' ? 'Manage Resource Hub Categories' : ($currentMode === 'report' ? 'Manage Report Categories' : 'Manage Forum Thread Categories');
$actionBase = $currentMode === 'resource' ? '/resource-categories' : ($currentMode === 'report' ? '/admin/report-categories' : '/admin/forum-categories');

$TITLE = 'MindHeaven — ' . $pageTitle;
// Mapping current mode to navigation slug for highlighting
$CURRENT_PAGE = $currentMode === 'resource' ? 'resource-hub' : 'moderate-forum';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $TITLE ?></title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <?php 
    $activePage = $CURRENT_PAGE;
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = $pageTitle;
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">

<style>
    <?php include '_forum_styles.php'; ?>

    /* ── Category Management Styles ── */
    .category-page-wrapper { padding: 28px 32px; }

    /* List / Table Styles */
    .list {
        background: var(--surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .users-table { width: 100%; border-collapse: collapse; }
    .users-table th { 
        background: var(--bg-mid); 
        padding: 1.25rem 1.5rem; 
        text-align: left; 
        font-weight: 700; 
        color: var(--text-primary); 
        border-bottom: 1px solid var(--border);
        font-size: 0.9rem;
    }
    .users-table td { 
        padding: 1.25rem 1.5rem; 
        border-bottom: 1px solid var(--border); 
        vertical-align: middle;
        color: var(--text-primary);
    }
    .users-table tr:last-child td { border-bottom: none; }
    .users-table tr:hover { background: var(--bg-soft); }

    .category-icon-box {
        width: 48px; height: 48px;
        border-radius: var(--radius-sm);
        background: var(--bg-mid);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border: 1px solid var(--border);
    }
    .category-icon-box img { width: 100%; height: 100%; object-fit: cover; }
    .category-icon-box i { color: var(--text-secondary); font-size: 1.2rem; }

    /* Badge & Action Styles */
    .badge { padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.8rem; font-weight: 600; }
    .status-active { background: rgba(76,175,130,0.12); color: var(--success); }
    .status-inactive { background: var(--bg-soft); color: var(--text-secondary); }

    /* Action buttons */
    .btn {
        padding: 8px 16px; border: none; border-radius: var(--radius-full);
        cursor: pointer; font-weight: 600; font-size: 0.85rem;
        transition: all 0.25s ease; display: inline-flex; align-items: center; gap: 6px;
        text-decoration: none;
    }
    .btn-icon {
        background: none; border: none; padding: 8px; cursor: pointer;
        font-size: 1.1rem; color: var(--primary); transition: all 0.2s ease;
    }
    .btn-icon:hover { transform: scale(1.1); color: var(--primary-dark); }
    .btn-delete { color: var(--crisis); }
    .btn-delete:hover { color: #b91c1c; }

    /* Modal Styles */
    .modal {
        display: none; position: fixed; top: 0; left: 0;
        width: 100%; height: 100%; background: rgba(30,58,52,0.45);
        z-index: 2000; align-items: center; justify-content: center;
    }
    .modal.active { display: flex; }
    .modal-content {
        background: var(--surface); border-radius: var(--radius-lg);
        padding: 0; width: 95%; max-width: 520px;
        box-shadow: var(--shadow-lg); overflow: hidden;
    }
    .modal-header {
        padding: 1.25rem 1.5rem; background: var(--bg-mid);
        border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-header h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
    .close-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-secondary); }
    .close-btn:hover { color: var(--crisis); }

    .form-row { margin-bottom: 1.25rem; }
    .form-row label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; }
    .form-input {
        width: 100%; padding: 10px 14px; border: 1.5px solid var(--border);
        border-radius: var(--radius-sm); font-size: 0.9rem; color: var(--text-primary);
        background: var(--surface); font-family: inherit;
    }
    .form-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(61,139,110,0.12); }

    /* Alert banners */
    .alert { padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.9rem; }
    .alert-success { background: rgba(76,175,130,0.12); border-left: 4px solid var(--success); color: var(--success); }
    .alert-danger  { background: rgba(214,79,79,0.1);  border-left: 4px solid var(--crisis);  color: var(--crisis);  }
</style>

<div class="category-page-wrapper">

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; ?> <?php unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; ?> <?php unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="toolbar">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0;"><?= $pageTitle ?></h2>
        <div class="actions">
            <button class="btn" style="background: var(--primary); color: white;" onclick="openModal('addCategoryModal')">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
    </div>

    <?php 
    // Show tabs only for Forum and Report moderation context
    if ($currentMode !== 'resource') {
        $activeTab = ($currentMode === 'report') ? 'report-categories' : 'forum-categories';
        include '_forum_tabs.php'; 
    }
    ?>

    <section class="list">
        <table class="users-table">
            <thead>
                <tr>
                    <?php if($currentMode === 'resource'): ?>
                    <th style="width: 80px;">Icon</th>
                    <?php endif; ?>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="<?= ($currentMode === 'resource' ? 5 : 4) ?>" style="text-align:center; padding:3rem; color:var(--text-secondary);">No categories found.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <?php if($currentMode === 'resource'): ?>
                            <td>
                                <div class="category-icon-box">
                                    <?php if(!empty($category['thumbnail'])): ?>
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($category['thumbnail']) ?>" alt="">
                                    <?php else: ?>
                                        <i class="fas fa-image"></i>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php endif; ?>
                            <td style="font-weight: 700;"><?= htmlspecialchars($category['name']) ?></td>
                            <td style="color: var(--text-secondary); font-size: 0.9rem; max-width: 400px; line-height: 1.5;">
                                <?= htmlspecialchars($category['description']) ?>
                            </td>
                            <td>
                                <?php if ($category['is_active']): ?>
                                    <span class="badge status-active">Active</span>
                                <?php else: ?>
                                    <span class="badge status-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <button class="btn-icon" title="Edit"
                                    onclick="editCategory(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['name'])) ?>', '<?= htmlspecialchars(addslashes($category['description'])) ?>')">
                                    <i class="fas fa-pen-to-square"></i>
                                </button>
                                <?php if ($category['is_active']): ?>
                                    <button class="btn-icon btn-delete" title="Deactivate" onclick="deleteCategory(<?= $category['id'] ?>)">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn-icon" style="color:var(--text-secondary);" title="Reactivate" onclick="activateCategory(<?= $category['id'] ?>)">
                                        <i class="fas fa-toggle-off"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>

<!-- Add Modal -->
<div id="addCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>✨ Add New Category</h3>
            <button class="close-btn" onclick="closeModal('addCategoryModal')">&times;</button>
        </div>
        <form action="<?= BASE_URL ?><?= $actionBase ?>/create" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
            <div class="form-row">
                <label>Category Name</label>
                <input type="text" name="name" class="form-input" required placeholder="e.g. Mental Wellness">
            </div>
            <div class="form-row">
                <label>Description</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Briefly describe what belongs in this category..."></textarea>
            </div>
            <?php if($currentMode === 'resource'): ?>
                <div class="form-row">
                    <label>Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" style="padding: 8px;">
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Square ratio recommended. Max 2MB.</p>
                </div>
            <?php endif; ?>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                <button type="button" class="btn" style="background:var(--bg-mid); color:var(--text-secondary);" onclick="closeModal('addCategoryModal')">Cancel</button>
                <button type="submit" class="btn" style="background:var(--primary); color:white;">Create Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editCategoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>✏️ Edit Category</h3>
            <button class="close-btn" onclick="closeModal('editCategoryModal')">&times;</button>
        </div>
        <form action="<?= BASE_URL ?><?= $actionBase ?>/update" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-row">
                <label>Category Name</label>
                <input type="text" name="name" id="edit_name" class="form-input" required>
            </div>
            <div class="form-row">
                <label>Description</label>
                <textarea name="description" id="edit_description" class="form-input" rows="3"></textarea>
            </div>
            <?php if($currentMode === 'resource'): ?>
                <div class="form-row">
                    <label>Replace Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" style="padding: 8px;">
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Leave blank to keep the current image.</p>
                </div>
            <?php endif; ?>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                <button type="button" class="btn" style="background:var(--bg-mid); color:var(--text-secondary);" onclick="closeModal('editCategoryModal')">Cancel</button>
                <button type="submit" class="btn" style="background:var(--primary); color:white;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Action Forms -->
<form id="deleteForm" action="<?= BASE_URL ?><?= $actionBase ?>/delete" method="POST" style="display:none;"><input type="hidden" name="id" id="delete_id"></form>
<form id="activateForm" action="<?= BASE_URL ?><?= $actionBase ?>/activate" method="POST" style="display:none;"><input type="hidden" name="id" id="activate_id"></form>

<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    
    function editCategory(id, name, description) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        openModal('editCategoryModal');
    }

    function deleteCategory(id) { 
        if (confirm('Deactivate this category? It will no longer appear in selection menus.')) { 
            document.getElementById('delete_id').value = id; 
            document.getElementById('deleteForm').submit(); 
        } 
    }

    function activateCategory(id) { 
        document.getElementById('activate_id').value = id; 
        document.getElementById('activateForm').submit(); 
    }

    // Modal click-outside to close
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
    }
</script>

        </div> <!-- End content-wrapper -->
    </div> <!-- End main-content -->

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>
