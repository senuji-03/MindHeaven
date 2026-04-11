<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindHeaven — <?= htmlspecialchars($resource['title']) ?></title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\Cdashboard.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/resources.css">
    <style>
        .resources-main {
            padding: 2rem;
            max-width: 100%;
            margin: 0;
        }

        .resource-detail-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .like-button.liked svg {
            fill: #ff385c !important;
            stroke: #ff385c !important;
        }

        .like-button:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">M</div>
                Mindheaven
            </div>
            <div class="nav-icons">
                <div class="nav-icon">🔔<span class="badge">3</span></div>
                <div class="nav-icon">💬<span class="badge">7</span></div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content resources-main">
            <div class="resource-detail-container">
                <a href="<?= BASE_URL ?>/counselor/category-resources?category=<?= urlencode($resource['category']) ?>"
                    class="btn btn-secondary" style="margin-bottom: 2rem; display: inline-block; text-decoration: none; color: #64748b; padding: 0.5rem 1rem; background: #f1f5f9; border-radius: 8px;">&larr; Back to <?= htmlspecialchars($resource['category']) ?></a>

                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                    <div style="margin-bottom: 1rem;">
                        <span style="background: #eee; padding: 4px 10px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize; margin-bottom: 1rem; display: inline-block;">
                            <?= htmlspecialchars($resource['content_type']) ?>
                        </span>
                        <h1 style="font-size: 2.25rem; margin: 0.5rem 0; color: #1e293b; font-weight: 700;">
                            <?= htmlspecialchars($resource['title']) ?>
                        </h1>
                    </div>

                    <p style="font-size: 1.1rem; color: #475569; margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 1.5rem; line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($resource['summary'])) ?>
                    </p>

                    <div class="content" style="font-size: 1.1rem; line-height: 1.8; color: #334155; margin-bottom: 2rem;">
                        <?php if (!empty($resource['file_path'])): ?>
                            <?php
                            $pathParts = explode('/', ltrim($resource['file_path'], '/'));
                            $encodedPath = implode('/', array_map('rawurlencode', $pathParts));
                            $cleanPath = BASE_URL . '/public/' . $encodedPath;
                            
                            $ext = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $isPdf = ($ext === 'pdf');
                            ?>

                            <?php if ($isImage): ?>
                                <img src="<?= htmlspecialchars($cleanPath) ?>" alt="Resource file" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <?php elseif ($isPdf): ?>
                                <iframe src="<?= htmlspecialchars($cleanPath) ?>" width="100%" height="800px" style="border: none; border-radius: 8px; border: 1px solid #e2e8f0;"></iframe>
                            <?php elseif ($resource['content_type'] === 'video'): ?>
                                <video controls src="<?= htmlspecialchars($cleanPath) ?>" style="max-width: 100%; border-radius: 8px; width: 100%; background: #000;"></video>
                            <?php elseif ($resource['content_type'] === 'audio'): ?>
                                <div style="background: #f8fafc; border-radius: 12px; padding: 2.5rem; text-align: center; border: 1px solid #e2e8f0;">
                                    <p style="font-size: 1.1rem; color: #64748b; margin-bottom: 1.5rem;">🎧 <?= htmlspecialchars($resource['file_name'] ?? 'Audio File') ?></p>
                                    <audio controls style="width: 100%; max-width: 500px;" preload="auto">
                                        <source src="<?= htmlspecialchars($cleanPath) ?>">
                                    </audio>
                                </div>
                            <?php else: ?>
                                <div style="padding: 2.5rem; background: #f8fafc; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0;">
                                    <a href="<?= htmlspecialchars($cleanPath) ?>" target="_blank" class="btn btn-primary" style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 600;">Open File Attachment</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (!empty($resource['content'])): ?>
                            <div style="margin-top: 2.5rem; background: #fff;">
                                <?= $resource['content'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 1.5rem; margin-top: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <button class="like-button <?= in_array($resource['id'], $userLikes ?? []) ? 'liked' : '' ?>"
                                onclick="toggleLikeDetail(this, <?= $resource['id'] ?>)"
                                style="background: transparent; border: none; cursor: pointer; padding: 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #f8fafc; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: rgba(0, 0, 0, 0.4); height: 26px; width: 26px; stroke: white; stroke-width: 2; overflow: visible; transition: all 0.2s ease;"><path d="m16 28c7-4.733 14-10 14-17 0-1.792-.683-3.583-2.05-4.95-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05l-2.051 2.051-2.05-2.051c-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05-1.367 1.367-2.051 3.158-2.051 4.95 0 7 7 12.267 14 17z"></path></svg>
                            </button>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-weight: 600; color: #1e293b; font-size: 1.05rem;">Helpful?</span>
                                <span style="color: #64748b; font-size: 0.9rem;"><span id="detail-likes-count-<?= $resource['id'] ?>"><?= $resource['likes'] ?? 0 ?></span> likes</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.35rem; color: #1e293b; margin-bottom: 1.5rem; font-weight: 700;">Comments (<?= count($comments) ?>)</h3>

                    <form action="<?= BASE_URL ?>/counselor/addComment" method="POST" style="margin-bottom: 2.5rem; display: flex; flex-direction: column; gap: 1rem;">
                        <input type="hidden" name="resource_id" value="<?= $resource['id'] ?>">
                        <textarea name="comment" rows="3" placeholder="Add your professional insights or a helpful note..." required style="width: 100%; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; font-size: 1rem; resize: vertical; transition: border-color 0.2s;"></textarea>
                        <div style="display: flex; justify-content: flex-end;">
                            <button type="submit" class="btn btn-primary" style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">Post Comment</button>
                        </div>
                    </form>

                    <div class="comments-list" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <?php if (empty($comments)): ?>
                            <p style="color: #64748b; font-style: italic; text-align: center; padding: 2rem 0;">No comments yet.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div style="display: flex; gap: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #2563eb; font-size: 1.1rem; flex-shrink: 0; border: 1px solid #dbeafe;">
                                        <?= strtoupper(substr($comment['user_name'] ?? 'U', 0, 1)) ?>
                                    </div>
                                    <div style="flex-grow: 1;">
                                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.25rem;">
                                            <strong style="color: #1e293b; font-size: 1.05rem;"><?= htmlspecialchars($comment['user_name'] ?? 'User') ?></strong>
                                            <span style="font-size: 0.85rem; color: #94a3b8;"><?= date('M j, Y', strtotime($comment['created_at'])) ?></span>
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
    </div>

    <script>
        function toggleLikeDetail(btn, resourceId) {
            fetch('<?= BASE_URL ?>/counselor/likeResource', {
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
            });
        }
    </script>
</body>

</html>
