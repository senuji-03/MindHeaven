<?php 
$TITLE = 'MindHeaven — Feedback System';
$CURRENT_PAGE = 'feedback';
$PAGE_CSS = array('/MindHeaven/public/css/undergrad/style.css');
$PAGE_JS = array('/MindHeaven/public/js/undergrad/main.js');
require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
/* ══════════════════════════════════════════════
   Design tokens
   ══════════════════════════════════════════════ */
:root {
  --primary:        #3D8B6E;
  --primary-dark:   #2A6B52;
  --primary-light:  #6BB89A;
  --accent-warm:    #E8A87C;
  --accent-calm:    #A8C5DA;
  --bg-deep:        #1C2B2A;
  --bg-soft:        #F5F0E8;
  --bg-mid:         #EEF6F2;
  --text-primary:   #1E3A34;
  --text-secondary: #6B8C7E;
  --surface:        #FFFFFF;
  --border:         #D6E4DD;
  --crisis:         #D64F4F;
  --success:        #4CAF82;
  --shadow-sm:      0 1px 3px rgba(30,58,52,.06);
  --shadow-md:      0 4px 12px rgba(30,58,52,.08);
  --shadow-lg:      0 12px 32px rgba(30,58,52,.10);
  --shadow-xl:      0 20px 48px rgba(30,58,52,.12);
  --radius-sm:      8px;
  --radius-md:      14px;
  --radius-lg:      20px;
  --radius-xl:      28px;
  --radius-full:    9999px;
}

/* ── Base Layout ──────────────────────────────── */
.mp {
  font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
  color: var(--text-primary);
  background: transparent;
  padding: 16px 28px;
  max-width: 1200px;
  margin: 0 auto;
  min-height: 100vh;
}

/* ── Page header ─────────────────────────── */
.mp-header {
  background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
  border-radius: var(--radius-lg);
  padding: 24px 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: var(--shadow-lg);
  margin-bottom: 24px;
  position: relative;
  overflow: hidden;
}

.mp-header::after {
  content: '';
  position: absolute;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: rgba(232,168,124,0.15);
  bottom: -40px;
  left: 15%;
  z-index: 0;
}

.mp-header__inner {
  position: relative;
  z-index: 1;
}

.mp-header__title {
  color: #fff;
  font-size: 2.1rem;
  font-weight: 700;
  margin: 0 0 6px;
  letter-spacing: -0.5px;
}

.mp-header__sub {
  color: rgba(255,255,255,.9);
  font-size: .95rem;
  margin: 0;
}

/* ── Stats Row ───────────────────────────── */
.mp-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  background: var(--surface);
  padding: 20px;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--border);
  text-align: center;
  transition: transform .2s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.stat-number {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--primary-dark);
}

.stat-label {
  color: var(--text-secondary);
  font-size: 0.85rem;
  margin-top: 4px;
  font-weight: 500;
}

/* ── Content Grid ────────────────────────── */
.mp-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-bottom: 24px;
}

.mp-card {
  background: var(--surface);
  border-radius: var(--radius-lg);
  padding: 28px;
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--border);
}

