<?php
$TITLE = 'Create New Thread - MindHeaven';
$CURRENT_PAGE = 'forum';
include BASE_PATH . '/app/views/layouts/header.php';

$userRole = $_SESSION['role'] ?? 'guest';
$oldInput = $old ?? [];
?>

<main id="main" class="main-content">
    <div class="container">

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="create-thread-form" style="display: block; max-width: 800px; margin: 2rem auto;">
            <div class="form-container">
                <h3>Create New Discussion Thread</h3>
                <form id="threadForm" action="<?php echo BASE_URL; ?>/forum/create" method="POST">
                    <div class="form-group">
                        <label for="threadTitle">Thread Title <span style="color:red">*</span></label>
                        <input type="text" id="threadTitle" name="title"
                            value="<?php echo htmlspecialchars($oldInput['title'] ?? ''); ?>"
                            placeholder="Enter a descriptive title..." required>
                    </div>

                    <div class="form-group">
                        <label for="threadCategory">Category <span style="color:red">*</span></label>
                        <select id="threadCategory" name="category" required>
                            <option value="">Select a category...</option>
                            <option value="General" <?php echo (isset($oldInput['category']) && $oldInput['category'] == 'General') ? 'selected' : ''; ?>>General Discussion</option>
                            <option value="Stress" <?php echo (isset($oldInput['category']) && $oldInput['category'] == 'Stress') ? 'selected' : ''; ?>>Stress</option>
                            <option value="Academics" <?php echo (isset($oldInput['category']) && $oldInput['category'] == 'Academics') ? 'selected' : ''; ?>>Academics</option>
                            <option value="Relationships" <?php echo (isset($oldInput['category']) && $oldInput['category'] == 'Relationships') ? 'selected' : ''; ?>>Relationships</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="threadContent">Thread Description <span style="color:red">*</span></label>
                        <textarea id="threadContent" name="content" rows="6"
                            placeholder="Share your thoughts, ask questions, or offer support..."
                            required><?php echo htmlspecialchars($oldInput['content'] ?? ''); ?></textarea>
                    </div>

                    <?php if ($userRole === 'undergraduate'): ?>
                        <div class="options-group"
                            style="background: #f9fafb; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                            <h4 style="margin-top:0; font-size:1rem; color:#4b5563;">Privacy Options</h4>

                            <div class="form-group" style="margin-bottom: 0.5rem;">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="anonymousPost" name="anonymous" <?php echo (isset($oldInput['anonymous'])) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    Post anonymously
                                </label>
                                <small class="help-text">Your username will be hidden from other users.</small>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="transparencyOption" name="transparency" <?php echo (isset($oldInput['transparency'])) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    Allow counselors to view my identity
                                </label>
                                <small class="help-text">If checked, counselors can see who posted even if you post
                                    anonymously.</small>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-actions">
                        <a href="<?php echo BASE_URL; ?>/forum" class="btn-secondary"
                            style="text-decoration: none; text-align: center;">Cancel</a>
                        <button type="submit" class="btn-primary">Create Thread</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
    /* Include necessary styles locally or ensure they are in forum.css */
    .main-content {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ... (Add other styles from forum.css if not loaded) ... */
</style>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>