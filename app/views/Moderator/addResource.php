<?php 
$TITLE = 'Add New Resource';
$CURRENT_PAGE = 'resource-hub';
require BASE_PATH . '/app/views/layouts/header.php'; 
?>

<style>

    /* ── FORM LAYOUT ── */
    .form-wrapper {
        max-width: 860px;
        margin: 0 auto 60px;
    }

    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 0 4px;
    }

    .card-header-flex h2 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mod-form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-md);
    }

    .form-rows {
        display: grid;
        gap: 24px;
    }

    .form-group-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        align-items: flex-start;
        gap: 24px;
    }

    .form-group-row label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-secondary);
        margin-top: 12px;
    }

    /* ── INPUTS ── */
    .form-input-lib {
        width: 100%;
        padding: 12px 16px;
        border: 1.8px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 1rem;
        background: var(--bg-mid);
        transition: all 0.25s ease;
        outline: none;
        color: var(--text-primary);
    }

    .form-input-lib:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 5px rgba(61, 139, 110, 0.12);
    }

    textarea.form-input-lib {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    /* ── CONTENT TYPE SUB-CARDS ── */
    .type-fields-card {
        background: var(--bg-soft);
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 32px;
        margin-top: 32px;
        display: none; /* Controlled by JS */
    }

    .type-fields-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── UPLOAD AREA ── */
    .upload-box {
        background: #fff;
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 40px 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-secondary);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .upload-box:hover {
        border-color: var(--primary);
        background: var(--bg-mid);
        color: var(--primary);
    }

    .upload-box i {
        font-size: 2rem;
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .upload-box:hover i {
        opacity: 1;
        transform: translateY(-4px);
    }

    .upload-box strong {
        color: var(--primary);
        word-break: break-all;
    }

    /* ── ALERTS ── */
    .alert-box {
        padding: 18px 24px;
        border-radius: var(--radius-md);
        margin-bottom: 32px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        border-left: 4px solid;
    }

    .alert-success { background: var(--bg-mid); color: #1e3a34; border-left-color: var(--success); }
    .alert-error { background: rgba(214, 79, 79, 0.05); color: #7f1d1d; border-left-color: var(--crisis); }

    /* ── ACTIONS ── */
    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
        margin-top: 48px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-group-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        .form-group-row label {
            margin-top: 0;
        }
        .mod-form-card {
            padding: 24px;
        }
    }
</style>

<div class="main-content" style="padding: 40px; background: var(--surface);">
    <div class="add-page-header">
        <h1>Add New Resource</h1>
        <p>Curate high-quality wellness materials for the Mind Heaven community. Select your content type and fill out the details below.</p>
    </div>

    <div class="form-wrapper">
        <!-- Status Alerts -->
        <?php if (isset($_GET['created'])): ?>
            <div class="alert-box alert-success">
                <i class="fas fa-check-circle"></i> Resource added successfully to the library!
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert-box alert-error">
                <i class="fas fa-triangle-exclamation"></i> Error: <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <div class="card-header-flex">
            <h2><i class="fas fa-book-medical" style="color:var(--primary);"></i> Resource Details</h2>
            <a href="<?= BASE_URL ?>/resource-categories" class="btn btn-outline" style="border-radius: var(--radius-full); font-size: 0.85rem; padding: 8px 16px;">
                <i class="fas fa-tags"></i> Manage Categories
            </a>
        </div>

        <div class="mod-form-card">
            <form id="addPostForm" action="<?= BASE_URL ?>/Moderator/resource/create" method="POST" enctype="multipart/form-data">
                <div class="form-rows">
                    <div class="form-group-row">
                        <label for="postName">Title</label>
                        <input id="postName" type="text" name="title" class="form-input-lib" placeholder="e.g. Managing Daily Stress" required>
                    </div>

                    <div class="form-group-row">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-input-lib" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group-row">
                        <label for="contentTypeSelect">Content Type</label>
                        <select name="content_type" id="contentTypeSelect" class="form-input-lib" required>
                            <option value="">Select format</option>
                            <option value="article">📝 Article</option>
                            <option value="video">🎥 Video</option>
                            <option value="audio">🎵 Audio</option>
                        </select>
                    </div>

                    <div class="form-group-row">
                        <label for="summary">Summary</label>
                        <textarea id="summary" name="summary" class="form-input-lib" rows="3" placeholder="Briefly describe what students will learn..."></textarea>
                    </div>

                    <div class="form-group-row">
                        <label for="tags">Keywords/Tags</label>
                        <input id="tags" type="text" name="tags" class="form-input-lib" placeholder="stress-relief, meditation, anxiety" />
                    </div>

                    <div class="form-group-row">
                        <label for="status">Publish Status</label>
                        <select name="status" id="status" class="form-input-lib">
                            <option value="draft">Draft (Private)</option>
                            <option value="published">Published (Public)</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <!-- Type Specific Sections (Dynamic) -->
                    
                    <!-- Article Fields -->
                    <div id="articleFields" class="type-fields-card">
                        <h3><i class="fas fa-file-lines"></i> Article Content</h3>
                        <div class="form-rows">
                            <div class="form-group-row">
                                <label>Featured Image</label>
                                <div class="upload-box" id="articleImageUpload">
                                    <i class="fas fa-image"></i>
                                    <span>Click to upload header image (Max 2MB)</span>
                                    <input id="articleImage" type="file" name="article_image" accept="image/*" style="display: none;">
                                </div>
                            </div>
                            <div class="form-group-row">
                                <label for="articleContent">Text Body</label>
                                <textarea id="articleContent" name="article_content" class="form-input-lib" rows="12" placeholder="Write or paste your article content here..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Video Fields -->
                    <div id="videoFields" class="type-fields-card">
                        <h3><i class="fas fa-video"></i> Video Content</h3>
                        <div class="form-rows">
                            <div class="form-group-row">
                                <label>Video File</label>
                                <div class="upload-box" id="videoFileUpload">
                                    <i class="fas fa-clapperboard"></i>
                                    <span>Click to upload video file (Max 2MB)</span>
                                    <input id="videoFile" type="file" name="video_file" accept="video/*" style="display: none;">
                                </div>
                            </div>
                            <div class="form-group-row" style="padding: 12px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); margin: 8px 0;">
                                <div style="text-align: center; width: 100%; color: var(--text-secondary); font-size: 0.85rem; font-weight: 700;">OR USE YOUTUBE</div>
                            </div>
                            <div class="form-group-row">
                                <label for="youtubeUrl">YouTube Link</label>
                                <input id="youtubeUrl" type="url" name="youtube_url" class="form-input-lib" placeholder="https://youtube.com/watch?v=..." />
                            </div>
                            <div class="form-group-row">
                                <label for="videoDescription">Description</label>
                                <textarea id="videoDescription" name="video_content" class="form-input-lib" rows="6" placeholder="Additional details about the video..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Audio Fields -->
                    <div id="audioFields" class="type-fields-card">
                        <h3><i class="fas fa-headphones"></i> Audio Content</h3>
                        <div class="form-rows">
                            <div class="form-group-row">
                                <label>Audio File</label>
                                <div class="upload-box" id="audioFileUpload">
                                    <i class="fas fa-microphone-lines"></i>
                                    <span>Click to upload audio/podcast file (Max 2MB)</span>
                                    <input id="audioFile" type="file" name="audio_file" accept="audio/*" style="display: none;">
                                </div>
                            </div>
                            <div class="form-group-row">
                                <label for="audioDescription">Description</label>
                                <textarea id="audioDescription" name="audio_content" class="form-input-lib" rows="6" placeholder="Additional details about the audio content..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-outline" type="reset" style="border-radius: var(--radius-full); padding: 12px 32px;">
                            <i class="fas fa-rotate-left"></i> Reset Form
                        </button>
                        <button class="btn btn-primary" type="submit" id="submitBtn" style="border-radius: var(--radius-full); padding: 12px 40px; box-shadow: var(--shadow-md);">
                            <i class="fas fa-save"></i> Create Resource
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function(){
    const select = document.getElementById('contentTypeSelect');
    const sections = {
        article: document.getElementById('articleFields'),
        video: document.getElementById('videoFields'),
        audio: document.getElementById('audioFields')
    };
    
    function updateVisibility(){
        Object.keys(sections).forEach(key => {
            if(sections[key]) {
                sections[key].style.display = (select.value === key) ? 'block' : 'none';
            }
        });
    }
    
    select.addEventListener('change', updateVisibility);
    document.getElementById('addPostForm').addEventListener('reset', () => setTimeout(updateVisibility, 0));

    // File upload logic
    function setupFile(areaId, inputId, defaultText) {
        const area = document.getElementById(areaId);
        const input = document.getElementById(inputId);
        if(!area || !input) return;

        area.onclick = (e) => {
            if(e.target !== input) input.click();
        };
        input.onchange = () => {
            if (input.files.length > 0) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (file.size > maxSize) {
                    area.removeChild(input);
                    area.innerHTML = `<i class="fas fa-circle-exclamation" style="color:var(--crisis); opacity:1;"></i> <strong style="color:var(--crisis);">File too large (${(file.size/1024/1024).toFixed(2)}MB)</strong> <span style="font-size:0.8rem; display:block; margin-top:4px;">Max limit is 2MB</span>`;
                    area.style.borderColor = 'var(--crisis)';
                    area.style.background = 'rgba(214, 79, 79, 0.05)';
                    area.appendChild(input);
                    input.value = ""; // Clear the input
                    return;
                }

                area.removeChild(input);
                area.innerHTML = `<i class="fas fa-file-circle-check" style="color:var(--success); opacity:1;"></i> <strong>${file.name}</strong> <span style="font-size:0.8rem; display:block; margin-top:4px;">Click to change</span>`;
                area.style.borderColor = 'var(--success)';
                area.style.background = 'rgba(61, 139, 110, 0.05)';
                area.appendChild(input);
            } else {
                area.removeChild(input);
                area.innerHTML = `<i class="fas fa-upload"></i> <span>${defaultText}</span>`;
                area.style.borderColor = 'var(--border)';
                area.style.background = '#fff';
                area.appendChild(input);
            }
        };
    }
    setupFile('articleImageUpload', 'articleImage', 'Click to upload header image');
    setupFile('videoFileUpload', 'videoFile', 'Click to upload video file');
    setupFile('audioFileUpload', 'audioFile', 'Click to upload audio/podcast file');

    document.getElementById('addPostForm').onsubmit = function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;
    };
})();
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
