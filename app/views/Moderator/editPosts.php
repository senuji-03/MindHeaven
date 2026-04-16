<?php 
$TITLE = 'Manage Resources';
$CURRENT_PAGE = 'EditPosts';
require BASE_PATH . '/app/views/layouts/header.php'; 
?>

<style>
    /* ── EDIT RESOURCES UNIFIED STYLES ── */
    .edit-page-header {
        margin-bottom: 40px;
    }

    .edit-page-header h1 {
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 12px;
        letter-spacing: -0.7px;
    }

    .edit-page-header p {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 600px;
        line-height: 1.7;
        margin: 0;
    }

    /* ── FILTER SECTION ── */
    .filter-section {
        background: var(--surface);
        padding: 24px 32px;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        margin-bottom: 32px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-secondary);
    }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        background: var(--bg-mid);
        transition: all 0.25s ease;
        outline: none;
    }

    .filter-input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(61, 139, 110, 0.1);
    }

    /* ── RESOURCES GRID ── */
    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 24px;
    }

    .resource-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
    }

    .resource-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-light);
    }

    .resource-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.4;
    }

    .resource-meta {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .res-badge {
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .res-badge-type { background: var(--bg-mid); color: var(--primary); }
    .res-badge-cat { background: rgba(168, 197, 218, 0.2); color: #475569; }

    .resource-summary {
        font-size: 0.95rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── FILE PREVIEW ── */
    .res-file-box {
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        padding: 16px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .res-file-icon {
        width: 48px;
        height: 48px;
        background: #fff;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
        box-shadow: var(--shadow-sm);
    }

    .res-file-info h4 {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 2px;
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .res-file-info p {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin: 0;
    }

    /* ── STATUS & ACTIONS ── */
    .res-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .status-indicator {
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .form-row label {
                text-align: left;
            }
            
            .resources-grid {
                grid-template-columns: 1fr;
            }
        }

        .status-published { color: var(--success); }
        .status-draft { color: var(--accent-warm); }
        .status-archived { color: var(--text-secondary); }

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text-secondary);
            text-decoration: none;
        }

        .btn-icon:hover {
            background: var(--bg-mid);
            border-color: var(--primary);
            color: var(--primary);
            transform: scale(1.1);
        }

        .btn-icon-danger:hover {
            border-color: var(--crisis);
            color: var(--crisis);
            background: rgba(214, 79, 79, 0.05);
        }

        /* ── ALERTS ── */
        .alert-box {
            padding: 16px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 32px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid;
        }

        .alert-success { 
            background: var(--bg-mid); 
            color: #1e3a34; 
            border-left-color: var(--success); 
        }

        .alert-error { 
            background: rgba(214, 79, 79, 0.05); 
            color: #7f1d1d; 
            border-left-color: var(--crisis); 
        }
    </style>
<div class="main-content" style="padding: 40px; background: var(--surface);">
        <div class="edit-page-header">
            <h1>Resource Management Library</h1>
            <p>Refine and organize your educational materials. Use filters to quickly locate specific content blocks.</p>
        </div>

        <!-- Feedback Alerts -->
        <?php if (isset($_GET['created'])): ?>
            <div class="alert-box alert-success">
                <i class="fas fa-check-circle"></i> Resource created successfully! It is now live for students.
            </div>
        <?php elseif (isset($_GET['updated'])): ?>
            <div class="alert-box alert-success">
                <i class="fas fa-check-circle"></i> Content updates saved successfully.
            </div>
        <?php elseif (isset($_GET['deleted'])): ?>
            <div class="alert-box alert-success">
                <i class="fas fa-trash-can"></i> Resource removed from the library.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert-box alert-error">
                <i class="fas fa-triangle-exclamation"></i> 
                <?php 
                $error = $_GET['error'];
                echo ($error === 'missing_fields') ? 'Please provide all required fields.' : 'An error occurred. Please try again.';
                ?>
            </div>
        <?php endif; ?>

    <!-- Filter Bar -->
    <div class="filter-section">
        <div class="filter-group">
            <label for="searchTitle">Search Title</label>
            <input type="text" id="searchTitle" class="filter-input" placeholder="Title keywords...">
        </div>
        <div class="filter-group">
            <label for="searchTag">Search Tag</label>
            <input type="text" id="searchTag" class="filter-input" placeholder="#wellness...">
        </div>
        <div class="filter-group">
            <label for="filterCategory">Category</label>
            <select id="filterCategory" class="filter-input">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['name']); ?>"><?= htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label for="filterType">Type</label>
            <select id="filterType" class="filter-input">
                <option value="all">All Types</option>
                <option value="article">Article</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="filterStatus">Status</label>
            <select id="filterStatus" class="filter-input">
                <option value="all">Statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
        </div>
    </div>

    <!-- Resource Grid -->
    <?php if (!empty($resources)): ?>
        <div class="resources-grid">
            <?php foreach ($resources as $r): ?>
                <div class="resource-card" 
                     data-title="<?= htmlspecialchars(strtolower($r['title'])); ?>" 
                     data-tags="<?= htmlspecialchars(strtolower(isset($r['tags']) ? $r['tags'] : '')); ?>" 
                     data-category="<?= htmlspecialchars($r['category']); ?>" 
                     data-type="<?= htmlspecialchars($r['content_type']); ?>" 
                     data-status="<?= htmlspecialchars($r['status']); ?>">
                    
                    <div>
                        <div class="resource-meta">
                            <span class="res-badge res-badge-type"><?= ucfirst($r['content_type']); ?></span>
                            <span class="res-badge res-badge-cat"><?= htmlspecialchars($r['category']); ?></span>
                        </div>
                        <h3 style="margin-top:12px;"><?= htmlspecialchars($r['title']); ?></h3>
                    </div>
                    
                    <p class="resource-summary"><?= htmlspecialchars($r['summary']); ?></p>
                    
                    <!-- File Attachment Display -->
                    <?php if (!empty($r['file_path']) && !empty($r['file_name'])): ?>
                        <?php 
                        $fileExists = file_exists(BASE_PATH . '/public/' . $r['file_path']);
                        $icon = '📄';
                        if ($r['content_type'] === 'video') $icon = '🎥';
                        if ($r['content_type'] === 'audio') $icon = '🎵';
                        ?>
                        <div class="res-file-box">
                            <div class="res-file-icon"><?= $icon ?></div>
                            <div class="res-file-info">
                                <h4><?= htmlspecialchars($r['file_name']); ?></h4>
                                <p><?= !empty($r['file_size']) ? number_format($r['file_size'] / 1024 / 1024, 2) . ' MB' : 'Size unknown' ?></p>
                            </div>
                            <?php if ($fileExists): ?>
                                <a href="<?= BASE_URL . '/' . $r['file_path']; ?>" target="_blank" class="btn-icon" title="View File">
                                    <i class="fas fa-eye"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="res-file-box" style="background: var(--bg-mid); border-style: dashed;">
                            <div class="res-file-icon" style="opacity:0.5;"><i class="fas fa-font"></i></div>
                            <div class="res-file-info">
                                <h4>Text Resource Only</h4>
                                <p>No attachment</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="res-footer">
                        <span class="status-indicator status-<?= $r['status']; ?>">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                            <?= ucfirst($r['status']); ?>
                        </span>
                        
                        <div class="btn-group">
                            <a href="<?= BASE_URL ?>/Moderator/resource/edit?id=<?= $r['id']; ?>" class="btn-icon" title="Edit Metadata">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="<?= BASE_URL ?>/Moderator/resource/delete" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= (int)$r['id']; ?>">
                                <button type="submit" class="btn-icon btn-icon-danger" onclick="return confirm('Permanently delete this resource?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 60px 24px; color: var(--text-secondary);">
            <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i>
            <h3>No Resources Found</h3>
            <p>Your content library is currently empty. Start by adding a new resource.</p>
        </div>
    <?php endif; ?>
</div>

<script>
(function(){
    // Filtering Logic (Preserved and Adjusted)
    const filterInputs = {
        title: document.getElementById('searchTitle'),
        tag: document.getElementById('searchTag'),
        category: document.getElementById('filterCategory'),
        type: document.getElementById('filterType'),
        status: document.getElementById('filterStatus')
    };
    const resourceCards = document.querySelectorAll('.resource-card');

    function filterResources() {
        const filters = {
            title: filterInputs.title.value.toLowerCase(),
            tag: filterInputs.tag.value.toLowerCase(),
            category: filterInputs.category.value,
            type: filterInputs.type.value,
            status: filterInputs.status.value
        };

        resourceCards.forEach(card => {
            const cardData = {
                title: card.getAttribute('data-title'),
                tags: card.getAttribute('data-tags'),
                category: card.getAttribute('data-category'),
                type: card.getAttribute('data-type'),
                status: card.getAttribute('data-status')
            };

            const matchesTitle = cardData.title.includes(filters.title);
            const matchesTag = filters.tag === '' || cardData.tags.includes(filters.tag);
            const matchesCategory = filters.category === 'all' || cardData.category === filters.category;
            const matchesType = filters.type === 'all' || cardData.type === filters.type;
            const matchesStatus = filters.status === 'all' || cardData.status === filters.status;

            if (matchesTitle && matchesTag && matchesCategory && matchesType && matchesStatus) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    Object.values(filterInputs).forEach(input => {
        if(input) {
            input.addEventListener('input', filterResources);
            input.addEventListener('change', filterResources);
        }
    });
})();
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
