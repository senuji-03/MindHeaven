<?php
// views/layout/footer.php
// Expected variable: $PAGE_JS (array)
if (!isset($PAGE_JS)) $PAGE_JS = [];
?>
    </div> <!-- End main-wrapper -->

    <!-- Modern Footer -->
    <footer class="site-footer">
      <div class="footer-content">
        <div class="footer-main">
          <div class="footer-brand">
            <div class="footer-logo">
              <span class="logo-icon">🧠</span>
              <span class="brand-name">MindHeaven</span>
            </div>
            <p class="footer-description">Your comprehensive mental health companion for undergraduate students.</p>
            <div class="footer-social">
              <a href="#" class="social-link" aria-label="Facebook">
                <span class="social-icon">📘</span>
              </a>
              <a href="#" class="social-link" aria-label="Twitter">
                <span class="social-icon">🐦</span>
              </a>
              <a href="#" class="social-link" aria-label="Instagram">
                <span class="social-icon">📷</span>
              </a>
              <a href="#" class="social-link" aria-label="LinkedIn">
                <span class="social-icon">💼</span>
              </a>
            </div>
          </div>

          <div class="footer-links">
            <div class="footer-column">
              <h4 class="footer-title">Features</h4>
              <ul class="footer-list">
                <li><a href="/MindHeaven/Undergrad_student/index.php">Dashboard</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/habits.php">Habit Tracker</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/mood.php">Mood Tracker</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/appointments.php">Appointments</a></li>
              </ul>
            </div>

            <div class="footer-column">
              <h4 class="footer-title">Support</h4>
              <ul class="footer-list">
                <li><a href="/MindHeaven/Undergrad_student/views/resources.php">Resources</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/contact.php">Contact Us</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/about.php">About</a></li>
                <li><a href="/MindHeaven/Undergrad_student/views/crisis.php">Crisis Support</a></li>
              </ul>
            </div>

            <div class="footer-column">
              <h4 class="footer-title">Legal</h4>
              <ul class="footer-list">
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Cookie Policy</a></li>
                <li><a href="#">Accessibility</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <div class="footer-copyright">
            <p>&copy; <?= date('Y') ?> MindHeaven. All rights reserved.</p>
            <p class="footer-disclaimer">This platform is designed for educational purposes and should not replace professional mental health care.</p>
          </div>
          <div class="footer-emergency">
            <p class="emergency-text">In crisis? Call <strong>988</strong> or <strong>911</strong></p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
      <span class="back-to-top-icon">↑</span>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php foreach ($PAGE_JS as $js): ?>
      <script src="<?= htmlspecialchars($js) ?>" defer></script>
    <?php endforeach; ?>
  </body>
</html>
