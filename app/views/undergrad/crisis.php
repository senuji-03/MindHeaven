<?php
$TITLE = 'MindHeaven — Crisis Support';
$CURRENT_PAGE = 'crisis';
require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="dashboard-main">
  <!-- Emergency Hero Section -->
  <section class="crisis-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title"> Crisis Support</h1>
      <p class="hero-subtitle">You're not alone. Help is available 24/7.</p>
      </div>
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
    <div class="resources-grid">
      <!-- MindHeaven Crisis Support -->
      <div class="crisis-card mindheaven-support">
        <div class="card-header">
          <h2>🌟 MindHeaven Crisis Support</h2>
          <p class="card-subtitle">Connect with our trained crisis responders</p>
        </div>
        <div class="card-body">
          <div class="support-options">
            <div class="support-option">
              <div class="option-icon">💬</div>
              <div class="option-content">
                <h3>Live Chat Support</h3>
                <p>Connect instantly with our crisis support team</p>
                <button class="btn btn-primary" onclick="openCrisisChat()">Start Chat</button>
              </div>
            </div>
            <div class="support-option">
              <div class="option-icon">📞</div>
              <div class="option-content">
                <h3>Crisis Hotline</h3>
                <p>Speak directly with a trained counselor</p>
                <button class="btn btn-outline" onclick="requestCrisisCall()">Request Call</button>
              </div>
            </div>
            <div class="support-option">
              <div class="option-icon">🎯</div>
              <div class="option-content">
                <h3>Emergency Response</h3>
                <p>Immediate assistance for urgent situations</p>
                <button class="btn btn-danger" onclick="triggerEmergencyResponse()">Emergency Help</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Immediate Help -->
      <div class="crisis-card immediate-help">
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
                <a href="tel:988" class="btn btn-small">Call Now</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">💬</div>
              <div class="resource-content">
                <h3>Crisis Text Line</h3>
                <p>Text HOME to 741741 for immediate support</p>
                <a href="sms:741741&body=HOME" class="btn btn-small btn-outline">Text Now</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">🏥</div>
              <div class="resource-content">
                <h3>Emergency Room</h3>
                <p>Go to your nearest emergency room for immediate care</p>
                <button class="btn btn-small btn-ghost" onclick="findNearestER()">Find ER</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Campus Resources -->
      <div class="crisis-card campus-resources">
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
                <a href="tel:+1-555-0123" class="btn btn-small">Call Center</a>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">🏠</div>
              <div class="resource-content">
                <h3>Resident Advisor (RA)</h3>
                <p>24/7 support from trained student staff</p>
                <button class="btn btn-small btn-outline" onclick="contactRA()">Contact RA</button>
              </div>
            </div>
            <div class="resource-item">
              <div class="resource-icon">👨‍⚕️</div>
              <div class="resource-content">
                <h3>Student Health Services</h3>
                <p>Medical and mental health support</p>
                <a href="tel:+1-555-0124" class="btn btn-small">Call Health</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Support Network -->
      <div class="crisis-card support-network">
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
                <button class="btn btn-small btn-ghost" onclick="addSupportContact()">Add Contact</button>
              </div>
            </div>
            <div class="support-item">
              <div class="support-avatar">👨</div>
              <div class="support-content">
                <h3>Trusted Faculty</h3>
                <p>Professors, advisors, or mentors</p>
                <button class="btn btn-small btn-ghost" onclick="addFacultyContact()">Add Contact</button>
              </div>
            </div>
          </div>
          <div class="quick-contact">
            <h4>Quick Contact</h4>
            <div class="contact-buttons">
              <button class="btn btn-small" onclick="callSupport()">Call Support</button>
              <button class="btn btn-small btn-outline" onclick="textSupport()">Text Support</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Self-Help Tools -->
      <div class="crisis-card self-help-tools">
        <div class="card-header">
          <h2>🛠️ Self-Help Tools</h2>
          <p class="card-subtitle">Immediate coping strategies</p>
        </div>
        <div class="card-body">
          <div class="tool-grid">
            <button class="tool-btn" onclick="openBreathingExercise()">
              <!-- <span class="tool-icon">🫁</span> -->
              <span class="tool-text">Breathing Exercise</span>
            </button>
            <button class="tool-btn" onclick="openGroundingTechnique()">
              <!-- <span class="tool-icon">🌍</span> -->
              <span class="tool-text">Grounding 5-4-3-2-1</span>
            </button>
            <button class="tool-btn" onclick="openSafetyPlan()">
              <!-- <span class="tool-icon">📋</span> -->
              <span class="tool-text">Safety Plan</span>
            </button>
            <button class="tool-btn" onclick="openDistractionTools()">
              <!-- <span class="tool-icon">🎯</span> -->
              <span class="tool-text">Distraction Tools</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Warning Signs Section -->
  <section class="warning-signs">
    <div class="crisis-card warning-signs-card">
      <div class="card-header">
        <h2>⚠️ Warning Signs to Watch For</h2>
        <p class="card-subtitle">Recognizing when you or someone else needs help</p>
      </div>
      <div class="card-body">
        <div class="warning-grid">
          <div class="warning-column">
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
          <div class="warning-column">
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

