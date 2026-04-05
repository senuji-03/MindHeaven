<?php
$TITLE = 'MindHeaven — Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/css/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="resources-main">
  <!-- Hero Section -->
  <section class="resources-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Mental Health Resources 📚</h1>
        <p class="hero-subtitle">Comprehensive tools, guides, and support for your mental wellness journey</p>
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
            <span class="stat-label">For Students</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <button id="emergencyBtn" class="btn btn-danger">
          <span class="btn-icon">🆘</span>
          Emergency Support
        </button>
        <a href="/MindHeaven/Undergrad_student/views/contact.php" class="btn btn-outline">
          <span class="btn-icon">📞</span>
          Contact Support
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
            <a href="tel:988" class="btn btn-danger btn-small">Call 988</a>
            <a href="tel:911" class="btn btn-outline btn-small">Call 911</a>
          </div>
        </div>
      </div>

      <div class="quick-card chat-card">
        <div class="quick-icon">💬</div>
        <div class="quick-content">
          <h3 class="quick-title">Live Chat</h3>
          <p class="quick-description">Chat with a counselor right now</p>
          <div class="quick-actions">
            <button class="btn btn-primary btn-small">Start Chat</button>
          </div>
        </div>
      </div>

      <div class="quick-card appointment-card">
        <div class="quick-icon">📅</div>
        <div class="quick-content">
          <h3 class="quick-title">Book Appointment</h3>
          <p class="quick-description">Schedule a counseling session</p>
          <div class="quick-actions">
            <a href="/MindHeaven/Undergrad_student/views/appointments.php" class="btn btn-primary btn-small">Book
              Now</a>
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
<<<<<<< HEAD
                  <a href="#" class="resource-link"
                    onclick="openResourceModal(<?= htmlspecialchars(json_encode($resource)) ?>)">
=======
                  <a href="#" class="resource-link resource-modal-trigger" data-resource="<?= htmlspecialchars(json_encode($resource), ENT_QUOTES, 'UTF-8') ?>">
