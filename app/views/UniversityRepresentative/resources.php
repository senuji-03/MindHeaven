<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resources - University Representative | MindHeaven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 MindHeaven</h2>
            <p>University Representative</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <span class="icon">📅</span> Manage Events
            </a>
           
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span> University Profile
            </a>
          
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <span class="icon">👤</span> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">➡️</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div class="header-content">
                <h1>📚 Resources</h1>
                <p>Manage educational resources for students</p>
            </div>
            <button class="btn btn-primary" onclick="openUploadModal()">
                <i class="fas fa-upload"></i>
                Upload Resource
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon blue">📚</div>
                <div class="stat-content">
                    <h3>Total</h3>
                    <p class="stat-number">25</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">⬇️</div>
                <div class="stat-content">
                    <h3>Downloads</h3>
                    <p class="stat-number">1,456</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">📁</div>
                <div class="stat-content">
                    <h3>Categories</h3>
                    <p class="stat-number">8</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search resources..." id="searchInput">
            </div>
        </div>

        <!-- Resources List -->
        <div class="content-section">
            <div class="resources-grid">
                <!-- Sample Resource 1 -->
                <div class="resource-card">
                    <div class="resource-header">
                        <span class="resource-type pdf">PDF</span>
                        <div class="resource-actions">
                            <button class="action-btn" onclick="editResource(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteResource(1)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="resource-content">
                        <h3>Mental Health Guide</h3>
                        <p>Comprehensive guide to mental health resources and support services.</p>
                        <div class="resource-tags">
                            <span class="tag">Mental Health</span>
                            <span class="tag">Guide</span>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <span><i class="fas fa-download"></i> 234 downloads</span>
                        <span><i class="fas fa-calendar"></i> Dec 15, 2024</span>
                    </div>
                </div>

                <!-- Sample Resource 2 -->
                <div class="resource-card">
                    <div class="resource-header">
                        <span class="resource-type video">Video</span>
                        <div class="resource-actions">
                            <button class="action-btn" onclick="editResource(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteResource(2)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="resource-content">
                        <h3>Stress Management Workshop</h3>
                        <p>Video workshop on effective stress management techniques for students.</p>
                        <div class="resource-tags">
                            <span class="tag">Stress</span>
                            <span class="tag">Workshop</span>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <span><i class="fas fa-download"></i> 189 downloads</span>
                        <span><i class="fas fa-calendar"></i> Dec 10, 2024</span>
                    </div>
                </div>

                <!-- Sample Resource 3 -->
                <div class="resource-card">
                    <div class="resource-header">
                        <span class="resource-type document">Document</span>
                        <div class="resource-actions">
                            <button class="action-btn" onclick="editResource(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteResource(3)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="resource-content">
                        <h3>Study Tips & Techniques</h3>
                        <p>Document with proven study techniques and time management strategies.</p>
                        <div class="resource-tags">
                            <span class="tag">Study</span>
                            <span class="tag">Academic</span>
                        </div>
                    </div>
                    <div class="resource-footer">
                        <span><i class="fas fa-download"></i> 156 downloads</span>
                        <span><i class="fas fa-calendar"></i> Dec 12, 2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Upload Modal -->
    <div id="uploadModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload New Resource</h3>
                <button class="modal-close" onclick="closeUploadModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="resourceForm">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-input" id="resourceTitle" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-textarea" id="resourceDescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-select" id="resourceCategory" required>
                            <option value="">Select Category</option>
                            <option value="mental-health">Mental Health</option>
                            <option value="academic">Academic</option>
                            <option value="wellness">Wellness</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" class="form-input" id="resourceFile" accept=".pdf,.doc,.docx,.mp4,.mp3,.jpg,.png" required>
                    </div>
                    <div class="form-group">
                        <label>Tags (comma separated)</label>
                        <input type="text" class="form-input" id="resourceTags" placeholder="e.g., Guide, Workshop, Tips">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeUploadModal()">Cancel</button>
                <button class="btn btn-primary" onclick="saveResource()">Upload Resource</button>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript functions
        function openUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
            document.getElementById('resourceForm').reset();
        }

        function saveResource() {
            const title = document.getElementById('resourceTitle').value;
            const description = document.getElementById('resourceDescription').value;
            const category = document.getElementById('resourceCategory').value;
            const file = document.getElementById('resourceFile').files[0];
            const tags = document.getElementById('resourceTags').value;
            
            if (!title || !description || !category || !file) {
                alert('Please fill in all required fields');
                return;
            }
            
            alert('Resource uploaded successfully!');
            closeUploadModal();
        }

        function editResource(id) {
            alert('Edit resource ' + id);
        }

        function deleteResource(id) {
            if (confirm('Are you sure you want to delete this resource?')) {
                alert('Resource deleted');
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.resource-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const content = card.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>