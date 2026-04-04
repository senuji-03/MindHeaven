<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Forum Thread Categories - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- ... existing sidebar content ... -->
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>

        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <!-- ... other nav items ... -->
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <span class="icon">📚</span>
                Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <!-- ... -->
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- ... topbar ... -->
        <div class="topbar">
            <h1>Manage Forum Thread Categories</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <!-- ... toolbar ... -->
            <div class="toolbar">
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="btn secondary">
                    &larr; Back to Moderation
                </a>
                <button class="btn" onclick="var f=document.getElementById('addCatInline'); f.style.display=f.style.display==='none'?'flex':'none';">+ Add Category</button>
            </div>

            <!-- Inline Add Category Form -->
            <form id="addCatInline" action="<?= BASE_URL ?>/admin/forum-categories/create" method="POST"
              style="display:none; align-items:center; gap:8px; padding:10px 0; border-bottom:1px solid #e5e7eb; margin-bottom:12px;">
              <input type="text" name="name" placeholder="Category name" required
                style="padding:6px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:0.9rem; min-width:220px;">
              <input type="text" name="description" placeholder="Description (optional)"
                style="padding:6px 10px; border:1px solid #d1d5db; border-radius:6px; font-size:0.9rem; min-width:200px;">
              <button type="submit" class="btn">Save</button>
              <button type="button" class="btn secondary"
                onclick="document.getElementById('addCatInline').style.display='none'">Cancel</button>
            </form>

            <!-- Categories List -->
            <section class="list">
                <!-- ... messages ... -->
                <h2>Existing Categories</h2>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <div id="categoriesList">
                    <?php if (empty($categories)): ?>
                        <p>No categories found.</p>
                    <?php else: ?>
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($category['description']) ?>
                                        </td>
                                        <td>
                                            <?php if ($category['is_active']): ?>
                                                <span class="badge status-active">Active</span>
                                            <?php else: ?>
                                                <span class="badge status-inactive">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn-icon btn-edit" title="Edit"
                                                onclick="editCategory(<?= $category['id'] ?>, '<?= htmlspecialchars(addslashes($category['name'])) ?>', '<?= htmlspecialchars(addslashes($category['description'])) ?>')">
                                                ✏️
                                            </button>
                                            <?php if ($category['is_active']): ?>
                                                <button class="btn-icon btn-delete" title="Deactivate"
                                                    onclick="deleteCategory(<?= $category['id'] ?>)">
                                                    🗑️
                                                </button>
                                            <?php else: ?>
                                                <button class="btn-icon btn-activate" title="Reactivate"
                                                    onclick="activateCategory(<?= $category['id'] ?>)">
                                                    ✅
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

    <!-- ... Modals ... -->

    <!-- Add Modal -->
    <div id="addCategoryModal" class="modal">
        <!-- ... -->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Category</h3>
                <button class="close-btn" onclick="closeModal('addCategoryModal')">&times;</button>
            </div>
            <form action="<?= BASE_URL ?>/admin/forum-categories/create" method="POST">
                <div class="form-row">
                    <label for="add_name">Name</label>
                    <input type="text" name="name" id="add_name" class="form-input" required autocomplete="off">
                </div>
                <div class="form-row">
                    <label for="add_description">Description (Optional)</label>
                    <input type="text" name="description" id="add_description" class="form-input" autocomplete="off">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn secondary" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="btn">Create Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editCategoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Category</h3>
                <button class="close-btn" onclick="closeModal('editCategoryModal')">&times;</button>
            </div>
            <form action="<?= BASE_URL ?>/admin/forum-categories/update" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-row">
                    <label for="edit_name">Name</label>
                    <input type="text" name="name" id="edit_name" class="form-input" required autocomplete="off">
                </div>
                <div class="form-row">
                    <label for="edit_description">Description (Optional)</label>
                    <input type="text" name="description" id="edit_description" class="form-input" autocomplete="off">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn secondary"
                        onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="btn">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" action="<?= BASE_URL ?>/admin/forum-categories/delete" method="POST" style="display:none;">
        <input type="hidden" name="id" id="delete_id">
    </form>

    <!-- Activate Form (Hidden) -->
    <form id="activateForm" action="<?= BASE_URL ?>/admin/forum-categories/activate" method="POST"
        style="display:none;">
        <input type="hidden" name="id" id="activate_id">
    </form>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function editCategory(id, name, description) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            openModal('editCategoryModal');
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to deactivate this category?')) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }

        function activateCategory(id) {
            if (confirm('Are you sure you want to reactivate this category?')) {
                document.getElementById('activate_id').value = id;
                document.getElementById('activateForm').submit();
            }
        }
    </script>
</body>

</html>

