<?php
$isEmbedded = isset($_GET['embed']) && $_GET['embed'] === 'true';
$TITLE = htmlspecialchars($thread_data['title']) . ' - MindHeaven Forum';
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
        <title><?= $TITLE ?></title>
        <link rel="stylesheet" href="<?= BASE_URL ?>/css/undergrad/style.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>/css/forum.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <body class="is-embedded">
        <?php
}
?>

    <main id="main" class="main-content">
        <div class="forum-container">
            <!-- Back Link -->
            <!-- Back Link -->
            <?php
            $backLink = BASE_URL . '/forum';
            $backText = 'Back to Forum';

            if ($isEmbedded) {
                $backLink = BASE_URL . '/forum?embed=true';
            } elseif (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'undergraduate') {
                    $backLink = BASE_URL . '/ug/forum';
                } elseif ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'moderator') {
                    $backLink = BASE_URL . '/admin/moderate-forum';
                    $backText = 'Back to Moderation';
                } elseif ($_SESSION['role'] === 'counselor') {
                    // Assuming counselors might have access, though not explicitly seen in CounselorControl yet
                    // Defaulting to standard forum for now unless they have a specific view
                    $backLink = BASE_URL . '/forum';
                }
            }
            ?>
            <a href="<?= $backLink ?>" class="back-link">
                <span>&larr;</span> <?= $backText ?>
            </a>

            <!-- Main Content Grid -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"
                    style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #f87171;">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"
                    style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #4ade80;">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <div class="thread-layout">
                <!-- Left Column: Thread Content -->
                <div class="thread-content-col">
                    <!-- Thread Header -->
                    <div class="thread-card main-thread">
                        <div class="thread-header-row">
                            <div class="category-tag <?= htmlspecialchars($thread_data['category']) ?>">
                                <?= htmlspecialchars(ucfirst($thread_data['category'])) ?>
                            </div>
                            <div class="thread-status">
                                <?php if (!empty($thread_data['is_locked'])): ?>
                                    <span class="status-badge locked"><i class="fas fa-lock"></i> Locked</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <h1 class="thread-heading">
                            <?= htmlspecialchars($thread_data['title']) ?>
                        </h1>

                        <div class="author-meta">
                            <div class="avatar-circle">
                                <?= strtoupper(substr($thread_data['is_anonymous'] ? 'A' : $thread_data['username'], 0, 1)) ?>
                            </div>
                            <div class="meta-details">
                                <span class="author-name">
                                    <?= $thread_data['is_anonymous']
                                        ? 'Anonymous' . str_pad($thread_data['user_id'], 3, '0', STR_PAD_LEFT)
                                        : htmlspecialchars($thread_data['username']) ?>
                                    <?php if (!$thread_data['is_anonymous'] && in_array($thread_data['role'] ?? '', ['admin', 'moderator', 'counselor'])): ?>
                                        <span
                                            style="font-size: 0.7em; padding: 2px 6px; border-radius: 4px; margin-left: 5px; vertical-align: middle; background: <?= $thread_data['role'] === 'admin' ? '#ef4444' : ($thread_data['role'] === 'counselor' ? '#10b981' : '#f59e0b') ?>; color: white; display: inline-block; line-height: 1;">
                                            <?= ucfirst(htmlspecialchars($thread_data['role'])) ?>
                                        </span>
                                    <?php endif; ?>
                                </span>
                                <span class="post-date">
                                    Posted on
                                    <?= date('M j, Y \a\t g:i a', strtotime($thread_data['created_at'])) ?>
                                </span>
                            </div>
                        </div>

                        <div class="thread-body">
                            <?= nl2br(htmlspecialchars($thread_data['description'])) ?>
                        </div>

                        <div class="thread-actions">
                            <div class="stats">
                                <span><i class="far fa-eye"></i>
                                    <?= $thread_data['view_count'] ?? 0 ?> Views
                                </span>
                                <span><i class="far fa-comment-alt"></i>
                                    <?= count($posts) ?> Replies
                                </span>
                            </div>
                            <div class="actions-right">
                                <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $thread_data['user_id'] || $_SESSION['role'] === 'admin' || $_SESSION['role'] === 'moderator')): ?>
                                    <form action="<?= BASE_URL ?>/forum/delete" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this thread? This action cannot be undone.');">
                                        <input type="hidden" name="type" value="thread">
                                        <input type="hidden" name="id" value="<?= $thread_data['id'] ?>">
                                        <button type="submit" class="btn-flag btn-delete-content" title="Delete Thread">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <button onclick="openReportModal('thread', <?= $thread_data['id'] ?>)" class="btn-flag">
                                        <i class="far fa-flag"></i> Report
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    <div class="replies-section">
                        <h3>Replies (
                            <?= count($posts) ?>)
                        </h3>

                        <?php if (empty($posts)): ?>
                            <div class="empty-state">
                                <p>No replies yet. Be the first to share your thoughts!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <div class="reply-card">
                                    <div class="reply-header">
                                        <div class="author-meta small">
                                            <div class="avatar-circle small">
                                                <?= ($post['is_anonymous']) ? 'A' : strtoupper(substr($post['username'], 0, 1)) ?>
                                            </div>
                                            <div class="meta-details text">
                                                <span class="author-name">
                                                    <?= ($post['is_anonymous'])
                                                        ? 'Anonymous' . str_pad($post['user_id'], 3, '0', STR_PAD_LEFT)
                                                        : htmlspecialchars($post['username']) ?>
                                                    <?php if (!$post['is_anonymous'] && in_array($post['role'] ?? '', ['admin', 'moderator', 'counselor'])): ?>
                                                        <span
                                                            style="font-size: 0.7em; padding: 2px 6px; border-radius: 4px; margin-left: 5px; vertical-align: middle; background: <?= $post['role'] === 'admin' ? '#ef4444' : ($post['role'] === 'counselor' ? '#10b981' : '#f59e0b') ?>; color: white; display: inline-block; line-height: 1;">
                                                            <?= ucfirst(htmlspecialchars($post['role'])) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="post-date">
                                                    <?= date('M j, Y, g:i a', strtotime($post['created_at'])) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reply-body">
                                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                                        <?php if (!empty($post['is_edited'])): ?>
                                            <div style="font-size: 0.8em; color: #6b7280; margin-top: 5px; font-style: italic;">
                                                (Edited by <?= htmlspecialchars($post['edited_by_role'] ?? 'Moderator') ?>)
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="reply-actions">

                                        <div class="left-actions">
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button
                                                    class="like-btn <?= isset($post['is_liked']) && $post['is_liked'] ? 'liked' : '' ?>"
                                                    data-post-id="<?= $post['id'] ?>" type="button" onclick="toggleLike(this)">
                                                    <i
                                                        class="<?= isset($post['is_liked']) && $post['is_liked'] ? 'fas' : 'far' ?> fa-heart"></i>
                                                    <span class="like-count"><?= $post['like_count'] ?? 0 ?></span>
                                                </button>

                                                <button class="btn-reply-action"
                                                    onclick="prepareReply(<?= $post['id'] ?>, '<?= ($post['is_anonymous']) ? 'Anonymous' . str_pad($post['user_id'], 3, '0', STR_PAD_LEFT) : htmlspecialchars($post['username']) ?>', <?= !empty($post['parent_reply_id']) ? $post['parent_reply_id'] : $post['id'] ?>)"
                                                    style="background: none; border: none; color: #6b7280; cursor: pointer; margin-left: 1rem;">
                                                    <i class="fas fa-reply"></i> Reply
                                                </button>
                                            <?php else: ?>
                                                <div style="color: #6b7280; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i
                                                        class="<?= isset($post['is_liked']) && $post['is_liked'] ? 'fas' : 'far' ?> fa-heart"></i>
                                                    <span class="like-count"><?= $post['like_count'] ?? 0 ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="right-actions">
                                            <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['role'] === 'admin' || $_SESSION['role'] === 'moderator')): ?>
                                                <form action="<?= BASE_URL ?>/forum/delete" method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this reply?');">
                                                    <input type="hidden" name="type" value="post">
                                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                                    <button type="submit" class="btn-flag btn-delete-content" title="Delete Reply">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <button onclick="openReportModal('post', <?= $post['id'] ?>)" class="btn-flag">
                                                    <i class="far fa-flag"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Reply Form -->
                    <div class="reply-form-card" id="reply-form">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <h3 id="reply-title">Leave a Reply</h3>
                            <form action="<?= BASE_URL ?>/forum/reply" method="POST">
                                <input type="hidden" name="thread_id" value="<?= $thread_data['id'] ?>">
                                <input type="hidden" name="parent_reply_id" id="parent_reply_id" value="">

                                <div id="replying-to-banner"
                                    style="display: none; background: #e0e7ff; color: #3730a3; padding: 0.5rem 1rem; border-radius: 8px; margin-bottom: 1rem; align-items: center; justify-content: space-between;">
                                    <span>Replying to <b id="replying-to-user"></b></span>
                                    <button type="button" onclick="cancelReply()"
                                        style="background: none; border: none; cursor: pointer; color: #3730a3; font-size: 1.2rem;">&times;</button>
                                </div>

                                <div class="form-group">
                                    <textarea name="content" id="reply-content" rows="4" class="form-control"
                                        placeholder="Type your reply here... Be kind and supportive." required></textarea>
                                </div>

                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'undergraduate'): ?>
                                    <div class="form-group">
                                        <label class="checkbox-label"
                                            style="display: flex; align-items: center; cursor: pointer;">
                                            <input type="checkbox" name="anonymous" value="1" style="margin-right: 8px;">
                                            <span>Post anonymously</span>
                                        </label>
                                        <small style="color: #6b7280; display: block; margin-top: 4px;">Your username will be
                                            hidden from other users.</small>
                                    </div>
                                <?php endif; ?>
                                <div class="form-actions">
                                    <button type="submit" class="btn-primary">Post Reply</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div style="text-align: center; padding: 2rem;">
                                <h3>Join the Conversation</h3>
                                <p style="margin-bottom: 1rem; color: #6b7280;">Please log in to reply to this thread.</p>
                                <a href="<?= BASE_URL ?>/login" class="btn-primary"
                                    style="display: inline-block; text-decoration: none;">Log In</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Sidebar (Optional) -->
                <div class="sidebar-col">
                    <div class="support-card">
                        <h3>Need Immediate Help?</h3>
                        <p>If you or someone you know is in crisis, please contact emergency services immediately.</p>
                        <a href="<?= BASE_URL ?>/ug/crisis" class="btn-danger-outline">Get Crisis Support</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Report Content</h3>
                <span onclick="closeReportModal()" class="close-modal">&times;</span>
            </div>

            <form id="reportForm" onsubmit="submitReport(event)">
                <input type="hidden" id="reportContentType" name="content_type">
                <input type="hidden" id="reportContentId" name="content_id">

                <div class="form-group">
                    <label>Reason for Report:</label>
                    <div id="reportCategories">
                        <!-- Categories will be loaded here -->
                        <p>Loading categories...</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reportExplanation">Explanation (Optional):</label>
                    <textarea id="reportExplanation" name="explanation" rows="3" class="form-control"
                        placeholder="Please provide more details..."></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;">Submit Report</button>
            </form>
        </div>
    </div>

    <script>
        function prepareReply(postId, username, parentId) {
            document.getElementById('parent_reply_id').value = parentId;
            document.getElementById('replying-to-user').textContent = '@' + username;
            document.getElementById('replying-to-banner').style.display = 'flex';
            document.getElementById('reply-title').textContent = 'Reply to ' + username;

            const textarea = document.getElementById('reply-content');
            textarea.value = '@' + username + ' ';
            textarea.focus();

            document.getElementById('reply-form').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelReply() {
            document.getElementById('parent_reply_id').value = '';
            document.getElementById('replying-to-banner').style.display = 'none';
            document.getElementById('reply-title').textContent = 'Leave a Reply';
            document.getElementById('reply-content').value = '';
        }

        function toggleLike(btn) {
            const postId = btn.dataset.postId;
            const icon = btn.querySelector('i');
            const countSpan = btn.querySelector('.like-count');

            // Optimistic UI update
            const isLiked = btn.classList.contains('liked');

            fetch('<?= BASE_URL ?>/forum/toggleLike', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ post_id: postId })
            })
                .then(async response => {
                    const text = await response.text();
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            countSpan.textContent = data.new_count;
                            if (data.liked) {
                                btn.classList.add('liked');
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                            } else {
                                btn.classList.remove('liked');
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                            }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to update like'));
                        }
                    } catch (e) {
                        alert('Server Error');
                    }
                })
                .catch(error => {
                    alert('Network error.');
                });
        }

        // Reporting System
        const reportModal = document.getElementById('reportModal');
        let categoriesLoaded = false;

        function openReportModal(type, id) {
            document.getElementById('reportContentType').value = type;
            document.getElementById('reportContentId').value = id;
            document.getElementById('reportExplanation').value = '';

            if (!categoriesLoaded) {
                fetch('<?= BASE_URL ?>/report/categories')
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            const container = document.getElementById('reportCategories');
                            container.innerHTML = '';
                            data.categories.forEach(cat => {
                                const div = document.createElement('div');
                                div.style.marginBottom = '5px';
                                div.innerHTML = `
                                    <label style="cursor:pointer; display:flex; align-items:center;">
                                        <input type="radio" name="category_id" value="${cat.id}" required style="margin-right:8px;"> 
                                        <span>${cat.name} <small style="color:#666;">- ${cat.description}</small></span>
                                    </label>
                                `;
                                container.appendChild(div);
                            });
                            categoriesLoaded = true;
                        }
                    });
            }

            reportModal.style.display = 'block';
        }

        function closeReportModal() {
            reportModal.style.display = 'none';
        }

        function submitReport(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            fetch('<?= BASE_URL ?>/report/submit', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        alert('Report submitted successfully. Thank you for keeping the community safe.');
                        closeReportModal();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => alert('Network error'));
        }

        window.onclick = function (event) {
            if (event.target == reportModal) {
                closeReportModal();
            }
        }
    </script>

    <?php
    if (!$isEmbedded) {
        include BASE_PATH . '/app/views/layouts/footer.php';
    } else {
        echo '</body></html>';
    }
    ?>