>>>>>>> origin/moderator_branch
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
            <button class="btn btn-outline btn-small"
              onclick="showCategoryResources('<?= htmlspecialchars($category) ?>')">
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
        <button class="btn btn-primary btn-small" onclick="openBreathingExercise()">Start Exercise</button>
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
        <button class="btn btn-primary btn-small" onclick="openGroundingExercise()">Start Exercise</button>
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
        <a href="/MindHeaven/Undergrad_student/views/mood.php" class="btn btn-primary btn-small">Open Journal</a>
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
        <button class="btn btn-primary btn-small" onclick="openGratitudePractice()">Start Practice</button>
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
        <button class="btn btn-primary btn-small" onclick="openThoughtChallenge()">Start Challenge</button>
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
        <button class="btn btn-primary btn-small" onclick="openStressAssessment()">Take Assessment</button>
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
          <button class="btn btn-primary btn-small">Book Appointment</button>
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
          <button class="btn btn-primary btn-small">Book Session</button>
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
          <button class="btn btn-primary btn-small">View Schedule</button>
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
          <div class="step-description" id="stepDescription">Look around and name 5 things you can see. Take your time
            and really notice the details.</div>
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
<<<<<<< HEAD
  // Resource modal functionality
  function openResourceModal(resource) {
    const modal = document.getElementById('resourceModal');
    const title = document.getElementById('resourceModalTitle');
    const content = document.getElementById('resourceModalContent');

    title.textContent = resource.title;

    let contentHtml = `
=======
// Resource modal functionality
function openResourceModal(resource) {
  try {
    const modal = document.getElementById('resourceModal');
    const title = document.getElementById('resourceModalTitle');
    const content = document.getElementById('resourceModalContent');
    
    title.textContent = resource.title;
  
  let contentHtml = `
>>>>>>> origin/moderator_branch
    <div class="resource-details">
      <div class="resource-meta">
        <span class="resource-category">${resource.category}</span>
        <span class="resource-type">${resource.content_type.toUpperCase()}</span>
        <span class="resource-date">${new Date(resource.created_at).toLocaleDateString()}</span>
      </div>
      <div class="resource-summary">
        <h4>Summary</h4>
        <p>${resource.summary}</p>
      </div>
  `;
<<<<<<< HEAD

    // Add file display if exists
    if (resource.file_path && resource.file_name) {
      const fileExtension = resource.file_name.split('.').pop().toLowerCase();
      const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);

      if (isImage) {
        contentHtml += `
=======
  
  // Handle different content types with proper file paths
  function buildFileUrl(filePath) {
    if (!filePath) return '';
    if (filePath.startsWith('http')) return filePath;
    const clean = filePath.replace(/^\/+/, '');
    return encodeURI('/MindHeaven/public/' + clean);
  }

  let fullFilePath = '';
  if (resource.file_path) {
    fullFilePath = buildFileUrl(resource.file_path);
  }

  if (resource.file_path && resource.file_name) {
    const fileExtension = resource.file_name.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
    
    if (resource.content_type === 'article' && isImage) {
      contentHtml += `
>>>>>>> origin/moderator_branch
        <div class="resource-file">
          <h4>Featured Image</h4>
          <img src="${fullFilePath}" alt="${resource.title}" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 1rem;">
          <div class="file-info">
            <p><strong>File:</strong> ${resource.file_name}</p>
            <p><strong>Size:</strong> ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
          </div>
        </div>
      `;
    } else if (resource.content_type === 'video') {
      contentHtml += `
        <div class="resource-file">
          <h4>Video Content</h4>
          <div class="video-container">
            <video controls style="width: 100%; max-width: 600px; border-radius: 8px;">
              <source src="${fullFilePath}" type="video/mp4">
              <source src="${fullFilePath}" type="video/webm">
              <source src="${fullFilePath}" type="video/ogg">
              Your browser does not support the video tag.
            </video>
          </div>
          <div class="file-info">
            <p><strong>File:</strong> ${resource.file_name}</p>
            <p><strong>Size:</strong> ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
            <a href="${fullFilePath}" target="_blank" class="btn btn-secondary btn-small">Download Video</a>
          </div>
        </div>
      `;
    } else if (resource.content_type === 'audio') {
      contentHtml += `
        <div class="resource-file">
          <h4>Audio Content</h4>
          <div class="audio-container">
            <audio controls style="width: 100%; max-width: 500px;">
              <source src="${fullFilePath}" type="audio/mpeg">
              <source src="${fullFilePath}" type="audio/wav">
              <source src="${fullFilePath}" type="audio/ogg">
              Your browser does not support the audio element.
            </audio>
          </div>
          <div class="file-info">
            <p><strong>File:</strong> ${resource.file_name}</p>
            <p><strong>Size:</strong> ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
            <a href="${fullFilePath}" target="_blank" class="btn btn-secondary btn-small">Download Audio</a>
          </div>
        </div>
      `;
<<<<<<< HEAD
      } else {
        contentHtml += `
=======
    } else {
      // Generic file display
      contentHtml += `
>>>>>>> origin/moderator_branch
        <div class="resource-file">
          <h4>Media File</h4>
          <div style="padding: 1rem; background: #f8fafc; border-radius: 8px; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">
              ${resource.content_type === 'video' ? '🎥' : '🎵'}
            </div>
            <p><strong>${resource.file_name}</strong></p>
            <p>Size: ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
            <a href="${fullFilePath}" target="_blank" class="btn btn-primary">View/Download File</a>
          </div>
        </div>
      `;
      }
    }
<<<<<<< HEAD

    // Add content
    if (resource.content) {
      contentHtml += `
=======
  }
  
  // Add content
  if (resource.content && resource.content_type === 'article') {
    contentHtml += `
>>>>>>> origin/moderator_branch
      <div class="resource-content">
        <h4>Article Content</h4>
        <div class="article-content" style="line-height:1.8;color:#374151;font-size:1rem;">${resource.content}</div>
      </div>
    `;
  } else if (resource.content && (resource.content_type === 'video' || resource.content_type === 'audio')) {
    contentHtml += `
      <div class="resource-content">
        <h4>Description</h4>
        <div style="white-space: pre-wrap; line-height: 1.6; background: #f8fafc; padding: 1rem; border-radius: 8px;">${resource.content}</div>
      </div>
    `;
<<<<<<< HEAD
    }

    // Add tags if exist
    if (resource.tags) {
      contentHtml += `
=======
  }
  
  // Add tags
  if (resource.tags) {
    const tagsArray = resource.tags.split(',').map(tag => tag.trim()).filter(tag => tag);
    contentHtml += `
>>>>>>> origin/moderator_branch
      <div class="resource-tags">
        <h4>Tags</h4>
        <div class="tags-container" style="display:flex;gap:0.5rem;">
          ${tagsArray.map(tag => `<span class="tag" style="background:#f1f5f9;padding:0.25rem 0.5rem;border-radius:4px;font-size:0.75rem;">${tag}</span>`).join('')}
        </div>
      </div>
    `;
  }
  
  // Add action buttons
  if (resource.content_type === 'video' || resource.content_type === 'audio') {
    contentHtml += `
      <div class="resource-actions" style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid #e5e7eb;">
        <a href="${fullFilePath}" target="_blank" class="btn btn-primary" style="margin-right:1rem;">
          ${resource.content_type === 'video' ? '🎥 Open Video' : '🎵 Open Audio'}
        </a>
      </div>
    `;
    }

    contentHtml += `</div>`;

    content.innerHTML = contentHtml;
    modal.style.display = 'block';
  }
<<<<<<< HEAD

  function showCategoryResources(category) {
    // Redirect to category-specific page
    window.location.href = `<?= BASE_URL ?>/ug/category-resources?category=${encodeURIComponent(category)}`;
  }

  // Close modal functionality
  document.getElementById('closeResourceModal').onclick = function () {
    document.getElementById('resourceModal').style.display = 'none';
  }

  window.onclick = function (event) {
    const modal = document.getElementById('resourceModal');
    if (event.target === modal) {
      modal.style.display = 'none';
    }
=======
  
  contentHtml += `</div>`;
  
  content.innerHTML = contentHtml;
  modal.style.display = 'flex';
  modal.classList.add('open');
  } catch (err) {
    console.error(err);
    alert('Debugging error: ' + err.message);
  }
}

// Category toggle functionality
function showCategoryResources(category) {
  var base = '<?= isset($categoryBaseUrl) ? $categoryBaseUrl : BASE_URL . "/ug/category-resources" ?>';
  window.location.href = base + '?category=' + encodeURIComponent(category);
}

// Attach safe click listeners to all resource triggers using data attributes
document.addEventListener('DOMContentLoaded', function() {
  const triggers = document.querySelectorAll('.resource-modal-trigger, .resource-card');
  triggers.forEach(trigger => {
    trigger.addEventListener('click', function(e) {
      // Prevent default anchor behavior
      if (this.tagName === 'A') {
        e.preventDefault();
      }
      const resourceData = this.getAttribute('data-resource');
      if (resourceData) {
        try {
          const resource = JSON.parse(resourceData);
          openResourceModal(resource);
        } catch (error) {
          console.error("Failed to parse resource data:", error);
        }
      }
    });
  });
});

// Close modal functionality
document.getElementById('closeResourceModal').onclick = function() {
  const modal = document.getElementById('resourceModal');
  modal.classList.remove('open');
  setTimeout(() => modal.style.display = 'none', 300);
}

window.onclick = function(event) {
  const resourceModal = document.getElementById('resourceModal');
  if (event.target === resourceModal) {
    resourceModal.classList.remove('open');
    setTimeout(() => resourceModal.style.display = 'none', 300);
  }
  // Keep the other modal closures generic if they exist
  if (event.target.classList.contains('modal') && event.target.id !== 'resourceModal') {
    event.target.style.display = 'none';
>>>>>>> origin/moderator_branch
  }
</script>

<<<<<<< HEAD
<?
require BASE_PATH . '/app/views/layouts/footer.php'; ?>
=======
<?php require BASE_PATH.'/app/views/layouts/footer.php'; ?>
>>>>>>> origin/moderator_branch
