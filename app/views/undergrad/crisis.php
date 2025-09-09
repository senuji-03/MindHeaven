<?php
$TITLE = 'MindHeaven — Crisis Support';
$CURRENT_PAGE = 'crisis';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/crisis.css'];
$PAGE_JS  = ['/MindHeaven/public/css/undergrad/crisis.js'];

require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="container crisis">
  <!-- Emergency Hero Section -->
  <section class="hero crisis-hero">
    <div class="crisis-content">
      <h1>🆘 Crisis Support</h1>
      <p class="hero-subtitle">You're not alone. Help is available 24/7.</p>
      <div class="emergency-buttons">
        <a href="tel:988" class="btn emergency-btn primary">
          <span class="btn-icon">📞</span>
          <span class="btn-text">
            <strong>Call 988</strong>
            <small>Suicide & Crisis Lifeline</small>
          </span>
        </a>
        <a href="tel:911" class="btn emergency-btn secondary">
          <span class="btn-icon">🚨</span>
          <span class="btn-text">
            <strong>Call 911</strong>
            <small>Emergency Services</small>
          </span>
        </a>
      </div>
    </div>
  </section>

  <!-- Crisis Resources Grid -->
  <section class="crisis-resources">
    <div class="grid">
      <!-- Immediate Help -->
      <div class="card col-6 crisis-card immediate">
        <div class="card-header">
          <h2>🚨 Immediate Help</h2>
          <p class="card-subtitle">Available right now, 24/7</p>
        </div>
        <div class="card-body">
          <div class="resource-list">
            <div class="resource-item">
              <div class="resource-icon">📞</div>
              <div class="resource-content">
                <h3>988 Suicide & Crisis Lifeline</h3>
                <p>Free, confidential support for anyone in crisis</p>
                <a href="tel:988" class="btn small">Call Now</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">💬</div>
              <div class="resource-content">
                <h3>Crisis Text Line</h3>
                <p>Text HOME to 741741 for immediate support</p>
                <a href="sms:741741&body=HOME" class="btn small outline">Text Now</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">🏥</div>
              <div class="resource-content">
                <h3>Emergency Room</h3>
                <p>Go to your nearest emergency room for immediate care</p>
                <button class="btn small ghost" onclick="findNearestER()">Find ER</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Campus Resources -->
      <div class="card col-6 crisis-card campus">
        <div class="card-header">
          <h2>🏫 Campus Resources</h2>
          <p class="card-subtitle">University-specific support services</p>
        </div>
        <div class="card-body">
          <div class="resource-list">
            <div class="resource-item">
              <div class="resource-icon">👥</div>
              <div class="resource-content">
                <h3>Counseling Center</h3>
                <p>Professional mental health services on campus</p>
                <a href="tel:+1-555-0123" class="btn small">Call Center</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">🏠</div>
              <div class="resource-content">
                <h3>Resident Advisor (RA)</h3>
                <p>24/7 support from trained student staff</p>
                <button class="btn small outline" onclick="contactRA()">Contact RA</button>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">👨‍⚕️</div>
              <div class="resource-content">
                <h3>Student Health Services</h3>
                <p>Medical and mental health support</p>
                <a href="tel:+1-555-0124" class="btn small">Call Health</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Self-Help Tools -->
      <div class="card col-6 crisis-card self-help">
        <div class="card-header">
          <h2>🛠️ Self-Help Tools</h2>
          <p class="card-subtitle">Immediate coping strategies</p>
        </div>
        <div class="card-body">
          <div class="tool-grid">
            <button class="tool-btn" onclick="openBreathingExercise()">
              <span class="tool-icon">🫁</span>
              <span class="tool-text">Breathing Exercise</span>
            </button>
            <button class="tool-btn" onclick="openGroundingTechnique()">
              <span class="tool-icon">🌍</span>
              <span class="tool-text">Grounding 5-4-3-2-1</span>
            </button>
            <button class="tool-btn" onclick="openSafetyPlan()">
              <span class="tool-icon">📋</span>
              <span class="tool-text">Safety Plan</span>
            </button>
            <button class="tool-btn" onclick="openDistractionTools()">
              <span class="tool-icon">🎯</span>
              <span class="tool-text">Distraction Tools</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Support Network -->
      <div class="card col-6 crisis-card support">
        <div class="card-header">
          <h2>🤝 Your Support Network</h2>
          <p class="card-subtitle">People who care about you</p>
        </div>
        <div class="card-body">
          <div class="support-list">
            <div class="support-item">
              <div class="support-avatar">👨‍👩‍👧‍👦</div>
              <div class="support-content">
                <h3>Family & Friends</h3>
                <p>Reach out to trusted loved ones</p>
                <button class="btn small ghost" onclick="addSupportContact()">Add Contact</button>
              </div>
            </div>
            <div class="support-item">
              <div class="support-avatar">👨‍🏫</div>
              <div class="support-content">
                <h3>Trusted Faculty</h3>
                <p>Professors, advisors, or mentors</p>
                <button class="btn small ghost" onclick="addFacultyContact()">Add Contact</button>
              </div>
            </div>
          </div>
          <div class="quick-contact">
            <h4>Quick Contact</h4>
            <div class="contact-buttons">
              <button class="btn small" onclick="callSupport()">Call Support</button>
              <button class="btn small outline" onclick="textSupport()">Text Support</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Warning Signs Section -->
  <section class="warning-signs">
    <div class="card">
      <div class="card-header">
        <h2>⚠️ Warning Signs to Watch For</h2>
        <p class="card-subtitle">Recognizing when you or someone else needs help</p>
      </div>
      <div class="card-body">
        <div class="grid">
          <div class="col-6">
            <h3>In Yourself</h3>
            <ul class="warning-list">
              <li>Thoughts of suicide or self-harm</li>
              <li>Feeling hopeless or trapped</li>
              <li>Extreme mood swings</li>
              <li>Withdrawing from friends and activities</li>
              <li>Changes in sleep or appetite</li>
              <li>Increased use of alcohol or drugs</li>
            </ul>
          </div>
          <div class="col-6">
            <h3>In Others</h3>
            <ul class="warning-list">
              <li>Talking about wanting to die</li>
              <li>Giving away possessions</li>
              <li>Saying goodbye to people</li>
              <li>Sudden calm after depression</li>
              <li>Isolation and withdrawal</li>
              <li>Risky or reckless behavior</li>
            </ul>
          </div>
        </div>
        <div class="help-reminder">
          <p><strong>Remember:</strong> It's okay to ask for help. Reaching out is a sign of strength, not weakness.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Breathing Exercise Modal -->
