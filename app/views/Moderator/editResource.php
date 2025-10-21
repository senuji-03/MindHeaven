
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Edit Resource</title>
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

        /* Current file display */
        .current-file {
            background: #f0f9ff;
            border: 2px solid #3b82f6;
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .current-file img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .current-file-info {
            flex: 1;
        }

        .current-file-info h4 {
            margin: 0 0 0.5rem 0;
            color: #1e293b;
        }

        .current-file-info p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .file-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            min-width: auto;
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
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item active">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <span class="icon">🚩</span>
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <span class="icon">⚠️</span>
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
        <header><h1>✏️ Edit Resource</h1></header>

        <div class="form-wrapper">
            <div class="section-header-bar">
                <h2>📝 Update Resource: <?= htmlspecialchars($resource['title']); ?></h2>
            </div>
            <section class="create-resource card flush-top stack">
                <form id="editResourceForm" action="<?= BASE_URL ?>/Moderator/resource/update" method="POST" enctype="multipart/form-data" class="stack">
                    <input type="hidden" name="id" value="<?= $resource['id']; ?>">
                    
                    <div class="form-rows">
                        <div class="form-row">
                            <label for="title">📝 Resource Title</label>
                            <input id="title" type="text" name="title" value="<?= htmlspecialchars($resource['title']); ?>" placeholder="Enter a descriptive title for your resource" required>
                        </div>
                        
                        <div class="form-row">
                            <label for="category">🏷️ Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="Mental Health Basics" <?= $resource['category'] === 'Mental Health Basics' ? 'selected' : '' ?>>Mental Health Basics</option>
                                <option value="Anxiety & Stress" <?= $resource['category'] === 'Anxiety & Stress' ? 'selected' : '' ?>>Anxiety & Stress</option>
                                <option value="Depression Support" <?= $resource['category'] === 'Depression Support' ? 'selected' : '' ?>>Depression Support</option>
                                <option value="Mindfulness & Meditation" <?= $resource['category'] === 'Mindfulness & Meditation' ? 'selected' : '' ?>>Mindfulness & Meditation</option>
                                <option value="Sleep & Wellness" <?= $resource['category'] === 'Sleep & Wellness' ? 'selected' : '' ?>>Sleep & Wellness</option>
                                <option value="Relationships & Social" <?= $resource['category'] === 'Relationships & Social' ? 'selected' : '' ?>>Relationships & Social</option>
                                <option value="Crisis Support" <?= $resource['category'] === 'Crisis Support' ? 'selected' : '' ?>>Crisis Support</option>
                                <option value="Self-Help Tools" <?= $resource['category'] === 'Self-Help Tools' ? 'selected' : '' ?>>Self-Help Tools</option>
                                <option value="Professional Development" <?= $resource['category'] === 'Professional Development' ? 'selected' : '' ?>>Professional Development</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="contentTypeSelect">📄 Content Type</label>
                            <select name="content_type" id="contentTypeSelect" required>
                                <option value="">Select content type</option>
                                <option value="article" <?= $resource['content_type'] === 'article' ? 'selected' : '' ?>>📝 Article</option>
                                <option value="video" <?= $resource['content_type'] === 'video' ? 'selected' : '' ?>>🎥 Video</option>
                                <option value="audio" <?= $resource['content_type'] === 'audio' ? 'selected' : '' ?>>🎵 Audio</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="summary">📋 Summary</label>
                            <textarea id="summary" name="summary" rows="3" placeholder="Brief description of what this resource covers..." required><?= htmlspecialchars($resource['summary']); ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <label for="tags">🏷️ Tags</label>
                            <input id="tags" type="text" name="tags" value="<?= htmlspecialchars($resource['tags']); ?>" placeholder="Enter tags separated by commas (e.g., anxiety, stress, coping)" />
                        </div>
                        
                        <div class="form-row">
                            <label for="status">📊 Status</label>
                            <select name="status" id="status">
                                <option value="draft" <?= $resource['status'] === 'draft' ? 'selected' : '' ?>>📝 Draft</option>
                                <option value="published" <?= $resource['status'] === 'published' ? 'selected' : '' ?>>✅ Published</option>
                                <option value="archived" <?= $resource['status'] === 'archived' ? 'selected' : '' ?>>📦 Archived</option>
                            </select>
                        </div>
                    </div>

                    <!-- Current File Display -->
                    <?php if (!empty($resource['file_path']) && !empty($resource['file_name'])): ?>
                        <div class="current-file">
                            <?php if ($resource['content_type'] === 'article' && in_array(strtolower(pathinfo($resource['file_name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                                <img src="<?= BASE_URL . $resource['file_path']; ?>" alt="Current image" />
                            <?php else: ?>
                                <div style="width: 100px; height: 100px; background: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    <?= $resource['content_type'] === 'video' ? '🎥' : '🎵'; ?>
                                </div>
                            <?php endif; ?>
                            <div class="current-file-info">
                                <h4><?= htmlspecialchars($resource['file_name']); ?></h4>
                                <p>Size: <?= number_format($resource['file_size'] / 1024 / 1024, 2); ?> MB | Type: <?= htmlspecialchars($resource['file_type']); ?></p>
                            </div>
                            <div class="file-actions">
                                <a href="<?= BASE_URL . $resource['file_path']; ?>" target="_blank" class="btn btn-primary btn-small">👁️ View</a>
                                <button type="button" class="btn btn-secondary btn-small" onclick="removeCurrentFile()">🗑️ Remove</button>
                            </div>
                        </div>
                    <?php endif; ?>

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
                            <label for="articleContent">📄 Article Content</label>
                            <textarea id="articleContent" name="content" rows="12" placeholder="Write your article content here. You can use basic HTML formatting..."><?= htmlspecialchars($resource['content']); ?></textarea>
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
                            <label for="videoDescription">📝 Video Description</label>
                            <textarea id="videoDescription" name="content" rows="6" placeholder="Describe what this video covers and any key points..."><?= htmlspecialchars($resource['content']); ?></textarea>
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
                            <label for="audioDescription">📝 Audio Description</label>
                            <textarea id="audioDescription" name="content" rows="6" placeholder="Describe what this audio covers and any key points..."><?= htmlspecialchars($resource['content']); ?></textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="<?= BASE_URL ?>/EditPosts" class="btn btn-secondary">
                            ← Back to Resources
                        </a>
                        <button class="btn btn-primary" type="submit">
                            💾 Update Resource
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert success">✅ Resource updated successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert error">❌ Error updating resource. Please try again.</div>
        <?php endif; ?>
    </div>

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
            updateVisibility(); // Initialize on page load
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
        
        // Remove current file function
        window.removeCurrentFile = function() {
            if (confirm('Are you sure you want to remove the current file?')) {
                var currentFile = document.querySelector('.current-file');
                if (currentFile) {
                    currentFile.style.display = 'none';
                }
            }
        };
        
        // Form validation
        var form = document.getElementById('editResourceForm');
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
                submitBtn.innerHTML = '⏳ Updating Resource...';
                submitBtn.disabled = true;
            }
        });
        
    })();
    </script>
</body>
</html>
