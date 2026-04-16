<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Resource Management</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
    <style>
        /* Enhanced UI Styles */
        .main-content { 
            padding: 2rem; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        header h1 { 
            margin: 0 0 1rem 0; 
            font-size: 2rem; 
            color: #1e293b;
            text-align: center;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        h2 { margin: 1.5rem 0 .75rem 0; font-size: 1.5rem; color: #1e293b; }

        .card { 
            background: #fff; 
            border: 1px solid #e5e7eb; 
            border-radius: 16px; 
            padding: 2rem; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .stack { display: grid; gap: 1.5rem; }
        .form-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; }
        .form-grid .full { grid-column: 1 / -1; }
        .form-group { display: grid; gap: 0.5rem; }
        .form-rows { display: grid; gap: 1rem; }
        .form-row { display: grid; grid-template-columns: 200px 1fr; align-items: center; gap: 1rem; }
        .form-row label { margin: 0; font-weight: 600; color: #374151; }

        label { font-weight: 600; color: #374151; font-size: 0.95rem; }
        
        input[type="text"], input[type="file"], select, textarea {
            width: 100%; 
            padding: 0.75rem 1rem; 
            border: 2px solid #e5e7eb; 
            border-radius: 12px; 
            font-size: 1rem; 
            outline: none;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        input[type="text"]:focus, input[type="file"]:focus, select:focus, textarea:focus {
            border-color: #3b82f6; 
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: #fff;
        }
        
        textarea { 
            min-height: 160px; 
            resize: vertical; 
            font-family: inherit;
        }

        .actions { 
            display: flex; 
            gap: 1rem; 
            justify-content: center; 
            margin-top: 2rem;
        }
        
        .btn { 
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem; 
            border-radius: 12px; 
            border: 2px solid transparent; 
            background: #3b82f6; 
            color: #fff; 
            cursor: pointer; 
            text-decoration: none; 
            font-size: 1rem; 
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
            justify-content: center;
        }
        
        .btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary { 
            background: #6b7280; 
            color: #fff;
        }
        
        .btn-secondary:hover {
            background: #4b5563;
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.3);
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .alert { 
            padding: 1rem 1.5rem; 
            border-radius: 12px; 
            margin: 1rem 0; 
            font-size: 1rem;
            border-left: 4px solid;
        }
        
        .alert.success { 
            background: linear-gradient(135deg, #ecfdf5, #d1fae5); 
            color: #065f46; 
            border-left-color: #10b981;
        }
        
        .alert.error { 
            background: linear-gradient(135deg, #fef2f2, #fecaca); 
            color: #991b1b; 
            border-left-color: #ef4444;
        }

        .resource { 
            display: grid; 
            grid-template-columns: 1fr auto;
            gap: 1rem; 
            align-items: center; 
            padding: 1.5rem; 
            border: 2px solid #e5e7eb; 
            border-radius: 16px; 
            background: linear-gradient(135deg, #fff, #f8fafc);
            transition: all 0.3s ease;
        }
        
        .resource:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.1);
        }
        
        .resource-summary { 
            color: #475569; 
            line-height: 1.6;
        }
        
        .resource-summary strong {
            color: #1e293b;
            font-size: 1.1rem;
        }
        
        .resource-actions {
            display: flex;
            gap: 0.5rem;
            flex-direction: column;
        }
        
        .section-divider { 
            height: 2px; 
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent); 
            margin: 2rem 0; 
            border: 0; 
        }

        /* Enhanced form wrapper */
        .form-wrapper { 
            max-width: 800px; 
            margin: 2rem auto; 
        }
        
        .section-header-bar { 
            background: linear-gradient(135deg, #1e3a8a, #1e40af); 
            color: #ffffff; 
            padding: 1.25rem 1.5rem; 
            border-radius: 16px 16px 0 0; 
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .section-header-bar h2 { 
            margin: 0; 
            color: #ffffff; 
            font-size: 1.5rem; 
            font-weight: 700;
        }
        
        .card.flush-top { 
            border-top-left-radius: 0; 
            border-top-right-radius: 0; 
        }
        
        .create-resource.card.flush-top { 
            min-height: 60vh; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }

        /* Resource grid for better display */
        .resources-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        /* Filter section styles */
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin: 1.5rem 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
            border: 1px solid #e5e7eb;
        }

        .filter-group {
            display: grid;
            gap: 0.5rem;
        }

        .filter-group label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
        }

        .filter-input {
            width: 100%;
            padding: 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }

        .filter-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .resource-card[style*="display: none"] {
            display: none !important;
        }

        .resource-card {
            background: linear-gradient(135deg, #fff, #f8fafc);
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .resource-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.15);
            transform: translateY(-4px);
        }

        .resource-meta {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .resource-type {
            background: #3b82f6;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .resource-category {
            background: #10b981;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* File upload styling */
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .file-upload-area.dragover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        /* Status indicators */
        .status-published { color: #10b981; font-weight: 600; }
        .status-draft { color: #f59e0b; font-weight: 600; }
        .status-archived { color: #6b7280; font-weight: 600; }

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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Moderator Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/Moderator/resource-hub" class="nav-item">
                <span class="icon">📚</span>
                Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <header><h1>Edit Resources</h1></header>



        <?php if (isset($_GET['created'])): ?>
            <div class="alert success">✅ Resource created successfully! It should now appear in the undergraduate resources section.</div>
        <?php elseif (isset($_GET['updated'])): ?>
            <div class="alert success">✅ Resource updated successfully!</div>
        <?php elseif (isset($_GET['deleted'])): ?>
            <div class="alert success">✅ Resource deleted successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert error">
                ❌ Error: 
                <?php 
                $error = isset($_GET['error']) ? $_GET['error'] : 'Unknown error';
                switch($error) {
                    case 'missing_fields':
                        echo 'Please provide all required fields.';
                        break;
                    case 'creation_failed':
                        echo 'Failed to create resource. Please try again.';
                        break;
                    default:
                        echo 'Please provide all fields.';
                }
                ?>
            </div>
        <?php endif; ?>

        <hr class="section-divider">
        
        <div class="section-header-bar">
            <h2>📚 Manage Resources</h2>
        </div>
        
        <section class="resources-management card flush-top">
            <div class="filter-section">
                <div class="filter-group">
                    <label for="searchTitle">Search Title</label>
                    <input type="text" id="searchTitle" class="filter-input" placeholder="Find by title...">
                </div>
                <div class="filter-group">
                    <label for="searchTag">Search Tag</label>
                    <input type="text" id="searchTag" class="filter-input" placeholder="e.g. #counselor">
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
                        <option value="all">All Statuses</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>

            <?php if (!empty($resources)): ?>
                <div class="resources-grid">
                    <?php foreach ($resources as $r): ?>
                        <div class="resource-card" 
                             data-title="<?= htmlspecialchars(strtolower($r['title'])); ?>" 
                             data-tags="<?= htmlspecialchars(strtolower(isset($r['tags']) ? $r['tags'] : '')); ?>" 
                             data-category="<?= htmlspecialchars($r['category']); ?>" 
                             data-type="<?= htmlspecialchars($r['content_type']); ?>" 
                             data-status="<?= htmlspecialchars($r['status']); ?>">
                            <div class="resource-header">
                                <h3><?= htmlspecialchars($r['title']); ?></h3>
                                <div class="resource-meta">
                                    <span class="resource-type"><?= ucfirst($r['content_type']); ?></span>
                                    <span class="resource-category"><?= htmlspecialchars($r['category']); ?></span>
                                </div>
                            </div>
                            
                            <div class="resource-content">
                                <p class="resource-summary"><?= htmlspecialchars($r['summary']); ?></p>
                                
                                <!-- Display uploaded file if exists -->
                                <?php if (!empty($r['file_path']) && !empty($r['file_name'])): ?>
                                    <div class="resource-file-display" style="margin: 1rem 0; padding: 1rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e5e7eb;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <?php 
                                            $fileExtension = strtolower(pathinfo($r['file_name'], PATHINFO_EXTENSION));
                                            $isImage = in_array($fileExtension, array('jpg', 'jpeg', 'png', 'gif', 'webp'));
                                            $fileExists = file_exists(BASE_PATH . '/public/' . $r['file_path']);
                                            ?>
                                            
                                            <?php if ($r['content_type'] === 'article' && $isImage && $fileExists): ?>
                                                <img src="<?= BASE_URL . '/' . $r['file_path']; ?>" alt="Resource image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;" />
                                            <?php else: ?>
                                                <div style="width: 80px; height: 80px; background: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                                    <?php if ($r['content_type'] === 'video'): ?>
                                                        🎥
                                                    <?php elseif ($r['content_type'] === 'audio'): ?>
                                                        🎵
                                                    <?php else: ?>
                                                        📄
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div style="flex: 1;">
                                                <h4 style="margin: 0 0 0.25rem 0; color: #1e293b; font-size: 1rem;">
                                                    <?= htmlspecialchars($r['file_name']); ?>
                                                    <?php if (!$fileExists): ?>
                                                        <span style="color: #ef4444; font-size: 0.8rem;">(File not found)</span>
                                                    <?php endif; ?>
                                                </h4>
                                                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                                                    <?php if (!empty($r['file_size'])): ?>
                                                        Size: <?= number_format($r['file_size'] / 1024 / 1024, 2); ?> MB | 
                                                    <?php endif; ?>
                                                    Type: <?= htmlspecialchars(isset($r['file_type']) ? $r['file_type'] : 'Unknown'); ?>
                                                </p>
                                            </div>
                                            
                                            <?php if ($fileExists): ?>
                                                <a href="<?= BASE_URL . '/' . $r['file_path']; ?>" target="_blank" class="btn btn-primary btn-small" style="padding: 0.5rem 1rem; font-size: 0.9rem; min-width: auto;">
                                                    👁️ View
                                                </a>
                                            <?php else: ?>
                                                <span style="color: #ef4444; font-size: 0.9rem; padding: 0.5rem;">File Missing</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div style="margin: 1rem 0; padding: 1rem; background: #fef3c7; border-radius: 8px; border: 1px solid #f59e0b; color: #92400e;">
                                        <strong>📄 Text Content Only</strong> - No file attached
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($r['tags'])): ?>
                                    <div class="resource-tags" style="margin: 0.5rem 0;">
                                        <strong>Tags:</strong> <?= htmlspecialchars($r['tags']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="resource-status" style="margin: 0.5rem 0;">
                                    <strong>Status:</strong> 
                                    <span class="status-<?= $r['status']; ?>">
                                        <?= ucfirst($r['status']); ?>
                                    </span>
                                </div>
                                
                                <div class="resource-dates" style="margin: 0.5rem 0; font-size: 0.9rem; color: #6b7280;">
                                    <small>Created: <?= date('M j, Y', strtotime($r['created_at'])); ?></small>
                                    <?php if ($r['updated_at'] !== $r['created_at']): ?>
                                        <br><small>Updated: <?= date('M j, Y', strtotime($r['updated_at'])); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="resource-actions">
                                <a href="<?= BASE_URL ?>/Moderator/resource/edit?id=<?= $r['id']; ?>" class="btn btn-primary">
                                    ✏️ Edit
                                </a>
                                <form action="<?= BASE_URL ?>/Moderator/resource/delete" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= (int)$r['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this resource?')">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state" style="text-align: center; padding: 3rem; color: #6b7280;">
                    <h3>📚 No Resources Yet</h3>
                    <p>Click the "Add New Resource" button to get started!</p>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
    <script>
    (function(){
        // Auto-resize textareas
        var textareas = document.querySelectorAll('textarea');
        textareas.forEach(function(textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
        
        // Filtering Logic
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
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Add event listeners to all filters
        Object.values(filterInputs).forEach(input => {
            input.addEventListener('input', filterResources);
            input.addEventListener('change', filterResources);
        });
    })();
    </script>
</body>
</html>
