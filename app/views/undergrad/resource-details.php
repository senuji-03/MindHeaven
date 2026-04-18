<?php
$TITLE = 'MindHeaven — ' . htmlspecialchars($resource['title']);
$CURRENT_PAGE = 'resources';
$PAGE_CSS = array('/MindHeaven/public/css/undergrad/resources.css');
$PAGE_JS = array('/MindHeaven/public/js/undergrad/resources.js');

require BASE_PATH . '/app/views/layouts/header.php';

$isImage = false;
$isPdf = false;
if (!empty($resource['file_path'])) {
    $ext = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
    $isImage = in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'));
    $isPdf = ($ext === 'pdf');
}
?>

<main id="main" class="resources-details-page" style="padding: 48px 0; background: var(--surface); min-height: 100vh;">
    <div class="container" style="max-width: 1000px; margin: 0 auto;">
        
        <!-- Back Navigation -->
        <div style="margin-bottom: 32px;">
            <a href="<?= isset($categoryBaseUrl) ? $categoryBaseUrl : (BASE_URL . '/ug/category-resources') ?>?category=<?= urlencode($resource['category']) ?>"
                class="btn btn-outline" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> 
                Back to <?= htmlspecialchars($resource['category']) ?>
            </a>
        </div>

        <!-- Main Content Card -->
        <article class="card" style="padding: 48px; margin-bottom: 32px; border: none; box-shadow: var(--shadow-xl); background: var(--bg-deep);">
            <header style="margin-bottom: 40px;">
                <span class="section-label" style="display: inline-block; background: var(--bg-mid); color: var(--primary-dark); padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.78rem; font-weight: 700; margin-bottom: 16px;">
                    <?= htmlspecialchars($resource['content_type']) ?>
                </span>
                <h1 class="section-title" style="font-size: 2.8rem; margin: 0 0 16px; text-align: left; color: white;">
                    <?= htmlspecialchars($resource['title']) ?>
                </h1>
                <div style="display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                    <i class="far fa-calendar-alt"></i>
                    <span>Published in <?= htmlspecialchars($resource['category']) ?></span>
                </div>
            </header>

            <div style="font-size: 1.15rem; color: rgba(255,255,255,0.9); margin-bottom: 40px; border-left: 4px solid var(--primary-light); padding-left: 24px; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($resource['summary'])) ?>
            </div>

            <div class="resource-content-body" style="margin-bottom: 48px;">
                <?php if (!empty($resource['file_path'])): ?>
                    <?php
                    $pathParts = explode('/', ltrim($resource['file_path'], '/'));
                    $encodedPath = implode('/', array_map('rawurlencode', $pathParts));
                    $cleanPath = BASE_URL . '/' . $encodedPath;
                    ?>
                    
                    <div class="file-display-container" style="background: var(--bg-soft); border-radius: var(--radius-lg); padding: 12px; margin-bottom: 32px; border: 1px solid var(--border);">
                        <?php if ($isImage): ?>
                            <img src="<?= htmlspecialchars($cleanPath) ?>" alt="Resource detail image"
                                style="width: 100%; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); display: block;">
                        <?php elseif ($isPdf): ?>
                            <div style="position: relative; overflow: hidden; border-radius: var(--radius-md);">
                                <iframe src="<?= htmlspecialchars($cleanPath) ?>" width="100%" height="800px" style="border: none;"></iframe>
                            </div>
                        <?php elseif ($resource['content_type'] === 'video'): ?>
                            <div style="position: relative; border-radius: var(--radius-md); overflow: hidden; aspect-ratio: 16/9;">
                                <video controls src="<?= htmlspecialchars($cleanPath) ?>" style="width: 100%; height: 100%; object-fit: cover;"></video>
                            </div>
                        <?php elseif ($resource['content_type'] === 'audio'): ?>
                            <div style="background: var(--surface); border-radius: var(--radius-md); padding: 32px; text-align: center; border: 1px dashed var(--border);">
                                <div style="width: 56px; height: 56px; background: var(--bg-mid); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 1.4rem;">
                                    <i class="fas fa-headphones"></i>
                                </div>
                                <h4 style="margin-bottom: 12px; color: white;"><?= htmlspecialchars(isset($resource['file_name']) ? $resource['file_name'] : 'Wellness Audio Session') ?></h4>
                                <audio controls style="width: 100%; max-width: 500px;" preload="auto">
                                    <source src="<?= htmlspecialchars($cleanPath) ?>">
                                </audio>
                            </div>
                        <?php else: ?>
                            <div style="padding: 40px; background: var(--surface); border-radius: var(--radius-md); text-align: center; border: 1.5px dashed var(--border);">
                                <i class="far fa-file-alt" style="font-size: 2.5rem; color: var(--text-secondary); margin-bottom: 16px;"></i>
                                <p style="margin-bottom: 20px; color: var(--text-secondary);">This resource contains an external attachment.</p>
                                <a href="<?= htmlspecialchars($cleanPath) ?>" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt" style="margin-right: 8px;"></i> View Full Document
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($resource['content'])): ?>
                    <div class="text-content" style="font-size: 1.05rem; line-height: 1.75; color: rgba(255,255,255,0.92); letter-spacing: -0.01em;">
                        <?= $resource['content'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Interaction Bar -->
            <footer style="display: flex; justify-content: space-between; align-items: center; padding-top: 32px; border-top: 1.5px solid var(--bg-mid);">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <button class="like-button-fancy <?= in_array($resource['id'], isset($userLikes) ? $userLikes : array()) ? 'liked' : '' ?>"
                        onclick="toggleLikeDetail(this, <?= $resource['id'] ?>)"
                        title="Mark as helpful"
                        style="width: 52px; height: 52px; border-radius: 50%; border: none; background: var(--bg-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: var(--shadow-sm);">
                        <i class="fas fa-heart" style="font-size: 1.4rem; color: #94a3b8; transition: color 0.3s ease;"></i>
                        <span class="like-ripple"></span>
                    </button>
                    <div style="line-height: 1.4;">
                        <span style="display: block; font-weight: 700; color: white; font-size: 0.95rem;">Do you find this helpful?</span>
                        <span style="color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                            <span id="detail-likes-count-<?= $resource['id'] ?>" style="font-weight: 600; color: var(--primary-light);"><?= isset($resource['likes']) ? $resource['likes'] : 0 ?></span> users appreciated this
                        </span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                     <div style="position: relative;">
                         <button onclick="toggleDropdown(event, 'actionDropdown<?= $resource['id'] ?>')" class="btn btn-outline" style="width: 42px; padding: 0;">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div id="actionDropdown<?= $resource['id'] ?>" class="dropdown-menu-modern"
                            style="display: none; position: absolute; bottom: 100%; right: 0; margin-bottom: 12px; background: white; min-width: 180px; border-radius: var(--radius-md); border: 1px solid var(--border); box-shadow: var(--shadow-lg); overflow: hidden; z-index: 100;">
                            <button onclick="openReportModal()" style="width: 100%; padding: 12px 16px; text-align: left; background: none; border: none; cursor: pointer; color: var(--crisis); display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem;">
                                <i class="fas fa-flag"></i> Report Resource
                            </button>
                        </div>
                    </div>
                </div>
            </footer>
        </article>

        <!-- Comments Section -->
        <section class="card" style="padding: 40px; border: none; box-shadow: var(--shadow-xl); background: var(--bg-deep);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px;">
                <h3 style="font-size: 1.4rem; font-weight: 700; margin: 0; color: white;">Discussion</h3>
                <span style="background: rgba(255,255,255,0.1); color: var(--primary-light); padding: 2px 10px; border-radius: var(--radius-full); font-size: 0.85rem; font-weight: 600;">
                    <?= count($comments) ?> Comments
                </span>
            </div>

            <form action="<?= isset($addCommentUrl) ? $addCommentUrl : (BASE_URL . '/ug/addComment') ?>" method="POST" style="margin-bottom: 40px;">
                <input type="hidden" name="resource_id" value="<?= $resource['id'] ?>">
                <div style="position: relative;">
                    <textarea name="comment" rows="1" class="comment-input" placeholder="Share your perspective..." required
                        style="width: 100%; padding: 18px; border: 1.5px solid rgba(255,255,255,0.15); border-radius: var(--radius-md); font-family: inherit; font-size: 1rem; transition: all 0.3s ease; resize: none; overflow: hidden; min-height: 56px; background: rgba(255,255,255,0.05); color: white;"
                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                    <button type="submit" style="position: absolute; right: 10px; bottom: 8px; background: var(--primary); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>

            <div class="comments-list" style="display: flex; flex-direction: column; gap: 24px;">
                <?php if (empty($comments)): ?>
                    <div style="text-align: center; padding: 40px; background: var(--bg-soft); border-radius: var(--radius-md); border: 1.5px dashed var(--border);">
                        <i class="far fa-comments" style="font-size: 2rem; color: var(--text-secondary); margin-bottom: 8px;"></i>
                        <p style="color: var(--text-secondary); margin: 0;">No thoughts shared yet. Start the conversation!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item" style="display: flex; gap: 16px; padding-bottom: 24px; border-bottom: 1.2px solid var(--bg-mid);">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <?= strtoupper(substr(isset($comment['user_name']) ? $comment['user_name'] : 'U', 0, 1)) ?>
                            </div>
                            <div style="flex-grow: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <strong style="color: white; font-size: 0.98rem;"><?= htmlspecialchars(isset($comment['user_name']) ? $comment['user_name'] : 'User') ?></strong>
                                        <?php if (isset($_SESSION['user_id']) && (int)$comment['user_id'] === (int)$_SESSION['user_id']): ?>
                                            <div style="display: flex; gap: 8px; margin-left: 8px;">
                                                <button onclick="toggleEditComment(<?= $comment['id'] ?>)" style="background:none; border:none; color:rgba(255,255,255,0.4); cursor:pointer; font-size: 0.8rem; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-light)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="confirmDeleteComment(<?= $comment['id'] ?>)" style="background:none; border:none; color:rgba(255,255,255,0.4); cursor:pointer; font-size: 0.8rem; transition: color 0.2s;" onmouseover="this.style.color='var(--crisis)'" onmouseout="this.style.color='rgba(255,255,255,0.4)'" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <span style="font-size: 0.78rem; color: rgba(255,255,255,0.5); font-weight: 500;">
                                        <?= date('M j, Y', strtotime($comment['created_at'])) ?>
                                    </span>
                                </div>
                                
                                <div id="comment-display-<?= $comment['id'] ?>">
                                    <p style="margin: 0; color: rgba(255,255,255,0.85); line-height: 1.6; font-size: 0.95rem;">
                                        <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                    </p>
                                </div>

                                <?php if (isset($_SESSION['user_id']) && (int)$comment['user_id'] === (int)$_SESSION['user_id']): ?>
                                    <div id="comment-edit-<?= $comment['id'] ?>" style="display: none;">
                                        <form action="<?= BASE_URL ?>/ug/editComment" method="POST">
                                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                            <input type="hidden" name="resource_id" value="<?= $resource['id'] ?>">
                                            <textarea name="comment" class="comment-input" required style="width: 100%; padding: 12px; border: 1.5px solid var(--primary); border-radius: var(--radius-md); background: rgba(255,255,255,0.05); color: white; margin-bottom: 8px;"><?= htmlspecialchars($comment['comment']) ?></textarea>
                                            <div style="display: flex; gap: 8px;">
                                                <button type="submit" class="btn btn-primary" style="padding: 4px 12px; font-size: 0.85rem;">Save</button>
                                                <button type="button" onclick="toggleEditComment(<?= $comment['id'] ?>)" class="btn btn-outline" style="padding: 4px 12px; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.2); background:transparent; color:white;">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <form id="delete-form-<?= $comment['id'] ?>" action="<?= BASE_URL ?>/ug/deleteComment" method="POST" style="display: none;">
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                        <input type="hidden" name="resource_id" value="<?= $resource['id'] ?>">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<!-- Report Modal Modernized -->
<div id="reportModal" style="display: none; position: fixed; inset: 0; background: rgba(28, 43, 42, 0.7); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 2000; padding: 24px;">
    <div class="card" style="width: 100%; max-width: 500px; padding: 32px; box-shadow: var(--shadow-xl); border: 1px solid rgba(255,255,255,0.1); background: var(--bg-deep); animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        <header style="margin-bottom: 24px;">
            <h3 style="margin: 0 0 8px; color: white; font-size: 1.4rem;">Report Resource</h3>
            <p style="color: rgba(255,255,255,0.65); font-size: 0.9rem; margin: 0;">Your report helps us maintain high accuracy and safety standards.</p>
        </header>

        <form id="reportForm">
            <input type="hidden" id="reportResourceId" value="<?= $resource['id'] ?>">

            <div style="margin-bottom: 20px;">
                <label class="form-label" style="color: white;">Select Reason</label>
                <select id="reportReason" required class="form-input" style="background: rgba(255,255,255,0.05); color: white; border-color: rgba(255,255,255,0.2);">
                    <option value="" disabled selected style="background: var(--bg-deep);">Select a reason...</option>
                    <option value="Inappropriate content" style="background: var(--bg-deep);">Inappropriate content</option>
                    <option value="Misinformation" style="background: var(--bg-deep);">Misinformation</option>
                    <option value="Copyright violation" style="background: var(--bg-deep);">Copyright violation</option>
                    <option value="Spam / irrelevant" style="background: var(--bg-deep);">Spam / irrelevant</option>
                    <option value="Other" style="background: var(--bg-deep);">Other (please specify below)</option>
                </select>
            </div>

            <div style="margin-bottom: 32px;">
                <label class="form-label" style="color: white;">Additional Context (Optional)</label>
                <textarea id="reportDescription" rows="3" class="form-input" placeholder="Provide more details..." style="background: rgba(255,255,255,0.05); color: white; border-color: rgba(255,255,255,0.2);"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeReportModal()" class="btn btn-outline" style="border: 1px solid rgba(255,255,255,0.4); background: transparent; color: white;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: var(--crisis);">
                    <i class="fas fa-flag" style="margin-right: 6px;"></i> Send Report
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Transitions and Animations for Details Page */
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.like-button-fancy.liked i {
    color: var(--crisis) !important;
    animation: heartBeat 0.4s ease;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.comment-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 4px rgba(61, 139, 110, 0.1) !important;
    outline: none;
}

.dropdown-menu-modern {
    animation: dropDown 0.2s ease-out;
}

@keyframes dropDown {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.btn-primary:active { transform: translateY(0) scale(0.98); }

.comment-actions-btn:hover {
    background: rgba(255,255,255,0.1);
}
</style>

<script>
    function openReportModal() {
        document.getElementById('reportModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function copyResourceLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            setTimeout(() => btn.innerHTML = originalHtml, 2000);
        });
    }

    // Reuse existing toggleDropdown and toggleLikeDetail functions from original file, but optimized
    function toggleDropdown(event, id) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        const isVisible = dropdown.style.display === 'block';
        document.querySelectorAll('[id^="actionDropdown"]').forEach(el => el.style.display = 'none');
        dropdown.style.display = isVisible ? 'none' : 'block';
    }

    document.addEventListener('click', () => {
        document.querySelectorAll('[id^="actionDropdown"]').forEach(el => el.style.display = 'none');
    });

    function toggleEditComment(id) {
        const displayDiv = document.getElementById('comment-display-' + id);
        const editDiv = document.getElementById('comment-edit-' + id);
        if (displayDiv.style.display === 'none') {
            displayDiv.style.display = 'block';
            editDiv.style.display = 'none';
        } else {
            displayDiv.style.display = 'none';
            editDiv.style.display = 'block';
            editDiv.querySelector('textarea').focus();
        }
    }

    function confirmDeleteComment(id) {
        if (confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    function toggleLikeDetail(btn, resourceId) {
        const likeUrlBase = '<?= isset($likeUrl) ? $likeUrl : (BASE_URL . "/ug/likeResource") ?>';
        fetch(likeUrlBase, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ resource_id: resourceId })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                const countSpan = document.getElementById('detail-likes-count-' + resourceId);
                let count = parseInt(countSpan.textContent) || 0;
                if (data.action === 'liked') {
                    btn.classList.add('liked');
                    countSpan.textContent = count + 1;
                } else {
                    btn.classList.remove('liked');
                    countSpan.textContent = Math.max(0, count - 1);
                }
            }
        }).catch(err => console.error("Like error:", err));
    }

    document.getElementById('reportForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const resourceId = document.getElementById('reportResourceId').value;
        const reason = document.getElementById('reportReason').value;
        const description = document.getElementById('reportDescription').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        
        submitBtn.disabled = true;
        
        const reportUrlBase = '<?= isset($reportResourceUrl) ? $reportResourceUrl : (BASE_URL . "/ug/reportResource") ?>';
        fetch(reportUrlBase, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ resource_id: resourceId, reason: reason, description: description })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Thank you. Your report has been submitted.');
                closeReportModal();
                this.reset();
            } else {
                alert(data.error || 'Failed to submit report.');
            }
        })
        .finally(() => {
            submitBtn.disabled = false;
        });
    });
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>