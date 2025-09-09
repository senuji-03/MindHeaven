<?php
$TITLE = 'MindHeaven — Contact & Support';
$CURRENT_PAGE = 'contact';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/contact.css'];
$PAGE_JS  = ['/MindHeaven/public/css/undergrad/contact.js'];

require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="container contact">
  <!-- Contact Hero Section -->
  <section class="hero contact-hero">
    <div class="hero-content">
      <h1>📞 Contact & Support</h1>
      <p class="hero-subtitle">We're here to help. Reach out to us anytime.</p>
    </div>
  </section>

  <!-- Contact Methods Grid -->
  <section class="contact-methods">
    <div class="grid">
      <!-- Contact Form -->
      <div class="card col-6 contact-form-card">
        <div class="card-header">
          <h2>💬 Send us a Message</h2>
          <p class="card-subtitle">We'll get back to you within 24 hours</p>
        </div>
        <div class="card-body">
          <form id="contactForm" class="contact-form" novalidate>
            <div class="form-row">
              <div class="form-group">
                <label for="firstName" class="label">First Name *</label>
                <input type="text" id="firstName" name="firstName" class="input" required>
                <div class="error-message" id="firstNameError"></div>
              </div>
              <div class="form-group">
                <label for="lastName" class="label">Last Name *</label>
                <input type="text" id="lastName" name="lastName" class="input" required>
                <div class="error-message" id="lastNameError"></div>
              </div>
            </div>
            
            <div class="form-group">
              <label for="email" class="label">Email Address *</label>
              <input type="email" id="email" name="email" class="input" required>
              <div class="error-message" id="emailError"></div>
            </div>
            
            <div class="form-group">
              <label for="phone" class="label">Phone Number</label>
              <input type="tel" id="phone" name="phone" class="input">
              <div class="error-message" id="phoneError"></div>
            </div>
            
            <div class="form-group">
              <label for="subject" class="label">Subject *</label>
              <select id="subject" name="subject" class="input" required>
                <option value="">Select a subject</option>
                <option value="general">General Inquiry</option>
                <option value="technical">Technical Support</option>
                <option value="feature">Feature Request</option>
                <option value="bug">Bug Report</option>
                <option value="feedback">Feedback</option>
                <option value="crisis">Crisis Support</option>
                <option value="other">Other</option>
              </select>
              <div class="error-message" id="subjectError"></div>
            </div>
            
            <div class="form-group">
              <label for="message" class="label">Message *</label>
              <textarea id="message" name="message" class="input" rows="6" placeholder="Please describe your inquiry in detail..." required></textarea>
              <div class="error-message" id="messageError"></div>
            </div>
            
            <div class="form-group">
              <label class="checkbox-label">
                <input type="checkbox" id="urgent" name="urgent">
                <span class="checkmark"></span>
                This is an urgent matter requiring immediate attention
              </label>
            </div>
            
            <div class="form-group">
              <label class="checkbox-label">
                <input type="checkbox" id="privacy" name="privacy" required>
                <span class="checkmark"></span>
                I agree to the <a href="#" onclick="showPrivacyPolicy()">Privacy Policy</a> and consent to data processing *
              </label>
              <div class="error-message" id="privacyError"></div>
            </div>
            
            <div class="form-actions">
              <button type="submit" class="btn primary" id="submitBtn">
                <span class="btn-text">Send Message</span>
                <span class="btn-loading" style="display: none;">Sending...</span>
              </button>
              <button type="reset" class="btn outline">Clear Form</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="card col-6 contact-info-card">
        <div class="card-header">
          <h2>📍 Get in Touch</h2>
          <p class="card-subtitle">Multiple ways to reach us</p>
        </div>
        <div class="card-body">
          <div class="contact-info-list">
            <div class="contact-info-item">
              <div class="contact-icon">📧</div>
              <div class="contact-details">
                <h3>Email Support</h3>
                <p>support@mindheaven.edu</p>
                <a href="mailto:support@mindheaven.edu" class="btn small">Send Email</a>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">📞</div>
              <div class="contact-details">
                <h3>Phone Support</h3>
                <p>+1 (555) 123-4567</p>
                <p class="hours">Mon-Fri: 9AM-5PM EST</p>
                <a href="tel:+15551234567" class="btn small">Call Now</a>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">💬</div>
              <div class="contact-details">
                <h3>Live Chat</h3>
                <p>Available during business hours</p>
                <button class="btn small outline" onclick="openLiveChat()">Start Chat</button>
              </div>
            </div>
            
            <div class="contact-info-item">
              <div class="contact-icon">🏫</div>
              <div class="contact-details">
                <h3>Office Location</h3>
                <p>Student Wellness Center<br>
                123 University Drive<br>
                Campus, ST 12345</p>
                <button class="btn small ghost" onclick="getDirections()">Get Directions</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Support Hours & Response Times -->
  <section class="support-info">
    <div class="grid">
      <div class="card col-6">
        <div class="card-header">
          <h2>⏰ Support Hours</h2>
        </div>
        <div class="card-body">
          <div class="hours-grid">
            <div class="hours-item">
              <h4>General Support</h4>
              <p>Monday - Friday: 9:00 AM - 5:00 PM EST</p>
              <p>Saturday: 10:00 AM - 2:00 PM EST</p>
              <p>Sunday: Closed</p>
            </div>
            <div class="hours-item">
              <h4>Crisis Support</h4>
              <p>24/7 Emergency Hotline</p>
              <p>Call 988 for immediate help</p>
            </div>
            <div class="hours-item">
              <h4>Technical Issues</h4>
              <p>Monday - Friday: 8:00 AM - 6:00 PM EST</p>
              <p>Weekend: Limited support</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card col-6">
        <div class="card-header">
          <h2>📋 Response Times</h2>
        </div>
        <div class="card-body">
          <div class="response-times">
            <div class="response-item">
              <h4>Urgent Issues</h4>
              <p>Within 2 hours during business hours</p>
              <span class="response-badge urgent">Priority</span>
            </div>
            <div class="response-item">
              <h4>General Inquiries</h4>
              <p>Within 24 hours</p>
              <span class="response-badge normal">Standard</span>
            </div>
            <div class="response-item">
              <h4>Technical Support</h4>
              <p>Within 4 hours during business hours</p>
              <span class="response-badge technical">Technical</span>
            </div>
            <div class="response-item">
              <h4>Feature Requests</h4>
              <p>Within 48 hours</p>
              <span class="response-badge feature">Enhancement</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="card">
      <div class="card-header">
        <h2>❓ Frequently Asked Questions</h2>
        <p class="card-subtitle">Quick answers to common questions</p>
      </div>
      <div class="card-body">
        <div class="faq-list">
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>How do I reset my password?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Click on "Forgot Password" on the login page and enter your email address. You'll receive a reset link within a few minutes.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>Is my data secure and private?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Yes, we use industry-standard encryption and follow strict privacy guidelines. Your data is never shared without your explicit consent.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>Can I use this system on my mobile device?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Absolutely! MindHeaven is fully responsive and works great on smartphones, tablets, and desktop computers.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>What if I'm having a mental health crisis?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>If you're in immediate danger, call 911 or 988 (Suicide & Crisis Lifeline). For non-emergency support, contact our crisis support team through the crisis page.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>How do I schedule an appointment with a counselor?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Use the Appointments page to book sessions with available counselors. You can also call our counseling center directly at (555) 123-4567.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Success Modal -->
<div id="successModal" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3>✅ Message Sent Successfully!</h3>
      <button class="modal-close" onclick="closeSuccessModal()">&times;</button>
    </div>
    <div class="modal-body">
      <p>Thank you for contacting us. We've received your message and will get back to you as soon as possible.</p>
      <div class="success-details">
        <p><strong>Reference ID:</strong> <span id="referenceId"></span></p>
        <p><strong>Expected Response:</strong> <span id="expectedResponse"></span></p>
      </div>
      <div class="modal-actions">
        <button class="btn" onclick="closeSuccessModal()">Close</button>
        <button class="btn outline" onclick="printConfirmation()">Print Confirmation</button>
      </div>
    </div>
  </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyModal" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3>🔒 Privacy Policy</h3>
      <button class="modal-close" onclick="closePrivacyModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="privacy-content">
        <h4>Data Collection</h4>
        <p>We collect only the information necessary to provide you with support and improve our services.</p>
        
        <h4>Data Usage</h4>
        <p>Your information is used solely for responding to your inquiries and providing mental health support services.</p>
        
        <h4>Data Protection</h4>
        <p>We implement industry-standard security measures to protect your personal information.</p>
        
        <h4>Data Sharing</h4>
        <p>We never share your personal information with third parties without your explicit consent, except as required by law.</p>
        
        <h4>Your Rights</h4>
        <p>You have the right to access, update, or delete your personal information at any time.</p>
      </div>
      <div class="modal-actions">
        <button class="btn" onclick="closePrivacyModal()">I Understand</button>
      </div>
    </div>
  </div>
</div>

<?php require BASE_PATH.'/app/views/layouts/footer.php'; ?>

