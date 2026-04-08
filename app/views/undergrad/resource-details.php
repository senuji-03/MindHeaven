<?php
$TITLE = 'MindHeaven — ' . htmlspecialchars($resource['title']);
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/js/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';

$isImage = false;
$isPdf = false;
if (!empty($resource['file_path'])) {
    $ext = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    $isPdf = ($ext === 'pdf');
}
?>

<main id="main" class="resources-main" style="padding-top: 2rem;">
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 2rem;">
        <a href="<?= BASE_URL ?>/ug/category-resources?category=<?= urlencode($resource['category']) ?>"
            class="btn btn-secondary" style="margin-bottom: 2rem;">&larr; Back to
            <?= htmlspecialchars($resource['category']) ?></a>

        <div
            style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 2rem;">
            <div style="margin-bottom: 1rem;">
                <span
                    style="background: #eee; padding: 4px 10px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize; margin-bottom: 1rem; display: inline-block;">
                    <?= htmlspecialchars($resource['content_type']) ?>
                </span>
                <h1 style="font-size: 2.5rem; margin: 0.5rem 0; color: #222;">
                    <?= htmlspecialchars($resource['title']) ?>
                </h1>
            </div>

            <p
                style="font-size: 1.2rem; color: #666; margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1.5rem;">
                <?= nl2br(htmlspecialchars($resource['summary'])) ?>
            </p>

            <div class="content" style="font-size: 1.1rem; line-height: 1.8; color: #333; margin-bottom: 2rem;">
                <?php if (!empty($resource['file_path'])): ?>
                    <?php
                    // Build properly URL-encoded path (encode each path segment separately)
                    $pathParts = explode('/', ltrim($resource['file_path'], '/'));
                    $encodedPath = implode('/', array_map('rawurlencode', $pathParts));
                    $cleanPath = BASE_URL . '/' . $encodedPath;
                    ?>
                    <?php if ($isImage): ?>
                        <img src="<?= htmlspecialchars($cleanPath) ?>" alt="Resource file"
                            style="max-width: 100%; border-radius: 8px;">
                    <?php elseif ($isPdf): ?>
                        <iframe src="<?= htmlspecialchars($cleanPath) ?>" width="100%" height="800px"
                            style="border: none; border-radius: 8px;"></iframe>
                    <?php elseif ($resource['content_type'] === 'video'): ?>
                        <video controls src="<?= htmlspecialchars($cleanPath) ?>"
                            style="max-width: 100%; border-radius: 8px;"></video>
                    <?php elseif ($resource['content_type'] === 'audio'):
                        $audioExt = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
                        $mimeMap = ['mp3' => 'audio/mpeg', 'ogg' => 'audio/ogg', 'oga' => 'audio/ogg', 'wav' => 'audio/wav', 'm4a' => 'audio/mp4'];
                        $audioMime = $mimeMap[$audioExt] ?? 'audio/mpeg';
                        ?>
                        <div style="background: #f8f9fa; border-radius: 12px; padding: 2rem; text-align: center;">
                            <p style="font-size: 1rem; color: #555; margin-bottom: 1rem;">🎧
                                <?= htmlspecialchars($resource['file_name'] ?? 'Audio File') ?>
                            </p>
                            <audio controls style="width: 100%;" preload="auto">
                                <source src="<?= htmlspecialchars($cleanPath) ?>" type="<?= $audioMime ?>">
                                Your browser does not support audio playback.
                            </audio>
                            <p style="margin-top: 1rem;">
                                <a href="<?= htmlspecialchars($cleanPath) ?>" target="_blank"
                                    style="color: #2563eb; font-size: 0.9rem;">▶ Open audio directly if player doesn't work</a>
                            </p>
                        </div>
                    <?php else: ?>
                        <div style="padding: 2rem; background: #f8f9fa; border-radius: 8px; text-align: center;">
                            <a href="<?= htmlspecialchars($cleanPath) ?>" target="_blank" class="btn btn-primary">Open File</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($resource['content'])): ?>
                    <div style="margin-top: 2rem;">
                        <?= $resource['content'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div
                style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 1.5rem; margin-top: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="like-button <?= in_array($resource['id'], $userLikes ?? []) ? 'liked' : '' ?>"
                        onclick="toggleLikeDetail(this, <?= $resource['id'] ?>)"
                        style="background: transparent; border: none; cursor: pointer; padding: 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #f8f9fa; transition: transform 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                            role="presentation" focusable="false"
                            style="display: block; fill: rgba(0, 0, 0, 0.5); height: 28px; width: 28px; stroke: white; stroke-width: 2; overflow: visible; transition: fill 0.2s ease, stroke 0.2s ease;">
                            <path
                                d="m16 28c7-4.733 14-10 14-17 0-1.792-.683-3.583-2.05-4.95-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05l-2.051 2.051-2.05-2.051c-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05-1.367 1.367-2.051 3.158-2.051 4.95 0 7 7 12.267 14 17z">
                            </path>
                        </svg>
                    </button>
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 600; color: #222; font-size: 1.1rem;">Do you find this helpful?</span>
                        <span style="font-weight: 500; color: #666; font-size: 0.95rem;"><span
                                id="detail-likes-count-<?= $resource['id'] ?>"><?= $resource['likes'] ?? 0 ?></span>
                            people liked this</span>
                    </div>
                </div>

                <div style="position: relative;">
                    <button onclick="toggleDropdown(event, 'actionDropdown<?= $resource['id'] ?>')" title="More actions"
                        style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #999; padding: 0.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; transition: background 0.2s, color 0.2s;"
                        onmouseover="this.style.background='#f1f5f9'; this.style.color='#334155'"
                        onmouseout="this.style.background='none'; this.style.color='#999'">
                        &#8942;
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="actionDropdown<?= $resource['id'] ?>" class="dropdown-menu"
                        style="display: none; position: absolute; bottom: 100%; right: 0; margin-bottom: 0.5rem; background: #2d2d2d; color: #fff; border-radius: 4px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.2); width: max-content; z-index: 10;">
                        <button
                            onclick="document.getElementById('reportModal').style.display='flex'; toggleDropdown(event, 'actionDropdown<?= $resource['id'] ?>')"
                            style="background: transparent; border: none; color: #fff; width: 100%; padding: 0.75rem 1.25rem; text-align: left; cursor: pointer; font-family: inherit; font-size: 0.95rem; display: flex; align-items: center; gap: 0.75rem; transition: background 0.2s;"
                            onmouseover="this.style.background='#444'" onmouseout="this.style.background='transparent'">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                                <line x1="4" y1="22" x2="4" y2="15"></line>
                            </svg>
                            Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.5rem; color: #222; margin-bottom: 1.5rem;">Comments (<?= count($comments) ?>)</h3>

            <form action="<?= BASE_URL ?>/ug/addComment" method="POST"
                style="margin-bottom: 2.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <input type="hidden" name="resource_id" value="<?= $resource['id'] ?>">
                <textarea name="comment" rows="3" placeholder="Add a comment..." required
                    style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 1rem; resize: vertical;"></textarea>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary"
                        style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s ease;">Post
                        Comment</button>
                </div>
            </form>

            <div class="comments-list" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <?php if (empty($comments)): ?>
                    <p style="color: #666; font-style: italic; text-align: center; padding: 2rem 0;">No comments yet. Be the
                        first to share your thoughts!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div style="display: flex; gap: 1rem; border-bottom: 1px solid #eee; padding-bottom: 1.5rem;">
                            <div
                                style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #64748b; font-size: 1.2rem; flex-shrink: 0;">
                                <?= strtoupper(substr($comment['user_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div style="flex-grow: 1;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.25rem;">
                                    <strong
                                        style="color: #334155; font-size: 1.05rem;"><?= htmlspecialchars($comment['user_name'] ?? 'User') ?></strong>
                                    <span
                                        style="font-size: 0.85rem; color: #94a3b8;"><?= date('M j, Y, g:i a', strtotime($comment['created_at'])) ?></span>
                                </div>
                                <p style="margin: 0; color: #475569; line-height: 1.5; font-size: 1rem;">
                                    <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Report Modal -->
<div id="reportModal"
    style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; padding: 1rem;">
    <div
        style="background: white; width: 100%; max-width: 500px; border-radius: 12px; padding: 2rem; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0; margin-bottom: 1.5rem; color: #222;">Report Resource</h3>
        <p style="color: #666; margin-bottom: 2rem; font-size: 0.95rem;">Please let us know why you are reporting this
            resource. Your feedback helps keep MindHeaven safe.</p>

        <form id="reportForm">
            <input type="hidden" id="reportResourceId" value="<?= $resource['id'] ?>">

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Reason</label>
                <select id="reportReason" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 1rem;">
                    <option value="" disabled selected>Select a reason...</option>
                    <option value="Inappropriate content">Inappropriate content</option>
                    <option value="Misinformation">Misinformation</option>
                    <option value="Copyright violation">Copyright violation</option>
                    <option value="Spam / irrelevant">Spam / irrelevant</option>
                    <option value="Other">Other (please specify below)</option>
                </select>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Description
                    (Optional)</label>
                <textarea id="reportDescription" rows="3" placeholder="Provide more details..."
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; font-size: 1rem; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="document.getElementById('reportModal').style.display='none'"
                    style="padding: 0.75rem 1.5rem; border: 1px solid #ddd; background: transparent; border-radius: 8px; font-weight: 600; color: #555; cursor: pointer;">Cancel</button>
                <button type="submit"
                    style="padding: 0.75rem 1.5rem; border: none; background: #dc2626; color: white; border-radius: 8px; font-weight: 600; cursor: pointer;">Submit
                    Report</button>
            </div>
        </form>
    </div>
</div>

<style>
    .like-button.liked svg {
        fill: #ff385c !important;
        stroke: #ff385c !important;
    }

    .like-button:hover {
        transform: scale(1.1);
    }
</style>

<script>
    function toggleDropdown(event, id) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        const isVisible = dropdown.style.display === 'block';

        // Hide all other open dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');

        // Toggle targeted dropdown
        dropdown.style.display = isVisible ? 'none' : 'block';
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('[id^=actionDropdown]') && !event.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
        }
    });

    function toggleLikeDetail(btn, resourceId) {
        fetch('<?= BASE_URL ?>/ug/likeResource', {
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
            } else {
                alert("Error processing like request.");
            }
        }).catch(err => {
            console.error("Like error:", err);
        });
    }

    document.getElementById('reportForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const resourceId = document.getElementById('reportResourceId').value;
        const reason = document.getElementById('reportReason').value;
        const description = document.getElementById('reportDescription').value;

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        fetch('<?= BASE_URL ?>/ug/reportResource', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ resource_id: resourceId, reason: reason, description: description })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you. Your report has been submitted successfully.');
                    document.getElementById('reportModal').style.display = 'none';
                    this.reset();
                } else {
                    alert(data.error || 'Failed to submit report. You may have already reported this item or exceeded your daily limit.');
                }
            })
            .catch(err => {
                console.error("Report error:", err);
                alert('An error occurred while submitting your report.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Report';
            });
    });
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>