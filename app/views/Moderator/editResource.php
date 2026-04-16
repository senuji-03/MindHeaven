<?php 
$TITLE = 'Edit Resource';
$CURRENT_PAGE = 'EditPosts';
require BASE_PATH . '/app/views/layouts/header.php'; 
?>

<style>
    /* ── EDIT RESOURCE PAGE STYLES ── */
    .edit-page-container {
        padding: 40px;
        background: var(--surface);
    }
</style>

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
                            <label for="title">Resource Title</label>
                            <input id="title" type="text" name="title" value="<?= htmlspecialchars($resource['title']); ?>" placeholder="Enter a descriptive title for your resource" required>
                        </div>
                        
                        <div class="form-row">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['name']) ?>" <?= $resource['category'] === $cat['name'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="contentTypeSelect">Content Type</label>
                            <select name="content_type" id="contentTypeSelect" required>
                                <option value="">Select content type</option>
                                <option value="article" <?= $resource['content_type'] === 'article' ? 'selected' : '' ?>>📝 Article</option>
                                <option value="video" <?= $resource['content_type'] === 'video' ? 'selected' : '' ?>>🎥 Video</option>
                                <option value="audio" <?= $resource['content_type'] === 'audio' ? 'selected' : '' ?>>🎵 Audio</option>
                            </select>
                        </div>
                        
                        <div class="form-row">
                            <label for="summary">Summary (Optional)</label>
                            <textarea id="summary" name="summary" rows="3" placeholder="Brief description of what this resource covers..."><?= htmlspecialchars($resource['summary']); ?></textarea>
                        </div>
                        
                        <div class="form-row">
                            <label for="tags">Tags</label>
                            <input id="tags" type="text" name="tags" value="<?= htmlspecialchars($resource['tags']); ?>" placeholder="Enter tags separated by commas (e.g., anxiety, stress, coping)" />
                        </div>
                        
                        <div class="form-row">
                            <label for="status">Status</label>
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
                            <?php 
                            $fileExt = strtolower(pathinfo($resource['file_name'], PATHINFO_EXTENSION));
                            if ($resource['content_type'] === 'article' && in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif', 'webp'))): 
                            ?>
                                <img src="<?= BASE_URL . '/' . $resource['file_path']; ?>" alt="Current image" />
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
                                <a href="<?= BASE_URL . '/' . $resource['file_path']; ?>" target="_blank" class="btn btn-primary btn-small">👁️ View</a>
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
                                <p>📁 Click to upload or drag and drop an image (Max 2MB)</p>
                                <small>Recommended: 1200x630px, max 5MB</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="articleContent">📄 Article Content</label>
                            <textarea id="articleContent" name="article_content" rows="12" placeholder="Write your article content here. You can use basic HTML formatting..."><?= htmlspecialchars($resource['content']); ?></textarea>
                        </div>
                    </div>

                    <div id="videoFields" class="stack card" style="display:none;">
                        <h3>🎥 Video Content</h3>
                        <div class="form-group">
                            <label for="videoFile">🎬 Upload Video File (optional)</label>
                            <div class="file-upload-area" id="videoFileUpload">
                                <input id="videoFile" type="file" name="video_file" accept="video/*" style="display: none;">
                                <p>📁 Click to upload or drag and drop a video file (Max 2MB)</p>
                                <small>Supported formats: MP4, AVI, MOV. Max size: 100MB</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="youtubeUrl">🔗 YouTube Link (optional)</label>
                            <input id="youtubeUrl" type="url" name="youtube_url" value="<?= htmlspecialchars(isset($resource['youtube_url']) ? $resource['youtube_url'] : '') ?>" placeholder="https://www.youtube.com/watch?v=..." />
                            <small style="color:#6b7280;">If provided, clicking the resource card will open YouTube directly.</small>
                        </div>
                        <div class="form-group">
                            <label for="videoDescription">Video Description</label>
                            <textarea id="videoDescription" name="video_content" rows="6" placeholder="Describe what this video covers and any key points..."><?= htmlspecialchars($resource['content']); ?></textarea>
                        </div>
                    </div>

                    <div id="audioFields" class="stack card" style="display:none;">
                        <h3>🎵 Audio Content</h3>
                        <div class="form-group">
                            <label for="audioFile">🎧 Upload Audio</label>
                            <div class="file-upload-area" id="audioFileUpload">
                                <input id="audioFile" type="file" name="audio_file" accept="audio/*" style="display: none;">
                                <p>📁 Click to upload or drag and drop an audio file (Max 2MB)</p>
                                <small>Supported formats: MP3, WAV, M4A. Max size: 50MB</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="audioDescription">Audio Description</label>
                            <textarea id="audioDescription" name="audio_content" rows="6" placeholder="Describe what this audio covers and any key points..."><?= htmlspecialchars($resource['content']); ?></textarea>
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
                uploadArea.addEventListener('click', function(e) {
                    if (e.target !== fileInput) fileInput.click();
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
                var file = fileInput.files[0];
                var fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                
                if (file.size > 2 * 1024 * 1024) {
                    uploadArea.removeChild(fileInput);
                    uploadArea.innerHTML = `<p style="color:#ef4444;">❌ <strong>File too large (${fileSizeMB} MB)</strong></p><small>Max limit is 2MB. Click to try another file.</small>`;
                    uploadArea.appendChild(fileInput);
                    fileInput.value = "";
                    return;
                }

                var fileName = file.name;
                // Move the input OUT before touching innerHTML, then put it back
                uploadArea.removeChild(fileInput);
                uploadArea.innerHTML = `<p>✅ <strong>${fileName}</strong> (${fileSizeMB} MB)</p><small>Click to change file</small>`;
                uploadArea.appendChild(fileInput);
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
        
        // Form validation + loading state (single submit listener)
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
                    // Article content is optional now
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
                return;
            }

            // Valid — show loading state
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '⏳ Updating Resource...';
                submitBtn.disabled = true;
            }
        });
        
    })();
    </script>
<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>

