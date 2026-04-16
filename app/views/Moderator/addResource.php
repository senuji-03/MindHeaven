<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator - Add Resource</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
    <style>
        /* Shared Styles from EditPosts */
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
        
        .card { 
            background: #fff; 
            border: 1px solid #e5e7eb; 
            border-radius: 16px; 
            padding: 2rem; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stack { display: grid; gap: 1.5rem; }
        .form-rows { display: grid; gap: 1rem; }
        .form-row { display: grid; grid-template-columns: 200px 1fr; align-items: center; gap: 1rem; }
        .form-row label { margin: 0; font-weight: 600; color: #374151; }
        
        input[type="text"], input[type="file"], select, textarea {
            width: 100%; 
            padding: 0.75rem 1rem; 
            border: 2px solid #e5e7eb; 
            border-radius: 12px; 
            font-size: 1rem; 
            outline: none;
            background: #fafafa;
        }
        
        textarea { min-height: 160px; resize: vertical; }

        .actions { display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; }
        
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
            font-weight: 600;
            min-width: 120px;
            justify-content: center;
        }
        
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .btn-secondary { background: #6b7280; }

        .form-wrapper { max-width: 800px; margin: 2rem auto; }
        
        .section-header-bar { 
            background: linear-gradient(135deg, #1e3a8a, #1e40af); 
            color: #ffffff; 
            padding: 1.25rem 1.5rem; 
            border-radius: 16px 16px 0 0; 
        }
        
        .section-header-bar h2 { margin: 0; color: #ffffff; font-size: 1.5rem; font-weight: 700; }
        .card.flush-top { border-top-left-radius: 0; border-top-right-radius: 0; }

        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f8fafc;
        }

        .alert { padding: 1rem 1.5rem; border-radius: 12px; margin: 1rem 0; font-size: 1rem; border-left: 4px solid; }
        .alert.success { background: #ecfdf5; color: #065f46; border-left-color: #10b981; }
        .alert.error { background: #fef2f2; color: #991b1b; border-left-color: #ef4444; }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p><?= (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'Admin Panel' : 'Moderator Panel' ?></p>
        </div>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                System Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon">💰</span>
                Donation Logs
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
        </nav>
        <?php else: ?>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/AddResource" class="nav-item active">
                <span class="icon">➕</span>
                Add Resource
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/Moderator/reported-resources" class="nav-item">
                <span class="icon">🚨</span>
                Reported Resources
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
        <?php endif; ?>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <header><h1>Add New Resource</h1></header>

        <div class="form-wrapper">
            <?php if (isset($_GET['created'])): ?>
                <div class="alert success">✅ Resource created successfully!</div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert error">❌ Error: <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <div class="section-header-bar" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>📚 Resource Details</h2>
                <a href="<?= BASE_URL ?>/resource-categories" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); border: 1px solid white; min-width: auto; padding: 0.5rem 1rem;">⚙️ Manage Categories</a>
            </div>
            
            <section class="card flush-top stack">
                <form id="addPostForm" action="<?= BASE_URL ?>/Moderator/resource/create" method="POST" enctype="multipart/form-data" class="stack">
                    <div class="form-rows">
                        <div class="form-row">
                            <label for="postName">Resource Title</label>
                            <input id="postName" type="text" name="title" placeholder="Enter a descriptive title" required>
                        </div>
                        
                        <div class="form-row">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
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
                            <label for="summary">Summary (Optional)</label>
                            <textarea id="summary" name="summary" rows="3" placeholder="Brief description..."></textarea>
                        </div>
                        
                        <div class="form-row">
                            <label for="tags">Tags</label>
                            <input id="tags" type="text" name="tags" placeholder="anxiety, stress, etc." />
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

                    <!-- Type Specific Fields -->
                    <div id="articleFields" class="stack card" style="display:none; border: 1px solid #e5e7eb; padding: 1.5rem;">
                        <h3>📝 Article Content</h3>
                        <div class="form-row">
                            <label for="articleImage">Featured Image</label>
                            <div class="file-upload-area" id="articleImageUpload">
                                <input id="articleImage" type="file" name="article_image" accept="image/*" style="display: none;">
                                <p>📁 Click to upload image</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="articleContent">Content</label>
                            <textarea id="articleContent" name="content" rows="12"></textarea>
                        </div>
                    </div>

                    <div id="videoFields" class="stack card" style="display:none; border: 1px solid #e5e7eb; padding: 1.5rem;">
                        <h3>🎥 Video Content</h3>
                        <div class="form-row">
                            <label for="videoFile">Video File</label>
                            <div class="file-upload-area" id="videoFileUpload">
                                <input id="videoFile" type="file" name="video_file" accept="video/*" style="display: none;">
                                <p>📁 Click to upload video</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="youtubeUrl">YouTube Link</label>
                            <input id="youtubeUrl" type="url" name="youtube_url" placeholder="https://..." />
                        </div>
                        <div class="form-row">
                            <label for="videoDescription">Description</label>
                            <textarea id="videoDescription" name="content" rows="6"></textarea>
                        </div>
                    </div>

                    <div id="audioFields" class="stack card" style="display:none; border: 1px solid #e5e7eb; padding: 1.5rem;">
                        <h3>🎵 Audio Content</h3>
                        <div class="form-row">
                            <label for="audioFile">Audio File</label>
                            <div class="file-upload-area" id="audioFileUpload">
                                <input id="audioFile" type="file" name="audio_file" accept="audio/*" style="display: none;">
                                <p>📁 Click to upload audio</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="audioDescription">Description</label>
                            <textarea id="audioDescription" name="content" rows="6"></textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn btn-secondary" type="reset">🗑️ Clear</button>
                        <button class="btn btn-primary" type="submit">💾 Create Resource</button>
                    </div>
                </form>
            </section>
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
                sections[key].style.display = (select.value === key) ? 'block' : 'none';
            });
        }
        
        select.addEventListener('change', updateVisibility);
        document.getElementById('addPostForm').addEventListener('reset', () => setTimeout(updateVisibility, 0));

        // Simplified file upload display
        function setupFile(areaId, inputId) {
            const area = document.getElementById(areaId);
            const input = document.getElementById(inputId);
            area.onclick = () => input.click();
            input.onchange = () => {
                if (input.files.length > 0) {
                    area.innerHTML = `<strong>✅ ${input.files[0].name}</strong>`;
                }
            };
        }
        setupFile('articleImageUpload', 'articleImage');
        setupFile('videoFileUpload', 'videoFile');
        setupFile('audioFileUpload', 'audioFile');

        document.getElementById('addPostForm').onsubmit = function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '⏳ Creating...';
            btn.disabled = true;
        };
    })();
    </script>
</body>
</html>
