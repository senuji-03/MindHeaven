<?php
$TITLE = 'MindHeaven — Habits';
$CURRENT_PAGE = 'habits';
$PAGE_CSS = ['/MindHeaven/Undergrad_student/assets/css/habits.css'];
$PAGE_JS  = ['/MindHeaven/Undergrad_student/assets/js/habits.js'];

include __DIR__ . '/layout/header.php';
?>

<style>
/* Habits Page Inline Styles */
.habits-main {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.habits-hero {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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

.btn-small {
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
}

/* Today's Habits Section */
.today-habits {
  margin-bottom: 3rem;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.section-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.section-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.completion-status {
  font-size: 0.9rem;
  color: #6b7280;
  font-weight: 500;
}

.progress-bar {
  width: 120px;
  height: 0.5rem;
  background: #e5e7eb;
  border-radius: 0.25rem;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #059669);
  transition: width 0.3s ease;
}

.habits-list {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
}

.habit-item {
  display: flex;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.3s ease;
}

.habit-item:last-child {
  border-bottom: none;
}

.habit-item:hover {
  background: #f9fafb;
}

.habit-checkbox {
  margin-right: 1rem;
}

.habit-check {
  display: none;
}

.habit-label {
  display: block;
  width: 1.5rem;
  height: 1.5rem;
  border: 2px solid #d1d5db;
  border-radius: 0.375rem;
  cursor: pointer;
  position: relative;
  transition: all 0.3s ease;
}

.habit-check:checked + .habit-label {
  background: #10b981;
  border-color: #10b981;
}

.habit-check:checked + .habit-label .checkmark {
  opacity: 1;
  transform: scale(1);
}

.checkmark {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0);
  color: white;
  font-size: 0.8rem;
  opacity: 0;
  transition: all 0.3s ease;
}

.habit-content {
  flex: 1;
}

.habit-name {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.habit-meta {
  display: flex;
  gap: 1rem;
  font-size: 0.9rem;
}

.habit-category {
  color: #6b7280;
  background: #f3f4f6;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
}

.habit-streak {
  color: #f59e0b;
  font-weight: 500;
}

.habit-actions {
  margin-left: 1rem;
}

.habit-btn {
  background: none;
  border: none;
  padding: 0.5rem;
  border-radius: 0.375rem;
  cursor: pointer;
  transition: all 0.3s ease;
  color: #6b7280;
}

.habit-btn:hover {
  background: #f3f4f6;
  color: #1f2937;
}

/* Habit Calendar Section */
.habit-calendar {
  margin-bottom: 3rem;
}

.calendar-controls {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.calendar-btn {
  background: #f3f4f6;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  color: #374151;
  font-weight: 500;
}

.calendar-btn:hover {
  background: #e5e7eb;
}

.calendar-month {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  min-width: 150px;
  text-align: center;
}

.calendar-container {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  padding: 1.5rem;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 0.5rem;
}

.calendar-day {
  aspect-ratio: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
  color: #374151;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
}

.calendar-day:hover {
  background: #e5e7eb;
}

.calendar-day.today {
  background: #dbeafe;
  color: #1e40af;
  border-color: #3b82f6;
}

.calendar-day.completed {
  background: #dcfce7;
  color: #166534;
  border-color: #22c55e;
}

.calendar-day-header {
  font-weight: 600;
  color: #6b7280;
  text-align: center;
  padding: 0.5rem;
  background: #f3f4f6;
  border-radius: 0.375rem;
}

/* Habit Analytics Section */
.habit-analytics {
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

.category-stats {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.category-item {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.category-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  min-width: 120px;
}

.category-icon {
  font-size: 1.2rem;
}

.category-name {
  font-weight: 500;
  color: #374151;
}

.category-progress {
  flex: 1;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.progress-text {
  font-size: 0.9rem;
  font-weight: 600;
  color: #6b7280;
  min-width: 40px;
}

/* Suggested Habits Section */
.suggested-habits {
  margin-bottom: 2rem;
}

.section-subtitle {
  color: #6b7280;
  margin: 0.5rem 0 2rem 0;
}

.suggestions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.suggestion-card {
  background: white;
  padding: 1.5rem;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.suggestion-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.suggestion-icon {
  font-size: 2.5rem;
  text-align: center;
}

.suggestion-content {
  flex: 1;
}

.suggestion-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.suggestion-description {
  color: #6b7280;
  margin: 0 0 1rem 0;
  line-height: 1.5;
}

.suggestion-meta {
  display: flex;
  gap: 1rem;
  font-size: 0.9rem;
}

.suggestion-category {
  color: #6b7280;
  background: #f3f4f6;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
}

.suggestion-difficulty {
  color: #6b7280;
  background: #f3f4f6;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
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

.habit-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

.form-input,
.form-select,
.form-textarea {
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-family: inherit;
  transition: all 0.3s ease;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-textarea {
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
  .habits-main {
    padding: 1rem;
  }
  
  .hero-content {
    flex-direction: column;
    text-align: center;
  }
  
  .hero-stats {
    justify-content: center;
  }
  
  .section-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }
  
  .habit-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .habit-actions {
    margin-left: 0;
    align-self: flex-end;
  }
  
  .analytics-grid {
    grid-template-columns: 1fr;
  }
  
  .suggestions-grid {
    grid-template-columns: 1fr;
  }
  
  .calendar-grid {
    gap: 0.25rem;
  }
  
  .calendar-day {
    font-size: 0.8rem;
  }
}
</style>

<main id="main" class="habits-main">
  <!-- Hero Section -->
  <section class="habits-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Build Better Habits 📈</h1>
        <p class="hero-subtitle">Track your daily routines and build lasting positive changes</p>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="stat-number" id="totalHabits">5</span>
            <span class="stat-label">Active Habits</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number" id="streakDays">7</span>
            <span class="stat-label">Day Streak</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number" id="completionRate">85%</span>
            <span class="stat-label">Completion Rate</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <button id="addHabitBtn" class="btn btn-primary">
          <span class="btn-icon">➕</span>
          Add New Habit
        </button>
      </div>
    </div>
  </section>

  <!-- Today's Habits -->
  <section class="today-habits">
    <div class="section-header">
      <h2 class="section-title">Today's Habits</h2>
      <div class="section-actions">
        <span class="completion-status" id="todayCompletion">3/5 completed</span>
        <div class="progress-bar">
          <div class="progress-fill" id="todayProgress" style="width: 60%"></div>
        </div>
      </div>
    </div>
    
    <div class="habits-list" id="todayHabitsList">
      <div class="habit-item">
        <div class="habit-checkbox">
          <input type="checkbox" id="habit-1" class="habit-check" data-habit="Drink 8 glasses of water">
          <label for="habit-1" class="habit-label">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="habit-content">
          <div class="habit-name">Drink 8 glasses of water</div>
          <div class="habit-meta">
            <span class="habit-category">Health</span>
            <span class="habit-streak">🔥 7 days</span>
          </div>
        </div>
        <div class="habit-actions">
          <button class="habit-btn" title="Edit habit">
            <span>✏️</span>
          </button>
        </div>
      </div>

      <div class="habit-item">
        <div class="habit-checkbox">
          <input type="checkbox" id="habit-2" class="habit-check" data-habit="Exercise for 30 minutes">
          <label for="habit-2" class="habit-label">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="habit-content">
          <div class="habit-name">Exercise for 30 minutes</div>
          <div class="habit-meta">
            <span class="habit-category">Fitness</span>
            <span class="habit-streak">🔥 5 days</span>
          </div>
        </div>
        <div class="habit-actions">
          <button class="habit-btn" title="Edit habit">
            <span>✏️</span>
          </button>
        </div>
      </div>

      <div class="habit-item">
        <div class="habit-checkbox">
          <input type="checkbox" id="habit-3" class="habit-check" data-habit="Sleep 7+ hours">
          <label for="habit-3" class="habit-label">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="habit-content">
          <div class="habit-name">Sleep 7+ hours</div>
          <div class="habit-meta">
            <span class="habit-category">Wellness</span>
            <span class="habit-streak">🔥 12 days</span>
          </div>
        </div>
        <div class="habit-actions">
          <button class="habit-btn" title="Edit habit">
            <span>✏️</span>
          </button>
        </div>
      </div>

      <div class="habit-item">
        <div class="habit-checkbox">
          <input type="checkbox" id="habit-4" class="habit-check" data-habit="Read 20 minutes">
          <label for="habit-4" class="habit-label">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="habit-content">
          <div class="habit-name">Read 20 minutes</div>
          <div class="habit-meta">
            <span class="habit-category">Learning</span>
            <span class="habit-streak">🔥 3 days</span>
          </div>
        </div>
        <div class="habit-actions">
          <button class="habit-btn" title="Edit habit">
            <span>✏️</span>
          </button>
        </div>
      </div>

      <div class="habit-item">
        <div class="habit-checkbox">
          <input type="checkbox" id="habit-5" class="habit-check" data-habit="Meditate 10 minutes">
          <label for="habit-5" class="habit-label">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="habit-content">
          <div class="habit-name">Meditate 10 minutes</div>
          <div class="habit-meta">
            <span class="habit-category">Mindfulness</span>
            <span class="habit-streak">🔥 1 day</span>
          </div>
        </div>
        <div class="habit-actions">
          <button class="habit-btn" title="Edit habit">
            <span>✏️</span>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Habit Calendar -->
  <section class="habit-calendar">
    <div class="section-header">
      <h2 class="section-title">Monthly Progress</h2>
      <div class="calendar-controls">
        <button class="calendar-btn" id="prevMonth">←</button>
        <span class="calendar-month" id="currentMonth">December 2024</span>
        <button class="calendar-btn" id="nextMonth">→</button>
      </div>
    </div>
    
    <div class="calendar-container">
      <div class="calendar-grid" id="habitCalendar">
        <!-- Calendar will be generated by JavaScript -->
      </div>
    </div>
  </section>

  <!-- Habit Analytics -->
  <section class="habit-analytics">
    <div class="analytics-grid">
      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Weekly Progress</h3>
          <div class="card-actions">
            <select class="time-filter" id="weeklyFilter">
              <option value="1">This Week</option>
              <option value="2">Last 2 Weeks</option>
              <option value="4">Last Month</option>
            </select>
          </div>
        </div>
        <div class="card-content">
          <canvas id="weeklyChart" width="400" height="200"></canvas>
        </div>
      </div>

      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Habit Categories</h3>
        </div>
        <div class="card-content">
          <div class="category-stats">
            <div class="category-item">
              <div class="category-info">
                <span class="category-icon">💧</span>
                <span class="category-name">Health</span>
              </div>
              <div class="category-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 80%"></div>
                </div>
                <span class="progress-text">80%</span>
              </div>
            </div>
            <div class="category-item">
              <div class="category-info">
                <span class="category-icon">💪</span>
                <span class="category-name">Fitness</span>
              </div>
              <div class="category-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 60%"></div>
                </div>
                <span class="progress-text">60%</span>
              </div>
            </div>
            <div class="category-item">
              <div class="category-info">
                <span class="category-icon">📚</span>
                <span class="category-name">Learning</span>
              </div>
              <div class="category-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 40%"></div>
                </div>
                <span class="progress-text">40%</span>
              </div>
            </div>
            <div class="category-item">
              <div class="category-info">
                <span class="category-icon">🧘</span>
                <span class="category-name">Mindfulness</span>
              </div>
              <div class="category-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 20%"></div>
                </div>
                <span class="progress-text">20%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Suggested Habits -->
  <section class="suggested-habits">
    <div class="section-header">
      <h2 class="section-title">Suggested Habits</h2>
      <p class="section-subtitle">Popular habits to help improve your wellbeing</p>
    </div>
    
    <div class="suggestions-grid">
      <div class="suggestion-card">
        <div class="suggestion-icon">📖</div>
        <div class="suggestion-content">
          <h4 class="suggestion-title">Read 20 minutes daily</h4>
          <p class="suggestion-description">Expand your knowledge and improve focus</p>
          <div class="suggestion-meta">
            <span class="suggestion-category">Learning</span>
            <span class="suggestion-difficulty">Easy</span>
          </div>
        </div>
        <button class="btn btn-outline btn-small">Add Habit</button>
      </div>

      <div class="suggestion-card">
        <div class="suggestion-icon">🧘‍♀️</div>
        <div class="suggestion-content">
          <h4 class="suggestion-title">Meditate 10 minutes</h4>
          <p class="suggestion-description">Reduce stress and improve mental clarity</p>
          <div class="suggestion-meta">
            <span class="suggestion-category">Mindfulness</span>
            <span class="suggestion-difficulty">Medium</span>
          </div>
        </div>
        <button class="btn btn-outline btn-small">Add Habit</button>
      </div>

      <div class="suggestion-card">
        <div class="suggestion-icon">🚶‍♂️</div>
        <div class="suggestion-content">
          <h4 class="suggestion-title">Walk 5,000+ steps</h4>
          <p class="suggestion-description">Stay active and maintain physical health</p>
          <div class="suggestion-meta">
            <span class="suggestion-category">Fitness</span>
            <span class="suggestion-difficulty">Easy</span>
          </div>
        </div>
        <button class="btn btn-outline btn-small">Add Habit</button>
      </div>

      <div class="suggestion-card">
        <div class="suggestion-icon">✍️</div>
        <div class="suggestion-content">
          <h4 class="suggestion-title">Journal for 5 minutes</h4>
          <p class="suggestion-description">Reflect on your day and process emotions</p>
          <div class="suggestion-meta">
            <span class="suggestion-category">Wellness</span>
            <span class="suggestion-difficulty">Easy</span>
          </div>
        </div>
        <button class="btn btn-outline btn-small">Add Habit</button>
      </div>
    </div>
  </section>
</main>

<!-- Add Habit Modal -->
<div id="addHabitModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Add New Habit</h3>
      <button class="modal-close" id="closeAddHabitModal">&times;</button>
    </div>
    <div class="modal-body">
      <form id="addHabitForm" class="habit-form">
        <div class="form-group">
          <label for="habitName" class="form-label">Habit Name</label>
          <input type="text" id="habitName" class="form-input" placeholder="e.g., Drink 8 glasses of water" required>
        </div>
        
        <div class="form-group">
          <label for="habitCategory" class="form-label">Category</label>
          <select id="habitCategory" class="form-select" required>
            <option value="">Select a category</option>
            <option value="Health">Health</option>
            <option value="Fitness">Fitness</option>
            <option value="Learning">Learning</option>
            <option value="Mindfulness">Mindfulness</option>
            <option value="Wellness">Wellness</option>
            <option value="Productivity">Productivity</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="habitFrequency" class="form-label">Frequency</label>
          <select id="habitFrequency" class="form-select" required>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="custom">Custom</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="habitReminder" class="form-label">Reminder Time (optional)</label>
          <input type="time" id="habitReminder" class="form-input">
        </div>
        
        <div class="form-group">
          <label for="habitNotes" class="form-label">Notes (optional)</label>
          <textarea id="habitNotes" class="form-textarea" placeholder="Any additional notes about this habit..."></textarea>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" id="cancelAddHabit">Cancel</button>
      <button class="btn btn-primary" id="saveHabit">Add Habit</button>
    </div>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