<div id="breathingModal" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3>🫁 Breathing Exercise</h3>
      <button class="modal-close" onclick="closeBreathingExercise()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="breathing-circle" id="breathingCircle">
        <div class="breathing-text" id="breathingText">Click Start to Begin</div>
      </div>
      <div class="breathing-controls">
        <button id="startBreathing" class="btn" onclick="startBreathingExercise()">Start</button>
        <button id="stopBreathing" class="btn outline" onclick="stopBreathingExercise()" style="display: none;">Stop</button>
      </div>
    </div>
  </div>
</div>

<!-- Grounding Technique Modal -->
<div id="groundingModal" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3>🌍 Grounding Technique: 5-4-3-2-1</h3>
      <button class="modal-close" onclick="closeGroundingTechnique()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="grounding-steps">
        <div class="step active" id="step1">
          <h4>5 Things You Can See</h4>
          <p>Look around and name 5 things you can see</p>
          <input type="text" placeholder="Type what you see..." class="input">
        </div>
        <div class="step" id="step2">
          <h4>4 Things You Can Touch</h4>
          <p>Name 4 things you can touch or feel</p>
          <input type="text" placeholder="Type what you can touch..." class="input">
        </div>
        <div class="step" id="step3">
          <h4>3 Things You Can Hear</h4>
          <p>Listen and name 3 things you can hear</p>
          <input type="text" placeholder="Type what you hear..." class="input">
        </div>
        <div class="step" id="step4">
          <h4>2 Things You Can Smell</h4>
          <p>Name 2 things you can smell</p>
          <input type="text" placeholder="Type what you smell..." class="input">
        </div>
        <div class="step" id="step5">
          <h4>1 Thing You Can Taste</h4>
          <p>Name 1 thing you can taste</p>
          <input type="text" placeholder="Type what you taste..." class="input">
        </div>
      </div>
      <div class="grounding-controls">
        <button class="btn" onclick="nextGroundingStep()">Next Step</button>
        <button class="btn outline" onclick="resetGrounding()">Start Over</button>
      </div>
    </div>
  </div>
</div>

<?php require BASE_PATH.'/app/views/layouts/footer.php'; ?>

