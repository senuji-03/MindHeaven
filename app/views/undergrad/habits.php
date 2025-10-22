<?php
$TITLE = 'MindHeaven — Habits';
$CURRENT_PAGE = 'habits';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/habits.css'];
$PAGE_JS  = ['/MindHeaven/public/js/undergrad/habits.js'];

require BASE_PATH.'/app/views/layouts/header.php';
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

.habit-item.completed {
  background: #f0fdf4;
  border-color: #bbf7d0;
}

.habit-item.completed .habit-name {
  opacity: 0.7;
  text-decoration: line-through;
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
  opacity: 0;
  transition: opacity 0.3s ease;
}

.modal.show {
  display: flex;
  opacity: 1;
}

.modal[style*="flex"] {
  display: flex !important;
  opacity: 1;
}

/* Force modal visibility for debugging */
#habitModal.show {
  display: flex !important;
  opacity: 1 !important;
  z-index: 9999 !important;
}

#habitModal[style*="flex"] {
  display: flex !important;
  opacity: 1 !important;
  z-index: 9999 !important;
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

/* Enhanced Calendar Styles */
.calendar-container {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
  margin-bottom: 1rem;
}

.calendar-header {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background: #f8fafc;
  border-bottom: 1px solid #e5e7eb;
}

.calendar-day-header {
  padding: 1rem 0.5rem;
  text-align: center;
  font-weight: 600;
  color: #6b7280;
  font-size: 0.9rem;
}

.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 1px;
  background: #e5e7eb;
}

.calendar-day {
  background: white;
  min-height: 100px;
  padding: 0.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
}

.calendar-day:hover {
  background: #f8fafc;
}

.calendar-day.today {
  background: #eff6ff;
  border: 2px solid #3b82f6;
}

.calendar-day.selected {
  background: #dbeafe;
  border: 2px solid #1d4ed8;
}

