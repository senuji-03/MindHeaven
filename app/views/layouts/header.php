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
        ['icon' => '🏠', 'text' => 'Dashboard', 'url' => '/ug', 'slug' => 'dashboard'],
        ['icon' => '✅', 'text' => 'Habits', 'url' => '/ug/habits', 'slug' => 'habits'],
        ['icon' => '😊', 'text' => 'Mood Tracker', 'url' => '/ug/mood', 'slug' => 'mood'],
        ['icon' => '📅', 'text' => 'Appointments', 'url' => '/ug/appointment', 'slug' => 'appointments'],
        ['icon' => '💬', 'text' => 'Chat', 'url' => '/ug/chat', 'slug' => 'chat'],
      ],
      'support' => [
        ['icon' => '📚', 'text' => 'Resources', 'url' => '/ug/resources', 'slug' => 'resources'],
        ['icon' => '💬', 'text' => 'Forum', 'url' => '/forum', 'slug' => 'forum'],
        ['icon' => '📞', 'text' => 'Contact', 'url' => '/ug/contact', 'slug' => 'contact'],
        ['icon' => 'ℹ️', 'text' => 'About', 'url' => '/ug/about', 'slug' => 'about'],
      ],
      'feedback' => [
        ['icon' => '💬', 'text' => 'Feedback', 'url' => '/ug/feedback', 'slug' => 'feedback'],
      ]
    ],
    'admin' => [
      'main' => [
        ['icon' => '📊', 'text' => 'Dashboard', 'url' => '/admin', 'slug' => 'dashboard'],
        ['icon' => '👥', 'text' => 'Manage Users', 'url' => '/admin/manage-users', 'slug' => 'manage-users'],
        ['icon' => '📚', 'text' => 'Resource Hub', 'url' => '/admin/resource-hub', 'slug' => 'resource-hub'],
        ['icon' => '💬', 'text' => 'Moderate Forum', 'url' => '/admin/moderate-forum', 'slug' => 'moderate-forum'],
        ['icon' => '👨‍⚕️', 'text' => 'Manage Counselors', 'url' => '/admin/counselors', 'slug' => 'counselors'],
        ['icon' => '📅', 'text' => 'Appointments', 'url' => '/admin/appointments', 'slug' => 'appointments'],
        ['icon' => '📈', 'text' => 'Reports', 'url' => '/admin/reports', 'slug' => 'reports'],
        ['icon' => '🏛️', 'text' => 'University Events', 'url' => '/admin/university-events', 'slug' => 'university-events'],
        ['icon' => '⚙️', 'text' => 'Settings', 'url' => '/admin/settings', 'slug' => 'settings'],
        ['icon' => '💰', 'text' => 'Donation logs', 'url' => '/admin/donations', 'slug' => 'donations'],
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
        ['icon' => 'fas fa-hand-holding-heart', 'text' => 'Donate', 'url' => '/donation', 'slug' => 'donation'],
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
  <?php $cacheBuster = time(); ?>
  <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/style.css?v=<?= $cacheBuster ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <?php foreach ($PAGE_CSS as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>?v=<?= $cacheBuster ?>">
  <?php endforeach; ?>

  <style>
    /* Header Inline Styles */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 240px;
      height: 100vh;
      background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
      color: white;
      z-index: 1000;
      overflow-y: auto;
      transform: none !important;
    }

    .sidebar-header {
      padding: 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(255, 255, 255, 0.1);
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
      background: transparent;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      overflow: hidden;
      border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .brand-logo-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    .brand-name {
      font-weight: bold;
      font-size: 1.3rem;
      color: #ffffff;
    }

    .sidebar-toggle {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
      padding: 0.5rem;
      border-radius: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
      background: rgba(255, 255, 255, 0.2);
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
      background: rgba(255, 255, 255, 0.1);
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
      /* Always visible */
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
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-avatar {
      width: 2.5rem;
      height: 2.5rem;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    .user-details {
      /* layout handled by flexbox parent */
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
      margin-left: 240px;
      min-height: 100vh;
      background: #f9fafb;
    }

    .top-header {
      background: rgba(255, 255, 255, 0.8);
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

    /* Button Styles */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
    }

    .btn-donate {
      background: #10b981;
      color: white;
      box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }

    .btn-donate:hover {
      background: #059669;
      color: white;
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-crisis {
      background: #ef4444;
      color: white;
      box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
    }

    .btn-crisis:hover {
      background: #dc2626;
      color: white;
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-icon {
      font-size: 1rem;
    }

    /* Responsive Design */
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
                  <span class="nav-icon">
                    <?php if (strpos($item['icon'], 'fas ') === 0 || strpos($item['icon'], 'far') === 0): ?>
                      <i class="<?= $item['icon'] ?>"></i>
                    <?php else: ?>
                      <?= $item['icon'] ?>
                    <?php endif; ?>
                  </span>
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
            <!-- Logged-in user: show Logout -->
            <a href="<?= BASE_URL ?>/logout">
              <button class="header-btn" type="button" aria-label="Logout">
                <span class="btn-icon">🚪</span> Logout
              </button>
            </a>
          <?php else: ?>
            <!-- Not logged in: show Login -->
            <a href="<?= BASE_URL ?>/login">
              <button class="header-btn" type="button" aria-label="Login">
                <span class="btn-icon">🔑</span> Login
              </button>
            </a>
          <?php endif; ?>

          <a href="<?= BASE_URL ?>/donation" class="btn btn-donate">
            <i class="fas fa-heart"></i> Donate
          </a>
          <a href="<?= BASE_URL ?>/ug/crisis" class="btn btn-crisis">
            <i class="fas fa-phone-alt"></i> Crisis
          </a>
        </div>
      </div>
    </header>