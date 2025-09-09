<?php
$TITLE = 'MindHeaven — Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/Undergrad_student/assets/css/resources.css'];
$PAGE_JS = ['/MindHeaven/Undergrad_student/assets/js/resources.js'];

require BASE_PATH.'/app/views/layouts/header.php';
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
            <span class="stat-number">50+</span>
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
            <a href="/MindHeaven/Undergrad_student/views/appointments.php" class="btn btn-primary btn-small">Book Now</a>
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
      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">🧠</div>
          <h3 class="category-title">Mental Health Basics</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Understanding mental health, common conditions, and when to seek help</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">What is Mental Health?</a></li>
            <li><a href="#" class="resource-link">Common Mental Health Conditions</a></li>
            <li><a href="#" class="resource-link">Signs You Should Seek Help</a></li>
            <li><a href="#" class="resource-link">Mental Health Myths vs Facts</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>

      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">😰</div>
          <h3 class="category-title">Anxiety & Stress</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Coping strategies and techniques for managing anxiety and stress</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">Breathing Exercises</a></li>
            <li><a href="#" class="resource-link">Grounding Techniques</a></li>
            <li><a href="#" class="resource-link">Progressive Muscle Relaxation</a></li>
            <li><a href="#" class="resource-link">Mindfulness for Anxiety</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>

      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">😢</div>
          <h3 class="category-title">Depression Support</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Resources and support for dealing with depression</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">Understanding Depression</a></li>
            <li><a href="#" class="resource-link">Self-Care Strategies</a></li>
            <li><a href="#" class="resource-link">Building Support Networks</a></li>
            <li><a href="#" class="resource-link">When to Seek Professional Help</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>

      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">🧘‍♀️</div>
          <h3 class="category-title">Mindfulness & Meditation</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Guided practices for mindfulness and meditation</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">5-Minute Meditation</a></li>
            <li><a href="#" class="resource-link">Body Scan Practice</a></li>
            <li><a href="#" class="resource-link">Mindful Breathing</a></li>
            <li><a href="#" class="resource-link">Walking Meditation</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>

      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">💤</div>
          <h3 class="category-title">Sleep & Wellness</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Tips for better sleep and overall wellness</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">Sleep Hygiene Tips</a></li>
            <li><a href="#" class="resource-link">Relaxation Techniques</a></li>
            <li><a href="#" class="resource-link">Healthy Sleep Schedule</a></li>
            <li><a href="#" class="resource-link">Managing Sleep Anxiety</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>

      <div class="category-card">
        <div class="category-header">
          <div class="category-icon">👥</div>
          <h3 class="category-title">Relationships & Social</h3>
        </div>
        <div class="category-content">
          <p class="category-description">Building healthy relationships and social connections</p>
          <ul class="resource-list">
            <li><a href="#" class="resource-link">Healthy Communication</a></li>
            <li><a href="#" class="resource-link">Setting Boundaries</a></li>
            <li><a href="#" class="resource-link">Building Friendships</a></li>
            <li><a href="#" class="resource-link">Dealing with Conflict</a></li>
          </ul>
        </div>
        <div class="category-footer">
          <button class="btn btn-outline btn-small">View All</button>
        </div>
      </div>
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

<?php include __DIR__ . '/layout/footer.php'; ?>

