<?php 
$TITLE = 'MindHeaven — Dashboard';
$CURRENT_PAGE = 'dashboard';
$PAGE_CSS = ['/MindHeaven/Undergrad_student/assets/css/dashboard.css'];
$PAGE_JS = ['/MindHeaven/Undergrad_student/assets/js/dashboard.js'];

//include __DIR__ . '/layout/header.php';
?>

<style>
/* Dashboard Inline Styles */
.dashboard-main {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.dashboard-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 3rem 2rem;
  border-radius: 1rem;
  margin-bottom: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
}

.hero-title {
  font-size: 2.5rem;
  margin: 0 0 0.5rem 0;
  font-weight: 700;
}

.hero-subtitle {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0 0 1.5rem 0;
}

.hero-stats {
  display: flex;
  gap: 2rem;
}

.hero-stat {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.9rem;
  opacity: 0.8;
}

.hero-actions {
  display: flex;
  gap: 1rem;
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
}

.btn-primary {
  background: #4f46e5;
  color: white;
}

.btn-primary:hover {
  background: #4338ca;
  transform: translateY(-2px);
}

.btn-outline {
  background: transparent;
  color: white;
  border: 2px solid white;
}

.btn-outline:hover {
  background: white;
  color: #4f46e5;
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

.dashboard-stats {
  margin-bottom: 3rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.stat-card {
  background: white;
  padding: 1.5rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.stat-icon {
  font-size: 2rem;
  width: 3rem;
  height: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f3f4f6;
  border-radius: 0.75rem;
}

.stat-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0 0 0.25rem 0;
  color: #1f2937;
}

.stat-subtitle {
  font-size: 0.9rem;
  color: #6b7280;
  margin: 0;
}

.stat-content {
  margin-bottom: 1rem;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.progress-bar {
  width: 100%;
  height: 0.5rem;
  background: #e5e7eb;
  border-radius: 0.25rem;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #059669);
  transition: width 0.3s ease;
}

.progress-text {
  font-size: 0.9rem;
  color: #6b7280;
}

.mood-display {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 0.5rem;
}

.mood-emoji {
  font-size: 2rem;
}

.mood-text {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
}

.mood-time {
  font-size: 0.9rem;
  color: #6b7280;
}

.appointment-info {
  color: #1f2937;
}

.appointment-time {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.appointment-type {
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 0.25rem;
}

.appointment-location {
  font-size: 0.9rem;
  color: #6b7280;
}

.wellness-score {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.score-circle {
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
  background: linear-gradient(135deg, #10b981, #059669);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: white;
}

.score-number {
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
}

.score-label {
  font-size: 0.8rem;
  opacity: 0.8;
}

.score-trend {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #10b981;
  font-size: 0.9rem;
}

.dashboard-analytics {
  margin-bottom: 3rem;
}

.analytics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 1.5rem;
}

.analytics-card {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
}

.card-header {
  padding: 1.5rem 1.5rem 0 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.time-filter {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  background: white;
  font-size: 0.9rem;
}

.card-content {
  padding: 1.5rem;
}

.dashboard-actions {
  margin-bottom: 2rem;
}

.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
}

.action-card {
  background: white;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  text-align: center;
  transition: all 0.3s ease;
}

.action-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.action-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.action-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.action-description {
  color: #6b7280;
  margin: 0 0 1.5rem 0;
  line-height: 1.5;
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
  max-width: 500px;
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

.mood-selector {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-bottom: 2rem;
}

.mood-option {
  background: #f9fafb;
  border: 2px solid #e5e7eb;
  border-radius: 0.75rem;
  padding: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
}

.mood-option:hover {
  border-color: #4f46e5;
  background: #f0f9ff;
}

.mood-option.selected {
  border-color: #4f46e5;
  background: #eef2ff;
}

.mood-emoji {
  font-size: 2rem;
  display: block;
  margin-bottom: 0.5rem;
}

.mood-label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #374151;
}

.mood-details {
  margin-top: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.intensity-slider {
  width: 100%;
  margin-bottom: 0.5rem;
}

.intensity-labels {
  display: flex;
  justify-content: space-between;
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 1rem;
}

.form-textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-family: inherit;
  resize: vertical;
  min-height: 80px;
}

.modal-footer {
  padding: 1.5rem;
  border-top: 1px solid #e5e7eb;
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

/* Responsive Design */
@media (max-width: 768px) {
  .dashboard-main {
    padding: 1rem;
  }
  
  .hero-content {
    flex-direction: column;
    text-align: center;
  }
  
  .hero-stats {
    justify-content: center;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .analytics-grid {
    grid-template-columns: 1fr;
  }
  
  .actions-grid {
    grid-template-columns: 1fr;
  }
  
  .mood-selector {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>

<main id="main" class="dashboard-main">
  <!-- Welcome Hero Section -->
  <section class="dashboard-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Welcome back, Student! 👋</h1>
        <p class="hero-subtitle">Here's your mental health overview for today</p>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="stat-number">7</span>
            <span class="stat-label">Day Streak</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number">85%</span>
            <span class="stat-label">Wellness Score</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <button id="quickMoodBtn" class="btn btn-primary">
          <span class="btn-icon">😊</span>
          Log Mood
        </button>
        <button id="quickHabitBtn" class="btn btn-outline">
          <span class="btn-icon">✅</span>
          Add Habit
        </button>
      </div>
    </div>
  </section>

  <!-- Quick Stats Grid -->
  <section class="dashboard-stats">
    <div class="stats-grid">
      <div class="stat-card habits-card">
        <div class="stat-header">
          <div class="stat-icon">✅</div>
          <div class="stat-info">
            <h3 class="stat-title">Today's Habits</h3>
            <p class="stat-subtitle">Keep building healthy routines</p>
          </div>
        </div>
        <div class="stat-content">
          <div class="stat-number">3/5</div>
          <div class="stat-progress">
            <div class="progress-bar">
              <div class="progress-fill" style="width: 60%"></div>
            </div>
            <span class="progress-text">60% Complete</span>
          </div>
        </div>
        <div class="stat-actions">
          <a href="/MindHeaven/Undergrad_student/views/habits.php" class="btn btn-small">View All</a>
        </div>
      </div>

      <div class="stat-card mood-card">
        <div class="stat-header">
          <div class="stat-icon">😊</div>
          <div class="stat-info">
            <h3 class="stat-title">Current Mood</h3>
            <p class="stat-subtitle">How are you feeling?</p>
          </div>
        </div>
        <div class="stat-content">
          <div class="mood-display">
            <span class="mood-emoji" id="currentMoodEmoji">😐</span>
            <span class="mood-text" id="currentMoodText">Not logged today</span>
          </div>
          <div class="mood-time" id="moodTime">Last logged: Never</div>
        </div>
        <div class="stat-actions">
          <button id="logMoodBtn" class="btn btn-small btn-primary">Log Mood</button>
        </div>
      </div>

      <div class="stat-card appointments-card">
        <div class="stat-header">
          <div class="stat-icon">📅</div>
          <div class="stat-info">
            <h3 class="stat-title">Next Appointment</h3>
            <p class="stat-subtitle">Upcoming sessions</p>
          </div>
        </div>
        <div class="stat-content">
          <div class="appointment-info">
            <div class="appointment-time">Tomorrow, 3:00 PM</div>
            <div class="appointment-type">Counseling Session</div>
            <div class="appointment-location">Student Health Center</div>
          </div>
        </div>
        <div class="stat-actions">
          <a href="/MindHeaven/Undergrad_student/views/appointments.php" class="btn btn-small">Manage</a>
        </div>
      </div>

      <div class="stat-card wellness-card">
        <div class="stat-header">
          <div class="stat-icon">💚</div>
          <div class="stat-info">
            <h3 class="stat-title">Wellness Score</h3>
            <p class="stat-subtitle">Your mental health progress</p>
          </div>
        </div>
        <div class="stat-content">
          <div class="wellness-score">
            <div class="score-circle">
              <span class="score-number">85</span>
              <span class="score-label">/100</span>
            </div>
            <div class="score-trend">
              <span class="trend-icon">📈</span>
              <span class="trend-text">+5 this week</span>
            </div>
          </div>
        </div>
        <div class="stat-actions">
          <a href="/MindHeaven/Undergrad_student/views/mood.php" class="btn btn-small">View Trends</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Charts and Analytics -->
  <section class="dashboard-analytics">
    <div class="analytics-grid">
      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Habit Progress</h3>
          <div class="card-actions">
            <select class="time-filter" id="habitTimeFilter">
              <option value="7">Last 7 days</option>
              <option value="30" selected>Last 30 days</option>
              <option value="90">Last 90 days</option>
            </select>
          </div>
        </div>
        <div class="card-content">
          <canvas id="habitChart" width="400" height="200"></canvas>
        </div>
      </div>

      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Mood Trends</h3>
          <div class="card-actions">
            <select class="time-filter" id="moodTimeFilter">
              <option value="7">Last 7 days</option>
              <option value="30" selected>Last 30 days</option>
              <option value="90">Last 90 days</option>
            </select>
          </div>
        </div>
        <div class="card-content">
          <canvas id="moodChart" width="400" height="200"></canvas>
        </div>
      </div>
    </div>
  </section>

  <!-- Quick Actions -->
  <section class="dashboard-actions">
    <div class="actions-grid">
      <div class="action-card">
        <div class="action-icon">🎯</div>
        <h4 class="action-title">Set Goals</h4>
        <p class="action-description">Create new wellness goals for this week</p>
        <button class="btn btn-outline">Get Started</button>
      </div>

      <div class="action-card">
        <div class="action-icon">📚</div>
        <h4 class="action-title">Resources</h4>
        <p class="action-description">Explore mental health resources and tools</p>
        <a href="/MindHeaven/Undergrad_student/views/resources.php" class="btn btn-outline">Browse</a>
      </div>

      <div class="action-card">
        <div class="action-icon">🤝</div>
        <h4 class="action-title">Support</h4>
        <p class="action-description">Connect with counselors and support groups</p>
        <a href="/MindHeaven/Undergrad_student/views/contact.php" class="btn btn-outline">Connect</a>
      </div>

      <div class="action-card">
        <div class="action-icon">🆘</div>
        <h4 class="action-title">Crisis Support</h4>
        <p class="action-description">Immediate help when you need it most</p>
        <a href="/MindHeaven/Undergrad_student/views/crisis.php" class="btn btn-danger">Get Help</a>
      </div>
    </div>
  </section>
</main>

<!-- Quick Mood Logging Modal -->
<div id="moodModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">How are you feeling right now?</h3>
      <button class="modal-close" id="closeMoodModal">&times;</button>
    </div>
    <div class="modal-body">
      <div class="mood-selector">
        <button class="mood-option" data-mood="excited" data-emoji="🤩">
          <span class="mood-emoji">🤩</span>
          <span class="mood-label">Excited</span>
        </button>
        <button class="mood-option" data-mood="happy" data-emoji="😊">
          <span class="mood-emoji">😊</span>
          <span class="mood-label">Happy</span>
        </button>
        <button class="mood-option" data-mood="content" data-emoji="😌">
          <span class="mood-emoji">😌</span>
          <span class="mood-label">Content</span>
        </button>
        <button class="mood-option" data-mood="neutral" data-emoji="😐">
          <span class="mood-emoji">😐</span>
          <span class="mood-label">Neutral</span>
        </button>
        <button class="mood-option" data-mood="tired" data-emoji="😴">
          <span class="mood-emoji">😴</span>
          <span class="mood-label">Tired</span>
        </button>
        <button class="mood-option" data-mood="stressed" data-emoji="😰">
          <span class="mood-emoji">😰</span>
          <span class="mood-label">Stressed</span>
        </button>
        <button class="mood-option" data-mood="sad" data-emoji="😢">
          <span class="mood-emoji">😢</span>
          <span class="mood-label">Sad</span>
        </button>
        <button class="mood-option" data-mood="angry" data-emoji="😡">
          <span class="mood-emoji">😡</span>
          <span class="mood-label">Angry</span>
        </button>
      </div>
      <div class="mood-details">
        <label for="moodIntensity" class="form-label">Intensity (1-10)</label>
        <input type="range" id="moodIntensity" class="intensity-slider" min="1" max="10" value="5">
        <div class="intensity-labels">
          <span>Low</span>
          <span>High</span>
        </div>
        <label for="moodNotes" class="form-label">Notes (optional)</label>
        <textarea id="moodNotes" class="form-textarea" placeholder="What's contributing to this mood?"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" id="cancelMoodLog">Cancel</button>
      <button class="btn btn-primary" id="saveMoodLog">Save Mood</button>
    </div>
  </div>
</div>