.calendar-day-number {
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.calendar-day-habits {
  display: flex;
  flex-wrap: wrap;
  gap: 2px;
  justify-content: center;
  width: 100%;
}

.habit-indicator {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  display: inline-block;
  margin: 1px;
}

.habit-indicator.completed {
  background: #10b981;
}

.habit-indicator.partial {
  background: #f59e0b;
}

.habit-indicator.missed {
  background: #ef4444;
}

.habit-indicator.future {
  background: #d1d5db;
}

.calendar-legend {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-top: 1rem;
  flex-wrap: wrap;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  color: #6b7280;
}

.legend-color {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: inline-block;
}

.legend-color.completed {
  background: #10b981;
}

.legend-color.partial {
  background: #f59e0b;
}

.legend-color.missed {
  background: #ef4444;
}

.legend-color.future {
  background: #d1d5db;
}

.calendar-controls {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.calendar-btn {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  background: white;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  font-weight: 500;
}

.calendar-btn:hover {
  background: #f3f4f6;
  border-color: #9ca3af;
}

.calendar-btn:active {
  background: #e5e7eb;
}

.calendar-month {
  font-weight: 600;
  color: #1f2937;
  min-width: 150px;
  text-align: center;
}

/* Day Detail Modal */
.day-detail-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.day-detail-content {
  background: white;
  border-radius: 1rem;
  padding: 2rem;
  max-width: 500px;
  width: 90%;
  max-height: 80vh;
  overflow-y: auto;
}

.day-detail-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.day-detail-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.day-habits-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.day-habit-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 0.5rem;
  border: 1px solid #e5e7eb;
}

.day-habit-checkbox {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.day-habit-name {
  flex: 1;
  font-weight: 500;
  color: #1f2937;
}

.day-habit-status {
  font-size: 0.9rem;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  font-weight: 500;
}

.day-habit-status.completed {
  background: #dcfce7;
  color: #166534;
}

.day-habit-status.pending {
  background: #fef3c7;
  color: #92400e;
}

/* No Habits State */
.no-habits {
  text-align: center;
  padding: 3rem 2rem;
  color: #6b7280;
}

.no-habits-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.no-habits h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #374151;
  margin: 0 0 0.5rem 0;
}

.no-habits p {
  margin: 0 0 2rem 0;
  font-size: 1rem;
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
    min-height: 80px;
  }
  
  .calendar-legend {
    gap: 1rem;
  }
  
  .calendar-controls {
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  
  .calendar-month {
    min-width: 120px;
    font-size: 0.9rem;
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
        <button id="testModalBtn" class="btn btn-primary" onclick="testModal();" style="background: #ef4444; margin-right: 1rem;">
          <span class="btn-icon">🧪</span>
          Test Modal
        </button>
        <button id="addHabitBtn" class="btn btn-primary" onclick="showAddHabitModal();">
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
      <!-- Habits will be loaded dynamically here -->
    </div>
  </section>

  <!-- Habit Calendar -->
  <section class="habit-calendar">
    <div class="section-header">
      <h2 class="section-title">📅 Monthly Progress</h2>
      <div class="calendar-controls">
        <button class="calendar-btn" id="prevMonth" onclick="changeMonth(-1)">←</button>
        <span class="calendar-month" id="currentMonth">December 2024</span>
        <button class="calendar-btn" id="nextMonth" onclick="changeMonth(1)">→</button>
        <button class="calendar-btn" id="todayBtn" onclick="goToToday()">Today</button>
      </div>
    </div>
    
    <div class="calendar-container">
      <div class="calendar-header">
        <div class="calendar-day-header">Sun</div>
        <div class="calendar-day-header">Mon</div>
        <div class="calendar-day-header">Tue</div>
        <div class="calendar-day-header">Wed</div>
        <div class="calendar-day-header">Thu</div>
        <div class="calendar-day-header">Fri</div>
        <div class="calendar-day-header">Sat</div>
      </div>
      <div class="calendar-grid" id="habitCalendar">
        <!-- Calendar will be generated by JavaScript -->
      </div>
    </div>
    
    <!-- Calendar Legend -->
    <div class="calendar-legend">
      <div class="legend-item">
        <div class="legend-color completed"></div>
        <span>Completed</span>
      </div>
      <div class="legend-item">
        <div class="legend-color partial"></div>
        <span>Partial</span>
      </div>
      <div class="legend-item">
        <div class="legend-color missed"></div>
        <span>Missed</span>
      </div>
      <div class="legend-item">
        <div class="legend-color future"></div>
        <span>Future</span>
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

<!-- Add/Edit Habit Modal -->
<div class="modal" id="habitModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Add New Habit</h3>
      <button class="modal-close" onclick="hideAddHabitModal()">×</button>
    </div>
    <div class="modal-body">
      <form id="habitForm">
        <input type="hidden" id="habitId" name="habitId">
        
        <div class="form-group">
          <label for="habitName" class="form-label">Habit Name *</label>
          <input type="text" id="habitName" name="name" class="form-input" placeholder="e.g., Drink 8 glasses of water" required>
        </div>
        
        <div class="form-group">
          <label for="habitDescription" class="form-label">Description</label>
          <textarea id="habitDescription" name="description" class="form-textarea" placeholder="Optional description of your habit..."></textarea>
        </div>
        
        <div class="form-group">
          <label for="habitCategory" class="form-label">Category *</label>
          <select id="habitCategory" name="category" class="form-select" required>
            <option value="">Select a category</option>
            <option value="health">Health</option>
            <option value="fitness">Fitness</option>
            <option value="wellness">Wellness</option>
            <option value="learning">Learning</option>
            <option value="productivity">Productivity</option>
            <option value="mindfulness">Mindfulness</option>
            <option value="social">Social</option>
            <option value="other">Other</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="habitFrequency" class="form-label">Frequency *</label>
          <select id="habitFrequency" name="frequency" class="form-select" required>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="custom">Custom</option>
          </select>
        </div>
        
        <div class="form-group" id="targetDaysGroup" style="display: none;">
          <label for="habitTargetDays" class="form-label">Target Days per Week</label>
          <input type="number" id="habitTargetDays" name="target_days" class="form-input" min="1" max="7" value="1">
        </div>
        
        <div class="form-group">
          <label for="habitColor" class="form-label">Color</label>
          <input type="color" id="habitColor" name="color" class="form-input" value="#10b981">
        </div>
        
        <div class="form-group">
          <label for="habitIcon" class="form-label">Icon</label>
          <input type="text" id="habitIcon" name="icon" class="form-input" placeholder="🎯" value="🎯">
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline modal-cancel" onclick="hideAddHabitModal()">Cancel</button>
      <button type="submit" form="habitForm" class="btn btn-primary" onclick="handleSaveHabit(event)">
        <span class="btn-icon">💾</span>
        <span class="btn-text">Save Habit</span>
      </button>
    </div>
  </div>
</div>

<!-- Day Detail Modal -->
<div class="day-detail-modal" id="dayDetailModal">
  <div class="day-detail-content">
    <div class="day-detail-header">
      <h3 class="day-detail-title" id="dayDetailTitle">Habits for December 15, 2024</h3>
      <button class="modal-close" onclick="hideDayDetailModal()">×</button>
    </div>
    <div class="day-habits-list" id="dayHabitsList">
      <!-- Day habits will be loaded here -->
    </div>
  </div>
</div>

<script>
// Set BASE_URL for JavaScript
window.BASE_URL = '<?= BASE_URL ?>';


function hideAddHabitModal() {
    const modal = document.getElementById('habitModal');
    if (modal) {
        modal.style.display = 'none';
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';
        modal.classList.remove('show');
        modal.style.border = 'none';
        modal.style.backgroundColor = '';
        document.body.style.overflow = '';
    }
}

function testModal() {
    alert('Button clicked!');
    console.log('testModal function called!');
    alert('testModal function called!');
    
    const modal = document.getElementById('habitModal');
    console.log('Modal element found:', modal);
    
    if (modal) {
        console.log('Showing test modal...');
        
        // Force show the modal with all necessary styles
        modal.style.cssText = `
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 9999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0,0,0,0.5) !important;
            align-items: center !important;
            justify-content: center !important;
        `;
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Ensure modal content is visible
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.cssText = `
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                background: white !important;
                border-radius: 1rem !important;
                max-width: 500px !important;
                width: 90% !important;
                max-height: 90vh !important;
                overflow-y: auto !important;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
                position: relative !important;
                z-index: 10000 !important;
            `;
            console.log('Test modal content made visible');
        }
        
        console.log('Test modal should now be visible');
        
    } else {
        console.error('Modal not found!');
        alert('Error: Modal not found!');
    }
}

function showAddHabitModal() {
    console.log('showAddHabitModal function called');
    
    const modal = document.getElementById('habitModal');
    console.log('Modal element found:', modal);
    
    if (modal) {
        console.log('Showing modal...');
        
        // Force show the modal with all necessary styles
        modal.style.cssText = `
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 9999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0,0,0,0.5) !important;
            align-items: center !important;
            justify-content: center !important;
        `;
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Ensure modal content is visible
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.cssText = `
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                background: white !important;
                border-radius: 1rem !important;
                max-width: 500px !important;
                width: 90% !important;
                max-height: 90vh !important;
                overflow-y: auto !important;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
                position: relative !important;
                z-index: 10000 !important;
            `;
            console.log('Modal content made visible');
        }
        
        // Set up form for adding new habit
        setupFormForNewHabit();
        
        console.log('Modal should now be visible');
        
    } else {
        console.error('Modal not found!');
        alert('Error: Modal not found!');
    }
}

function setupFormForNewHabit() {
    // Reset form
    const form = document.getElementById('habitForm');
    if (form) {
        form.reset();
    }
    
    // Clear habit ID (indicates new habit)
    const habitIdField = document.getElementById('habitId');
    if (habitIdField) {
        habitIdField.value = '';
    }
    
    // Update modal title
    const modalTitle = document.querySelector('#habitModal .modal-title');
    if (modalTitle) {
        modalTitle.textContent = 'Add New Habit';
    }
    
    // Update submit button text
    const submitBtn = document.querySelector('#habitForm button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = '<span class="btn-icon">💾</span><span class="btn-text">Save Habit</span>';
    }
    
    // Set default values
    const colorField = document.getElementById('habitColor');
    if (colorField) {
        colorField.value = '#10b981';
    }
    
    const iconField = document.getElementById('habitIcon');
    if (iconField) {
        iconField.value = '🎯';
    }
    
    // Hide target days group initially
    const targetDaysGroup = document.getElementById('targetDaysGroup');
    if (targetDaysGroup) {
        targetDaysGroup.style.display = 'none';
    }
    
    // Focus on name field
    setTimeout(() => {
        const nameField = document.getElementById('habitName');
        if (nameField) {
            nameField.focus();
        }
    }, 100);
}

// Handle save habit button click
function handleSaveHabit(event) {
    event.preventDefault(); // Prevent default form submission
    
    // Get the form element
    const form = document.getElementById('habitForm');
    if (form) {
        // Trigger the form submit event
        form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
    } else {
        console.error('Form not found!');
        alert('Error: Form not found. Please try again.');
    }
}

// Functions are now available globally

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set up Test Modal button
    const testModalBtn = document.getElementById('testModalBtn');
    if (testModalBtn) {
        testModalBtn.addEventListener('click', function(e) {
            e.preventDefault();
            testModal();
        });
    }
    
    // Set up Add New Habit button
    const addHabitBtn = document.getElementById('addHabitBtn');
    if (addHabitBtn) {
        addHabitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showAddHabitModal();
        });
    }
    
    // Set up form submission
    const habitForm = document.getElementById('habitForm');
    if (habitForm) {
        habitForm.addEventListener('submit', handleHabitFormSubmit);
    }
    
    // Add direct click handler to submit button as backup
    const submitBtn = document.querySelector('#habitForm button[type="submit"]');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            handleHabitFormSubmit(e);
        });
    }
    
    // Handle frequency change to show/hide target days
    const frequencySelect = document.getElementById('habitFrequency');
    const targetDaysGroup = document.getElementById('targetDaysGroup');
    if (frequencySelect && targetDaysGroup) {
        frequencySelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                targetDaysGroup.style.display = 'block';
            } else {
                targetDaysGroup.style.display = 'none';
            }
        });
    }
});