<!-- MindHeaven Crisis Support API Interface Modal -->
<div id="crisisSupportModal" class="modal hidden">
  <div class="modal-content crisis-modal">
    <div class="modal-header">
      <h3>🌟 MindHeaven Crisis Support</h3>
      <button class="modal-close" onclick="closeCrisisSupport()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="api-interface">
        <div class="interface-header">
          <h4>Connect with Crisis Support</h4>
          <p>Choose how you'd like to connect with our support team</p>
        </div>
        
        <div class="support-options-modal">
          <div class="option-card" onclick="initiateLiveChat()">
            <div class="option-icon">💬</div>
            <div class="option-content">
              <h5>Live Chat</h5>
              <p>Instant messaging with trained counselors</p>
              <div class="status-indicator online">Online Now</div>
            </div>
          </div>
          
          <div class="option-card" onclick="requestPhoneCall()">
            <div class="option-icon">📞</div>
            <div class="option-content">
              <h5>Phone Call</h5>
              <p>Speak directly with a crisis counselor</p>
              <div class="status-indicator available">Available</div>
            </div>
          </div>
          
          <div class="option-card" onclick="scheduleCallback()">
            <div class="option-icon">⏰</div>
            <div class="option-content">
              <h5>Schedule Callback</h5>
              <p>Request a callback at your convenience</p>
              <div class="status-indicator available">24/7 Available</div>
            </div>
          </div>
        </div>
        
        <div class="crisis-form" id="crisisForm" style="display: none;">
          <div class="form-group">
            <label class="form-label">Your Name (Optional)</label>
            <input type="text" id="userName" class="form-input" placeholder="Enter your name">
          </div>
          
          <div class="form-group">
            <label class="form-label">Contact Method</label>
            <select id="contactMethod" class="form-select">
              <option value="phone">Phone Call</option>
              <option value="chat">Live Chat</option>
              <option value="callback">Schedule Callback</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="form-label">Phone Number (if applicable)</label>
            <input type="tel" id="phoneNumber" class="form-input" placeholder="Enter your phone number">
          </div>
          
          <div class="form-group">
            <label class="form-label">Brief Description</label>
            <textarea id="crisisDescription" class="form-textarea" placeholder="Briefly describe what you're experiencing..."></textarea>
          </div>
          
          <div class="form-group">
            <label class="form-label">Priority Level</label>
            <select id="priorityLevel" class="form-select">
              <option value="low">Low - General Support</option>
              <option value="medium">Medium - Some Urgency</option>
              <option value="high">High - Immediate Support Needed</option>
              <option value="emergency">Emergency - Crisis Situation</option>
            </select>
          </div>
          
          <div class="form-actions">
            <button class="btn btn-primary" onclick="submitCrisisRequest()">
              <span class="btn-icon">🚀</span>
              Submit Request
            </button>
            <button class="btn btn-outline" onclick="resetCrisisForm()">Reset</button>
          </div>
        </div>
        
        <div class="api-status" id="apiStatus" style="display: none;">
          <div class="status-content">
            <div class="loading-spinner"></div>
            <h5>Connecting to Support...</h5>
            <p>Please wait while we connect you with our crisis support team.</p>
          </div>
        </div>
        
        <div class="api-response" id="apiResponse" style="display: none;">
          <div class="response-content">
            <div class="success-icon">✅</div>
            <h5>Request Submitted Successfully!</h5>
            <p>Our crisis support team has been notified and will contact you shortly.</p>
            <div class="response-details">
              <p><strong>Reference ID:</strong> <span id="referenceId"></span></p>
              <p><strong>Estimated Response Time:</strong> <span id="responseTime"></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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

