<?php
/**
 * Dedicated view for Managing Resource Hub Categories
 * Mode: resource
 */
$TITLE = 'MindHeaven — Manage Resource Hub Categories';
$CURRENT_PAGE = 'resource-hub'; 
$PAGE_CSS = [];
$actionBase = '/resource-categories';

require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
    /* ── Resource Category Management Styles ── */
    .category-page-wrapper { padding: 28px 32px; }

    /* Toolbar for title and main action */
    .toolbar {
        background: var(--surface);
        padding: 1.25rem 1.5rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        border: 1px solid var(--border);
    }

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
        <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0;">Manage Resource Hub Categories</h2>
        <div class="actions">
            <button class="btn" style="background: var(--primary); color: white;" onclick="openModal('addCategoryModal')">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>
    </div>

    <section class="list">
        <table class="users-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Icon</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="5" style="text-align:center; padding:3rem; color:var(--text-secondary);">No categories found.</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <div class="category-icon-box">
                                    <?php if(!empty($category['thumbnail'])): ?>
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($category['thumbnail']) ?>" alt="">
                                    <?php else: ?>
                                        <i class="fas fa-image"></i>
                                    <?php endif; ?>
                                </div>
                            </td>
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
            <div class="form-row">
                <label>Thumbnail Image</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input" style="padding: 8px;">
                <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Square ratio recommended. Max 2MB.</p>
            </div>
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
            <div class="form-row">
                <label>Replace Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input" style="padding: 8px;">
                <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Leave blank to keep the current image.</p>
            </div>
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

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
    }
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
