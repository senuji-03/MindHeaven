<?php
$TITLE = 'MindHeaven — Contact & Support';
$CURRENT_PAGE = 'contact';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/contact.css'];
$PAGE_JS = ['/MindHeaven/public/css/undergrad/contact.js'];

require BASE_PATH . '/app/views/layouts/header.php';
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
      <!-- Contact Information -->
      <div class="card col-12 contact-info-card">
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
              <p>Click on "Forgot Password" on the login page and enter your email address. You'll receive a reset link
                within a few minutes.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>Is my data secure and private?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Yes, we use industry-standard encryption and follow strict privacy guidelines. Your data is never
                shared without your explicit consent.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>Can I use this system on my mobile device?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Absolutely! MindHeaven is fully responsive and works great on smartphones, tablets, and desktop
                computers.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>What if I'm having a mental health crisis?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>If you're in immediate danger, call 911 or 988 (Suicide & Crisis Lifeline). For non-emergency support,
                contact our crisis support team through the crisis page.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" onclick="toggleFAQ(this)">
              <span>How do I schedule an appointment with a counselor?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <p>Use the Appointments page to book sessions with available counselors. You can also call our counseling
                center directly at (555) 123-4567.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>