<style>
/* Crisis Page Modern Styles */
.dashboard-main {
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.crisis-hero {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
  color: white;
  padding: 3rem 2rem;
  border-radius: 1rem;
  margin-bottom: 2rem;
  box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
  position: relative;
  overflow: hidden;
}

.crisis-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
  pointer-events: none;
}

.hero-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
  position: relative;
  z-index: 1;
}

.hero-title {
  font-size: 2.5rem;
  margin: 0 0 0.5rem 0;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0;
}

.emergency-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.emergency-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  min-width: 200px;
  justify-content: center;
}

.emergency-btn.primary {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
  color: #1f2937;
}

.emergency-btn.primary:hover {
  background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.emergency-btn.secondary {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.emergency-btn.secondary:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.btn-text {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.btn-text strong {
  font-size: 1.1rem;
  line-height: 1.2;
}

.btn-text small {
  font-size: 0.85rem;
  opacity: 0.8;
  font-weight: 400;
}

/* Crisis Resources Grid */
.crisis-resources {
  margin-bottom: 2rem;
}

.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 1.5rem;
}

.crisis-card {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
  transition: all 0.3s ease;
}

.crisis-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-header {
  padding: 1.5rem 1.5rem 0 1.5rem;
}

.card-header h2 {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.card-subtitle {
  color: #6b7280;
  font-size: 0.9rem;
  margin: 0 0 1.5rem 0;
}

.card-body {
  padding: 0 1.5rem 1.5rem 1.5rem;
}

/* MindHeaven Support Card */
.mindheaven-support {
  border-left: 4px solid #4f46e5;
}

.support-options {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.support-option {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  transition: all 0.3s ease;
}

.support-option:hover {
  background: #eef2ff;
  border-color: #4f46e5;
}

.option-icon {
  font-size: 2rem;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.option-content h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.25rem 0;
}

.option-content p {
  color: #6b7280;
  font-size: 0.9rem;
  margin: 0;
}

/* Resource Lists */
.resource-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.resource-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.resource-icon {
  font-size: 1.5rem;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.resource-content {
  flex: 1;
}

.resource-content h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.25rem 0;
}

.resource-content p {
  color: #6b7280;
  font-size: 0.85rem;
  margin: 0 0 0.5rem 0;
}

/* Support Network */
.support-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.support-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.support-avatar {
  font-size: 1.5rem;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.support-content h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.25rem 0;
}

.support-content p {
  color: #6b7280;
  font-size: 0.85rem;
  margin: 0;
}

.quick-contact {
  padding: 1rem;
  background: #eef2ff;
  border-radius: 8px;
  border: 1px solid #c7d2fe;
}

.quick-contact h4 {
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 1rem 0;
}

.contact-buttons {
  display: flex;
  gap: 0.5rem;
}

/* Self-Help Tools */
.tool-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}

.tool-btn {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1.5rem 1rem;
  background: #f9fafb;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
}

.tool-btn:hover {
  background: #eef2ff;
  border-color: #4f46e5;
  transform: translateY(-2px);
}

.tool-icon {
  font-size: 2rem;
}

.tool-text {
  font-size: 0.9rem;
  font-weight: 500;
  color: #374151;
}

/* Warning Signs */
.warning-signs-card {
  margin-bottom: 2rem;
}

.warning-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
  margin-bottom: 1.5rem;
}

.warning-column h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1rem;
}

.warning-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.warning-list li {
  padding: 0.75rem 1rem;
  background: #fef2f2;
  border-left: 4px solid #ef4444;
  margin-bottom: 0.5rem;
  border-radius: 0 8px 8px 0;
  color: #374151;
  font-size: 0.9rem;
}

.help-reminder {
  padding: 1rem 1.5rem;
  background: #e0f2fe;
  border-radius: 8px;
  border-left: 4px solid #0284c7;
}

.help-reminder p {
  margin: 0;
  color: #0c4a6e;
  font-size: 0.9rem;
}

/* Button Styles */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  font-size: 0.875rem;
}

