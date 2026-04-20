<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Flags - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --crisis: #D64F4F;
            --success: #4CAF82;
        }
        .flag-list { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .flag-item { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
        .match-highlight { background: rgba(214, 79, 79, 0.1); color: var(--crisis); padding: 2px 6px; border-radius: 4px; font-weight: 700; }
        .btn { padding: 8px 16px; border-radius: var(--radius-full); font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; border: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: var(--bg-mid); color: var(--text-secondary); border: 1px solid var(--border); }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php 
    $activePage = 'moderate-forum';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Automated Flags Queue';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
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

            <div class="flag-list">
                <?php if (empty($flags)): ?>
                    <p>No content currently flagged.</p>
                <?php else: ?>
                    <?php foreach ($flags as $flag): ?>
                        <?php
                        $contentType = $flag['content_type'] ?? '';
                        $contentId = $flag['content_id'] ?? '';
                        $username = $flag['username'] ?? ('User #' . ($flag['user_id'] ?? 'Unknown'));
                        $matchedKeyword = $flag['matched_keyword'] ?? '';
                        $createdAt = $flag['created_at'] ?? '';
                        $flagId = $flag['id'] ?? '';

                        $link = '#';
                        if ($contentType === 'thread' && !empty($contentId)) {
                            $link = BASE_URL . '/forum/thread/' . $contentId;
                        } elseif (in_array($contentType, ['post', 'reply', 'reply_reply']) && !empty($contentId)) {
                            $link = BASE_URL . '/forum';
                        }

                        $displayType = !empty($contentType) ? $contentType : 'unknown';
                        ?>
                        <div class="flag-item">
                            <div class="flag-header">
                                <span>
                                    <span class="chip">Type:
                                        <?= htmlspecialchars($displayType) ?>
                                    </span>
                                    <span class="chip">User:
                                        <?= htmlspecialchars($username) ?>
                                    </span>
                                </span>
                                <span style="font-size:0.9em; color:#888;">
                                    <?= htmlspecialchars($createdAt) ?>
                                </span>
                            </div>

                            <div class="flag-content">
                                <p>
                                    Matched Keyword:
                                    <span class="match-highlight">
                                        <?= htmlspecialchars($matchedKeyword) ?>
                                    </span>
                                </p>
                                <p>
                                    Content ID:
                                    <?= htmlspecialchars((string) $contentId) ?>
                                </p>

                                <?php if ($link !== '#'): ?>
                                    <a href="<?= $link ?>" target="_blank" style="color:#2563eb; text-decoration:underline;">
                                        View Content Context (New Tab)
                                    </a>
                                <?php else: ?>
                                    <span style="color:#6b7280;">Content context link unavailable.</span>
                                <?php endif; ?>
                            </div>

                            <div class="flag-actions" style="display:flex; gap:10px;">
                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $flagId) ?>">
                                    <input type="hidden" name="status" value="dismissed">
                                    <button type="submit" class="btn btn-secondary">Dismiss (Ignore)</button>
                                </form>

                                <form action="<?= BASE_URL ?>/admin/system-flags/update" method="POST">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $flagId) ?>">
                                    <input type="hidden" name="status" value="reviewed">
                                    <button type="submit" class="btn btn-primary">Mark Reviewed</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>