.section-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* ── Form Styles ─────────────────────────── */
.feedback-type-selector {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.feedback-type-btn {
  flex: 1;
  padding: 12px;
  border: 1px solid var(--border);
  background: var(--bg-mid);
  border-radius: var(--radius-md);
  cursor: pointer;
  transition: all 0.2s ease;
  font-weight: 600;
  font-size: 0.9rem;
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.feedback-type-btn:hover {
  border-color: var(--primary-light);
  color: var(--primary);
}

.feedback-type-btn.active {
  border-color: var(--primary);
  background: var(--surface);
  color: var(--primary);
  box-shadow: var(--shadow-sm);
}

.form-group {
  margin-bottom: 18px;
}

.form-label {
  display: block;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 8px;
  font-size: 0.9rem;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 12px;
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  font-size: 0.95rem;
  background: var(--bg-mid);
  color: var(--text-primary);
  transition: all 0.2s ease;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: var(--primary);
  background: var(--surface);
  box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.1);
}

.rating-stars {
  display: flex;
  gap: 6px;
  font-size: 1.5rem;
  color: var(--border);
}

.rating-star {
  cursor: pointer;
  transition: color 0.1s ease;
}

.rating-star.active {
  color: var(--accent-warm);
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.9rem;
  color: var(--text-secondary);
}

.btn {
  padding: 12px 24px;
  border: none;
  border-radius: var(--radius-full);
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-size: 0.95rem;
}

.btn-primary {
  background: var(--primary);
  color: white;
  box-shadow: 0 4px 12px rgba(61, 139, 110, 0.2);
}

.btn-primary:hover {
  background: var(--primary-dark);
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(61, 139, 110, 0.3);
}

.btn-secondary {
  background: var(--bg-mid);
  color: var(--text-primary);
  border: 1px solid var(--border);
}

.btn-secondary:hover {
  background: var(--border);
}

.btn-danger {
  background: var(--crisis);
  color: white;
}

.btn-danger:hover {
  background: #a84040;
}

/* ── Feedback List ───────────────────────── */
.feedback-filters {
  display: flex;
  gap: 10px;
  margin-bottom: 24px;
  overflow-x: auto;
  padding-bottom: 4px;
}

.filter-btn {
  white-space: nowrap;
  padding: 8px 16px;
  border: 1px solid var(--border);
  background: var(--bg-mid);
  border-radius: var(--radius-full);
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  color: var(--text-secondary);
}

.filter-btn:hover {
  border-color: var(--primary-light);
  color: var(--primary);
}

.filter-btn.active {
  background: var(--primary);
  color: white;
  border-color: var(--primary);
}

.feedback-item {
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  padding: 20px;
  margin-bottom: 16px;
  background: var(--bg-mid);
  transition: all 0.2s ease;
}

.feedback-item:hover {
  background: var(--surface);
  box-shadow: var(--shadow-md);
  border-color: var(--primary-light);
}

.feedback-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 12px;
}

.feedback-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0;
}

.feedback-type-badge {
  padding: 4px 10px;
  border-radius: var(--radius-full);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.feedback-type-badge.general {
  background: var(--accent-calm);
  color: #2b4c65;
}

.feedback-type-badge.counselor {
  background: var(--success);
  color: white;
}

.feedback-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 12px;
  font-size: 0.85rem;
  color: var(--text-secondary);
}

.feedback-author { font-weight: 700; color: var(--text-primary); }

.feedback-content-text {
  color: var(--text-primary);
  line-height: 1.6;
  margin-bottom: 16px;
  font-size: 0.95rem;
}

.feedback-rating {
  font-size: 0.85rem;
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 16px;
}

.feedback-actions {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
}

/* ── Modals ──────────────────────────────── */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(30, 58, 52, 0.4);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal.show { display: flex; }

.modal-content {
  background: var(--surface);
  border-radius: var(--radius-lg);
  max-width: 550px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: var(--shadow-xl);
  border: 1px solid var(--border);
}

.modal-header {
  padding: 24px;
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title { font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin: 0; }

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--text-secondary);
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-close:hover { background: var(--bg-mid); color: var(--text-primary); }

.modal-body { padding: 24px; }
.modal-footer { padding: 24px; border-top: 1px solid var(--border); display: flex; gap: 12px; justify-content: flex-end; }

/* ── Back Button ────────────────────────── */
.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  margin-bottom: 12px;
  opacity: 0.85;
  transition: opacity 0.2s;
}

.back-button:hover { opacity: 1; }

@media (max-width: 768px) {
  .mp { padding: 16px; }
  .mp-grid { grid-template-columns: 1fr; }
  .mp-stats { grid-template-columns: repeat(2, 1fr); }
  .mp-header { flex-direction: column; text-align: center; }
}
</style>