.btn-primary {
  background: #4f46e5;
  color: white;
  box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
}

.btn-primary:hover {
  background: #4338ca;
  color: white;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
}

.btn-outline {
  background: transparent;
  color: #4f46e5;
  border: 2px solid #4f46e5;
}

.btn-outline:hover {
  background: #4f46e5;
  color: white;
  transform: translateY(-1px);
}

.btn-danger {
  background: #ef4444;
  color: white;
  box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
}

.btn-danger:hover {
  background: #dc2626;
  color: white;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

.btn-ghost {
  background: transparent;
  color: #6b7280;
  border: 1px solid #d1d5db;
}

.btn-ghost:hover {
  background: #f3f4f6;
  color: #374151;
}

.btn-small {
  padding: 0.375rem 0.75rem;
  font-size: 0.8rem;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(4px);
}

.modal.show {
  display: flex;
}

.modal-content {
  background: white;
  border-radius: 1rem;
  max-width: 600px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
  from {
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.crisis-modal {
  max-width: 700px;
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  font-size: 1.3rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #6b7280;
  padding: 0.5rem;
  border-radius: 0.25rem;
  transition: all 0.3s ease;
}

.modal-close:hover {
  background: #f3f4f6;
  color: #1f2937;
}

.modal-body {
  padding: 1.5rem;
}

/* API Interface Styles */
.interface-header {
  text-align: center;
  margin-bottom: 2rem;
}

.interface-header h4 {
  font-size: 1.2rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.interface-header p {
  color: #6b7280;
  margin: 0;
}

.support-options-modal {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 2rem;
}

.option-card {
  padding: 1.5rem;
  background: #f9fafb;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
}

.option-card:hover {
  background: #eef2ff;
  border-color: #4f46e5;
  transform: translateY(-2px);
}

.option-card .option-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.option-card h5 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.option-card p {
  color: #6b7280;
  font-size: 0.9rem;
  margin: 0 0 1rem 0;
}

.status-indicator {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.status-indicator.online {
  background: #dcfce7;
  color: #166534;
}

.status-indicator.available {
  background: #e0f2fe;
  color: #0c4a6e;
}

/* Crisis Form */
.crisis-form {
  margin-top: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.form-input, .form-select, .form-textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-textarea {
  min-height: 100px;
  resize: vertical;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

/* API Status and Response */
.api-status, .api-response {
  text-align: center;
  padding: 2rem;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #e5e7eb;
  border-top: 4px solid #4f46e5;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.success-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.response-details {
  background: #f9fafb;
  padding: 1rem;
  border-radius: 8px;
  margin-top: 1rem;
  text-align: left;
}

.response-details p {
  margin: 0.5rem 0;
  font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .resources-grid {
    grid-template-columns: 1fr;
  }
  
  .warning-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .dashboard-main {
    padding: 1rem;
  }
  
  .crisis-hero {
    padding: 2rem 1rem;
  }
  
  .hero-content {
    flex-direction: column;
    text-align: center;
    gap: 1.5rem;
  }
  
  .hero-title {
    font-size: 2rem;
  }
  
  .emergency-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .emergency-btn {
    min-width: 250px;
  }
  
  .tool-grid {
    grid-template-columns: 1fr;
  }
  
  .support-options-modal {
    grid-template-columns: 1fr;
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .contact-buttons {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .crisis-hero {
    padding: 1.5rem 1rem;
  }
  
  .hero-title {
    font-size: 1.8rem;
  }
  
  .emergency-btn {
    min-width: 200px;
    padding: 0.75rem 1rem;
  }
  
  .modal-content {
    width: 95%;
    margin: 1rem;
  }
}
</style>

<script>
// Crisis Support API Interface JavaScript
document.addEventListener('DOMContentLoaded', function() {
  // Initialize crisis support functionality
  initializeCrisisSupport();
});

function initializeCrisisSupport() {
  // Add event listeners for crisis support buttons
  const crisisButtons = document.querySelectorAll('[onclick*="openCrisisChat"], [onclick*="requestCrisisCall"], [onclick*="triggerEmergencyResponse"]');
  crisisButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      openCrisisSupportModal();
    });
  });
}

function openCrisisSupportModal() {
  const modal = document.getElementById('crisisSupportModal');
  modal.classList.add('show');
  modal.style.display = 'flex';
}

function closeCrisisSupport() {
  const modal = document.getElementById('crisisSupportModal');
  modal.classList.remove('show');
  modal.style.display = 'none';
  resetCrisisInterface();
}

function resetCrisisInterface() {
  // Reset all form states
  document.getElementById('crisisForm').style.display = 'none';
  document.getElementById('apiStatus').style.display = 'none';
  document.getElementById('apiResponse').style.display = 'none';
  
  // Reset form fields
  document.getElementById('userName').value = '';
  document.getElementById('contactMethod').value = 'phone';
  document.getElementById('phoneNumber').value = '';
  document.getElementById('crisisDescription').value = '';
  document.getElementById('priorityLevel').value = 'low';
}

function initiateLiveChat() {
  showCrisisForm('chat');
}

function requestPhoneCall() {
  showCrisisForm('phone');
}

function scheduleCallback() {
  showCrisisForm('callback');
}

function showCrisisForm(contactMethod) {
  const form = document.getElementById('crisisForm');
  const contactMethodSelect = document.getElementById('contactMethod');
  
  contactMethodSelect.value = contactMethod;
  
  // Show/hide phone number field based on contact method
  const phoneField = document.getElementById('phoneNumber').parentElement;
  if (contactMethod === 'phone' || contactMethod === 'callback') {
    phoneField.style.display = 'block';
  } else {
    phoneField.style.display = 'none';
  }
  
  form.style.display = 'block';
  form.scrollIntoView({ behavior: 'smooth' });
}

function submitCrisisRequest() {
  // Get form data
  const formData = {
    name: document.getElementById('userName').value,
    contactMethod: document.getElementById('contactMethod').value,
    phoneNumber: document.getElementById('phoneNumber').value,
    description: document.getElementById('crisisDescription').value,
    priority: document.getElementById('priorityLevel').value,
    timestamp: new Date().toISOString()
  };
  
  // Validate form
  if (!formData.description.trim()) {
    showMessage('Please provide a brief description of your situation.', 'error');
    return;
  }
  
  if ((formData.contactMethod === 'phone' || formData.contactMethod === 'callback') && !formData.phoneNumber.trim()) {
    showMessage('Please provide a phone number for contact.', 'error');
    return;
  }
  
  // Show loading state
  showApiStatus();
  
  // Simulate API call
  setTimeout(() => {
    simulateCrisisApiCall(formData);
  }, 2000);
}

function showApiStatus() {
  document.getElementById('crisisForm').style.display = 'none';
  document.getElementById('apiStatus').style.display = 'block';
  document.getElementById('apiResponse').style.display = 'none';
}

function simulateCrisisApiCall(formData) {
  // Simulate API response
  const response = {
    success: true,
    referenceId: 'MH-CRISIS-' + Math.random().toString(36).substr(2, 9).toUpperCase(),
    responseTime: getResponseTime(formData.priority),
    message: 'Your crisis support request has been submitted successfully.'
  };
  
  showApiResponse(response);
}

function getResponseTime(priority) {
  switch(priority) {
    case 'emergency': return 'Immediate (within 5 minutes)';
    case 'high': return 'Within 15 minutes';
    case 'medium': return 'Within 30 minutes';
    case 'low': return 'Within 1 hour';
    default: return 'Within 30 minutes';
  }
}

function showApiResponse(response) {
  document.getElementById('apiStatus').style.display = 'none';
  
  const responseElement = document.getElementById('apiResponse');
  document.getElementById('referenceId').textContent = response.referenceId;
  document.getElementById('responseTime').textContent = response.responseTime;
  
  responseElement.style.display = 'block';
  
  // Auto-close modal after 5 seconds
  setTimeout(() => {
    closeCrisisSupport();
  }, 5000);
}

function resetCrisisForm() {
  document.getElementById('userName').value = '';
  document.getElementById('contactMethod').value = 'phone';
  document.getElementById('phoneNumber').value = '';
  document.getElementById('crisisDescription').value = '';
  document.getElementById('priorityLevel').value = 'low';
}

function showMessage(message, type) {
  // Remove existing message
  const existingMsg = document.querySelector('.crisis-message');
  if (existingMsg) {
    existingMsg.remove();
  }
  
  // Create message element
  const messageEl = document.createElement('div');
  messageEl.className = 'crisis-message';
  messageEl.textContent = message;
  
  const bgColor = type === 'success' ? '#dcfce7' : '#fef2f2';
  const textColor = type === 'success' ? '#166534' : '#dc2626';
  const borderColor = type === 'success' ? '#bbf7d0' : '#fecaca';
  
  messageEl.style.cssText = `
    background: ${bgColor};
    color: ${textColor};
    padding: 1rem 1.5rem;
    border-radius: 8px;
    border: 1px solid ${borderColor};
    margin: 1rem 0;
    text-align: center;
    font-weight: 500;
    animation: slideIn 0.3s ease;
  `;
  
  // Insert message
  const form = document.getElementById('crisisForm');
  form.insertBefore(messageEl, form.firstChild);
  
  // Remove message after 5 seconds
  setTimeout(() => {
    if (messageEl.parentNode) {
      messageEl.remove();
    }
  }, 5000);
}

// Existing crisis page functions
function openBreathingExercise() {
  document.getElementById('breathingModal').classList.add('show');
  document.getElementById('breathingModal').style.display = 'flex';
}

function closeBreathingExercise() {
  document.getElementById('breathingModal').classList.remove('show');
  document.getElementById('breathingModal').style.display = 'none';
}

function openGroundingTechnique() {
  document.getElementById('groundingModal').classList.add('show');
  document.getElementById('groundingModal').style.display = 'flex';
}

function closeGroundingTechnique() {
  document.getElementById('groundingModal').classList.remove('show');
  document.getElementById('groundingModal').style.display = 'none';
}

function findNearestER() {
  // Simulate finding nearest ER
  showMessage('Emergency Room locator feature coming soon. Please call 911 for immediate medical assistance.', 'info');
}

function contactRA() {
  showMessage('RA contact feature coming soon. Please call your campus emergency number.', 'info');
}

function addSupportContact() {
  showMessage('Support contact management feature coming soon.', 'info');
}

function addFacultyContact() {
  showMessage('Faculty contact management feature coming soon.', 'info');
}

function callSupport() {
  showMessage('Support calling feature coming soon.', 'info');
}

function textSupport() {
  showMessage('Support texting feature coming soon.', 'info');
}

function openSafetyPlan() {
  showMessage('Safety plan feature coming soon.', 'info');
}

function openDistractionTools() {
  showMessage('Distraction tools feature coming soon.', 'info');
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal')) {
    e.target.classList.remove('show');
    e.target.style.display = 'none';
  }
});

// Add slide-in animation keyframes
const style = document.createElement('style');
style.textContent = `
  @keyframes slideIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
`;
document.head.appendChild(style);
</script>

