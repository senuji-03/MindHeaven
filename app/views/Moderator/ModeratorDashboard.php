<?php
$TITLE = 'MindHeaven — Moderator Dashboard';
$CURRENT_PAGE = 'moderator-dashboard';
$PAGE_CSS = array(BASE_URL . '/css/undergrad/resources.css');
$PAGE_JS = array(BASE_URL . '/js/undergrad/resources.js');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $TITLE ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <?php foreach($PAGE_CSS as $css): ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>
    <style>
        /* Moderator Dashboard Specific Styles */
        .resources-main {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        .resources-hero {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 3rem 0;
            position: relative;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-cta {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .hero-stat {
            text-align: center;
        }
        
        .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .quick-access {
            padding: 3rem 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
        }
        
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .quick-access-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .quick-access-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }
        
        .quick-access-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .quick-access-item h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .quick-access-item p {
            color: #6b7280;
            line-height: 1.5;
        }
        
        .category-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .category-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .category-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }
        
        .category-content {
            margin-bottom: 1rem;
        }
        
        .category-description {
            color: #6b7280;
            margin-bottom: 1rem;
        }
        
        .resource-list {
            list-style: none;
            padding: 0;
        }
        
        .resource-item {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .resource-content h4 {
            margin: 0 0 0.5rem 0;
            color: #1e293b;
            font-size: 1rem;
        }
        
        .resource-content p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .resource-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        .btn-danger {
            background: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background: #dc2626;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .quick-access-grid {
                grid-template-columns: 1fr;
                padding: 0 1rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
        }
    </style>
    <?php foreach($PAGE_JS as $js): ?>
        <script src="<?= $js ?>"></script>
    <?php endforeach; ?>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Heaven</h2>
            <p>Moderator Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item active">
                <!-- <span class="icon">📊</span> -->
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <!-- <span class="icon">✏</span> -->
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <!-- <span class="icon">🚩</span> -->
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item">
                <!-- <span class="icon">⚠</span> -->
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Moderator Dashboard</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Moderator</span>
                    <div class="avatar">M</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">

<main id="main" class="resources-main">

  <!-- Hero Section -->
  <section class="resources-hero">
    <a href="<?= BASE_URL ?>/admin/resource-hub" class="btn btn-success hero-cta">Resource Hub</a>
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Moderator Dashboard 🛡</h1>
        <p class="hero-subtitle">Manage content, moderate discussions, and ensure community safety</p>
       </div>
      
    </div>
  </section>

  <!-- Quick Access -->
  <section class="quick-access">
    <div class="section-header">
      <h2 class="section-title">Moderation Tools</h2>
      <p class="section-subtitle">Quick access to moderation features</p>
    </div>
    <div class="quick-access-grid">
      <a href="<?= BASE_URL ?>/FlaggedUsers" class="quick-access-item">
        <div class="quick-access-icon">👥</div>
        <h3>Flagged Users</h3>
        <p>Manage user warnings and actions</p>
      </a>
      <a href="<?= BASE_URL ?>/WarnForm" class="quick-access-item">
        <div class="quick-access-icon">⚠</div>
        <h3>Send Warning</h3>
        <p>Issue warnings to users</p>
      </a>
      <a href="<?= BASE_URL ?>/EditPosts" class="quick-access-item">
        <div class="quick-access-icon">✏</div>
        <h3>Edit Resources</h3>
        <p>Manage community resources</p>
      </a>
    </div>
  </section>

</main>
        </div>
    </div>
</body>
</html>
