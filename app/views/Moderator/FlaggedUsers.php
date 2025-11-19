<?php
$TITLE = 'Flagged Users - Moderator Dashboard';
$CURRENT_PAGE = 'flagged-users';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($TITLE) ?></title>
    <link rel="icon" href="/MindHeaven/public/images/logo.png">
    <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/style.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/moderator/Moderator.css">
    
    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 20px;
            background: #1a252f;
            text-align: center;
            border-bottom: 1px solid #34495e;
        }
        
        .sidebar-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 12px;
            color: #95a5a6;
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover {
            background: #34495e;
            border-left-color: #3498db;
        }
        
        .nav-item.active {
            background: #34495e;
            border-left-color: #3498db;
            font-weight: 600;
        }
        
        .nav-item .icon {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #34495e;
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c0392b;
        }
        
        /* Main Content Adjustment */
        body {
            margin-left: 250px;
        }
        
        .flagged-users-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
        }
        
        .flagged-users-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .flagged-user-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            border-left: 4px solid #ef4444;
        }
        
        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .user-info h3 {
            color: #1f2937;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }
        
        .user-email {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .flag-count {
            background: #fef2f2;
            color: #dc2626;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .flag-reasons {
            margin-bottom: 1rem;
        }
        
        .flag-reason {
            background: #f9fafb;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            border-left: 3px solid #f59e0b;
        }
        
        .flag-reason-text {
            color: #374151;
            margin-bottom: 0.25rem;
        }
        
        .flag-reason-meta {
            font-size: 0.8rem;
            color: #6b7280;
        }
        
        .user-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-warn {
            background: #f59e0b;
            color: white;
        }
        
        .btn-warn:hover {
            background: #d97706;
        }
        
        .btn-suspend {
            background: #ef4444;
            color: white;
        }
        
        .btn-suspend:hover {
            background: #dc2626;
        }
        
        .btn-clear {
            background: #10b981;
            color: white;
        }
        
        .btn-clear:hover {
            background: #059669;
        }
        
        .btn-view {
            background: #3b82f6;
            color: white;
        }
        
        .btn-view:hover {
            background: #2563eb;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
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
                <!-- <span class="icon">📊</span> -->
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <!-- <span class="icon">✏️</span> -->
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item active">
                <!-- <span class="icon">🚩</span> -->
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <!-- <span class="icon">⚠️</span> -->
                Warn Users
            </a>
        </nav>

        <br/><br/> <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Flagged Users</h1>
        <p class="page-subtitle">Review and manage users who have been flagged for inappropriate behavior</p>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">12</div>
            <div class="stat-label">Total Flagged Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">5</div>
            <div class="stat-label">High Priority</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">3</div>
            <div class="stat-label">Pending Review</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">4</div>
            <div class="stat-label">Resolved This Week</div>
        </div>
    </div>

    <!-- Flagged Users List -->
    <div class="flagged-users-container">
        <div class="flagged-users-grid">
            <!-- Sample Flagged User 1 -->
            <div class="flagged-user-card">
                <div class="user-header">
                    <div class="user-info">
                        <h3>John Doe</h3>
                        <p class="user-email">john.doe@email.com</p>
                    </div>
                    <div class="flag-count">3 Flags</div>
                </div>
                
                <div class="flag-reasons">
                    <div class="flag-reason">
                        <div class="flag-reason-text">Inappropriate language in forum posts</div>
                        <div class="flag-reason-meta">Flagged by: Moderator • 2 hours ago</div>
                    </div>
                    <div class="flag-reason">
                        <div class="flag-reason-text">Spam messages in chat</div>
                        <div class="flag-reason-meta">Flagged by: System • 1 day ago</div>
                    </div>
                </div>
                
                <div class="user-actions">
                    <button class="btn btn-warn">Issue Warning</button>
                    <button class="btn btn-suspend">Suspend Account</button>
                    <button class="btn btn-view">View Profile</button>
                </div>
            </div>

            <!-- Sample Flagged User 2 -->
            <div class="flagged-user-card">
                <div class="user-header">
                    <div class="user-info">
                        <h3>Jane Smith</h3>
                        <p class="user-email">jane.smith@email.com</p>
                    </div>
                    <div class="flag-count">1 Flag</div>
                </div>
                
                <div class="flag-reasons">
                    <div class="flag-reason">
                        <div class="flag-reason-text">Sharing personal information of other users</div>
                        <div class="flag-reason-meta">Flagged by: User Report • 4 hours ago</div>
                    </div>
                </div>
                
                <div class="user-actions">
                    <button class="btn btn-warn">Issue Warning</button>
                    <button class="btn btn-clear">Clear Flag</button>
                    <button class="btn btn-view">View Profile</button>
                </div>
            </div>

            <!-- Sample Flagged User 3 -->
            <div class="flagged-user-card">
                <div class="user-header">
                    <div class="user-info">
                        <h3>Mike Johnson</h3>
                        <p class="user-email">mike.j@email.com</p>
                    </div>
                    <div class="flag-count">5 Flags</div>
                </div>
                
                <div class="flag-reasons">
                    <div class="flag-reason">
                        <div class="flag-reason-text">Harassment in private messages</div>
                        <div class="flag-reason-meta">Flagged by: User Report • 1 hour ago</div>
                    </div>
                    <div class="flag-reason">
                        <div class="flag-reason-text">Creating multiple accounts to bypass restrictions</div>
                        <div class="flag-reason-meta">Flagged by: System • 3 hours ago</div>
                    </div>
                </div>
                
                <div class="user-actions">
                    <button class="btn btn-suspend">Suspend Account</button>
                    <button class="btn btn-view">View Profile</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add interactive functionality
        document.querySelectorAll('.btn-warn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to issue a warning to this user?')) {
                    // Handle warning logic
                    alert('Warning issued successfully');
                }
            });
        });

        document.querySelectorAll('.btn-suspend').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to suspend this user? This action cannot be undone.')) {
                    // Handle suspension logic
                    alert('User suspended successfully');
                }
            });
        });

        document.querySelectorAll('.btn-clear').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear all flags for this user?')) {
                    // Handle clear flags logic
                    alert('Flags cleared successfully');
                }
            });
        });
    </script>
</body>
</html>