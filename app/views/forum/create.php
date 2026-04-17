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

        <div class="create-thread-form">
            <div class="form-container">
                <h3>Create New Discussion Thread</h3>
                <form id="threadForm" action="<?php echo BASE_URL; ?>/forum/create<?= $isEmbedded ? '?embed=true' : '' ?>" method="POST">
                    <div class="form-group">
                        <label for="threadTitle">Thread Title <span style="color:var(--crisis)">*</span></label>
                        <input type="text" id="threadTitle" name="title"
                            value="<?php echo htmlspecialchars($oldInput['title'] ?? ''); ?>"
                            placeholder="Enter a descriptive title..." required>
                    </div>

                    <div class="form-group">
                        <label for="threadCategory">Category <span style="color:var(--crisis)">*</span></label>
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
                        <label for="threadContent">Thread Description <span style="color:var(--crisis)">*</span></label>
                        <textarea id="threadContent" name="content" rows="6"
                            placeholder="Share your thoughts, ask questions, or offer support..."
                            required><?php echo htmlspecialchars($oldInput['content'] ?? ''); ?></textarea>
                    </div>

                    <?php if ($userRole === 'undergraduate'): ?>
                        <div class="options-group">
                            <h4>Privacy Options</h4>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="anonymousPost" name="anonymous" <?php echo (isset($oldInput['anonymous'])) ? 'checked' : ''; ?>>
                                    <span class="checkmark"></span>
                                    Post anonymously
                                </label>
                                <small class="help-text">Your username will be hidden from other users.</small>
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
        padding: 16px 28px !important;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Card wrapper ── */
    .create-thread-form {
        display: block;
        max-width: 760px;
        margin: 32px auto;
    }

    .form-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 32px 40px;
    }

    .form-container h3 {
        margin: 0 0 24px;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        padding-bottom: 16px;
    }

    /* ── Form groups ── */
    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 24px;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    /* ── Inputs, select, textarea ── */
    .form-group input[type="text"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: var(--text-primary);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        outline: none;
        transition: border-color .18s, box-shadow .18s, background .18s;
        font-family: inherit;
    }

    .form-group input[type="text"]:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--primary);
        background: var(--surface);
        box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
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
        background: var(--bg-mid);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
    }

    .options-group h4 {
        margin: 0 0 16px 0 !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: var(--text-primary) !important;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-primary);
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .help-text {
        display: block;
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 4px;
        margin-left: 24px;
    }

    /* ── Action buttons ── */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 24px;
        background: var(--primary);
        color: #fff;
        font-size: 0.92rem;
        font-weight: 600;
        border: none;
        border-radius: var(--radius-full);
        cursor: pointer;
        transition: background .18s, transform .12s, box-shadow .18s;
        box-shadow: 0 4px 12px rgba(61,139,110,0.25);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(61,139,110,0.35);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 24px;
        background: var(--bg-mid);
        color: var(--text-primary);
        font-size: 0.92rem;
        font-weight: 600;
        border: 1px solid var(--border);
        border-radius: var(--radius-full);
        text-decoration: none !important;
        transition: background .18s;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: var(--border);
    }

    /* ── Alert ── */
    .alert {
        padding: 16px;
        margin-bottom: 24px;
        border-radius: var(--radius-md);
        font-size: 0.9rem;
    }

    .alert-error {
        background-color: #FEE2E2;
        color: var(--crisis);
        border: 1px solid #FCA5A5;
    }
</style>


<?php
if (!$isEmbedded) {
    include BASE_PATH . '/app/views/layouts/footer.php';
} else {
    echo '</body></html>';
}
?>