// Handle habit form submission
async function handleHabitFormSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Validate required fields
    if (!data.name || !data.category || !data.frequency) {
        alert('Please fill in all required fields (Name, Category, Frequency)');
        return;
    }
    
    // Handle custom frequency and target days
    if (data.frequency === 'custom') {
        if (!data.target_days || data.target_days < 1 || data.target_days > 7) {
            alert('Please enter a valid number of target days (1-7) for custom frequency');
            return;
        }
        data.target_days = parseInt(data.target_days);
    } else {
        data.target_days = 1;
    }
    
    // Format data for database
    const habitData = {
        name: data.name.trim(),
        description: data.description ? data.description.trim() : null,
        category: data.category,
        frequency: data.frequency,
        target_days: data.target_days,
        color: data.color || '#10b981',
        icon: data.icon || '🎯'
    };
    
    try {
        const response = await fetch(window.BASE_URL + '/api/habits/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(habitData)
        });
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error || 'Failed to save habit');
        }
        
        // Show success message
        alert('✅ Habit saved successfully!\n\nYour habit has been added to the database.');
        
        // Hide modal
        hideAddHabitModal();
        
        // Reload habits (if the page has that functionality)
        if (typeof loadHabits === 'function') {
            await loadHabits();
        }
        if (typeof renderHabits === 'function') {
            renderHabits();
        }
        if (typeof updateStats === 'function') {
            updateStats();
        }
        
    } catch (error) {
        console.error('Error saving habit:', error);
        alert('❌ Failed to save habit!\n\nError: ' + error.message + '\n\nPlease try again or contact support if the problem persists.');
    }
}
</script>
<script src="<?= BASE_URL ?>/js/undergrad/habits.js"></script>

<?php require BASE_PATH.'/app/views/layouts/footer.php'; ?>
