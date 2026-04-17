<?php
$isEmbedded = isset($_GET['embed']) && $_GET['embed'] === 'true';
$TITLE = 'Peer Discussion Forum - MindHeaven';
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

    <body class="is-embedded">
        <?php
}
?>

    <main id="main" class="main-content">
        <div class="forum-container">

            <!-- Alerts -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Back to Home — guests only -->
            <?php if (($userRole ?? 'guest') === 'guest' || !isset($_SESSION['user_id'])): ?>
                <a href="<?= BASE_URL ?>/" style="
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    font-size: 0.875rem;
                    color: var(--text-secondary, #6b7280);
                    text-decoration: none;
                    margin-bottom: 1rem;
                    padding: 6px 14px;
                    border: 1px solid var(--border, #d1d5db);
                    border-radius: 99px;
                    background: var(--surface, #fff);
                    transition: all 0.15s;
                " onmouseover="this.style.color='#3D8B6E';this.style.borderColor='#3D8B6E';"
                   onmouseout="this.style.color='';this.style.borderColor='';">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            <?php endif; ?>

            <!-- Header Section -->
            <div class="forum-header">
                <div class="header-content">
                    <h1>Peer Discussion Forum</h1>
                    <p class="subtitle">Share, support, and connect with fellow students</p>
                </div>

                <!-- Create New Thread Button -->
                <?php if ($userRole !== 'guest' && $userRole !== 'university_representative'): ?>
                    <a href="<?php echo BASE_URL; ?>/forum/create<?= $isEmbedded ? '?embed=true' : '' ?>" class="btn-create-thread">
                        <i class="fas fa-plus"></i> Create New Thread
                    </a>
                <?php elseif ($userRole === 'guest'): ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn-create-thread">
                        <i class="fas fa-sign-in-alt"></i> Login to Post
                    </a>
                <?php endif; ?>
            </div>

            <!-- Search & Filter Section -->
            <div class="forum-controls">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="threadSearch" placeholder="Search discussions...">
                </div>

                <div class="filter-wrapper">
                    <button class="filter-btn active" data-category="all">All</button>
                    <?php foreach ($categories as $cat): ?>
                        <button class="filter-btn" 
                                data-category="<?php echo htmlspecialchars($cat['name']); ?>"
                                title="<?php echo htmlspecialchars($cat['description']); ?>">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Threads List -->
            <div class="threads-list" id="threadsList">
                <?php if (empty($threads)): ?>
                    <div style="padding: 24px; text-align: center; color: var(--text-secondary);">
                        No threads found. Be the first to start a discussion!
                    </div>
                <?php else: ?>
                    <?php foreach ($threads as $thread): ?>
                        <div class="thread-card" data-category="<?php echo htmlspecialchars($thread['category']); ?>"
                            onclick="window.location.href='<?php echo BASE_URL; ?>/forum/thread/<?php echo $thread['id']; ?><?php echo $isEmbedded ? '?embed=true' : ''; ?>'">
                            <div class="thread-main">
                                <div class="thread-title">
                                    <h4>
                                        <?php echo htmlspecialchars($thread['title']); ?>
                                    </h4>
                                    <!-- Role Badge -->
                                    <span class="role-badge <?php echo 'role-' . strtolower($thread['role'] ?? 'student'); ?>">
                                        <?php echo htmlspecialchars($thread['role'] ?? 'Student'); ?>
                                    </span>
                                    <!-- Category Badge (if separate style needed, handled by CSS or inline) -->
                                    <span class="category-badge category-badge-<?php echo strtolower(htmlspecialchars($thread['category'])); ?>">
                                        <?php echo htmlspecialchars($thread['category']); ?>
                                    </span>
                                </div>

                                <div class="thread-preview">
                                    <p>
                                        <?php echo htmlspecialchars(substr($thread['description'], 0, 150)) . (strlen($thread['description']) > 150 ? '...' : ''); ?>
                                    </p>
                                </div>

                                <div class="thread-meta">
                                    <span class="author-info">
                                        <div
                                            class="author-avatar <?php echo strtolower($thread['role'] ?? 'student') === 'counselor' ? 'counselor-avatar' : ''; ?>">
                                            <?php echo strtoupper(substr($thread['username'] ?? 'A', 0, 1)); ?>
                                        </div>
                                        <span class="author-name">
                                            <?php if ($thread['is_anonymous']): ?>
                                                Anonymous
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($thread['username']); ?>
                                            <?php endif; ?>
                                        </span>
                                    </span>
                                    <span class="meta-dot">•</span>
                                    <span class="timestamp">
                                        <?php echo date('M j, Y', strtotime($thread['created_at'])); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="thread-stats">
                                <div class="stat-item">
                                    <i class="fas fa-comment-alt"></i>
                                    <span><?php echo $thread['reply_count']; ?></span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-eye"></i>
                                    <span><?php echo $thread['view_count']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>


    <!-- Reuse previous JS for category filtering or adapt it -->
    <script src="<?php echo BASE_URL; ?>/js/forum.js"></script>
    <?php
    if (!$isEmbedded) {
        include BASE_PATH . '/app/views/layouts/footer.php';
    } else {
        echo '</body></html>';
    }
    ?>