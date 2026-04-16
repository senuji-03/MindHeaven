<?php
$TITLE = 'Peer Discussion Forum - MindHeaven';
$CURRENT_PAGE = 'forum';
include BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="main-content">
    <div class="container">
    <div class="page-header forum-hero">
        <h1 class="hero-title">Peer Discussion Forum</h1>
        <p class="hero-subtitle">Share, support, and connect with fellow students</p>
    </div>

        <!-- Forum Stats -->
        <div class="forum-stats">
            <div class="stat-card">
                <div class="stat-number"><?= htmlspecialchars($stats['active_threads'] ?? 0) ?></div>
                <div class="stat-label">Active Threads</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= htmlspecialchars($stats['total_posts'] ?? 0) ?></div>
                <div class="stat-label">Total Posts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= htmlspecialchars($stats['online_now'] ?? 0) ?></div>
                <div class="stat-label">Online Now</div>
            </div>
        </div>

        <!-- Create New Thread -->
        <div class="create-thread-section">
            <button class="create-thread-btn" onclick="toggleCreateThread()">
                <span class="btn-icon">✏️</span>
                Create New Thread
            </button>
        </div>

        <!-- Create Thread Form (Hidden by default) -->
        <div id="createThreadForm" class="create-thread-form" style="display: none;">
            <div class="form-container">
                <h3>Create New Discussion Thread</h3>
                <form id="threadForm" action="<?= BASE_URL ?>/forum/create" method="POST">
                    <div class="form-group">
                        <label for="threadTitle">Thread Title</label>
                        <input type="text" id="threadTitle" name="title" placeholder="Enter a descriptive title..."
                            required>
                    </div>

                    <div class="form-group">
                        <label for="threadCategory">Category</label>
                        <select id="threadCategory" name="category" required>
                            <option value="">Select a category...</option>
                            <option value="general">General Discussion</option>
                            <option value="academic">Academic Stress</option>
                            <option value="relationships">Relationships</option>
                            <option value="anxiety">Anxiety & Worry</option>
                            <option value="depression">Depression Support</option>
                            <option value="self-care">Self-Care Tips</option>
                            <option value="resources">Resources & Tools</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="threadContent">Your Message</label>
                        <textarea id="threadContent" name="content" rows="6"
                            placeholder="Share your thoughts, ask questions, or offer support..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="anonymousPost" name="anonymous">
                            <span class="checkmark"></span>
                            Post anonymously
                        </label>
                        <small class="help-text">Your username will be hidden, but moderators can still see it for
                            safety purposes.</small>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="toggleCreateThread()">Cancel</button>
                        <button type="submit" class="btn-primary">Create Thread</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Forum Categories -->
        <div class="forum-categories">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="all">All Threads</button>
                <button class="tab-btn" data-category="general">General</button>
                <button class="tab-btn" data-category="academic">Academic</button>
                <button class="tab-btn" data-category="relationships">Relationships</button>
                <button class="tab-btn" data-category="anxiety">Anxiety</button>
                <button class="tab-btn" data-category="depression">Depression</button>
                <button class="tab-btn" data-category="self-care">Self-Care</button>
                <button class="tab-btn" data-category="resources">Resources</button>
            </div>
        </div>

        <!-- Threads List -->
        <div class="threads-container">
            <div class="threads-header">
                <h3>Discussion Threads</h3>
                <div class="sort-options">
                    <select id="sortThreads">
                        <option value="recent">Most Recent</option>
                        <option value="popular">Most Popular</option>
                        <option value="replies">Most Replies</option>
                    </select>
                </div>
            </div>

            <div class="threads-list" id="threadsList">
                <?php if (empty($threads)): ?>
                    <div class="thread-item">
                        <div class="thread-preview">
                            <p style="text-align:center; color:var(--text-secondary);">No conversations yet. Be the first to verify a
                                thought!</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($threads as $thread): ?>
                        <div class="thread-item" data-id="<?= $thread['id'] ?>"
                            data-category="<?= htmlspecialchars($thread['category']) ?>">
                            <div class="thread-header">
                                <div class="thread-title">
                                    <h4><?= htmlspecialchars($thread['title']) ?></h4>
                                    <span
                                        class="category-badge <?= htmlspecialchars($thread['category']) ?>"><?= htmlspecialchars(ucfirst($thread['category'])) ?></span>
                                </div>
                                <div class="thread-meta">
                                    <span class="author">
                                        <?= $thread['is_anonymous'] ? 'Anonymous' : htmlspecialchars($thread['username']) ?>
                                        <?php if (!$thread['is_anonymous'] && in_array($thread['role'] ?? '', ['admin', 'moderator', 'counselor'])): ?>
                                            <span
                                                style="font-size: 0.7em; padding: 2px 6px; border-radius: var(--radius-sm); margin-left: 5px; vertical-align: middle; background: <?= $thread['role'] === 'admin' ? 'var(--crisis)' : ($thread['role'] === 'counselor' ? 'var(--success)' : 'var(--accent-warm)') ?>; color: white; display: inline-block; line-height: 1;">
                                                <?= ucfirst(htmlspecialchars($thread['role'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                    <span
                                        class="timestamp"><?= date('M j, Y, g:i a', strtotime($thread['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="thread-preview">
                                <p><?= htmlspecialchars(substr($thread['description'], 0, 150)) . (strlen($thread['description']) > 150 ? '...' : '') ?>
                                </p>
                            </div>
                            <div class="thread-stats">
                                <span class="replies"><?= $thread['reply_count'] ?> replies</span>
                                <span class="views"><?= $thread['view_count'] ?? 0 ?> views</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Real-time Activity Feed -->
        <div class="activity-feed">
            <h3>Recent Activity</h3>
            <div class="activity-list" id="activityList">
                <?php if (empty($recentActivity)): ?>
                    <p style="color:var(--text-secondary); text-align:center;">No recent activity.</p>
                <?php else: ?>
                    <?php foreach ($recentActivity as $activity): ?>
                        <div class="activity-item">
                            <span class="activity-icon">
                                <?= $activity['type'] === 'thread' ? '📝' : '💬' ?>
                            </span>
                            <span class="activity-text">
                                <?= $activity['type'] === 'thread' ? 'New thread: ' : 'New reply in ' ?>
                                "<?= htmlspecialchars($activity['title']) ?>"
                            </span>
                            <span class="activity-time">
                                <?php
                                $timeDiff = time() - strtotime($activity['created_at']);
                                if ($timeDiff < 60)
                                    echo "Just now";
                                elseif ($timeDiff < 3600)
                                    echo floor($timeDiff / 60) . " min ago";
                                elseif ($timeDiff < 86400)
                                    echo floor($timeDiff / 3600) . " hours ago";
                                else
                                    echo floor($timeDiff / 86400) . " days ago";
                                ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<style>
    .main-content {
        padding: 16px 28px;
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
    }

    .forum-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
        border-radius: var(--radius-lg);
        padding: 24px 32px;
        margin-bottom: 24px;
        color: white;
        text-align: left;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .forum-hero::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(232,168,124,0.15);
        bottom: -40px;
        left: 15%;
    }

    .forum-hero .hero-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: #fff;
        line-height: 1.2;
        letter-spacing: -0.5px;
        position: relative;
        z-index: 1;
    }

    .forum-hero .hero-subtitle {
        font-size: 1rem;
        color: rgba(255,255,255,0.85);
        margin: 0;
        line-height: 1.5;
        position: relative;
        z-index: 1;
    }

    /* Forum Stats */
    .forum-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--surface);
        padding: 20px;
        border-radius: var(--radius-lg);
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-light);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Create Thread */
    .create-thread-section {
        margin-bottom: 24px;
    }

    .create-thread-btn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: var(--radius-full);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(61,139,110,0.25);
    }

    .create-thread-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(61,139,110,0.35);
    }

    .create-thread-form {
        background: var(--surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        margin-bottom: 24px;
    }

    .form-container {
        padding: 24px;
    }

    .form-container h3 {
        color: var(--text-primary);
        margin-bottom: 24px;
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 1rem;
        transition: all 0.2s ease;
        box-sizing: border-box;
        background: var(--surface);
        color: var(--text-primary);
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .help-text {
        display: block;
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
    }

    .btn-primary,
    .btn-secondary {
        padding: 10px 20px;
        border-radius: var(--radius-full);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-secondary {
        background: var(--bg-mid);
        color: var(--text-primary);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        background: var(--border);
    }

    /* Category Tabs */
    .forum-categories {
        margin-bottom: 24px;
    }

    .category-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 8px 16px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text-secondary);
        border-radius: var(--radius-full);
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .tab-btn:hover {
        background: var(--bg-mid);
        border-color: var(--primary-light);
        color: var(--text-primary);
    }

    .tab-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Threads */
    .threads-container {
        background: var(--surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        margin-bottom: 24px;
    }

    .threads-header {
        padding: 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-mid);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .threads-header h3 {
        color: var(--text-primary);
        margin: 0;
        font-size: 1.15rem;
    }

    .sort-options select {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface);
        color: var(--text-primary);
        font-family: inherit;
        font-size: 0.85rem;
    }

    .threads-list {
        padding: 0;
    }

    .thread-item {
        padding: 24px;
        border-bottom: 1px solid var(--bg-mid);
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .thread-item:hover {
        background: var(--bg-mid);
    }

    .thread-item:last-child {
        border-bottom: none;
    }

    .thread-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .thread-title {
        flex: 1;
    }

    .thread-title h4 {
        color: var(--text-primary);
        margin: 0 0 8px 0;
        font-size: 1.15rem;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid transparent;
    }

    .category-badge.general {
        background: #E8F4F8;
        color: var(--accent-calm);
        border-color: #A8C5DA;
    }

    .category-badge.academic {
        background: #FEF3E6;
        color: var(--accent-warm);
        border-color: #E8A87C;
    }

    .category-badge.relationships {
        background: #FCE7F3;
        color: #BE185D;
    }

    .category-badge.anxiety {
        background: #FEE2E2;
        color: var(--crisis);
    }

    .category-badge.depression {
        background: var(--bg-mid);
        color: var(--text-secondary);
    }

    .category-badge.self-care {
        background: #D1FAE5;
        color: #065F46;
    }

    .category-badge.resources {
        background: #E0E7FF;
        color: #3730A3;
    }

    .thread-meta {
        text-align: right;
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    .thread-meta .author {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
    }

    .thread-meta .timestamp {
        display: block;
        margin-top: 4px;
    }

    .thread-preview {
        color: var(--text-secondary);
        margin-bottom: 16px;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .thread-stats {
        display: flex;
        gap: 16px;
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    /* Activity Feed */
    .activity-feed {
        background: var(--surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        padding: 24px;
    }

    .activity-feed h3 {
        color: var(--text-primary);
        margin-bottom: 16px;
        font-size: 1.15rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid var(--bg-mid);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        font-size: 1.2rem;
    }

    .activity-text {
        flex: 1;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .activity-time {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 16px;
        }

        .thread-header {
            flex-direction: column;
            gap: 16px;
        }

        .thread-meta {
            text-align: left;
        }

        .category-tabs {
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<script>
    // Toggle create thread form
    function toggleCreateThread() {
        const form = document.getElementById('createThreadForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    // Category filtering
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const category = this.dataset.category;
            filterThreads(category);
        });
    });

    function filterThreads(category) {
        const threads = document.querySelectorAll('.thread-item');
        threads.forEach(thread => {
            if (category === 'all' || thread.dataset.category === category) {
                thread.style.display = 'block';
            } else {
                thread.style.display = 'none';
            }
        });
    }

    // Thread form submission handled by server    
    // document.getElementById('threadForm').addEventListener('submit', function(    e) {
    //     // Native submission     allowed
    // });    });

    // Sort threads
    document.getElementById('sortThreads').addEventListener('change', function () {
        const sortBy = this.value;
        // In a real application, you would sort the threads based on the selected option
        console.log('Sorting by:', sortBy);
    });

    // Simulate real-time activity updates
    function updateActivity() {
        const activities = [
            { icon: '💬', text: 'New reply in discussion thread', time: '1 min ago' },
            { icon: '📝', text: 'New thread created', time: '5 min ago' },
            { icon: '👍', text: 'New like on thread', time: '10 min ago' },
            { icon: '👥', text: 'New user joined forum', time: '15 min ago' }
        ];

        const randomActivity = activities[Math.floor(Math.random() * activities.length)];

        // Add new activity to the top
        const activityList = document.getElementById('activityList');
        const newActivity = document.createElement('div');
        newActivity.className = 'activity-item';
        newActivity.innerHTML = `
        <span class="activity-icon">${randomActivity.icon}</span>
        <span class="activity-text">${randomActivity.text}</span>
        <span class="activity-time">${randomActivity.time}</span>
    `;

        activityList.insertBefore(newActivity, activityList.firstChild);

        // Remove oldest activity if more than 5
        if (activityList.children.length > 5) {
            activityList.removeChild(activityList.lastChild);
        }
    }

    // Update activity every 30 seconds
    setInterval(updateActivity, 30000);

    // Thread click handler
    document.querySelectorAll('.thread-item').forEach(thread => {
        thread.addEventListener('click', function () {
            const threadId = this.dataset.id;
            if (threadId) {
                window.location.href = `<?= BASE_URL ?>/forum/thread/${threadId}`;
            }
        });
    });
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>