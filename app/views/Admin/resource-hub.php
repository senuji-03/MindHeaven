<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Hub - Admin | Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <?php 
    $activePage = 'resource-hub';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Resource Hub</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <?php if (isset($isCategoryView) && $isCategoryView): ?>
                <div class="page-header" style="margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <a href="<?= BASE_URL ?>/admin/resource-hub" class="btn btn-outline" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 style="margin: 0; color: var(--text-primary);">Category: <?= htmlspecialchars($category) ?></h2>
                            <p style="margin: 5px 0 0; color: var(--text-secondary); font-size: 0.9rem;">Viewing all resources in this section.</p>
                        </div>
                    </div>
                </div>

                <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    <?php if (empty($resources)): ?>
                        <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg-soft); border-radius: var(--radius-lg);">
                            <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--border); margin-bottom: 15px; display: block;"></i>
                            <h3 style="color: var(--text-secondary);">No resources found in this category.</h3>
                        </div>
                    <?php else: ?>
                        <?php foreach ($resources as $res): ?>
                            <div class="resource-card" style="background: white; border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease;">
                                <div class="res-type-header" style="padding: 12px 20px; background: var(--bg-mid); display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--primary);">
                                        <?= $res['content_type'] === 'article' ? '📝 Article' : ($res['content_type'] === 'video' ? '🎥 Video' : '🎵 Audio') ?>
                                    </span>
                                    <span style="font-size: 0.8rem; color: var(--text-secondary);">
                                        👍 <?= $res['likes_count'] ?>
                                    </span>
                                </div>
                                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                                    <h3 style="margin: 0 0 10px; font-size: 1.1rem; color: var(--text-primary);"><?= htmlspecialchars($res['title']) ?></h3>
                                    <p style="margin: 0 0 20px; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; flex: 1;">
                                        <?= htmlspecialchars($res['summary'] ?: 'No description available.') ?>
                                    </p>
                                    <div style="display: flex; gap: 10px; margin-top: auto;">
                                        <a href="<?= BASE_URL ?>/ug/viewResource?id=<?= $res['id'] ?>" target="_blank" class="btn btn-primary" style="flex: 1; font-size: 0.85rem; padding: 10px;">View Full Content</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <!-- Hero/Stats Section -->
                <div class="admin-hero" style="background: linear-gradient(135deg, var(--bg-deep) 0%, #2a3f3d 100%); border-radius: var(--radius-lg); padding: 40px; margin-bottom: 40px; color: white;">
                    <div style="max-width: 600px;">
                        <h2 style="font-size: 2rem; margin: 0 0 15px;">Wellness Resource Hub</h2>
                        <p style="opacity: 0.8; line-height: 1.6; margin-bottom: 25px;">Manage and browse the high-quality wellness materials curated for the Mind Heaven community. High-impact resources across multiple formats.</p>
                        <div style="display: flex; gap: 30px;">
                            <div>
                                <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary-light);"><?= $stats['total_resources'] ?? 0 ?></div>
                                <div style="font-size: 0.8rem; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px;">Total Library</div>
                            </div>
                            <div>
                                <div style="font-size: 1.8rem; font-weight: 700; color: #84fab0;"><?= $stats['published'] ?? 0 ?></div>
                                <div style="font-size: 0.8rem; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px;">Live Now</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-header" style="margin-bottom: 25px;">
                    <h3 style="color: var(--text-primary); font-weight: 700;">Explore categories</h3>
                </div>

                <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                    <?php if (empty($categories)): ?>
                        <p>No categories found.</p>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <?php 
                                $catName = $cat['name'];
                                $count = isset($resourcesByCategory[$catName]) ? count($resourcesByCategory[$catName]) : 0;
                            ?>
                            <div class="category-card" onclick="location.href='<?= BASE_URL ?>/admin/category-resources?category=<?= urlencode($catName) ?>'" style="cursor: pointer; background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; transition: all 0.3s ease;">
                                <div style="height: 120px; background: var(--bg-mid); display: flex; align-items: center; justify-content: center;">
                                    <?php if ($cat['thumbnail']): ?>
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($cat['thumbnail']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <i class="fas fa-layer-group" style="font-size: 2.5rem; color: var(--border);"></i>
                                    <?php endif; ?>
                                </div>
                                <div style="padding: 20px;">
                                    <h4 style="margin: 0 0 8px; color: var(--text-primary);"><?= htmlspecialchars($catName) ?></h4>
                                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--primary); font-weight: 600;">
                                        <i class="fas fa-file-alt"></i>
                                        <?= $count ?> Published Resources
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>

