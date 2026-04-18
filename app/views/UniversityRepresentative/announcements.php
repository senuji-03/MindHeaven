<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - University Representative | MindHeaven</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Tokens ── */
        :root {
            --primary:        #3D8B6E;
            --primary-light:  #6BB89A;
            --primary-dark:   #2A6B52;
            --bg-deep:        #1C2B2A;
            --bg-soft:        #F5F0E8;
            --bg-mid:         #EEF6F2;
            --text-primary:   #1E3A34;
            --text-secondary: #6B8C7E;
            --surface:        #FFFFFF;
            --border:         #D6E4DD;
            --crisis:         #D64F4F;
            --success:        #4CAF82;
            --shadow-sm:      0 1px 3px rgba(30,58,52,0.06);
            --shadow-md:      0 4px 12px rgba(30,58,52,0.08);
            --shadow-lg:      0 12px 32px rgba(30,58,52,0.10);
            --radius-sm:      8px;
            --radius-md:      14px;
            --radius-lg:      20px;
            --radius-full:    9999px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
            background: var(--bg-soft);
            color: var(--text-primary);
            line-height: 1.7;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px; height: 100vh;
            background: var(--bg-deep);
            position: fixed; left: 0; top: 0;
            display: flex; flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        .sidebar-header {
            padding: 36px 28px 28px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-header h2 {
            font-size: 1.4rem; font-weight: 700;
            color: var(--primary-light);
            margin-bottom: 6px;
        }
        .sidebar-header p {
            font-size: 0.75rem; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 1.5px;
        }

        .sidebar-nav { flex: 1; padding: 24px 16px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            border-radius: var(--radius-sm);
            margin-bottom: 4px;
            font-weight: 500; font-size: 0.95rem;
            transition: all 0.25s ease;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 1rem; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; transform: translateX(3px); }
        .nav-item.active {
            background: var(--primary); color: white;
            box-shadow: 0 4px 12px rgba(61,139,110,0.3);
        }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .logout-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: #FFB3B3; text-decoration: none;
            border-radius: var(--radius-sm);
            font-weight: 600; font-size: 0.9rem;
            transition: all 0.25s;
        }
        .logout-btn:hover { background: rgba(214,79,79,0.1); }

        /* ── Main Layout ── */
        .main-content { margin-left: 280px; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 40px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .topbar h1 { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; }
        .user-profile {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 18px;
            background: var(--bg-mid);
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
            font-weight: 600; font-size: 0.9rem; color: var(--text-secondary);
        }
        .avatar {
            width: 34px; height: 34px;
            background: var(--primary); color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }

        /* ── Content Wrapper ── */
        .content-wrapper { padding: 36px 40px; }

        /* ── Alerts ── */
        .alert-container { margin-bottom: 24px; padding: 0 40px; margin-top: 24px; }
        .alert {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-weight: 600; font-size: 0.93rem;
            margin-bottom: 12px;
        }
        .alert-success { background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; }
        .alert-error { background: #FFEBEE; color: #C62828; border: 1px solid #FFCDD2; }
        .alert-close { background: none; border: none; cursor: pointer; font-size: 1.2rem; margin-left: auto; opacity: 0.5; }

        /* ── Stats ── */
        .stats-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .stat-card {
            background: var(--surface); padding: 24px;
            border-radius: var(--radius-lg); border: 1px solid var(--border);
            display: flex; align-items: center; gap: 20px;
            box-shadow: var(--shadow-sm); transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-icon.blue { background: #E3F2FD; color: #1565C0; }
        .stat-icon.green { background: #E8F5E9; color: #2E7D32; }
        .stat-icon.orange { background: #FFF3E0; color: #EF6C00; }
        .stat-content h3 { font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-number { font-size: 1.6rem; font-weight: 800; color: var(--text-primary); }

        /* ── Search ── */
        .search-section { margin-bottom: 24px; }
        .search-box {
            display: flex; align-items: center; gap: 12px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-full); padding: 4px 20px;
            box-shadow: var(--shadow-sm); max-width: 400px;
        }
        .search-box i { color: var(--text-secondary); }
        .search-box input {
            border: none; outline: none; padding: 10px 0;
            font-size: 0.95rem; width: 100%; color: var(--text-primary);
            background: transparent;
        }

        /* ── Announcement Cards ── */
        .announcements-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; }
        .announcement-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
            box-shadow: var(--shadow-sm); transition: all 0.3s ease;
            display: flex; flex-direction: column;
        }
        .announcement-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
        
        .announcement-header { padding: 16px 24px; background: var(--bg-soft); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .status-badge { padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .status-badge.published { background: #E8F5E9; color: #2E7D32; }
        .status-badge.draft { background: #ECEFF1; color: #546E7A; }

        .announcement-content { padding: 24px; flex: 1; }
        .announcement-content h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 12px; color: var(--text-primary); }
        .announcement-content p { font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        .announcement-tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .tag { background: var(--bg-mid); color: var(--primary); padding: 4px 10px; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 600; }

        .announcement-footer { padding: 16px 24px; background: var(--bg-soft); border-top: 1px solid var(--border); display: flex; justify-content: space-between; font-size: 0.82rem; color: var(--text-secondary); }
        .announcement-footer i { margin-right: 4px; }

        .action-btn { background: none; border: none; cursor: pointer; color: var(--text-secondary); transition: color 0.2s; font-size: 0.9rem; }
        .action-btn:hover { color: var(--primary); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: var(--radius-full);
            font-family: inherit; font-weight: 600; font-size: 0.88rem;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(61,139,110,0.3); }
        .btn-secondary { background: var(--bg-mid); color: var(--text-secondary); }

        /* ── Modal ── */
        .modal { position: fixed; inset: 0; background: rgba(28, 43, 42, 0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 2000; }
        .modal-content { background: var(--surface); width: 100%; max-width: 500px; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
        .modal-header { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .modal-header h3 { font-size: 1.15rem; font-weight: 700; color: var(--text-primary); }
        .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-secondary); }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; background: var(--bg-soft); display: flex; justify-content: flex-end; gap: 12px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-primary); }
        .form-input, .form-textarea { width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; }
        .form-textarea { height: 120px; resize: vertical; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .sidebar { width: 0; display: none; }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Representative</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <i class="fas fa-calendar-alt"></i> Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/announcements" class="nav-item active">
                <i class="fas fa-bullhorn"></i> Announcements
            </a>
            <a href="<?= BASE_URL ?>/university-rep/resources" class="nav-item">
                <i class="fas fa-book-open"></i> Resources
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <i class="fas fa-university"></i> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Announcements</h1>
            <div class="user-profile">
                <span><?= htmlspecialchars($_SESSION['university_name'] ?? 'University') ?></span>
                <div class="avatar"><?= strtoupper(substr($_SESSION['university_name'] ?? 'U', 0, 1)) ?></div>
            </div>
        </div>
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="alert-container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="content-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h2>Manage University Announcements</h2>
                    <p>Broadcast updates and important information to students and staff.</p>
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