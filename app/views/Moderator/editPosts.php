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
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
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
                <!-- <span class="icon"></span> -->
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item active">
                <!-- <span class="icon">✏️</span> -->
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <!-- <span class="icon">🚩</span> -->
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <!-- <span class="icon">⚠️</span> -->
                Warn Users
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

        <div class="form-wrapper">
            <div class="section-header-bar">
                <h2>📚 Create New Resource</h2>
            </div>
            <section class="create-resource card flush-top stack">
                <form id="addPostForm" action="<?= BASE_URL ?>/Moderator/resource/create" method="POST" enctype="multipart/form-data" class="stack">
                    <div class="form-rows">
                        <div class="form-row">
                            <label for="postName">Resource Title</label>
                            <input id="postName" type="text" name="title" placeholder="Enter a descriptive title for your resource" required>
                        </div>
                        
                        <div class="form-row">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="Mental Health Basics">Mental Health Basics</option>
                                <option value="Anxiety & Stress">Anxiety & Stress</option>
                                <option value="Depression Support">Depression Support</option>
                                <option value="Mindfulness & Meditation">Mindfulness & Meditation</option>
                                <option value="Sleep & Wellness">Sleep & Wellness</option>
                                <option value="Relationships & Social">Relationships & Social</option>
                                <option value="Crisis Support">Crisis Support</option>
                                <option value="Self-Help Tools">Self-Help Tools</option>
                                <option value="Professional Development">Professional Development</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="contentTypeSelect">Content Type</label>
                            <select name="content_type" id="contentTypeSelect" required>
                                <option value="">Select content type</option>
                                <option value="article">📝 Article</option>
                                <option value="video">🎥 Video</option>
                                <option value="audio">🎵 Audio</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="summary">Summary</label>
                            <textarea id="summary" name="summary" rows="3" placeholder="Brief description of what this resource covers..." required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <label for="tags">Tags</label>
                            <input id="tags" type="text" name="tags" placeholder="Enter tags separated by commas (e.g., anxiety, stress, coping)" />
                        </div>
                        
                        <div class="form-row">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="draft">📝 Draft</option>
                                <option value="published">✅ Published</option>
                                <option value="archived">📦 Archived</option>
                            </select>
                        </div>
                    </div>

                <div id="articleFields" class="stack card" style="display:none;">
                        <h3>📝 Article Content</h3>
                    <div class="form-group">
                            <label for="articleImage">🖼️ Featured Image</label>
                            <div class="file-upload-area" id="articleImageUpload">
                                <input id="articleImage" type="file" name="article_image" accept="image/*" style="display: none;">
                                <p>📁 Click to upload or drag and drop an image</p>
                                <small>Recommended: 1200x630px, max 5MB</small>
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="articleContent">Article Content</label>
                            <textarea id="articleContent" name="content" rows="12" placeholder="Write your article content here. You can use basic HTML formatting..."></textarea>
                        </div>
                </div>

                <div id="videoFields" class="stack card" style="display:none;">
                        <h3>🎥 Video Content</h3>
                        <div class="form-group">
                            <label for="videoFile">🎬 Upload Video</label>
                            <div class="file-upload-area" id="videoFileUpload">
                                <input id="videoFile" type="file" name="video_file" accept="video/*" style="display: none;">
                                <p>📁 Click to upload or drag and drop a video file</p>
                                <small>Supported formats: MP4, AVI, MOV. Max size: 100MB</small>
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="videoDescription">Video Description</label>
                            <textarea id="videoDescription" name="content" rows="6" placeholder="Describe what this video covers and any key points..."></textarea>
                        </div>
                </div>

                <div id="audioFields" class="stack card" style="display:none;">
                        <h3>🎵 Audio Content</h3>
                        <div class="form-group">
                            <label for="audioFile">🎧 Upload Audio</label>
                            <div class="file-upload-area" id="audioFileUpload">
                                <input id="audioFile" type="file" name="audio_file" accept="audio/*" style="display: none;">
                                <p>📁 Click to upload or drag and drop an audio file</p>
                                <small>Supported formats: MP3, WAV, M4A. Max size: 50MB</small>
                            </div>
                        </div>
                    <div class="form-group">
                            <label for="audioDescription">Audio Description</label>
                            <textarea id="audioDescription" name="content" rows="6" placeholder="Describe what this audio covers and any key points..."></textarea>
                        </div>
                </div>

                <div class="actions">
                        <button class="btn btn-secondary" type="reset">
                            🗑️ Clear Form
                        </button>
                        <button class="btn btn-primary" type="submit">
                            💾 Create Resource
                        </button>
                </div>
                </form>
            </section>
        </div>

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
                $error = $_GET['error'] ?? 'Unknown error';
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
            <?php if (!empty($resources)): ?>
                <div class="resources-grid">
                    <?php foreach ($resources as $r): ?>
                        <div class="resource-card">
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
                                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            $fileExists = file_exists(BASE_PATH . '/public' . $r['file_path']);
                                            ?>
                                            
                                            <?php if ($r['content_type'] === 'article' && $isImage && $fileExists): ?>
                                                <img src="<?= BASE_URL . $r['file_path']; ?>" alt="Resource image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;" />
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
                                                    Type: <?= htmlspecialchars($r['file_type'] ?? 'Unknown'); ?>
                                                </p>
                                            </div>
                                            
                                            <?php if ($fileExists): ?>
                                                <a href="<?= BASE_URL . $r['file_path']; ?>" target="_blank" class="btn btn-primary btn-small" style="padding: 0.5rem 1rem; font-size: 0.9rem; min-width: auto;">
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
                    <p>Create your first resource using the form above to get started!</p>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
    <script>
    (function(){
        // Content type visibility management
        var select = document.getElementById('contentTypeSelect');
        var article = document.getElementById('articleFields');
        var video = document.getElementById('videoFields');
        var audio = document.getElementById('audioFields');
        
        function updateVisibility(){
            var v = select.value;
            article.style.display = (v === 'article') ? 'block' : 'none';
            video.style.display = (v === 'video') ? 'block' : 'none';
            audio.style.display = (v === 'audio') ? 'block' : 'none';
        }
        
        if (select) {
            select.addEventListener('change', updateVisibility);
            updateVisibility();
        }
        
        // Form reset handling
        var form = document.getElementById('addPostForm');
        if (form) {
            form.addEventListener('reset', function(){
                setTimeout(updateVisibility, 0);
            });
        }
        
        // Enhanced file upload areas
        function setupFileUpload(uploadAreaId, fileInputId) {
            var uploadArea = document.getElementById(uploadAreaId);
            var fileInput = document.getElementById(fileInputId);
            
            if (uploadArea && fileInput) {
                uploadArea.addEventListener('click', function() {
                    fileInput.click();
                });
                
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    uploadArea.classList.add('dragover');
                });
                
                uploadArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                });
                
                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    uploadArea.classList.remove('dragover');
                    var files = e.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        updateFileDisplay(fileInput);
                    }
                });
                
                fileInput.addEventListener('change', function() {
                    updateFileDisplay(fileInput);
                });
            }
        }
        
        function updateFileDisplay(fileInput) {
            var uploadArea = fileInput.parentElement;
            if (fileInput.files.length > 0) {
                var fileName = fileInput.files[0].name;
                var fileSize = (fileInput.files[0].size / 1024 / 1024).toFixed(2);
                uploadArea.innerHTML = `
                    <p>✅ <strong>${fileName}</strong> (${fileSize} MB)</p>
                    <small>Click to change file</small>
                `;
            }
        }
        
        // Setup file upload areas
        setupFileUpload('articleImageUpload', 'articleImage');
        setupFileUpload('videoFileUpload', 'videoFile');
        setupFileUpload('audioFileUpload', 'audioFile');
        
        // Form validation
        form.addEventListener('submit', function(e) {
            var contentType = select.value;
            var isValid = true;
            var errorMessage = '';
            
            if (!contentType) {
                isValid = false;
                errorMessage = 'Please select a content type.';
            } else {
                if (contentType === 'article') {
                    var content = document.getElementById('articleContent').value.trim();
                    if (!content) {
                        isValid = false;
                        errorMessage = 'Please provide article content.';
                    }
                } else if (contentType === 'video') {
                    var videoFile = document.getElementById('videoFile').files.length;
                    var videoContent = document.getElementById('videoDescription').value.trim();
                    if (!videoFile && !videoContent) {
                        isValid = false;
                        errorMessage = 'Please provide video file or description.';
                    }
                } else if (contentType === 'audio') {
                    var audioFile = document.getElementById('audioFile').files.length;
                    var audioContent = document.getElementById('audioDescription').value.trim();
                    if (!audioFile && !audioContent) {
                        isValid = false;
                        errorMessage = 'Please provide audio file or description.';
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('❌ ' + errorMessage);
            }
        });
        
        // Auto-resize textareas
        var textareas = document.querySelectorAll('textarea');
        textareas.forEach(function(textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
        
        // Add loading state to submit button
        form.addEventListener('submit', function() {
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '⏳ Creating Resource...';
                submitBtn.disabled = true;
            }
        });
        
    })();
    </script>
</body>
</html>
