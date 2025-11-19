<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Forum - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-header p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #60a5fa;
        }

        .nav-item.active {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
            border-left-color: #60a5fa;
        }

        .nav-item .icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8fafc;
        }

        .topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f1f5f9;
            border-radius: 50px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .content-wrapper {
            padding: 2rem;
        }

        .toolbar {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .tabs {
            display: flex;
            gap: 0.5rem;
        }

        .tab {
            padding: 0.75rem 1.5rem;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .tab:hover:not(.active) {
            background: #e2e8f0;
            color: #475569;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:not(.secondary) {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn:not(.secondary):hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .btn.secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn.secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }

        .embed {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .embed-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .embed-header strong {
            font-size: 1.1rem;
            color: #1e293b;
        }

        .chip {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .list h2 {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 1.3rem;
        }

        .row {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .row:hover {
            background: #f8fafc;
        }

        .row:last-child {
            border-bottom: none;
        }

        .row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }

        .row .title {
            flex: 1;
            font-weight: 500;
            color: #1e293b;
        }

        .row .chip {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        .row .chip:not(.approved) {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
        }

        .row .chip.approved {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .row .btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .toolbar-actions {
            display: flex;
            gap: 0.75rem;
        }

        .embed-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .embed-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .list-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .list-header h2 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            padding: 0;
            background: none;
            border: none;
        }

        .list-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .stat-item {
            color: #64748b;
        }

        .content-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .content-info .meta {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        iframe {
            border: none;
            border-radius: 0 0 12px 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .tabs {
                justify-content: center;
            }

            .embed-header {
                flex-direction: column;
                text-align: center;
            }

            .row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .row .title {
                margin-bottom: 0.5rem;
            }
        }

        /* Animation for smooth transitions */
        .embed, .list {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading state */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: #64748b;
        }

        .loading::after {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon"></span>
                Donation logs
            </a>
            
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Moderate Forum</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
      <div class="toolbar">
        <div class="tabs">
                    <button class="tab active" data-tab="preview">
                        👁️ Preview
                    </button>
                    <button class="tab" data-tab="queue">
                        🚩 Flagged Queue
                    </button>
        </div>
                <div class="toolbar-actions">
                    <button class="btn secondary" onclick="bulkFlag()">
                        🚩 Flag Selected
                    </button>
                    <button class="btn" onclick="bulkDelete()">
                        🗑️ Delete Selected
                    </button>
        </div>
      </div>

            <!-- Forum Threads Management -->
            <section id="forumPreview" class="list">
                <div class="list-header">
                    <h2>
                        💬 Forum Threads Management
                    </h2>
                    <div class="list-stats">
                        <span class="stat-item">
                            📝 <span id="totalThreads">8</span> Total Threads
                        </span>
                        <span class="stat-item">
                            🔥 <span id="activeThreads">5</span> Active
                        </span>
                    </div>
                </div>
                <div id="forumThreads">
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Struggling with exam anxiety - need advice"</span>
                            <span class="meta">Posted by: Sarah M. • 2 hours ago • 12 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Best study techniques for finals"</span>
                            <span class="meta">Posted by: Alex K. • 4 hours ago • 8 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Feeling overwhelmed with coursework"</span>
                            <span class="meta">Posted by: Maria R. • 6 hours ago • 5 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"How to manage stress during midterms"</span>
                            <span class="meta">Posted by: David L. • 1 day ago • 15 replies</span>
                        </div>
                        <span class="chip">Popular</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Looking for study group partners"</span>
                            <span class="meta">Posted by: Emma W. • 2 days ago • 3 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Mental health resources on campus"</span>
                            <span class="meta">Posted by: James T. • 3 days ago • 7 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Time management tips for busy students"</span>
                            <span class="meta">Posted by: Lisa P. • 4 days ago • 9 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <input type="checkbox" />
                        <div class="content-info">
                            <span class="title">"Dealing with imposter syndrome"</span>
                            <span class="meta">Posted by: Michael C. • 5 days ago • 11 replies</span>
                        </div>
                        <span class="chip">Active</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="viewThread(this)">
                                👁️ View
                            </button>
                            <button class="btn" onclick="deleteThread(this)">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
        </div>
      </section>

      <!-- Flag/Delete queue (frontend only) -->
      <section id="queueList" class="list" style="display:none;">
                <div class="list-header">
                    <h2>
                        🚩 Flagged/Reported Items
                    </h2>
                    <div class="list-stats">
                        <span class="stat-item">
                            ⚠️ <span id="flaggedCount">2</span> Flagged
                        </span>
                        <span class="stat-item">
                            ✅ <span id="approvedCount">0</span> Approved
                        </span>
                    </div>
                </div>
        <div id="queue">
          <div class="row">
            <input type="checkbox" />
                        <div class="content-info">
            <span class="title">Thread: "Struggling with exam anxiety"</span>
                            <span class="meta">Posted by: John Doe • 2 hours ago</span>
                        </div>
            <span class="chip">Reported</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="approveItem(this)">
                                ✅ Approve
                            </button>
                            <button class="btn" onclick="deleteItem(this)">
                                🗑️ Delete
                            </button>
                        </div>
          </div>
          <div class="row">
            <input type="checkbox" />
                        <div class="content-info">
            <span class="title">Reply: "Just skip exams"</span>
                            <span class="meta">Posted by: Anonymous • 1 hour ago</span>
                        </div>
            <span class="chip">Flagged</span>
                        <div class="actions">
                            <button class="btn secondary" onclick="approveItem(this)">
                                ✅ Approve
                            </button>
                            <button class="btn" onclick="deleteItem(this)">
                                🗑️ Delete
                            </button>
                        </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
        // Tabs functionality
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', function(){
        document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const tab = this.dataset.tab;
                
                // Smooth transition between tabs
                const preview = document.getElementById('forumPreview');
                const queue = document.getElementById('queueList');
                
                if (tab === 'preview') {
                    preview.style.display = 'block';
                    queue.style.display = 'none';
                    preview.style.opacity = '0';
                    setTimeout(() => {
                        preview.style.opacity = '1';
                    }, 100);
                } else {
                    preview.style.display = 'none';
                    queue.style.display = 'block';
                    queue.style.opacity = '0';
                    setTimeout(() => {
                        queue.style.opacity = '1';
                    }, 100);
                }
      });
    });

        // Approve item function
    function approveItem(btn){
      const row = btn.closest('.row');
            const chip = row.querySelector('.chip');
            const actions = row.querySelector('.actions');
            
            // Update chip
            chip.textContent = 'Approved';
            chip.className = 'chip approved';
            
            // Update stats
            updateStats();
            
            // Add success animation
            row.style.background = '#d1fae5';
            setTimeout(() => {
                row.style.background = '';
            }, 2000);
            
            // Show success message
            showNotification('Item approved successfully!', 'success');
        }

        // Delete item function
    function deleteItem(btn){
      const row = btn.closest('.row');
            
            // Add confirmation
            if (confirm('Are you sure you want to delete this item?')) {
                // Add fade out animation
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
      row.remove();
                    updateStats();
                    showNotification('Item deleted successfully!', 'success');
                }, 300);
            }
    }

        // Bulk flag function
    function bulkFlag(){
            const checkedItems = document.querySelectorAll('#queue .row input[type="checkbox"]:checked');
            
            if (checkedItems.length === 0) {
                showNotification('Please select items to flag', 'warning');
                return;
            }
            
            checkedItems.forEach(cb => {
        const row = cb.closest('.row');
                const chip = row.querySelector('.chip');
                chip.textContent = 'Flagged';
                chip.className = 'chip';
                chip.style.background = 'linear-gradient(135deg, #fef2f2, #fee2e2)';
                chip.style.color = '#991b1b';
            });
            
            updateStats();
            showNotification(`${checkedItems.length} items flagged successfully!`, 'success');
        }

        // Bulk delete function
    function bulkDelete(){
            const checkedItems = document.querySelectorAll('#queue .row input[type="checkbox"]:checked');
            
            if (checkedItems.length === 0) {
                showNotification('Please select items to delete', 'warning');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${checkedItems.length} selected items?`)) {
                checkedItems.forEach(cb => {
                    const row = cb.closest('.row');
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-100%)';
                    
                    setTimeout(() => {
                        row.remove();
                    }, 300);
                });
                
                setTimeout(() => {
                    updateStats();
                    showNotification(`${checkedItems.length} items deleted successfully!`, 'success');
                }, 400);
            }
        }

        // Update statistics
        function updateStats() {
            const flaggedCount = document.querySelectorAll('#queue .row .chip:not(.approved)').length;
            const approvedCount = document.querySelectorAll('#queue .row .chip.approved').length;
            
            document.getElementById('flaggedCount').textContent = flaggedCount;
            document.getElementById('approvedCount').textContent = approvedCount;
        }

        // View thread function
        function viewThread(btn) {
            const row = btn.closest('.row');
            const title = row.querySelector('.title').textContent;
            showNotification(`Opening thread: ${title}`, 'info');
        }

        // Delete thread function
        function deleteThread(btn) {
            const row = btn.closest('.row');
            const title = row.querySelector('.title').textContent;
            
            if (confirm(`Are you sure you want to delete the thread: "${title}"?`)) {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
                    row.remove();
                    updateThreadStats();
                    showNotification('Thread deleted successfully!', 'success');
                }, 300);
            }
        }

        // Update thread statistics
        function updateThreadStats() {
            const totalThreads = document.querySelectorAll('#forumThreads .row').length;
            const activeThreads = document.querySelectorAll('#forumThreads .row .chip').length;
            
            document.getElementById('totalThreads').textContent = totalThreads;
            document.getElementById('activeThreads').textContent = activeThreads;
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <span>${type === 'success' ? '✅' : type === 'warning' ? '⚠️' : 'ℹ️'}</span>
                <span>${message}</span>
            `;
            
            // Add notification styles
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#d1fae5' : type === 'warning' ? '#fef3c7' : '#dbeafe'};
                color: ${type === 'success' ? '#065f46' : type === 'warning' ? '#92400e' : '#1e40af'};
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 0.5rem;
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .embed, .list {
                transition: opacity 0.3s ease;
            }
        `;
        document.head.appendChild(style);

        // Initialize stats on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            updateThreadStats();
        });
  </script>
</body>
</html>