<main class="mp">
  <!-- Hero Section -->
  <header class="mp-header">
    <div class="mp-header__inner">
      <a href="<?= BASE_URL ?>/ug/" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
      </a>
      <h1 class="mp-header__title">Feedback System</h1>
      <p class="mp-header__sub">Share your experience to help us grow together.</p>
    </div>
  </header>

  <!-- Statistics -->
  <section class="mp-stats">
    <div class="stat-card">
      <div class="stat-number"><?php echo isset($stats['total_feedback']) ? $stats['total_feedback'] : 0; ?></div>
      <div class="stat-label">Total Feedback</div>
    </div>
    <div class="stat-card">
      <div class="stat-number"><?php echo number_format(isset($stats['avg_rating']) ? $stats['avg_rating'] : 0, 1); ?></div>
      <div class="stat-label">Average Rating</div>
    </div>
    <div class="stat-card">
      <div class="stat-number"><?php echo isset($stats['general_feedback_count']) ? $stats['general_feedback_count'] : 0; ?></div>
      <div class="stat-label">System Feedback</div>
    </div>
    <div class="stat-card">
      <div class="stat-number"><?php echo isset($stats['counselor_feedback_count']) ? $stats['counselor_feedback_count'] : 0; ?></div>
      <div class="stat-label">Counselor Feedback</div>
    </div>
  </section>

  <!-- Alert Messages -->
  <?php if (isset($_SESSION['success'])): ?>
    <div style="background: var(--bg-mid); border-left: 4px solid var(--success); padding: 16px; border-radius: var(--radius-sm); margin-bottom: 24px; color: var(--text-primary); font-weight: 500;">
      <i class="fas fa-check-circle" style="color: var(--success); margin-right: 8px;"></i>
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div style="background: #fee2e2; border-left: 4px solid var(--crisis); padding: 16px; border-radius: var(--radius-sm); margin-bottom: 24px; color: #991b1b; font-weight: 500;">
      <i class="fas fa-exclamation-circle" style="color: var(--crisis); margin-right: 8px;"></i>
      <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <div class="mp-grid">
    <!-- Feedback Form Section -->
    <div class="mp-card">
      <h2 class="section-title">
        <i class="fas fa-pen-fancy" style="color: var(--primary);"></i>
        Submit Feedback
      </h2>

      <form id="feedbackForm" method="POST" action="<?php echo BASE_URL; ?>/ug/feedback/create">
        <div class="form-group">
          <label class="form-label">Type of Feedback</label>
          <div class="feedback-type-selector">
            <button type="button" class="feedback-type-btn active" data-type="general">
              <i class="fas fa-desktop"></i> Platform
            </button>
            <button type="button" class="feedback-type-btn" data-type="counselor">
              <i class="fas fa-user-md"></i> Counselor
            </button>
          </div>
          <input type="hidden" name="feedback_type" value="general" id="feedbackTypeInput">
        </div>

        <div class="form-group" id="counselorGroup" style="display: none;">
          <label for="counselor_id" class="form-label">Select Counselor</label>
          <select name="counselor_id" id="counselor_id" class="form-select">
            <option value="">Choose a counselor...</option>
            <?php foreach ($counselors as $counselor): ?>
              <option value="<?php echo $counselor['id']; ?>">
                <?php echo htmlspecialchars($counselor['full_name']); ?>
                <?php if ($counselor['specialization']): ?>
                  - <?php echo htmlspecialchars($counselor['specialization']); ?>
                <?php endif; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="title" class="form-label">Title</label>
          <input type="text" name="title" id="title" class="form-input" required 
                 placeholder="Short summary of your feedback">
        </div>

        <div class="form-group">
          <label for="content" class="form-label">Details</label>
          <textarea name="content" id="content" class="form-textarea" required 
                    placeholder="Share your experience or suggestions..."></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Overall Rating</label>
          <div class="rating-stars">
            <?php for($i=1; $i<=5; $i++): ?>
              <span class="rating-star" data-rating="<?= $i ?>">★</span>
            <?php endfor; ?>
          </div>
          <input type="hidden" name="rating" id="ratingInput">
        </div>

        <div class="form-group">
          <div class="checkbox-group">
            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" style="width: 18px; height: 18px; accent-color: var(--primary);">
            <label for="is_anonymous">Submit this anonymously</label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
          Submit My Feedback
        </button>
      </form>
    </div>

    <!-- Feedback List Section -->
    <div class="mp-card">
      <h2 class="section-title">
        <i class="fas fa-list-ul" style="color: var(--primary);"></i>
        Recent Feedback
      </h2>

      <div class="feedback-filters">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="general">Platform</button>
        <button class="filter-btn" data-filter="counselor">Counselor</button>
        <button class="filter-btn" data-filter="my">My Submissions</button>
      </div>

      <div id="feedbackList">
        <?php if (empty($allFeedback)): ?>
          <div style="text-align: center; padding: 48px 0; color: var(--text-secondary);">
            <i class="fas fa-comment-slash" style="font-size: 3rem; opacity: 0.2; margin-bottom: 16px; display: block;"></i>
            <p>No feedback entries found yet.</p>
          </div>
        <?php else: ?>
          <?php foreach ($allFeedback as $feedback): ?>
            <div class="feedback-item" data-type="<?php echo $feedback['feedback_type']; ?>" 
                 data-user="<?php echo $feedback['user_id'] == $_SESSION['user_id'] ? 'my' : 'other'; ?>">
              <div class="feedback-header">
                <h3 class="feedback-title"><?php echo htmlspecialchars($feedback['title']); ?></h3>
                <span class="feedback-type-badge <?php echo $feedback['feedback_type']; ?>">
                  <?php 
                    if ($feedback['feedback_type'] === 'general') echo 'Platform';
                    elseif ($feedback['feedback_type'] === 'counselor') echo 'Counselor (Private)';
                    else echo ucfirst($feedback['feedback_type']);
                  ?>
                </span>
              </div>

              <div class="feedback-meta">
                <span class="feedback-author">
                  <i class="fas fa-user-circle"></i>
                  <?php echo $feedback['is_anonymous'] ? 'Anonymous' : htmlspecialchars($feedback['user_name']); ?>
                </span>
                <span class="feedback-date">
                  <i class="far fa-calendar-alt"></i>
                  <?php echo date('M j, Y', strtotime($feedback['created_at'])); ?>
                </span>
              </div>

              <?php if ($feedback['rating']): ?>
                <div class="feedback-rating">
                  <div class="rating-stars" style="font-size: 1rem; color: var(--accent-warm);">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <span><?php echo $i <= $feedback['rating'] ? '★' : '☆'; ?></span>
                    <?php endfor; ?>
                  </div>
                  <span>(<?php echo $feedback['rating']; ?>/5)</span>
                </div>
              <?php endif; ?>

              <div class="feedback-content-text">
                <?php echo nl2br(htmlspecialchars($feedback['content'])); ?>
              </div>

              <?php if ($feedback['counselor_name']): ?>
                <div style="font-size: 0.85rem; padding: 8px 12px; background: var(--bg-soft); border-radius: var(--radius-sm); margin-bottom: 16px; color: var(--primary-dark); font-weight: 500;">
                  <i class="fas fa-user-md"></i> Recipient: <?php echo htmlspecialchars($feedback['counselor_name']); ?>
                </div>
              <?php endif; ?>

              <?php if ($feedback['user_id'] == $_SESSION['user_id']): ?>
                <div class="feedback-actions">
                  <button class="btn btn-secondary edit-feedback" style="padding: 6px 12px; font-size: 0.8rem;"
                          data-id="<?php echo $feedback['id']; ?>">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn btn-danger delete-feedback" style="padding: 6px 12px; font-size: 0.8rem;"
                          data-id="<?php echo $feedback['id']; ?>">
                    <i class="fas fa-trash"></i> Delete
                  </button>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<!-- Edit Feedback Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Edit Your Feedback</h3>
      <button class="modal-close" id="closeEditModal">&times;</button>
    </div>
    <form id="editForm" method="POST" action="<?php echo BASE_URL; ?>/ug/feedback/edit">
      <div class="modal-body">
        <input type="hidden" name="feedback_id" id="editFeedbackId">
        
        <div class="form-group">
          <label for="editTitle" class="form-label">Title</label>
          <input type="text" name="title" id="editTitle" class="form-input" required>
        </div>

        <div class="form-group">
          <label for="editContent" class="form-label">Your Message</label>
          <textarea name="content" id="editContent" class="form-textarea" required></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Rating</label>
          <div class="rating-stars" id="editRatingStars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <span class="rating-star" data-rating="<?= $i ?>">★</span>
            <?php endfor; ?>
          </div>
          <input type="hidden" name="rating" id="editRatingInput">
        </div>

        <div class="form-group">
          <div class="checkbox-group">
            <input type="checkbox" name="is_anonymous" id="editIsAnonymous" value="1" style="width: 18px; height: 18px; accent-color: var(--primary);">
            <label for="editIsAnonymous">Keep this anonymous</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelEdit">Discard</button>
        <button type="submit" class="btn btn-primary">Update Feedback</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Delete Entry</h3>
      <button class="modal-close" id="closeDeleteModal">&times;</button>
    </div>
    <div class="modal-body">
      <p style="color: var(--text-primary); margin: 0;">Are you sure you want to permanently delete this feedback? This action cannot be undone.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" id="cancelDelete">No, Keep it</button>
      <form id="deleteForm" method="POST" action="<?php echo BASE_URL; ?>/ug/feedback/delete" style="display: inline;">
        <input type="hidden" name="feedback_id" id="deleteFeedbackId">
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Feedback type selection
  const typeButtons = document.querySelectorAll('.feedback-type-btn');
  const feedbackTypeInput = document.getElementById('feedbackTypeInput');
  const counselorGroup = document.getElementById('counselorGroup');
  const counselorSelect = document.getElementById('counselor_id');

  typeButtons.forEach(button => {
    button.addEventListener('click', function() {
      typeButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      
      const type = this.dataset.type;
      feedbackTypeInput.value = type;
      
      if (type === 'counselor') {
        counselorGroup.style.display = 'block';
        counselorSelect.required = true;
      } else {
        counselorGroup.style.display = 'none';
        counselorSelect.required = false;
        counselorSelect.value = '';
      }
    });
  });

  // Rating system
  function setupRatingSystem(containerSelector, inputSelector) {
    const stars = document.querySelectorAll(containerSelector + ' .rating-star');
    const input = document.querySelector(inputSelector);
    let rating = 0;

    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        rating = index + 1;
        updateStars();
      });

      star.addEventListener('mouseenter', () => {
        highlightStars(index + 1);
      });
    });

    document.querySelector(containerSelector).addEventListener('mouseleave', () => {
      updateStars();
    });

    function highlightStars(count) {
      stars.forEach((s, i) => {
        s.classList.toggle('active', i < count);
      });
    }

    function updateStars() {
      stars.forEach((s, i) => {
        s.classList.toggle('active', i < rating);
      });
      input.value = rating;
    }

    return {
      setRating: (r) => {
        rating = r;
        updateStars();
      }
    };
  }

  const mainRating = setupRatingSystem('.mp-card .rating-stars', '#ratingInput');
  const editRating = setupRatingSystem('#editRatingStars', '#editRatingInput');

  // Filter system
  const filterButtons = document.querySelectorAll('.filter-btn');
  const feedbackItems = document.querySelectorAll('.feedback-item');

  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      
      const filter = this.dataset.filter;
      
      feedbackItems.forEach(item => {
        const itemType = item.dataset.type;
        const itemUser = item.dataset.user;
        
        let show = false;
        if (filter === 'all') {
          show = true;
        } else if (filter === 'general' && itemType === 'general') {
          show = true;
        } else if (filter === 'counselor' && itemType === 'counselor') {
          show = true;
        } else if (filter === 'my' && itemUser === 'my') {
          show = true;
        }
        
        item.style.display = show ? 'block' : 'none';
      });
    });
  });

  // Edit feedback
  const editButtons = document.querySelectorAll('.edit-feedback');
  const editModal = document.getElementById('editModal');
  const editFeedbackId = document.getElementById('editFeedbackId');
  const editTitle = document.getElementById('editTitle');
  const editContent = document.getElementById('editContent');
  const editIsAnonymous = document.getElementById('editIsAnonymous');

  editButtons.forEach(button => {
    button.addEventListener('click', function() {
      const id = this.dataset.id;
      
      fetch(`<?php echo BASE_URL; ?>/ug/feedback/get?id=${id}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const f = data.feedback;
            editFeedbackId.value = f.id;
            editTitle.value = f.title;
            editContent.value = f.content;
            editIsAnonymous.checked = f.is_anonymous == 1;
            editRating.setRating(f.rating || 0);
            
            editModal.classList.add('show');
          }
        });
    });
  });

  // Delete feedback
  const deleteButtons = document.querySelectorAll('.delete-feedback');
  const deleteModal = document.getElementById('deleteModal');
  const deleteFeedbackId = document.getElementById('deleteFeedbackId');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
      deleteFeedbackId.value = this.dataset.id;
      deleteModal.classList.add('show');
    });
  });

  // Close modals
  document.querySelectorAll('.modal-close, .modal .btn-secondary, .modal').forEach(el => {
    el.addEventListener('click', (e) => {
      if (e.target === el || el.classList.contains('modal-close') || el.id.startsWith('cancel')) {
        document.querySelectorAll('.modal').forEach(m => m.classList.remove('show'));
      }
    });
  });
});
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
