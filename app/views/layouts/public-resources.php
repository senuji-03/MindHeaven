<?php
$TITLE = 'MindHeaven — Public Resources';
$CURRENT_PAGE = 'public-resources';
$PAGE_CSS = ['/MindHeaven/public/css/public/resources.css'];
$PAGE_JS = ['/MindHeaven/public/css/public/resources.js'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $TITLE; ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/MindHeaven/public/css/Admin/style.css">
    <?php foreach ($PAGE_CSS as $css): ?>
        <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>
    
    <style>
    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #1f2937;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Navbar Styles */
    .navbar {
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
        flex-shrink: 0;
        width: 100%;
    }
    
    .navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4f46e5;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    
    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex: 1;
        justify-content: center;
    }
    
    .nav-link {
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        white-space: nowrap;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: #4f46e5;
    }
    
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        white-space: nowrap;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: #4f46e5;
        color: white;
    }
    
    .btn-primary:hover {
        background: #4338ca;
    }
    
    .btn-outline {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .btn-outline:hover {
        background: #4f46e5;
        color: white;
    }
    
    .btn-donate {
        background: #10b981;
        color: white;
    }
    
    .btn-donate:hover {
        background: #059669;
    }
    
    .btn-crisis {
        background: #dc2626;
        color: white;
    }
    
    .btn-crisis:hover {
        background: #b91c1c;
    }
    
    .profile-dropdown {
        position: relative;
    }
    
    .btn-profile {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .profile-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        min-width: 200px;
        display: none;
        z-index: 1000;
    }
    
    .profile-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .profile-item:hover {
        background: #f9fafb;
    }
    
    /* Main Content */
    main {
        flex: 1;
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .resources-main {
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
        min-height: auto !important;
        height: auto !important;
    }
    
    /* Footer Styles */
    .footer {
        background: #1f2937;
        color: white;
        padding: 3rem 0 1rem;
        margin-top: auto;
        flex-shrink: 0;
        height: 20%;
    }
    
    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .footer-section h5 {
        margin-bottom: 1rem;
        color: #f9fafb;
    }
    
    .footer-section p {
        margin-bottom: 0.5rem;
    }
    
    .footer-section a {
        color: #d1d5db;
        text-decoration: none;
    }
    
    .footer-section a:hover {
        color: white;
    }
    
    .footer-bottom {
        border-top: 1px solid #374151;
        padding-top: 1rem;
        text-align: center;
        color: #9ca3af;
    }
    
    /* Ensure scrolling works properly */
    html {
        overflow-x: hidden;
        overflow-y: auto;
    }
    
    /* Override any conflicting styles from external CSS */
    .resources-main * {
        box-sizing: border-box;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .navbar-content {
            flex-direction: column;
            gap: 1rem;
        }
        
        .navbar-nav {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .navbar-actions {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                    <i class="fas fa-heart"></i>
                    MindHeaven
                </a>
                
                <div class="navbar-nav">
                    <a href="<?php echo BASE_URL; ?>/" class="nav-link">Home</a>
                    <a href="<?php echo BASE_URL; ?>/public/resources" class="nav-link active">Resource Hub</a>
                    <a href="<?php echo BASE_URL; ?>/public/forum" class="nav-link">Forum Discussion</a>
                    <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-donate">Donate Now</a>
                    <a href="<?php echo BASE_URL; ?>/ug/crisis" class="btn btn-crisis">
                        <i class="fas fa-exclamation-triangle"></i>
                        Crisis Support
                    </a>
                </div>
                
                <div class="navbar-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Profile Dropdown -->
                        <div class="profile-dropdown">
                            <button class="btn btn-profile" onclick="toggleProfileDropdown()">
                                <i class="fas fa-user-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="profile-menu" id="profileMenu">
                                <a href="<?php echo BASE_URL; ?>/ug" class="profile-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                                <a href="<?php echo BASE_URL; ?>/ug/profile" class="profile-item">
                                    <i class="fas fa-user"></i>
                                    Profile
                                </a>
                                <a href="<?php echo BASE_URL; ?>/logout" class="profile-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">Log In</a>
                        <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

<main id="main" class="resources-main">
  <!-- Hero Section -->
  <section class="resources-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title" style="text-align: left; margin-left: 15px;">Mental Health Resources </h1>
        <p class="hero-subtitle" style="text-align: left; margin-left: 15px;">Comprehensive tools, guides, and support for your mental wellness journey</p>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="stat-number"><?= $stats['published'] ?? 0 ?></span>
            <span class="stat-label">Resources</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number">24/7</span>
            <span class="stat-label">Support Available</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number">Free</span>
            <span class="stat-label">For Everyone</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <button id="emergencyBtn" class="btn btn-danger">
          <span class="btn-icon"></span>
          Emergency Support
        </button>
        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">
          <span class="btn-icon"></span>
          Login for More Features
        </a>
      </div>
    </div>
  </section>

  <!-- Quick Access -->
  <section class="quick-access">
    <div class="section-header">
      <h2 class="section-title">Quick Access</h2>
      <p class="section-subtitle">Get help when you need it most</p>
    </div>
    
    <div class="quick-access-grid">
      <div class="quick-card crisis-card">
        <div class="quick-icon">🆘</div>
        <div class="quick-content">
          <h3 class="quick-title">Crisis Support</h3>
          <p class="quick-description">Immediate help for mental health emergencies</p>
          <div class="quick-actions">
            <a href="tel:988" class="btn btn-danger btn-small">Call Crisis Hotline</a>
            <a href="tel:911" class="btn btn-outline btn-small">Call Crisis Hotline</a>
          </div>
        </div>
      </div>

      <div class="quick-card chat-card">
        <div class="quick-icon">💬</div>
        <div class="quick-content">
          <h3 class="quick-title">Live Chat</h3>
          <p class="quick-description">Chat with a counselor right now</p>
          <div class="quick-actions">
            <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to Chat</a>
          </div>
        </div>
      </div>

      <div class="quick-card appointment-card">
        <div class="quick-icon">📅</div>
        <div class="quick-content">
          <h3 class="quick-title">Book Appointment</h3>
          <p class="quick-description">Schedule a counseling session</p>
          <div class="quick-actions">
            <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to Book</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Resource Categories -->
  <section class="resource-categories">
    <div class="section-header">
      <h2 class="section-title">Resource Categories</h2>
      <p class="section-subtitle">Explore resources by topic</p>
    </div>
    
    <div class="categories-grid">
      <?php 
      // Define category icons and descriptions
      $categoryInfo = [
        'Mental Health Basics' => ['icon' => '🧠', 'description' => 'Understanding mental health, common conditions, and when to seek help'],
        'Anxiety & Stress' => ['icon' => '😰', 'description' => 'Coping strategies and techniques for managing anxiety and stress'],
        'Depression Support' => ['icon' => '😢', 'description' => 'Resources and support for dealing with depression'],
        'Mindfulness & Meditation' => ['icon' => '🧘‍♀️', 'description' => 'Guided practices for mindfulness and meditation'],
        'Sleep & Wellness' => ['icon' => '💤', 'description' => 'Tips for better sleep and overall wellness'],
        'Relationships & Social' => ['icon' => '👥', 'description' => 'Building healthy relationships and social connections'],
        'Crisis Support' => ['icon' => '🆘', 'description' => 'Emergency resources and crisis intervention'],
        'Self-Help Tools' => ['icon' => '🛠️', 'description' => 'Interactive tools and exercises for mental wellness'],
        'Professional Development' => ['icon' => '🎓', 'description' => 'Resources for academic and career success']
      ];
      
      // Display categories that have resources
      foreach ($resourcesByCategory as $category => $categoryResources): 
        $categoryIcon = $categoryInfo[$category]['icon'] ?? '📚';
        $categoryDescription = $categoryInfo[$category]['description'] ?? 'Resources for ' . $category;
      ?>
        <div class="category-card">
          <div class="category-header">
            <div class="category-icon"><?= $categoryIcon ?></div>
            <h3 class="category-title"><?= htmlspecialchars($category) ?></h3>
          </div>
          <div class="category-content">
            <p class="category-description"><?= htmlspecialchars($categoryDescription) ?></p>
            <ul class="resource-list">
              <?php foreach (array_slice($categoryResources, 0, 4) as $resource): ?>
                <li>
                  <a href="#" class="resource-link" onclick="openResourceModal(<?= htmlspecialchars(json_encode($resource)) ?>)">
                    <?= htmlspecialchars($resource['title']) ?>
                    <?php if ($resource['content_type'] === 'video'): ?>
                      <span style="color: #3b82f6;">🎥</span>
                    <?php elseif ($resource['content_type'] === 'audio'): ?>
                      <span style="color: #10b981;">🎵</span>
                    <?php else: ?>
                      <span style="color: #6b7280;">📄</span>
                    <?php endif; ?>
                  </a>
                </li>
              <?php endforeach; ?>
              <?php if (count($categoryResources) > 4): ?>
                <li><em>... and <?= count($categoryResources) - 4 ?> more resources</em></li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="category-footer">
            <button class="btn btn-outline btn-small" onclick="showCategoryResources('<?= htmlspecialchars($category) ?>')">
              View All (<?= count($categoryResources) ?>)
            </button>
          </div>
        </div>
      <?php endforeach; ?>
      
      <?php if (empty($resourcesByCategory)): ?>
        <div class="category-card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
          <div class="category-header">
            <div class="category-icon">📚</div>
            <h3 class="category-title">No Resources Available</h3>
          </div>
          <div class="category-content">
            <p class="category-description">Resources are being added regularly. Check back soon for new content!</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Self-Help Tools -->
  <section class="self-help-tools">
    <div class="section-header">
      <h2 class="section-title">Self-Help Tools</h2>
      <p class="section-subtitle">Interactive tools to support your mental health</p>
    </div>
    
    <div class="tools-grid">
      <div class="tool-card">
        <div class="tool-icon">🫁</div>
        <div class="tool-content">
          <h3 class="tool-title">Breathing Exercise</h3>
          <p class="tool-description">Guided breathing exercise to reduce stress and anxiety</p>
          <div class="tool-meta">
            <span class="tool-duration">5 minutes</span>
            <span class="tool-difficulty">Easy</span>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-small" onclick="openBreathingExercise()">Start Exercise</button> -->
      </div>

      <div class="tool-card">
        <div class="tool-icon">🎯</div>
        <div class="tool-content">
          <h3 class="tool-title">5-4-3-2-1 Grounding</h3>
          <p class="tool-description">Grounding technique to help with anxiety and panic</p>
          <div class="tool-meta">
            <span class="tool-duration">3 minutes</span>
            <span class="tool-difficulty">Easy</span>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-small" onclick="openGroundingExercise()">Start Exercise</button> -->
      </div>

      <div class="tool-card">
        <div class="tool-icon">📝</div>
        <div class="tool-content">
          <h3 class="tool-title">Mood Journal</h3>
          <p class="tool-description">Track your emotions and identify patterns</p>
          <div class="tool-meta">
            <span class="tool-duration">2 minutes</span>
            <span class="tool-difficulty">Easy</span>
          </div>
        </div>
        <!-- <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to Access</a> -->
      </div>

      <div class="tool-card">
        <div class="tool-icon">🎨</div>
        <div class="tool-content">
          <h3 class="tool-title">Gratitude Practice</h3>
          <p class="tool-description">Daily gratitude exercises to boost positivity</p>
          <div class="tool-meta">
            <span class="tool-duration">5 minutes</span>
            <span class="tool-difficulty">Easy</span>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-small" onclick="openGratitudePractice()">Start Practice</button> -->
      </div>

      <div class="tool-card">
        <div class="tool-icon">🧠</div>
        <div class="tool-content">
          <h3 class="tool-title">Thought Challenge</h3>
          <p class="tool-description">Challenge negative thoughts with CBT techniques</p>
          <div class="tool-meta">
            <span class="tool-duration">10 minutes</span>
            <span class="tool-difficulty">Medium</span>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-small" onclick="openThoughtChallenge()">Start Challenge</button> -->
      </div>

      <div class="tool-card">
        <div class="tool-icon">💪</div>
        <div class="tool-content">
          <h3 class="tool-title">Stress Assessment</h3>
          <p class="tool-description">Evaluate your current stress levels and get recommendations</p>
          <div class="tool-meta">
            <span class="tool-duration">5 minutes</span>
            <span class="tool-difficulty">Easy</span>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-small" onclick="openStressAssessment()">Take Assessment</button> -->
      </div>
    </div>
  </section>

  <!-- Campus Resources -->
  <section class="campus-resources">
    <div class="section-header">
      <h2 class="section-title">Campus Resources</h2>
      <p class="section-subtitle">Mental health services available on campus</p>
    </div>
    
    <div class="campus-grid">
      <div class="campus-card">
        <div class="campus-header">
          <div class="campus-icon">🏥</div>
          <h3 class="campus-title">Student Health Center</h3>
        </div>
        <div class="campus-content">
          <p class="campus-description">On-campus medical and mental health services</p>
          <div class="campus-details">
            <div class="campus-detail">
              <span class="detail-label">Location:</span>
              <span class="detail-value">Building A, Room 101</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Hours:</span>
              <span class="detail-value">Mon-Fri 8AM-5PM</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Phone:</span>
              <span class="detail-value">(555) 123-4567</span>
            </div>
          </div>
        </div>
        <div class="campus-actions">
          <a href="tel:5551234567" class="btn btn-outline btn-small">Call</a>
          <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to Book</a>
        </div>
      </div>

      <div class="campus-card">
        <div class="campus-header">
          <div class="campus-icon">👥</div>
          <h3 class="campus-title">Counseling Services</h3>
        </div>
        <div class="campus-content">
          <p class="campus-description">Professional counseling and therapy services</p>
          <div class="campus-details">
            <div class="campus-detail">
              <span class="detail-label">Location:</span>
              <span class="detail-value">Building B, Room 205</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Hours:</span>
              <span class="detail-value">Mon-Fri 9AM-6PM</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Phone:</span>
              <span class="detail-value">(555) 123-4568</span>
            </div>
          </div>
        </div>
        <div class="campus-actions">
          <a href="tel:5551234568" class="btn btn-outline btn-small">Call</a>
          <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to Book</a>
        </div>
      </div>

      <div class="campus-card">
        <div class="campus-header">
          <div class="campus-icon">🤝</div>
          <h3 class="campus-title">Peer Support Groups</h3>
        </div>
        <div class="campus-content">
          <p class="campus-description">Student-led support groups for various topics</p>
          <div class="campus-details">
            <div class="campus-detail">
              <span class="detail-label">Location:</span>
              <span class="detail-value">Student Union, Room 301</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Schedule:</span>
              <span class="detail-value">Various times</span>
            </div>
            <div class="campus-detail">
              <span class="detail-label">Contact:</span>
              <span class="detail-value">support@university.edu</span>
            </div>
          </div>
        </div>
        <div class="campus-actions">
          <a href="mailto:support@university.edu" class="btn btn-outline btn-small">Email</a>
          <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary btn-small">Login to View</a>
        </div>
      </div>
    </div>
  </section>

  <!-- External Resources -->
  <section class="external-resources">
    <div class="section-header">
      <h2 class="section-title">External Resources</h2>
      <p class="section-subtitle">Trusted mental health organizations and hotlines</p>
    </div>
    
    <div class="external-grid">
      <div class="external-card">
        <div class="external-header">
          <div class="external-logo">🆘</div>
          <h3 class="external-title">National Suicide Prevention Lifeline</h3>
        </div>
        <div class="external-content">
          <p class="external-description">24/7 crisis support and suicide prevention</p>
          <div class="external-contact">
            <span class="contact-method">Call:</span>
            <a href="tel:988" class="contact-link">988</a>
          </div>
          <div class="external-contact">
            <span class="contact-method">Text:</span>
            <a href="sms:988" class="contact-link">Text HOME to 741741</a>
          </div>
        </div>
      </div>

      <div class="external-card">
        <div class="external-header">
          <div class="external-logo">🧠</div>
          <h3 class="external-title">National Alliance on Mental Illness (NAMI)</h3>
        </div>
        <div class="external-content">
          <p class="external-description">Education, advocacy, and support for mental health</p>
          <div class="external-contact">
            <span class="contact-method">Website:</span>
            <a href="https://www.nami.org" class="contact-link" target="_blank">nami.org</a>
          </div>
          <div class="external-contact">
            <span class="contact-method">Helpline:</span>
            <a href="tel:18009506264" class="contact-link">1-800-950-6264</a>
          </div>
        </div>
      </div>

      <div class="external-card">
        <div class="external-header">
          <div class="external-logo">💬</div>
          <h3 class="external-title">Crisis Text Line</h3>
        </div>
        <div class="external-content">
          <p class="external-description">24/7 crisis support via text message</p>
          <div class="external-contact">
            <span class="contact-method">Text:</span>
            <a href="sms:741741" class="contact-link">Text HOME to 741741</a>
          </div>
          <div class="external-contact">
            <span class="contact-method">Website:</span>
            <a href="https://www.crisistextline.org" class="contact-link" target="_blank">crisistextline.org</a>
          </div>
        </div>
      </div>

      <div class="external-card">
        <div class="external-header">
          <div class="external-logo">🏥</div>
          <h3 class="external-title">SAMHSA National Helpline</h3>
        </div>
        <div class="external-content">
          <p class="external-description">Substance abuse and mental health services</p>
          <div class="external-contact">
            <span class="contact-method">Call:</span>
            <a href="tel:18006624357" class="contact-link">1-800-662-4357</a>
          </div>
          <div class="external-contact">
            <span class="contact-method">Website:</span>
            <a href="https://www.samhsa.gov" class="contact-link" target="_blank">samhsa.gov</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Breathing Exercise Modal -->
<div id="breathingModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Breathing Exercise</h3>
      <button class="modal-close" id="closeBreathingModal">&times;</button>
    </div>
    <div class="modal-body">
      <div class="breathing-container">
        <div class="breathing-circle" id="breathingCircle">
          <div class="breathing-text" id="breathingText">Click Start to begin</div>
        </div>
        <div class="breathing-controls">
          <button id="startBreathing" class="btn btn-primary">Start Exercise</button>
          <button id="stopBreathing" class="btn btn-outline" style="display: none;">Stop</button>
        </div>
        <div class="breathing-instructions">
          <h4>Instructions:</h4>
          <ol>
            <li>Find a comfortable position</li>
            <li>Follow the breathing pattern on screen</li>
            <li>Breathe in when the circle expands</li>
            <li>Breathe out when the circle contracts</li>
            <li>Continue for 5 minutes or until you feel calm</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Grounding Exercise Modal -->
<div id="groundingModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">5-4-3-2-1 Grounding Technique</h3>
      <button class="modal-close" id="closeGroundingModal">&times;</button>
    </div>
    <div class="modal-body">
      <div class="grounding-container">
        <div class="grounding-step" id="groundingStep">
          <div class="step-number" id="stepNumber">1</div>
          <div class="step-title" id="stepTitle">5 Things You Can See</div>
          <div class="step-description" id="stepDescription">Look around and name 5 things you can see. Take your time and really notice the details.</div>
          <div class="step-input">
            <input type="text" id="stepInput" class="form-input" placeholder="Type what you see...">
            <button id="nextStep" class="btn btn-primary btn-small">Next</button>
          </div>
        </div>
        <div class="grounding-progress">
          <div class="progress-bar">
            <div class="progress-fill" id="groundingProgress" style="width: 0%"></div>
          </div>
          <span class="progress-text" id="groundingProgressText">Step 1 of 5</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Resource Modal -->
<div id="resourceModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="resourceModalTitle">Resource Details</h3>
      <button class="modal-close" id="closeResourceModal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="resourceModalContent">
        <!-- Resource content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<script>
// Resource modal functionality
function openResourceModal(resource) {
  const modal = document.getElementById('resourceModal');
  const title = document.getElementById('resourceModalTitle');
  const content = document.getElementById('resourceModalContent');
  
  title.textContent = resource.title;
  
  let contentHtml = `
    <div class="resource-details">
      <div class="resource-meta">
        <span class="resource-category">${resource.category}</span>
        <span class="resource-type">${resource.content_type.toUpperCase()}</span>
      </div>
      <div class="resource-summary">
        <h4>Summary</h4>
        <p>${resource.summary}</p>
      </div>
  `;
  
  // Add file display if exists
  if (resource.file_path && resource.file_name) {
    const fileExtension = resource.file_name.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
    
    if (isImage) {
      contentHtml += `
        <div class="resource-file">
          <h4>Featured Image</h4>
          <img src="${resource.file_path}" alt="${resource.title}" style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
      `;
    } else {
      contentHtml += `
        <div class="resource-file">
          <h4>Media File</h4>
          <div style="padding: 1rem; background: #f8fafc; border-radius: 8px; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">
              ${resource.content_type === 'video' ? '🎥' : '🎵'}
            </div>
            <p><strong>${resource.file_name}</strong></p>
            <p>Size: ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
            <a href="${resource.file_path}" target="_blank" class="btn btn-primary">View/Download File</a>
          </div>
        </div>
      `;
    }
  }
  
  // Add content
  if (resource.content) {
    contentHtml += `
      <div class="resource-content">
        <h4>Content</h4>
        <div style="white-space: pre-wrap; line-height: 1.6;">${resource.content}</div>
      </div>
    `;
  }
  
  // Add tags if exist
  if (resource.tags) {
    contentHtml += `
      <div class="resource-tags">
        <h4>Tags</h4>
        <p>${resource.tags}</p>
      </div>
    `;
  }
  
  contentHtml += `</div>`;
  
  content.innerHTML = contentHtml;
  modal.style.display = 'block';
}

function showCategoryResources(category) {
  // Redirect to category-specific page
  window.location.href = `<?= BASE_URL ?>/ug/category-resources?category=${encodeURIComponent(category)}`;
}

// Close modal functionality
document.getElementById('closeResourceModal').onclick = function() {
  document.getElementById('resourceModal').style.display = 'none';
}

window.onclick = function(event) {
  const modal = document.getElementById('resourceModal');
  if (event.target === modal) {
    modal.style.display = 'none';
  }
}
</script>

    <!-- Footer
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>MindHeaven</h5>
                    <p>Providing comprehensive mental health support for undergraduate students. Your mental wellness is our priority.</p>
                </div>
                
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <p><a href="<?php echo BASE_URL; ?>/">Home</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/public/resources">Resource Hub</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/public/forum">Forum Discussion</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/donation">Donate</a></p>
                </div> -->
                
                <!-- <div class="footer-section">
                    <h5>Support</h5>
                    <p><a href="<?php echo BASE_URL; ?>/ug/crisis">Crisis Support</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/ug/about">About Us</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/ug/contact">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h5>Emergency</h5>
                    <p><a href="tel:988">988 Suicide & Crisis Lifeline</a></p>
                    <p><a href="tel:911">Emergency Services: 911</a></p>
                    <p><a href="sms:741741">Crisis Text Line: Text HOME to 741741</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 MindHeaven. All rights reserved. | <a href="<?php echo BASE_URL; ?>/privacy">Privacy Policy</a> | <a href="<?php echo BASE_URL; ?>/terms">Terms of Service</a></p>
            </div>
        </div>
    </footer> -->

    <!-- Custom JS -->
    <?php foreach ($PAGE_JS as $js): ?>
        <script src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>
    
    <script>
    // Profile dropdown functionality
    function toggleProfileDropdown() {
        const menu = document.getElementById('profileMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.profile-dropdown');
        const menu = document.getElementById('profileMenu');
        if (dropdown && !dropdown.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
    </script>
</body>
</html>
