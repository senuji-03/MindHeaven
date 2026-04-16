<?php
$TITLE = 'MindHeaven — ' . htmlspecialchars($category ?? '') . ' Resources';
$CURRENT_PAGE = 'Ccategory_resources';
$PAGE_CSS = ['/MindHeaven/public/css/counselor/Cdashboard.css', '/MindHeaven/public/css/undergrad/resources.css'];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="main-container">
        <!-- Sidebar -->
        

        <!-- Main Content -->
        <main class="main-content resources-main">
            <!-- Hero Section -->
            <section class="resources-hero">
                <div class="hero-content">
                    <div>
                        <h1 class="hero-title"><?= htmlspecialchars($category) ?></h1>
                        <p class="hero-subtitle"><?= htmlspecialchars($categoryInfo['description'] ?? 'Curated resources for the counselor library.') ?></p>
                        <div class="hero-actions">
                            <a href="<?= BASE_URL ?>/counselor/Cresource_hub" class="btn btn-secondary" style="display:inline-flex; width: fit-content; margin-top:1rem; background:rgba(255,255,255,0.2); color:white; border:none; text-decoration:none; padding: 0.5rem 1rem; border-radius: 8px;">&larr; Back to Categories</a>
                        </div>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="stat-number"><?= $totalResources ?></span>
                            <span class="stat-label">Resources Available</span>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Filter Bar -->
            <?php
            $articlesCount = count(array_filter($resources, function($r){ return $r['content_type'] === 'article'; }));
            $videosCount   = count(array_filter($resources, function($r){ return $r['content_type'] === 'video'; }));
            $audiosCount   = count(array_filter($resources, function($r){ return $r['content_type'] === 'audio'; }));
            $totalCount    = count($resources);
            ?>
            <div class="filter-bar" style="max-width: 1200px; margin: 2rem 0; display: flex; gap: 1rem; flex-wrap: wrap;">
                <button class="filter-btn active" onclick="filterContent('all', this)" style="padding: 10px 24px; border-radius: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">All (<?= $totalCount ?>)</button>
                <button class="filter-btn" onclick="filterContent('article', this)" style="padding: 10px 24px; border-radius: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">Articles (<?= $articlesCount ?>)</button>
                <button class="filter-btn" onclick="filterContent('audio', this)" style="padding: 10px 24px; border-radius: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">Audio (<?= $audiosCount ?>)</button>
                <button class="filter-btn" onclick="filterContent('video', this)" style="padding: 10px 24px; border-radius: 25px; border: 1px solid #ddd; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">Videos (<?= $videosCount ?>)</button>
            </div>

            <style>
                .filter-btn:hover { background: #f4f4f4; }
                .filter-btn.active { background: #222 !important; color: #fff !important; border-color: #222 !important; }
            </style>

            <?php
            function renderResourceCard($resource, $userLikes) {
                $isImage = false;
                if (!empty($resource['file_path'])) {
                    $ext = strtolower(pathinfo($resource['file_path'], PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                }
                $hasYoutube = !empty($resource['youtube_url']);
                $icon = $resource['content_type'] === 'video' ? '🎬' : ($resource['content_type'] === 'audio' ? '🎧' : '📄');
                ?>
                <div class="airbnb-card" onclick="openResource(<?= htmlspecialchars(json_encode($resource), ENT_QUOTES, 'UTF-8') ?>)">
                    <div class="airbnb-cover">
                        <div class="airbnb-badge"><?= htmlspecialchars($resource['content_type']) ?></div>
                        <button class="like-button <?= in_array($resource['id'], $userLikes) ? 'liked' : '' ?>"
                                onclick="event.stopPropagation(); toggleLike(this, <?= $resource['id'] ?>)">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false"><path d="m16 28c7-4.733 14-10 14-17 0-1.792-.683-3.583-2.05-4.95-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05l-2.051 2.051-2.05-2.051c-1.367-1.366-3.158-2.05-4.95-2.05-1.791 0-3.583.684-4.949 2.05-1.367 1.367-2.051 3.158-2.051 4.95 0 7 7 12.267 14 17z"></path></svg>
                        </button>
                        <?php if ($isImage): ?>
                            <img src="<?= BASE_URL ?>/<?= ltrim($resource['file_path'], '/') ?>" alt="Cover">
                        <?php elseif ($hasYoutube): ?>
                            <?php
                            $ytId = '';
                            if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $resource['youtube_url'], $m)) $ytId = $m[1];
                            ?>
                            <?php if ($ytId): ?>
                                <img src="https://img.youtube.com/vi/<?= $ytId ?>/hqdefault.jpg" alt="YouTube Thumbnail">
                                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                                    <div style="width:48px;height:48px;background:rgba(255,0,0,0.85);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="white"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="placeholder-icon"><?= $icon ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="placeholder-icon"><?= $icon ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="airbnb-info">
                        <h3 class="airbnb-title"><?= htmlspecialchars($resource['title']) ?></h3>
                        <p class="airbnb-summary"><?= htmlspecialchars($resource['summary']) ?></p>
                        <div class="airbnb-meta">
                            <span id="likes-count-<?= $resource['id'] ?>"><?= $resource['likes'] ?? 0 ?></span> likes
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php if (empty($resources)): ?>
                <div style="padding: 3rem; text-align: center;">
                    <p style="font-size: 1.2rem; color: #717171;">No resources found in this category.</p>
                </div>
            <?php else: ?>
                <?php
                $articles = array_filter($resources, function($r){ return $r['content_type'] === 'article'; });
                $videos   = array_filter($resources, function($r){ return $r['content_type'] === 'video'; });
                $audios   = array_filter($resources, function($r){ return $r['content_type'] === 'audio'; });
                ?>
                <div style="padding: 1rem 0;">
                    <?php if (!empty($articles)): ?>
                        <div class="resource-section" data-type="article" style="margin-bottom: 3rem;">
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: #222; margin-bottom: 1.5rem; border-bottom: 2px solid #eee; padding-bottom: 0.75rem;">📄 Articles</h2>
                            <div class="airbnb-grid">
                                <?php foreach ($articles as $resource): renderResourceCard($resource, $userLikes ?? []); endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($videos)): ?>
                        <div class="resource-section" data-type="video" style="margin-bottom: 3rem;">
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: #222; margin-bottom: 1.5rem; border-bottom: 2px solid #eee; padding-bottom: 0.75rem;">🎬 Videos</h2>
                            <div class="airbnb-grid">
                                <?php foreach ($videos as $resource): renderResourceCard($resource, $userLikes ?? []); endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($audios)): ?>
                        <div class="resource-section" data-type="audio" style="margin-bottom: 3rem;">
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: #222; margin-bottom: 1.5rem; border-bottom: 2px solid #eee; padding-bottom: 0.75rem;">🎧 Audios</h2>
                            <div class="airbnb-grid">
                                <?php foreach ($audios as $resource): renderResourceCard($resource, $userLikes ?? []); endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function filterContent(type, btn) {
            // Update buttons
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Filter sections
            const sections = document.querySelectorAll('.resource-section');
            let found = false;
            sections.forEach(s => {
                if (type === 'all' || s.getAttribute('data-type') === type) {
                    s.style.display = 'block';
                    found = true;
                } else {
                    s.style.display = 'none';
                }
            });

            // Handle empty state
            const emptyMsg = document.getElementById('no-filter-results');
            if (!found) {
                if (!emptyMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'no-filter-results';
                    msg.innerHTML = '<p style="text-align:center; padding:3rem; color:#717171;">No resources of this type found in this category.</p>';
                    document.querySelector('.resource-section')?.parentNode.appendChild(msg);
                }
            } else if (emptyMsg) {
                emptyMsg.remove();
            }
        }

        function openResource(resource) {
            if (resource.youtube_url) {
                window.open(resource.youtube_url, '_blank');
            } else {
                window.location.href = '<?= BASE_URL ?>/counselor/viewResource?id=' + resource.id;
            }
        }

        function toggleLike(btn, resourceId) {
            fetch('<?= BASE_URL ?>/counselor/likeResource', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ resource_id: resourceId })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    const countSpan = document.getElementById('likes-count-' + resourceId);
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

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
