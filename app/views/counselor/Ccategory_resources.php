<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindHeaven — <?= htmlspecialchars($category) ?> Resources</title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\Cdashboard.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/resources.css">
    <style>
        .resources-main {
            padding: 2rem;
            max-width: 100%;
            margin: 0;
        }

        .airbnb-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .airbnb-card {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            border: none;
            background: transparent;
            text-align: left;
            transition: transform 0.2s ease;
        }

        .airbnb-card:hover .airbnb-cover img {
            transform: scale(1.05);
        }

        .airbnb-cover {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0.75rem;
            position: relative;
            background: #f4f4f4;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .airbnb-cover img,
        .airbnb-cover .placeholder-icon {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .airbnb-cover .placeholder-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        }

        .airbnb-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255, 255, 255, 0.9);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #222;
            text-transform: capitalize;
            z-index: 10;
        }

        .airbnb-title {
            font-size: 1rem;
            font-weight: 600;
            color: #222;
            margin: 0 0 0.2rem 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .airbnb-summary {
            font-size: 0.9rem;
            color: #717171;
            margin: 0 0 0.2rem 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.3;
        }

        .airbnb-meta {
            font-size: 0.85rem;
            color: #222;
            font-weight: 500;
            margin-top: 0.2rem;
        }

        .like-button {
            position: absolute;
            top: 12px;
            right: 12px;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 20;
            transition: transform 0.2s ease;
            padding: 0;
        }

        .like-button:hover {
            transform: scale(1.1);
        }

        .like-button svg {
            display: block;
            fill: rgba(0, 0, 0, 0.5);
            height: 24px;
            width: 24px;
            stroke: white;
            stroke-width: 2;
            overflow: visible;
            transition: fill 0.2s ease, stroke 0.2s ease;
        }

        .like-button.liked svg {
            fill: #ff385c !important;
            stroke: #ff385c !important;
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
                        <div style="margin-bottom: 3rem;">
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: #222; margin-bottom: 1.5rem; border-bottom: 2px solid #eee; padding-bottom: 0.75rem;">📄 Articles</h2>
                            <div class="airbnb-grid">
                                <?php foreach ($articles as $resource): renderResourceCard($resource, $userLikes ?? []); endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($videos)): ?>
                        <div style="margin-bottom: 3rem;">
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: #222; margin-bottom: 1.5rem; border-bottom: 2px solid #eee; padding-bottom: 0.75rem;">🎬 Videos</h2>
                            <div class="airbnb-grid">
                                <?php foreach ($videos as $resource): renderResourceCard($resource, $userLikes ?? []); endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($audios)): ?>
                        <div style="margin-bottom: 3rem;">
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
</body>

</html>
