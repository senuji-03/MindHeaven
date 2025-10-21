<?php 
$TITLE = 'Feedback System';
$CURRENT_PAGE = 'feedback';
$PAGE_CSS = array('/MindHeaven/public/css/undergrad/style.css');
$PAGE_JS = array('/MindHeaven/public/js/undergrad/main.js');
?>

<style>
/* Feedback System Styles */
.feedback-main {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.feedback-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 3rem 2rem;
  border-radius: 1rem;
  margin-bottom: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  text-align: center;
}

.feedback-hero h1 {
  font-size: 2.5rem;
  margin: 0 0 1rem 0;
  font-weight: 700;
}

.feedback-hero p {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0;
}

.feedback-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  padding: 1.5rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  text-align: center;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.stat-label {
  color: #6b7280;
  font-size: 0.9rem;
}

.feedback-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.feedback-form-section {
  background: white;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 1.5rem 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.feedback-type-selector {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
}

.feedback-type-btn {
  flex: 1;
  padding: 1rem;
  border: 2px solid #e5e7eb;
  background: #f9fafb;
  border-radius: 0.75rem;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  font-weight: 600;
  color: #374151;
}

.feedback-type-btn:hover {
  border-color: #4f46e5;
  background: #f0f9ff;
}

.feedback-type-btn.active {
  border-color: #4f46e5;
  background: #eef2ff;
  color: #4f46e5;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-family: inherit;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-textarea {
  resize: vertical;
  min-height: 120px;
}

.rating-group {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.rating-star {
  font-size: 1.5rem;
  color: #d1d5db;
  cursor: pointer;
  transition: color 0.3s ease;
}

.rating-star.active {
  color: #fbbf24;
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.checkbox-group input[type="checkbox"] {
  width: auto;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover {
  background: #4338ca;
  transform: translateY(-2px);
}

.btn-secondary {
  background: #6b7280;
  color: white;
}

.btn-secondary:hover {
  background: #4b5563;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}

.btn-small {
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
}

.feedback-list-section {
  background: white;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
}

.feedback-filters {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}

.filter-btn {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  background: white;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.9rem;
}

.filter-btn:hover {
  border-color: #4f46e5;
  color: #4f46e5;
}

.filter-btn.active {
  background: #4f46e5;
  color: white;
  border-color: #4f46e5;
}

.feedback-item {
  border: 1px solid #e5e7eb;
  border-radius: 0.75rem;
  padding: 1.5rem;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
}

.feedback-item:hover {
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transform: translateY(-2px);
}

.feedback-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.feedback-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.feedback-type-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.feedback-type-badge.general {
  background: #dbeafe;
  color: #1e40af;
}

.feedback-type-badge.counselor {
  background: #dcfce7;
  color: #166534;
}

.feedback-meta {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
  font-size: 0.9rem;
  color: #6b7280;
}

.feedback-content-text {
  color: #374151;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.feedback-rating {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.feedback-actions {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.feedback-author {
  font-weight: 600;
  color: #1f2937;
}

.feedback-date {
  color: #6b7280;
}

.counselor-name {
  color: #4f46e5;
  font-weight: 600;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 1000;
  align-items: center;
  justify-content: center;
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
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
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
}

.modal-close:hover {
  background: #f3f4f6;
  color: #1f2937;
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  padding: 1.5rem;
  border-top: 1px solid #e5e7eb;
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

/* Alert Messages */
.alert {
  padding: 1rem;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
}

.alert-success {
  background: #d1fae5;
  color: #065f46;
  border-color: #a7f3d0;
}

.alert-error {
  background: #fee2e2;
  color: #991b1b;
  border-color: #fca5a5;
}

/* Responsive Design */
@media (max-width: 768px) {
  .feedback-main {
    padding: 1rem;
  }
  
  .feedback-content {
    grid-template-columns: 1fr;
  }
  
  .feedback-stats {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .feedback-type-selector {
    flex-direction: column;
  }
  
  .feedback-filters {
    flex-direction: column;
  }
  
  .feedback-header {
    flex-direction: column;
    gap: 1rem;
  }
  
  .feedback-actions {
    justify-content: flex-start;
  }
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 3rem 1rem;
  color: #6b7280;
}

.empty-state-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.empty-state-title {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #374151;
}

.empty-state-text {
  margin-bottom: 2rem;
}
</style>

<main class="feedback-main">
  <!-- Hero Section -->
  <section class="feedback-hero">
    <h1>💬 Feedback System</h1>
    <p>Share your thoughts about the system and counselors to help us improve</p>
  </section>

  <!-- Statistics -->
  <section class="feedback-stats">
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
    <div class="alert alert-success">
      <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
      <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <!-- Main Content -->
  <div class="feedback-content">
    <!-- Feedback Form Section -->
    <div class="feedback-form-section">
      <h2 class="section-title">
        <span>✍️</span>
        Submit Feedback
      </h2>

      <form id="feedbackForm" method="POST" action="<?php echo BASE_URL; ?>/ug/feedback/create">
        <!-- Feedback Type Selection -->
        <div class="form-group">
          <label class="form-label">Feedback Type</label>
          <div class="feedback-type-selector">
            <button type="button" class="feedback-type-btn active" data-type="general">
              🏢 General Feedback
            </button>
            <button type="button" class="feedback-type-btn" data-type="counselor">
              👨‍⚕️ Counselor Feedback
            </button>
          </div>
          <input type="hidden" name="feedback_type" value="general" id="feedbackTypeInput">
        </div>

        <!-- Counselor Selection (hidden by default) -->
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

        <!-- Title -->
        <div class="form-group">
          <label for="title" class="form-label">Title</label>
          <input type="text" name="title" id="title" class="form-input" required 
                 placeholder="Brief title for your feedback">
        </div>

        <!-- Content -->
        <div class="form-group">
          <label for="content" class="form-label">Feedback Content</label>
          <textarea name="content" id="content" class="form-textarea" required 
                    placeholder="Share your detailed feedback here..."></textarea>
        </div>

        <!-- Rating -->
        <div class="form-group">
          <label class="form-label">Rating (Optional)</label>
          <div class="rating-group">
            <span>Poor</span>
            <div class="rating-stars">
              <span class="rating-star" data-rating="1">★</span>
              <span class="rating-star" data-rating="2">★</span>
              <span class="rating-star" data-rating="3">★</span>
              <span class="rating-star" data-rating="4">★</span>
              <span class="rating-star" data-rating="5">★</span>
            </div>
            <span>Excellent</span>
          </div>
          <input type="hidden" name="rating" id="ratingInput">
        </div>

        <!-- Anonymous Option -->
        <div class="form-group">
          <div class="checkbox-group">
            <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1">
            <label for="is_anonymous">Submit anonymously</label>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
          <span>📤</span>
          Submit Feedback
        </button>
      </form>
    </div>

    <!-- Feedback List Section -->
    <div class="feedback-list-section">
      <h2 class="section-title">
        <span>📋</span>
        All Feedback
      </h2>

      <!-- Filters -->
      <div class="feedback-filters">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="general">General</button>
        <button class="filter-btn" data-filter="counselor">Counselor</button>
        <button class="filter-btn" data-filter="my">My Feedback</button>
      </div>

      <!-- Feedback List -->
      <div id="feedbackList">
        <?php if (empty($allFeedback)): ?>
          <div class="empty-state">
            <div class="empty-state-icon">💭</div>
            <h3 class="empty-state-title">No feedback yet</h3>
            <p class="empty-state-text">Be the first to share your thoughts!</p>
          </div>
        <?php else: ?>
          <?php foreach ($allFeedback as $feedback): ?>
            <div class="feedback-item" data-type="<?php echo $feedback['feedback_type']; ?>" 
                 data-user="<?php echo $feedback['user_id'] == $_SESSION['user_id'] ? 'my' : 'other'; ?>">
              <div class="feedback-header">
                <h3 class="feedback-title"><?php echo htmlspecialchars($feedback['title']); ?></h3>
                <span class="feedback-type-badge <?php echo $feedback['feedback_type']; ?>">
                  <?php echo ucfirst($feedback['feedback_type']); ?>
                </span>
              </div>

              <div class="feedback-meta">
                <span class="feedback-author">
                  <?php if ($feedback['is_anonymous']): ?>
                    Anonymous User
                  <?php else: ?>
                    <?php echo htmlspecialchars($feedback['user_name']); ?>
                  <?php endif; ?>
                </span>
                <span class="feedback-date">
                  <?php echo date('M j, Y', strtotime($feedback['created_at'])); ?>
                </span>
                <?php if ($feedback['counselor_name']): ?>
                  <span class="counselor-name">
                    for <?php echo htmlspecialchars($feedback['counselor_name']); ?>
                  </span>
                <?php endif; ?>
              </div>

              <?php if ($feedback['rating']): ?>
                <div class="feedback-rating">
                  <span>Rating:</span>
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="rating-star <?php echo $i <= $feedback['rating'] ? 'active' : ''; ?>">★</span>
                  <?php endfor; ?>
                  <span>(<?php echo $feedback['rating']; ?>/5)</span>
                </div>
              <?php endif; ?>

              <div class="feedback-content-text">
                <?php echo nl2br(htmlspecialchars($feedback['content'])); ?>
              </div>

              <?php if ($feedback['user_id'] == $_SESSION['user_id']): ?>
                <div class="feedback-actions">
                  <button class="btn btn-small btn-secondary edit-feedback" 
                          data-id="<?php echo $feedback['id']; ?>">
                    <span>✏️</span>
                    Edit
                  </button>
                  <button class="btn btn-small btn-danger delete-feedback" 
                          data-id="<?php echo $feedback['id']; ?>">
                    <span>🗑️</span>
                    Delete
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
      <h3 class="modal-title">Edit Feedback</h3>
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
          <label for="editContent" class="form-label">Content</label>
          <textarea name="content" id="editContent" class="form-textarea" required></textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Rating</label>
          <div class="rating-group">
            <span>Poor</span>
            <div class="rating-stars" id="editRatingStars">
              <span class="rating-star" data-rating="1">★</span>
              <span class="rating-star" data-rating="2">★</span>
              <span class="rating-star" data-rating="3">★</span>
              <span class="rating-star" data-rating="4">★</span>
              <span class="rating-star" data-rating="5">★</span>
            </div>
            <span>Excellent</span>
          </div>
          <input type="hidden" name="rating" id="editRatingInput">
        </div>

        <div class="form-group">
          <div class="checkbox-group">
            <input type="checkbox" name="is_anonymous" id="editIsAnonymous" value="1">
            <label for="editIsAnonymous">Submit anonymously</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelEdit">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Feedback</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Delete Feedback</h3>
      <button class="modal-close" id="closeDeleteModal">&times;</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete this feedback? This action cannot be undone.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" id="cancelDelete">Cancel</button>
      <form id="deleteForm" method="POST" action="<?php echo BASE_URL; ?>/ug/feedback/delete" style="display: inline;">
        <input type="hidden" name="feedback_id" id="deleteFeedbackId">
        <button type="submit" class="btn btn-danger">Delete</button>
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
  const ratingStars = document.querySelectorAll('.rating-star');
  const ratingInput = document.getElementById('ratingInput');
  let currentRating = 0;

  ratingStars.forEach((star, index) => {
    star.addEventListener('click', function() {
      currentRating = index + 1;
      updateRatingDisplay();
    });

    star.addEventListener('mouseenter', function() {
      highlightStars(index + 1);
    });
  });

  document.querySelector('.rating-group').addEventListener('mouseleave', function() {
    updateRatingDisplay();
  });

  function updateRatingDisplay() {
    ratingStars.forEach((star, index) => {
      star.classList.toggle('active', index < currentRating);
    });
    ratingInput.value = currentRating;
  }

  function highlightStars(rating) {
    ratingStars.forEach((star, index) => {
      star.classList.toggle('active', index < rating);
    });
  }

  // Edit rating system
  const editRatingStars = document.querySelectorAll('#editRatingStars .rating-star');
  const editRatingInput = document.getElementById('editRatingInput');
  let editCurrentRating = 0;

  editRatingStars.forEach((star, index) => {
    star.addEventListener('click', function() {
      editCurrentRating = index + 1;
      updateEditRatingDisplay();
    });

    star.addEventListener('mouseenter', function() {
      highlightEditStars(index + 1);
    });
  });

  document.getElementById('editRatingStars').addEventListener('mouseleave', function() {
    updateEditRatingDisplay();
  });

  function updateEditRatingDisplay() {
    editRatingStars.forEach((star, index) => {
      star.classList.toggle('active', index < editCurrentRating);
    });
    editRatingInput.value = editCurrentRating;
  }

  function highlightEditStars(rating) {
    editRatingStars.forEach((star, index) => {
      star.classList.toggle('active', index < rating);
    });
  }

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
  const editForm = document.getElementById('editForm');
  const editFeedbackId = document.getElementById('editFeedbackId');
  const editTitle = document.getElementById('editTitle');
  const editContent = document.getElementById('editContent');
  const editIsAnonymous = document.getElementById('editIsAnonymous');

  editButtons.forEach(button => {
    button.addEventListener('click', function() {
      const feedbackId = this.dataset.id;
      console.log('Edit button clicked for feedback ID:', feedbackId);
      
      // Fetch feedback data
      fetch(`<?php echo BASE_URL; ?>/ug/feedback/get?id=${feedbackId}`)
        .then(response => response.json())
        .then(data => {
          console.log('Feedback data received:', data);
          if (data.success) {
            const feedback = data.feedback;
            editFeedbackId.value = feedback.id;
            editTitle.value = feedback.title;
            editContent.value = feedback.content;
            editIsAnonymous.checked = feedback.is_anonymous == 1;
            
            // Set rating
            editCurrentRating = feedback.rating || 0;
            updateEditRatingDisplay();
            
            editModal.classList.add('show');
            console.log('Edit modal opened');
          } else {
            alert('Error loading feedback: ' + data.error);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error loading feedback');
        });
    });
  });

  // Delete feedback
  const deleteButtons = document.querySelectorAll('.delete-feedback');
  const deleteModal = document.getElementById('deleteModal');
  const deleteForm = document.getElementById('deleteForm');
  const deleteFeedbackId = document.getElementById('deleteFeedbackId');

  deleteButtons.forEach(button => {
    button.addEventListener('click', function() {
      const feedbackId = this.dataset.id;
      console.log('Delete button clicked for feedback ID:', feedbackId);
      deleteFeedbackId.value = feedbackId;
      deleteModal.classList.add('show');
      console.log('Delete modal opened');
    });
  });

  // Modal controls
  const closeEditModal = document.getElementById('closeEditModal');
  const cancelEdit = document.getElementById('cancelEdit');
  const closeDeleteModal = document.getElementById('closeDeleteModal');
  const cancelDelete = document.getElementById('cancelDelete');

  closeEditModal.addEventListener('click', () => {
    console.log('Edit modal closed');
    editModal.classList.remove('show');
  });
  cancelEdit.addEventListener('click', () => {
    console.log('Edit modal cancelled');
    editModal.classList.remove('show');
  });
  closeDeleteModal.addEventListener('click', () => {
    console.log('Delete modal closed');
    deleteModal.classList.remove('show');
  });
  cancelDelete.addEventListener('click', () => {
    console.log('Delete modal cancelled');
    deleteModal.classList.remove('show');
  });

  // Close modals when clicking outside
  editModal.addEventListener('click', function(e) {
    if (e.target === this) {
      this.classList.remove('show');
    }
  });

  deleteModal.addEventListener('click', function(e) {
    if (e.target === this) {
      this.classList.remove('show');
    }
  });
});
</script>
