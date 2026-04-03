<?php
// views/layout/header.php
// Expected variables: $TITLE, $CURRENT_PAGE, $PAGE_CSS (array)
if (!isset($TITLE))
  $TITLE = 'MindHeaven';
if (!isset($CURRENT_PAGE))
  $CURRENT_PAGE = '';
if (!isset($PAGE_CSS))
  $PAGE_CSS = [];

// Include Auth class for session checking
require_once BASE_PATH . '/core/Auth.php';

if (!function_exists('is_active')) {
  function is_active($slug, $current)
  {
    return $slug === $current ? 'active' : '';
  }
}

// Function to get navigation items based on user role
function getNavigationItems($role)
{
  $navItems = [
    'undergrad' => [
      'main' => [
        ['icon' => 'fas fa-th-large', 'text' => 'Dashboard', 'url' => '/ug', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-check-circle', 'text' => 'Habits', 'url' => '/ug/habits', 'slug' => 'habits'],
        ['icon' => 'fas fa-smile', 'text' => 'Mood Tracker', 'url' => '/ug/mood', 'slug' => 'mood'],
        ['icon' => 'fas fa-calendar-alt', 'text' => 'Appointments', 'url' => '/ug/appointment', 'slug' => 'appointments'],
      ],
      'support' => [
        ['icon' => 'fas fa-book-open', 'text' => 'Resources', 'url' => '/ug/resources', 'slug' => 'resources'],
        ['icon' => 'fas fa-comments', 'text' => 'Forum', 'url' => '/ug/forum', 'slug' => 'forum'],
        ['icon' => 'fas fa-envelope', 'text' => 'Contact', 'url' => '/ug/contact', 'slug' => 'contact'],
        ['icon' => 'fas fa-info-circle', 'text' => 'About', 'url' => '/ug/about', 'slug' => 'about'],
      ],
      'feedback' => [
        ['icon' => 'fas fa-comment-dots', 'text' => 'Feedback', 'url' => '/ug/feedback', 'slug' => 'feedback'],
      ]
    ],
    'admin' => [
      'main' => [
        ['icon' => 'fas fa-th-large', 'text' => 'Dashboard', 'url' => '/admin', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-users-cog', 'text' => 'Manage Users', 'url' => '/admin/manage-users', 'slug' => 'manage-users'],
        ['icon' => 'fas fa-folder-open', 'text' => 'Resource Hub', 'url' => '/admin/resource-hub', 'slug' => 'resource-hub'],
      ]
    ],
    'counselor' => [
      'main' => [
        ['icon' => 'fas fa-th-large', 'text' => 'Dashboard', 'url' => '/counselor', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-calendar-check', 'text' => 'Appointments', 'url' => '/counselor/appointments', 'slug' => 'appointments'],
        ['icon' => 'fas fa-calendar', 'text' => 'Calendar', 'url' => '/counselor/calender', 'slug' => 'calendar'],
        ['icon' => 'fas fa-history', 'text' => 'Session History', 'url' => '/counselor/session-history', 'slug' => 'session-history'],
      ]
    ],
    'moderator' => [
      'main' => [
        ['icon' => 'fas fa-chart-bar', 'text' => 'Dashboard', 'url' => '/ModeratorDashboard', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-edit', 'text' => 'Edit Posts', 'url' => '/EditPosts', 'slug' => 'edit-posts'],
        ['icon' => 'fas fa-flag', 'text' => 'Flagged Users', 'url' => '/FlaggedUsers', 'slug' => 'flagged-users'],
        ['icon' => 'fas fa-exclamation-triangle', 'text' => 'Warn Users', 'url' => '/WarnForm', 'slug' => 'warn-form'],
      ]
    ],
    'call_responder' => [
      'main' => [
        ['icon' => 'fas fa-phone-alt', 'text' => 'Call Dashboard', 'url' => '/CallResponder', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-check-double', 'text' => 'Call Success', 'url' => '/CallSuccess', 'slug' => 'success'],
      ]
    ],
    'donor' => [
      'main' => [
        ['icon' => 'fas fa-heart', 'text' => 'Donation Form', 'url' => '/DonationForm', 'slug' => 'donation-form'],
        ['icon' => 'fas fa-check-circle', 'text' => 'Donation Success', 'url' => '/DonationSuccess', 'slug' => 'donation-success'],
      ]
    ]
  ];

  return $navItems[$role] ?? $navItems['undergrad'];
}

// Get current user info
$currentUser = Auth::user();
$userRole = $currentUser ? $currentUser['role'] : 'undergrad';
$navigationItems = getNavigationItems($userRole);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="color-scheme" content="light only" />
  <title><?= htmlspecialchars($TITLE) ?> — MindHeaven</title>
  <link rel="icon" href="/MindHeaven/public/images/logo.png">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/style.css">
  <?php foreach ($PAGE_CSS as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
  <?php endforeach; ?>

  <style>
    /* ── Design System Tokens ── */
    :root {
      --primary: #3D8B6E;
      --primary-dark: #2A6B52;
      --primary-light: #6BB89A;
      --accent-warm: #E8A87C;
      --accent-calm: #A8C5DA;
      --bg-deep: #1C2B2A;
      --bg-soft: #F5F0E8;
      --bg-mid: #EEF6F2;
      --text-primary: #1E3A34;
      --text-secondary: #6B8C7E;
      --surface: #FFFFFF;
      --crisis: #D64F4F;
      --success: #4CAF82;
      --border: #D6E4DD;
      --shadow-sm: 0 1px 3px rgba(30, 58, 52, 0.06);
      --shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);
      --radius-sm: 8px;
      --radius-md: 14px;
      --radius-full: 9999px;
    }

    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
      line-height: 1.7;
      color: var(--text-primary);
      background: var(--bg-mid);
      -webkit-font-smoothing: antialiased;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ── Sidebar ── */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 280px;
      height: 100vh;
      background: var(--bg-deep);
      color: white;
      z-index: 1000;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      scrollbar-width: thin;
      scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
      transform: none !important;
      /* Never slide away on desktop */
    }

    /* Only allow sidebar transform on mobile */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%) !important;
        transition: transform 0.3s ease;
      }

      .sidebar.open {
        transform: translateX(0) !important;
      }
    }

    .sidebar-header {
      padding: 20px 20px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: white;
    }

    .brand-logo {
      width: 38px;
      height: 38px;
      background: var(--primary);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: white;
      overflow: hidden;
    }

    .brand-logo-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .brand-name {
      font-weight: 700;
      font-size: 1.2rem;
      letter-spacing: -0.3px;
    }

    /* ── Sidebar Nav ── */
    .sidebar-nav {
      padding: 12px 0;
      flex: 1;
    }

    .nav-section {
      margin-bottom: 8px;
    }

    .nav-section-title {
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: rgba(255, 255, 255, 0.35);
      margin: 0;
      padding: 12px 20px 6px;
    }

    .nav-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 20px;
      color: rgba(255, 255, 255, 0.6);
      text-decoration: none;
      transition: all 0.2s ease;
      font-size: 0.88rem;
      font-weight: 500;
      border-left: 3px solid transparent;
      margin: 1px 0;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.06);
      color: rgba(255, 255, 255, 0.9);
    }

    .nav-link.active {
      background: rgba(61, 139, 110, 0.2);
      color: white;
      border-left-color: var(--primary-light);
      font-weight: 600;
    }

    .nav-icon {
      font-size: 0.9rem;
      width: 20px;
      text-align: center;
      opacity: 0.8;
    }

    .nav-link.active .nav-icon {
      opacity: 1;
    }

    .crisis-link {
      background: rgba(214, 79, 79, 0.08) !important;
      border-left-color: var(--crisis) !important;
      color: rgba(255, 255, 255, 0.7) !important;
    }

    .crisis-link:hover {
      background: rgba(214, 79, 79, 0.15) !important;
    }

    /* ── Sidebar Footer ── */
    .sidebar-footer {
      padding: 16px 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
    }

    .user-name {
      font-weight: 600;
      color: white;
      font-size: 0.88rem;
      margin-bottom: 1px;
    }

    .user-role {
      font-size: 0.75rem;
      color: rgba(255, 255, 255, 0.45);
      text-transform: capitalize;
    }

    /* ── Main Wrapper ── */
    .main-wrapper {
      margin-left: 280px !important;
      min-height: 100vh;
      background: var(--bg-mid);
    }

    /* Prevent external CSS from removing the margin on desktop */
    .main-wrapper.sidebar-collapsed {
      margin-left: 280px !important;
    }

    @media (max-width: 768px) {

      .main-wrapper,
      .main-wrapper.sidebar-collapsed {
        margin-left: 0 !important;
      }
    }

    /* ── Top Header ── */
    .top-header {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 0 28px;
      position: sticky;
      top: 0;
      z-index: 100;
      height: 60px;
      display: flex;
      align-items: center;
    }

    .header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .mobile-menu-toggle {
      display: none;
      background: none;
      border: none;
      padding: 8px;
      cursor: pointer;
      border-radius: var(--radius-sm);
      transition: background 0.2s;
    }

    .mobile-menu-toggle:hover {
      background: var(--bg-mid);
    }

    .hamburger {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .bar {
      width: 20px;
      height: 2px;
      background: var(--text-primary);
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    .header-title h1 {
      font-size: 1.15rem;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
      letter-spacing: -0.3px;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .header-btn {
      background: none;
      border: none;
      padding: 8px 12px;
      border-radius: var(--radius-full);
      cursor: pointer;
      transition: all 0.2s ease;
      color: var(--text-secondary);
      font-family: inherit;
      font-size: 0.82rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .header-btn:hover {
      background: var(--bg-mid);
      color: var(--text-primary);
    }

    .btn-header {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: var(--radius-full);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.82rem;
      transition: all 0.25s ease;
      border: none;
      cursor: pointer;
    }

    .btn-donate {
      background: var(--primary);
      color: white;
    }

    .btn-donate:hover {
      background: var(--primary-dark);
      color: white;
      transform: translateY(-1px);
    }

    .btn-crisis {
      background: var(--crisis);
      color: white;
    }

    .btn-crisis:hover {
      background: #c14343;
      color: white;
      transform: translateY(-1px);
    }

    .skip-link {
      position: absolute;
      left: -9999px;
      top: auto;
      width: 1px;
      height: 1px;
      overflow: hidden;
    }

    .skip-link:focus {
      position: fixed;
      top: 8px;
      left: 8px;
      width: auto;
      height: auto;
      padding: 10px 20px;
      background: var(--primary);
      color: white;
      border-radius: var(--radius-sm);
      z-index: 9999;
      font-weight: 600;
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

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
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

      .top-header {
        padding: 0 16px;
      }

      .header-title {
        flex: 1;
        text-align: center;
      }
    }
  </style>
  <script src="/MindHeaven/public/js/undergrad/main.js" defer></script>
</head>

<body>
  <a class="skip-link" href="#main">Skip to content</a>

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar" role="navigation" aria-label="Main navigation">
    <div class="sidebar-header">
      <a class="brand" href="<?= BASE_URL ?>/" aria-label="MindHeaven Home">
        <div class="brand-logo">
          <i class="fas fa-leaf"></i>
        </div>
        <span class="brand-name">MindHeaven</span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <?php foreach ($navigationItems as $sectionName => $items): ?>
        <div class="nav-section">
          <h3 class="nav-section-title"><?= ucfirst($sectionName) ?></h3>
          <ul class="nav-list">
            <?php foreach ($items as $item): ?>
              <li>
                <a class="nav-link <?= is_active($item['slug'], $CURRENT_PAGE) ?> <?= $item['class'] ?? '' ?>"
                  href="<?= BASE_URL . $item['url'] ?>">
                  <span class="nav-icon"><i class="<?= $item['icon'] ?>"></i></span>
                  <span class="nav-text"><?= $item['text'] ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
      <?php if (Auth::check()): ?>
        <div class="user-info">
          <div class="user-avatar"><i class="fas fa-user"></i></div>
          <div class="user-details">
            <div class="user-name"><?= htmlspecialchars($currentUser['username']) ?></div>
            <div class="user-role"><?= ucfirst($currentUser['role']) ?></div>
          </div>
        </div>
      <?php else: ?>
        <div class="user-info">
          <div class="user-avatar"><i class="fas fa-user"></i></div>
          <div class="user-details">
            <div class="user-name">Guest</div>
            <div class="user-role">Not logged in</div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="main-wrapper">
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
          <?php if (Auth::check()): ?>
            <a href="<?= BASE_URL ?>/logout">
              <button class="header-btn" type="button" aria-label="Logout">
                <i class="fas fa-sign-out-alt"></i> Logout
              </button>
            </a>
          <?php else: ?>
            <a href="<?= BASE_URL ?>/login">
              <button class="header-btn" type="button" aria-label="Login">
                <i class="fas fa-sign-in-alt"></i> Login
              </button>
            </a>
          <?php endif; ?>

          <a href="<?= BASE_URL ?>/donation" class="btn-header btn-donate">
            <i class="fas fa-heart"></i> Donate
          </a>
          <a href="<?= BASE_URL ?>/ug/crisis" class="btn-header btn-crisis">
            <i class="fas fa-phone-alt"></i> Crisis
          </a>
        </div>
      </div>
    </header>