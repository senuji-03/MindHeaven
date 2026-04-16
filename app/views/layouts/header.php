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
        ['icon' => 'fas fa-home', 'text' => 'Dashboard', 'url' => '/ug', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-check-circle', 'text' => 'Habits', 'url' => '/ug/habits', 'slug' => 'habits'],
        ['icon' => 'fas fa-smile', 'text' => 'Mood Tracker', 'url' => '/ug/mood', 'slug' => 'mood'],
        ['icon' => 'fas fa-calendar-alt', 'text' => 'Appointments', 'url' => '/ug/appointment', 'slug' => 'appointments'],
        ['icon' => 'fas fa-comments', 'text' => 'Chat', 'url' => '/ug/chat', 'slug' => 'chat'],
      ],
      'support' => [
        ['icon' => 'fas fa-book', 'text' => 'Resources', 'url' => '/ug/resources', 'slug' => 'resources'],
        ['icon' => 'fas fa-users', 'text' => 'Forum', 'url' => '/forum', 'slug' => 'forum'],
        ['icon' => 'fas fa-envelope', 'text' => 'Contact', 'url' => '/ug/contact', 'slug' => 'contact'],
        ['icon' => 'fas fa-info-circle', 'text' => 'About', 'url' => '/ug/about', 'slug' => 'about'],
      ],
      'feedback' => [
        ['icon' => 'fas fa-comment-dots', 'text' => 'Feedback', 'url' => '/ug/feedback', 'slug' => 'feedback'],
      ]
    ],
    'admin' => [
      'main' => [
        ['icon' => 'fas fa-chart-line', 'text' => 'Dashboard', 'url' => '/admin', 'slug' => 'dashboard'],
        ['icon' => 'fas fa-user-friends', 'text' => 'Manage Users', 'url' => '/admin/manage-users', 'slug' => 'manage-users'],
        ['icon' => 'fas fa-book-open', 'text' => 'Resource Hub', 'url' => '/admin/resource-hub', 'slug' => 'resource-hub'],
        ['icon' => 'fas fa-shield-alt', 'text' => 'Moderate Forum', 'url' => '/admin/moderate-forum', 'slug' => 'moderate-forum'],
        ['icon' => 'fas fa-user-md', 'text' => 'Manage Counselors', 'url' => '/admin/counselors', 'slug' => 'counselors'],
        ['icon' => 'fas fa-calendar-check', 'text' => 'Appointments', 'url' => '/admin/appointments', 'slug' => 'appointments'],
        ['icon' => 'fas fa-chart-bar', 'text' => 'Reports', 'url' => '/admin/reports', 'slug' => 'reports'],
        ['icon' => 'fas fa-university', 'text' => 'University Events', 'url' => '/admin/university-events', 'slug' => 'university-events'],
        ['icon' => 'fas fa-cog', 'text' => 'Settings', 'url' => '/admin/settings', 'slug' => 'settings'],
        ['icon' => 'fas fa-hand-holding-usd', 'text' => 'Donation logs', 'url' => '/admin/donations', 'slug' => 'donations'],
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
  <link rel="stylesheet" href="/MindHeaven/public/css/notifications.css?v=<?= $cacheBuster ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <?php foreach ($PAGE_CSS as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>?v=<?= $cacheBuster ?>">
  <?php endforeach; ?>

  <style>
    :root {
      /* MindHeaven Design System Tokens */
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
      --border: #D6E4DD;
      --crisis: #D64F4F;
      --success: #4CAF82;
      --shadow-sm: 0 1px 3px rgba(30, 58, 52, 0.06);
      --shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);
      --shadow-lg: 0 12px 32px rgba(30, 58, 52, 0.10);
      --shadow-xl: 0 20px 48px rgba(30, 58, 52, 0.12);
      --radius-sm: 8px;
      --radius-md: 14px;
      --radius-lg: 20px;
      --radius-full: 9999px;
    }

    body {
      font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
      margin: 0;
      color: var(--text-primary);
    }

    /* ── Sidebar Redesign ── */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 260px;
      height: 100vh;
      background: var(--bg-deep);
      /* Dark Canopy */
      border-right: 1px solid rgba(255, 255, 255, 0.05);
      z-index: 1000;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      transform: none !important;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);

      /* Hide scrollbar */
      scrollbar-width: none;
      /* Firefox */
      -ms-overflow-style: none;
      /* IE/Edge */
    }

    .sidebar::-webkit-scrollbar {
      display: none;
      /* Chrome/Safari */
    }

    .sidebar-header {
      height: 74px;
      
      padding: 0 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
      background: var(--surface);
      border-bottom: 1px solid var(--border);

    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      transition: opacity 0.2s;
    }

    .brand:hover {
      opacity: 0.85;
    }

    .brand-logo {
      width: 34px;
      height: 34px;
      background: var(--primary);
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      color: white;
      box-shadow: 0 4px 12px rgba(61, 139, 110, 0.25);
    }

    .brand-name {
      font-family: 'Georgia', serif;
      font-weight: 700;
      font-size: 1.55rem;
      letter-spacing: 0;
      color: var(--text-primary);
    }

    .brand-name-highlight {
      color: #DDA700;
    }

    .sidebar-nav {
      padding: 10px 16px;
      flex: 1;
    }

    .nav-section {
      margin-bottom: 24px;
    }

    .nav-section-title {
      font-size: 0.78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: rgba(255, 255, 255, 0.5);
      /* Dimmed section title */
      margin: 0 0 10px 0;
      padding: 0 8px;
    }

    .nav-list {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      color: rgba(255, 255, 255, 0.7);
      /* Light translucent text */
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      border-radius: var(--radius-sm);
      transition: all 0.25s ease;
    }

    .nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      transform: translateX(4px);
    }

    .nav-link.active {
      background: var(--primary);
      color: white;
      font-weight: 600;
      border: 1px solid transparent;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .nav-link.active .nav-icon {
      color: white;
    }

    .nav-icon {
      font-size: 1.15rem;
      width: 24px;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
      color: rgba(255, 255, 255, 0.5);
      transition: color 0.25s ease;
    }

    .nav-link:hover .nav-icon {
      color: white;
    }

    .nav-text {
      flex: 1;
    }

    .crisis-link {
      color: var(--accent-warm) !important;
      background: rgba(232, 168, 124, 0.1);
      font-weight: 600;
    }

    .crisis-link:hover {
      background: var(--accent-warm) !important;
      color: #1C2B2A !important;
      transform: translateX(4px);
    }

    .crisis-link .nav-icon {
      color: var(--accent-warm);
    }

    .crisis-link:hover .nav-icon {
      color: #1C2B2A;
    }

    .profile-link {
      text-decoration: none;
      color: inherit;
      display: flex;
    }

    .profile-link:hover .user-name {
      color: var(--primary);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-left: 16px;
      border-left: 1px solid var(--border);
      margin-left: 8px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      background: var(--bg-mid);
      color: var(--primary);
      border-radius: var(--radius-full);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.15rem;
      transition: all 0.2s ease;
    }

    .profile-link:hover .user-avatar {
      background: var(--primary);
      color: white;
    }

    .user-details {
      flex: 1;
      white-space: nowrap;
      text-align: left;
    }

    .user-name {
      font-weight: 700;
      color: var(--text-primary);
      font-size: 0.9rem;
      margin-bottom: 0px;
      transition: color 0.2s ease;
    }

    .user-role {
      font-size: 0.78rem;
      font-weight: 500;
      color: var(--text-secondary);
      text-transform: capitalize;
    }

    /* ── Main Top Header ── */
    .main-wrapper {
      margin-left: 260px;
      min-height: 100vh;
      background: var(--surface);
    }

    .top-header {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      height: 74px;
      position: sticky;
      top: 0;
      z-index: 100;
      transition: all 0.3s ease;
    }

    .top-header.scrolled {
      background: rgba(255, 255, 255, 0.98);
      box-shadow: var(--shadow-sm);
    }

    .header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 100%;
      padding: 0 28px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .mobile-menu-toggle {
      display: none;
      background: var(--surface);
      border: 1px solid var(--border);
      padding: 10px;
      cursor: pointer;
      border-radius: var(--radius-sm);
      transition: all 0.25s ease;
      color: var(--text-secondary);
    }

    .mobile-menu-toggle:hover {
      background: var(--bg-mid);
      color: var(--primary-dark);
      border-color: var(--primary-light);
    }

    .hamburger {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .bar {
      width: 20px;
      height: 2px;
      background: currentColor;
      border-radius: var(--radius-full);
      transition: all 0.3s ease;
    }

    .header-title h1 {
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: -0.5px;
      margin: 0;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .header-btn {
      background: transparent;
      border: 1.5px solid var(--border);
      padding: 8px 18px;
      border-radius: var(--radius-full);
      cursor: pointer;
      transition: all 0.3s ease;
      color: var(--text-secondary);
      font-weight: 600;
      font-size: 0.88rem;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-family: inherit;
    }

    .header-btn:hover {
      border-color: var(--primary);
      background: var(--bg-mid);
      color: var(--primary-dark);
      transform: translateY(-1px);
    }

    /* ── Action Buttons ── */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 22px;
      border-radius: var(--radius-full);
      font-weight: 600;
      font-size: 0.88rem;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      text-decoration: none;
      border: none;
      font-family: inherit;
    }

    .btn-donate {
      background: var(--primary);
      color: white;
    }

    .btn-donate:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
    }

    .btn-crisis {
      background: var(--crisis);
      color: white;
    }

    .btn-crisis:hover {
      background: #C43D3D;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(214, 79, 79, 0.3);
    }

    .btn-icon {
      font-size: 1rem;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
      .sidebar {
        transform: translateX(-100%) !important;
        box-shadow: var(--shadow-xl);
      }

      .sidebar.open {
        transform: translateX(0) !important;
      }

      .main-wrapper {
        margin-left: 0;
      }

      .mobile-menu-toggle {
        display: block;
      }

      .header-content {
        padding: 16px 20px;
        gap: 16px;
      }
    }

    @media (max-width: 600px) {
      .header-title h1 {
        font-size: 1.25rem;
      }

      .header-actions .btn-donate,
      .header-actions .btn-crisis,
      .header-actions .header-btn {
        padding: 8px 12px;
        font-size: 0.85rem;
      }

      .header-actions {
        gap: 8px;
      }

      span.btn-text-hide {
        display: none;
      }
    }


  </style>
  <script src="/MindHeaven/public/js/undergrad/main.js" defer></script>
  <script src="/MindHeaven/public/js/notifications.js" defer></script>
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
        <span class="brand-name">Mind<span class="brand-name-highlight">Heaven</span></span>
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
          <?php
          $displayTitle = str_replace(
            ['MindHeaven — ', ' — MindHeaven', 'MindHeaven - ', ' - MindHeaven', 'MindHeaven'],
            '',
            $TITLE
          );
          $displayTitle = trim($displayTitle);
          if (empty($displayTitle))
            $displayTitle = 'Dashboard';
          ?>
          <h1><?= htmlspecialchars($displayTitle) ?></h1>
        </div>

        <div class="header-actions">
          <a href="<?= BASE_URL ?>/donation" class="btn btn-donate">
            <i class="fas fa-heart"></i> <span class="btn-text-hide">Donate</span>
          </a>
          <a href="<?= BASE_URL ?>/ug/crisis" class="btn btn-crisis">
            <i class="fas fa-phone-alt"></i> <span class="btn-text-hide">Crisis</span>
          </a>

          <?php if (Auth::check()): ?>
            <!-- Notifications -->
            <div class="notification-wrapper">
              <button class="header-btn" type="button" id="notificationBtn" aria-label="Notifications">
                <span class="btn-icon">🔔</span>
                <span class="notification-badge" id="notificationBadge">0</span>
              </button>
              <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                  <h3>Notifications</h3>
                </div>
                <div class="notification-list" id="notificationList">
                  <!-- JS populated -->
                </div>
                <div class="notification-footer">
                  <button type="button" id="markAllReadBtn">Mark all as read</button>
                </div>
              </div>
            </div>

          <?php 
            $profileUrl = '#';
            $role = $currentUser['role'] ?? '';
            if ($role === 'undergraduate') {
              $profileUrl = BASE_URL . '/ug/profile';
            } elseif ($role === 'counselor') {
              $profileUrl = BASE_URL . '/counselor/counselor_profile';
            } elseif ($role === 'admin') {
              $profileUrl = BASE_URL . '/admin/profile';
            } elseif ($role === 'university_representative') {
              $profileUrl = BASE_URL . '/university-rep/profile';
            }
            ?>
            <a href="<?= $profileUrl ?>" class="profile-link">
              <div class="user-info">
                <div class="user-avatar"><i class="fas fa-user"></i></div>
                <div class="user-details hide-on-mobile">
                  <div class="user-name"><?= htmlspecialchars($currentUser['username']) ?></div>
                  <div class="user-role"><?= ucfirst($currentUser['role']) ?></div>
                </div>
              </div>
            </a>

            <a href="<?= BASE_URL ?>/logout">
              <button class="header-btn" type="button" aria-label="Logout">
                <i class="fas fa-sign-out-alt"></i> <span class="btn-text-hide">Logout</span>
              </button>
            </a>
          <?php else: ?>
            <div class="user-info">
              <div class="user-avatar"><i class="fas fa-user"></i></div>
              <div class="user-details hide-on-mobile">
                <div class="user-name">Guest</div>
                <div class="user-role">Not logged in</div>
              </div>
            </div>
            <a href="<?= BASE_URL ?>/login">
              <button class="header-btn" type="button" aria-label="Login">
                <i class="fas fa-sign-in-alt"></i> <span class="btn-text-hide">Login</span>
              </button>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </header>
    <script>
      document.addEventListener('scroll', function () {
        const header = document.querySelector('.top-header');
        if (header) {
          if (window.scrollY > 40) header.classList.add('scrolled');
          else header.classList.remove('scrolled');
        }
      });
    </script>