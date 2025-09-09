<?php
// views/layout/header.php
// Expected variables: $TITLE, $CURRENT_PAGE, $PAGE_CSS (array)
if (!isset($TITLE)) $TITLE = 'MindHeaven';
if (!isset($CURRENT_PAGE)) $CURRENT_PAGE = '';
if (!isset($PAGE_CSS)) $PAGE_CSS = [];

if (!function_exists('is_active')) {
  function is_active($slug, $current) {
    return $slug === $current ? 'active' : '';
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="color-scheme" content="light only" />
  <title><?= htmlspecialchars($TITLE) ?></title>
  <link rel="icon" href="/MindHeaven/public/images/logo.png">
  <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/style.css">
  <?php foreach ($PAGE_CSS as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
  <?php endforeach; ?>
  
  <style>
  /* Header Inline Styles */
  .sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
    color: white;
    z-index: 1000;
    transition: all 0.3s ease;
    overflow-y: auto;
  }
  
  .sidebar.collapsed {
    width: 80px;
  }
  
  .sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  
  .brand {
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
  }
  
  .brand-logo {
    width: 2.5rem;
    height: 2.5rem;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
  }
  
  .brand-name {
    transition: opacity 0.3s ease;
  }
  
  .sidebar.collapsed .brand-name {
    opacity: 0;
    width: 0;
    overflow: hidden;
  }
  
  .sidebar-toggle {
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
    padding: 0.5rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .sidebar-toggle:hover {
    background: rgba(255,255,255,0.2);
  }
  
  .sidebar-nav {
    padding: 1rem 0;
  }
  
  .nav-section {
    margin-bottom: 2rem;
  }
  
  .nav-section-title {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9ca3af;
    margin: 0 0 1rem 0;
    padding: 0 1.5rem;
    transition: opacity 0.3s ease;
  }
  
  .sidebar.collapsed .nav-section-title {
    opacity: 0;
    height: 0;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }
  
  .nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  
  .nav-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem;
    color: #d1d5db;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
  }
  
  .nav-link:hover {
    background: rgba(255,255,255,0.1);
    color: white;
  }
  
  .nav-link.active {
    background: rgba(79, 70, 229, 0.2);
    color: white;
    border-left-color: #4f46e5;
  }
  
  .nav-icon {
    font-size: 1.2rem;
    width: 1.5rem;
    text-align: center;
  }
  
  .nav-text {
    transition: opacity 0.3s ease;
  }
  
  .sidebar.collapsed .nav-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
  }
  
  .crisis-link {
    background: rgba(239, 68, 68, 0.1);
    border-left-color: #ef4444 !important;
  }
  
  .crisis-link:hover {
    background: rgba(239, 68, 68, 0.2);
  }
  
  .sidebar-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.1);
  }
  
  .user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  
  .user-avatar {
    width: 2.5rem;
    height: 2.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }
  
  .user-details {
    transition: opacity 0.3s ease;
  }
  
  .sidebar.collapsed .user-details {
    opacity: 0;
    width: 0;
    overflow: hidden;
  }
  
  .user-name {
    font-weight: 600;
    color: white;
    margin-bottom: 0.25rem;
  }
  
  .user-role {
    font-size: 0.875rem;
    color: #9ca3af;
  }
  
  .main-wrapper {
    margin-left: 280px;
    transition: margin-left 0.3s ease;
    min-height: 100vh;
    background: #f9fafb;
  }
  
  .sidebar.collapsed + .main-wrapper {
    margin-left: 80px;
  }
  
  .top-header {
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem 2rem;
    position: sticky;
    top: 0;
    z-index: 100;
  }
  
  .header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .mobile-menu-toggle {
    display: none;
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
  }
  
  .mobile-menu-toggle:hover {
    background: #f3f4f6;
  }
  
  .hamburger {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }
  
  .bar {
    width: 1.5rem;
    height: 2px;
    background: #374151;
    border-radius: 1px;
    transition: all 0.3s ease;
  }
  
  .header-title h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
  }
  
  .header-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .header-btn {
    background: none;
    border: none;
    padding: 0.75rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    position: relative;
  }
  
  .header-btn:hover {
    background: #f3f4f6;
    color: #374151;
  }
  
  .btn-icon {
    font-size: 1.2rem;
  }
  
  .notification-badge {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    background: #ef4444;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.125rem 0.375rem;
    border-radius: 9999px;
    min-width: 1.25rem;
    text-align: center;
  }
  
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }
    
    .sidebar.open {
      transform: translateX(0);
    }
    
    .main-wrapper {
      margin-left: 0;
    }
    
    .mobile-menu-toggle {
      display: block;
    }
    
    .header-title {
      flex: 1;
      text-align: center;
    }
    
    .header-actions {
      gap: 0.25rem;
    }
    
    .header-btn {
      padding: 0.5rem;
    }
  }
  </style>
  <script src="/MindHeaven/public/js/undergrad/main.js" defer></script>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>

  <!-- Sidebar Navigation -->
  <aside id="sidebar" class="sidebar" role="navigation" aria-label="Main navigation">
    <div class="sidebar-header">
      <a class="brand" href="./" aria-label="MindHeaven Home">
        <div class="brand-logo">
          <span class="logo-icon">🧠</span>
        </div>
        <span class="brand-name">MindHeaven</span>
      </a>
      <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <span class="toggle-icon">←</span>
      </button>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section">
        <h3 class="nav-section-title">Main</h3>
        <ul class="nav-list">
          <li>
            <a class="nav-link <?= is_active('dashboard', $CURRENT_PAGE) ?>" href="./">
              <span class="nav-icon">📊</span>
              <span class="nav-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a class="nav-link <?= is_active('habits', $CURRENT_PAGE) ?>" href="./habits">
              <span class="nav-icon">✅</span>
              <span class="nav-text">Habits</span>
            </a>
          </li>
          <li>
            <a class="nav-link <?= is_active('mood', $CURRENT_PAGE) ?>" href="./mood">
              <span class="nav-icon">😊</span>
              <span class="nav-text">Mood Tracker</span>
            </a>
          </li>
          <li>
            <a class="nav-link <?= is_active('appointments', $CURRENT_PAGE) ?>" href="./appointment">
              <span class="nav-icon">📅</span>
              <span class="nav-text">Appointments</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="nav-section">
        <h3 class="nav-section-title">Support</h3>
        <ul class="nav-list">
          <li>
            <a class="nav-link <?= is_active('resources', $CURRENT_PAGE) ?>" href="./resources">
              <span class="nav-icon">📚</span>
              <span class="nav-text">Resources</span>
            </a>
          </li>
          <li>
            <a class="nav-link <?= is_active('contact', $CURRENT_PAGE) ?>" href="./contact">
              <span class="nav-icon">📞</span>
              <span class="nav-text">Contact</span>
            </a>
          </li>
          <li>
            <a class="nav-link <?= is_active('about', $CURRENT_PAGE) ?>" href="./about">
              <span class="nav-icon">ℹ️</span>
              <span class="nav-text">About</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="nav-section">
        <h3 class="nav-section-title">Emergency</h3>
        <ul class="nav-list">
          <li>
            <a class="nav-link crisis-link <?= is_active('crisis', $CURRENT_PAGE) ?>" href="./crisis">
              <span class="nav-icon">🆘</span>
              <span class="nav-text">Crisis Support</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">👤</div>
        <div class="user-details">
          <div class="user-name">Student</div>
          <div class="user-role">Undergraduate</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Top Header -->
    <header class="top-header" role="banner">
      <div class="header-content">
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-controls="sidebar" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </span>
        </button>

        <div class="header-title">
          <h1><?= htmlspecialchars($TITLE) ?></h1>
        </div>

        <div class="header-actions">
          <button class="header-btn" id="themeToggle" aria-label="Toggle theme">
            <span class="btn-icon">🌙</span>
          </button>
          <button class="header-btn" id="notificationsToggle" aria-label="Notifications">
            <span class="btn-icon">🔔</span>
            <span class="notification-badge">3</span>
          </button>
        </div>
      </div>
    </header>
