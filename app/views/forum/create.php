<?php
$isEmbedded = isset($_GET['embed']) && $_GET['embed'] === 'true';
$TITLE = 'Create New Thread - MindHeaven';
$CURRENT_PAGE = 'forum';

if (!$isEmbedded) {
    include BASE_PATH . '/app/views/layouts/header.php';
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($TITLE) ?></title>
        <link rel="stylesheet" href="<?= BASE_URL ?>/css/undergrad/style.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body class="is-embedded">
    <?php
}

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
                <form id="threadForm" action="<?php echo BASE_URL; ?>/forum/create<?= $isEmbedded ? '?embed=true' : '' ?>" method="POST">
                    <div class="form-group">
                        <label for="threadTitle">Thread Title <span style="color:red">*</span></label>
                        <input type="text" id="threadTitle" name="title"
                            value="<?php echo htmlspecialchars($oldInput['title'] ?? ''); ?>"
                            placeholder="Enter a descriptive title..." required>
                    </div>

                    <div class="form-group">
                        <label for="threadCategory">Category <span style="color:red">*</span></label>
                        <select id="threadCategory" name="category" required 
                                onchange="this.title = this.options[this.selectedIndex].getAttribute('title') || ''">
                            <option value="">Select a category...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['name']); ?>"
                                    title="<?php echo htmlspecialchars($cat['description']); ?>"
                                    <?php echo (isset($oldInput['category']) && $oldInput['category'] == $cat['name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
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
                        <a href="<?php echo BASE_URL; ?>/forum<?= $isEmbedded ? '?embed=true' : '' ?>" class="btn-secondary"
                            style="text-decoration: none; text-align: center;">Cancel</a>
                        <button type="submit" class="btn-primary">Create Thread</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
    .main-content {
        padding: 2.5rem 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Card wrapper ── */
    .create-thread-form {
        display: block;
        max-width: 760px;
        margin: 2rem auto;
    }

    .form-container {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,.07);
        padding: 2.4rem 2.8rem;
    }

    .form-container h3 {
        margin: 0 0 1.8rem;
        font-size: 1.4rem;
        font-weight: 700;
        color: #111827;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 1rem;
    }

    /* ── Form groups ── */
    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 1.4rem;
    }

    .form-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.45rem;
    }

    .form-group label span[style*="color:red"],
    .form-group label span[style*="color: red"] {
        color: #ef4444 !important;
        margin-left: 2px;
    }

    /* ── Inputs, select, textarea ── */
    .form-group input[type="text"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 0.65rem 0.9rem;
        font-size: 0.95rem;
        color: #1f2937;
        background: #f9fafb;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        transition: border-color .18s, box-shadow .18s, background .18s;
        font-family: inherit;
    }

    .form-group input[type="text"]:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }

    .form-group select {
        cursor: pointer;
        appearance: auto;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 130px;
        line-height: 1.6;
    }

    /* ── Privacy options card ── */
    .options-group {
        background: #f8faff !important;
        border: 1.5px solid #e0e7ff;
        border-radius: 10px !important;
        padding: 1.1rem 1.3rem !important;
        margin-bottom: 1.6rem !important;
    }

    .options-group h4 {
        margin-top: 0 !important;
        font-size: 0.9rem !important;
        font-weight: 700 !important;
        color: #4338ca !important;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .options-group .form-group {
        margin-bottom: 0.6rem !important;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #6366f1;
        cursor: pointer;
    }

    .help-text {
        display: block;
        font-size: 0.78rem;
        color: #6b7280;
        margin-top: 0.25rem;
        margin-left: 1.6rem;
    }

    /* ── Action buttons ── */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 1.8rem;
        padding-top: 1.2rem;
        border-top: 1px solid #f3f4f6;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.6rem;
        background: #6366f1;
        color: #fff;
        font-size: 0.92rem;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .18s, transform .12s;
    }

    .btn-primary:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1.3rem;
        background: #f3f4f6;
        color: #374151;
        font-size: 0.92rem;
        font-weight: 600;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        text-decoration: none !important;
        transition: background .18s;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    /* ── Alert ── */
    .alert {
        padding: 0.9rem 1.1rem;
        margin-bottom: 1.2rem;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>


<?php
if (!$isEmbedded) {
    include BASE_PATH . '/app/views/layouts/footer.php';
} else {
    echo '</body></html>';
}
?>