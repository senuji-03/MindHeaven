<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - University Representative | MindHeaven</title>
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
            <a href="<?= BASE_URL ?>/university-rep/announcements" class="nav-item active">
                <span class="icon">📰</span> Announcements
            </a>
            <a href="<?= BASE_URL ?>/university-rep/resources" class="nav-item">
                <span class="icon">📚</span> Resources
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/analytics" class="nav-item">
                <span class="icon">📈</span> Analytics
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
                <h1>📰 Announcements</h1>
                <p>Manage university announcements</p>
            </div>
            <button class="btn btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus"></i>
                Create Announcement
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon blue">📰</div>
                <div class="stat-content">
                    <h3>Total</h3>
                    <p class="stat-number">24</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">👁️</div>
                <div class="stat-content">
                    <h3>Views</h3>
                    <p class="stat-number">1,247</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">⏰</div>
                <div class="stat-content">
                    <h3>Pending</h3>
                    <p class="stat-number">3</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search announcements..." id="searchInput">
            </div>
        </div>

        <!-- Announcements List -->
        <div class="content-section">
            <div class="announcements-grid">
                <!-- Sample Announcement 1 -->
                <div class="announcement-card">
                    <div class="announcement-header">
                        <span class="status-badge published">Published</span>
                        <div class="announcement-actions">
                            <button class="action-btn" onclick="editAnnouncement(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteAnnouncement(1)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <h3>Campus Safety Guidelines Update</h3>
                        <p>Please review the updated safety protocols for the upcoming semester.</p>
                        <div class="announcement-tags">
                            <span class="tag">Safety</span>
                            <span class="tag">Important</span>
                        </div>
                    </div>
                    <div class="announcement-footer">
                        <span><i class="fas fa-eye"></i> 156 views</span>
                        <span><i class="fas fa-calendar"></i> Dec 15, 2024</span>
                    </div>
                </div>

                <!-- Sample Announcement 2 -->
                <div class="announcement-card">
                    <div class="announcement-header">
                        <span class="status-badge draft">Draft</span>
                        <div class="announcement-actions">
                            <button class="action-btn" onclick="editAnnouncement(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteAnnouncement(2)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <h3>Spring Semester Registration</h3>
                        <p>Registration for Spring 2025 courses will begin on January 15th.</p>
                        <div class="announcement-tags">
                            <span class="tag">Registration</span>
                            <span class="tag">Academic</span>
                        </div>
                    </div>
                    <div class="announcement-footer">
                        <span><i class="fas fa-eye"></i> 0 views</span>
                        <span><i class="fas fa-calendar"></i> Dec 10, 2024</span>
                    </div>
                </div>

                <!-- Sample Announcement 3 -->
                <div class="announcement-card">
                    <div class="announcement-header">
                        <span class="status-badge published">Published</span>
                        <div class="announcement-actions">
                            <button class="action-btn" onclick="editAnnouncement(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="deleteAnnouncement(3)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="announcement-content">
                        <h3>Mental Health Resources</h3>
                        <p>Our counseling center is now offering extended hours and additional resources.</p>
                        <div class="announcement-tags">
                            <span class="tag">Mental Health</span>
                            <span class="tag">Support</span>
                        </div>
                    </div>
                    <div class="announcement-footer">
                        <span><i class="fas fa-eye"></i> 89 views</span>
                        <span><i class="fas fa-calendar"></i> Dec 12, 2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Create Modal -->
    <div id="createModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Announcement</h3>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="announcementForm">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-input" id="announcementTitle" required>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-textarea" id="announcementContent" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tags (comma separated)</label>
                        <input type="text" class="form-input" id="announcementTags" placeholder="e.g., Important, Academic, Safety">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
                <button class="btn btn-primary" onclick="saveAnnouncement()">Create Announcement</button>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript functions
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
            document.getElementById('announcementForm').reset();
        }

        function saveAnnouncement() {
            const title = document.getElementById('announcementTitle').value;
            const content = document.getElementById('announcementContent').value;
            const tags = document.getElementById('announcementTags').value;
            
            if (!title || !content) {
                alert('Please fill in all required fields');
                return;
            }
            
            alert('Announcement created successfully!');
            closeCreateModal();
        }

        function editAnnouncement(id) {
            alert('Edit announcement ' + id);
        }

        function deleteAnnouncement(id) {
            if (confirm('Are you sure you want to delete this announcement?')) {
                alert('Announcement deleted');
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.announcement-card');
            
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