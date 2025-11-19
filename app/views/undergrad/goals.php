<?php
$TITLE = 'Wellness Goals & Journal';
$CURRENT_PAGE = 'goals';
require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="dashboard-main">
  <!-- Welcome Hero Section -->
  <section class="goals-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">🎯 Wellness Goals & Journal</h1>
        <p class="hero-subtitle">Set meaningful goals and track your mental wellness journey</p>
      </div>
    </div>
  </section>

  <div class="goals-container">
    <!-- Sidebar -->
    <aside class="goals-sidebar">
      <div class="sidebar-content">
        <div class="sidebar-section">
          <h3 class="sidebar-title">Quick Actions</h3>
          <div class="action-buttons">
            <button class="sidebar-btn active" data-tab="journal">
              <span class="btn-icon">📝</span>
              <span class="btn-text">Daily Journal</span>
            </button>
            <button class="sidebar-btn" data-tab="goals">
              <span class="btn-icon">🎯</span>
              <span class="btn-text">Set Goals</span>
            </button>
            <button class="sidebar-btn" data-tab="progress">
              <span class="btn-icon">📊</span>
              <span class="btn-text">Progress</span>
            </button>
            <button class="sidebar-btn" data-tab="reflections">
              <span class="btn-icon">💭</span>
              <span class="btn-text">Reflections</span>
            </button>
          </div>
        </div>

        <div class="sidebar-section">
          <h3 class="sidebar-title">Recent Entries</h3>
          <div class="recent-entries">
            <div class="entry-item">
              <div class="entry-date">Today</div>
              <div class="entry-preview">Feeling motivated about my goals...</div>
            </div>
            <div class="entry-item">
              <div class="entry-date">Yesterday</div>
              <div class="entry-preview">Had a challenging day but stayed positive...</div>
            </div>
            <div class="entry-item">
              <div class="entry-date">2 days ago</div>
              <div class="entry-preview">Completed my morning meditation routine...</div>
            </div>
          </div>
        </div>

        <div class="sidebar-section">
          <h3 class="sidebar-title">Goal Progress</h3>
          <div class="goal-stats">
            <div class="stat-item">
              <div class="stat-label">Active Goals</div>
              <div class="stat-value">5</div>
            </div>
            <div class="stat-item">
              <div class="stat-label">Completed</div>
              <div class="stat-value">12</div>
            </div>
            <div class="stat-item">
              <div class="stat-label">This Week</div>
              <div class="stat-value">3/7</div>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="goals-content">
      <!-- Daily Journal Tab -->
      <div id="journal-tab" class="content-tab active">
        <div class="tab-header">
          <h2 class="tab-title">📝 Daily Journal</h2>
          <p class="tab-subtitle">Reflect on your day and track your emotions</p>
        </div>

        <div class="journal-form">
          <div class="form-group">
            <label class="form-label">How are you feeling today?</label>
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
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">What's on your mind today?</label>
            <textarea class="form-textarea" id="journalEntry" placeholder="Write about your day, thoughts, feelings, or anything that's important to you..."></textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Gratitude (Optional)</label>
            <textarea class="form-textarea" id="gratitudeEntry" placeholder="What are you grateful for today?"></textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Energy Level (1-10)</label>
            <div class="energy-slider">
              <input type="range" id="energyLevel" min="1" max="10" value="5" class="slider">
              <div class="slider-labels">
                <span>Low</span>
                <span id="energyValue">5</span>
                <span>High</span>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button class="btn btn-primary" onclick="saveJournalEntry()">
              <span class="btn-icon">💾</span>
              Save Entry
            </button>
            <button class="btn btn-outline" onclick="clearForm()">
              <span class="btn-icon">🗑️</span>
              Clear
            </button>
          </div>
        </div>
      </div>

      <!-- Set Goals Tab -->
      <div id="goals-tab" class="content-tab">
        <div class="tab-header">
          <h2 class="tab-title">🎯 Set Wellness Goals</h2>
          <p class="tab-subtitle">Create meaningful goals to improve your mental wellness</p>
        </div>

        <div class="goals-form">
          <div class="form-group">
            <label class="form-label">Goal Title</label>
            <input type="text" class="form-input" id="goalTitle" placeholder="e.g., Practice mindfulness daily">
          </div>

          <div class="form-group">
            <label class="form-label">Category</label>
            <select class="form-select" id="goalCategory">
              <option value="">Select a category</option>
              <option value="mindfulness">Mindfulness & Meditation</option>
              <option value="exercise">Physical Activity</option>
              <option value="sleep">Sleep & Rest</option>
              <option value="social">Social Connection</option>
              <option value="learning">Learning & Growth</option>
              <option value="stress">Stress Management</option>
              <option value="hobbies">Hobbies & Interests</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea class="form-textarea" id="goalDescription" placeholder="Describe your goal in detail..."></textarea>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Target Date</label>
              <input type="date" class="form-input" id="goalDeadline">
            </div>
            <div class="form-group">
              <label class="form-label">Priority</label>
              <select class="form-select" id="goalPriority">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <div class="form-actions">
            <button class="btn btn-primary" onclick="saveGoal()">
              <span class="btn-icon">🎯</span>
              Create Goal
            </button>
            <button class="btn btn-outline" onclick="clearGoalForm()">
              <span class="btn-icon">🗑️</span>
              Clear
            </button>
          </div>
        </div>

        <!-- Active Goals List -->
        <div class="goals-list">
          <h3 class="section-title">Active Goals</h3>
          <div class="goals-grid">
            <div class="goal-card">
              <div class="goal-header">
                <h4 class="goal-title">Practice Mindfulness Daily</h4>
                <span class="goal-category">Mindfulness</span>
              </div>
              <p class="goal-description">Spend 10 minutes each morning practicing mindfulness meditation.</p>
              <div class="goal-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 75%"></div>
                </div>
                <span class="progress-text">5/7 days this week</span>
              </div>
              <div class="goal-footer">
                <span class="goal-deadline">Due: Dec 31, 2024</span>
                <button class="btn btn-small">Update</button>
              </div>
            </div>

            <div class="goal-card">
              <div class="goal-header">
                <h4 class="goal-title">Exercise 3x per Week</h4>
                <span class="goal-category">Exercise</span>
              </div>
              <p class="goal-description">Complete at least 30 minutes of physical activity three times per week.</p>
              <div class="goal-progress">
                <div class="progress-bar">
                  <div class="progress-fill" style="width: 66%"></div>
                </div>
                <span class="progress-text">2/3 sessions this week</span>
              </div>
              <div class="goal-footer">
                <span class="goal-deadline">Due: Jan 15, 2025</span>
                <button class="btn btn-small">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress Tab -->
      <div id="progress-tab" class="content-tab">
        <div class="tab-header">
          <h2 class="tab-title">📊 Your Progress</h2>
          <p class="tab-subtitle">Track your wellness journey over time</p>
        </div>

        <div class="progress-stats">
          <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-content">
              <div class="stat-number">24</div>
              <div class="stat-label">Journal Entries</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div class="stat-content">
              <div class="stat-number">5</div>
              <div class="stat-label">Active Goals</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">✅</div>
              <div class="stat-content">
              <div class="stat-number">12</div>
              <div class="stat-label">Completed Goals</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">📈</div>
            <div class="stat-content">
              <div class="stat-number">85%</div>
              <div class="stat-label">Success Rate</div>
            </div>
          </div>
        </div>

        <div class="progress-chart">
          <h3 class="section-title">Mood Trends (Last 7 Days)</h3>
          <div class="chart-container">
            <canvas id="moodChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>

      <!-- Reflections Tab -->
      <div id="reflections-tab" class="content-tab">
        <div class="tab-header">
          <h2 class="tab-title">💭 Reflections</h2>
          <p class="tab-subtitle">Review your past entries and insights</p>
        </div>

        <div class="reflections-list">
          <div class="reflection-item">
            <div class="reflection-date">Today</div>
            <div class="reflection-content">
              <h4>Feeling motivated and focused</h4>
              <p>Had a great day working on my goals. The morning meditation really helped me stay centered throughout the day.</p>
              <div class="reflection-meta">
                <span class="mood-tag happy">😊 Happy</span>
                <span class="energy-level">Energy: 8/10</span>
              </div>
            </div>
          </div>

          <div class="reflection-item">
            <div class="reflection-date">Yesterday</div>
            <div class="reflection-content">
              <h4>Challenging but growth-filled day</h4>
              <p>Faced some difficulties at work but managed to stay positive. Practiced deep breathing techniques which really helped.</p>
              <div class="reflection-meta">
                <span class="mood-tag neutral">😐 Neutral</span>
                <span class="energy-level">Energy: 6/10</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<style>
/* Goals Page Styles */
.dashboard-main {
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.goals-hero {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 3rem 2rem;
  border-radius: 1rem;
  margin-bottom: 2rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-content {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.hero-title {
  font-size: 2.5rem;
  margin: 0 0 0.5rem 0;
  font-weight: 700;
}

.hero-subtitle {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0;
}

.goals-container {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 2rem;
  min-height: 600px;
}

/* Sidebar Styles */
.goals-sidebar {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
  height: fit-content;
}

.sidebar-content {
  padding: 1.5rem;
}

.sidebar-section {
  margin-bottom: 2rem;
}

.sidebar-section:last-child {
  margin-bottom: 0;
}

.sidebar-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #e5e7eb;
}

.action-buttons {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.sidebar-btn {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  border: none;
  background: transparent;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: left;
  width: 100%;
  font-size: 0.9rem;
  color: #6b7280;
}

.sidebar-btn:hover {
  background: #f3f4f6;
  color: #1f2937;
}

.sidebar-btn.active {
  background: #eef2ff;
  color: #4f46e5;
  font-weight: 600;
}

.btn-icon {
  font-size: 1.2rem;
}

.recent-entries {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.entry-item {
  padding: 0.75rem;
  background: #f9fafb;
  border-radius: 8px;
  border-left: 3px solid #4f46e5;
}

.entry-date {
  font-size: 0.8rem;
  font-weight: 600;
  color: #6b7280;
  margin-bottom: 0.25rem;
}

.entry-preview {
  font-size: 0.85rem;
  color: #374151;
  line-height: 1.4;
}

.goal-stats {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.stat-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem;
  background: #f9fafb;
  border-radius: 8px;
}

.stat-label {
  font-size: 0.9rem;
  color: #6b7280;
}

.stat-value {
  font-size: 1.1rem;
  font-weight: 700;
  color: #4f46e5;
}

/* Main Content Styles */
.goals-content {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
  overflow: hidden;
}

.content-tab {
  display: none;
  padding: 2rem;
}

.content-tab.active {
  display: block;
}

.tab-header {
  margin-bottom: 2rem;
  text-align: center;
}

.tab-title {
  font-size: 1.8rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.tab-subtitle {
  color: #6b7280;
  font-size: 1rem;
  margin: 0;
}

/* Form Styles */
.journal-form, .goals-form {
  max-width: 600px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
  font-size: 1rem;
}

.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
}

.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-textarea {
  min-height: 120px;
  resize: vertical;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.mood-selector {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 0.75rem;
}

.mood-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  background: white;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
}

.mood-option:hover {
  border-color: #4f46e5;
  background: #f8faff;
}

.mood-option.selected {
  border-color: #4f46e5;
  background: #eef2ff;
}

.mood-emoji {
  font-size: 2rem;
}

.mood-label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #374151;
}

.energy-slider {
  margin-top: 0.5rem;
}

.slider {
  width: 100%;
  height: 6px;
  border-radius: 3px;
  background: #e5e7eb;
  outline: none;
  -webkit-appearance: none;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #4f46e5;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #4f46e5;
  cursor: pointer;
  border: none;
}

.slider-labels {
  display: flex;
  justify-content: space-between;
  margin-top: 0.5rem;
  font-size: 0.9rem;
  color: #6b7280;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

/* Button Styles */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
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

.btn-small {
  padding: 0.5rem 1rem;
  font-size: 0.8rem;
}

/* Goals List Styles */
.goals-list {
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid #e5e7eb;
}

.section-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 1.5rem;
}

.goals-grid {
  display: grid;
  gap: 1.5rem;
}

.goal-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 1.5rem;
  border: 1px solid #e5e7eb;
  transition: all 0.3s ease;
}

.goal-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.goal-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.goal-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
}

.goal-category {
  background: #eef2ff;
  color: #4f46e5;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.goal-description {
  color: #6b7280;
  margin-bottom: 1rem;
  line-height: 1.5;
}

.goal-progress {
  margin-bottom: 1rem;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e5e7eb;
  border-radius: 4px;
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
  font-weight: 500;
}

.goal-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.goal-deadline {
  font-size: 0.9rem;
  color: #6b7280;
}

/* Progress Stats */
.progress-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.stat-card {
  background: #f9fafb;
  border-radius: 12px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  border: 1px solid #e5e7eb;
}

.stat-icon {
  font-size: 2rem;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #eef2ff;
  border-radius: 12px;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.9rem;
  color: #6b7280;
}

/* Reflections */
.reflections-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.reflection-item {
  background: #f9fafb;
  border-radius: 12px;
  padding: 1.5rem;
  border-left: 4px solid #4f46e5;
}

.reflection-date {
  font-size: 0.9rem;
  font-weight: 600;
  color: #6b7280;
  margin-bottom: 0.75rem;
}

.reflection-content h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.reflection-content p {
  color: #6b7280;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.reflection-meta {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.mood-tag {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
}

.mood-tag.happy {
  background: #dcfce7;
  color: #166534;
}

.mood-tag.neutral {
  background: #f3f4f6;
  color: #374151;
}

.energy-level {
  font-size: 0.9rem;
  color: #6b7280;
}

/* Chart Container */
.chart-container {
  background: #f9fafb;
  border-radius: 12px;
  padding: 1.5rem;
  border: 1px solid #e5e7eb;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .goals-container {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .goals-sidebar {
    order: 2;
  }
  
  .goals-content {
    order: 1;
  }
}

@media (max-width: 768px) {
  .dashboard-main {
    padding: 1rem;
  }
  
  .goals-hero {
    padding: 2rem 1rem;
  }
  
  .hero-title {
    font-size: 2rem;
  }
  
  .content-tab {
    padding: 1rem;
  }
  
  .form-row {
    grid-template-columns: 1fr;
  }
  
  .mood-selector {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .progress-stats {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .goal-footer {
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-start;
  }
}

@media (max-width: 480px) {
  .mood-selector {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .progress-stats {
    grid-template-columns: 1fr;
  }
  
  .goal-header {
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-start;
  }
}
</style>

<script>
// Goals Page Functionality
let currentTab = 'journal';

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tab switching
  const tabButtons = document.querySelectorAll('.sidebar-btn');
  const tabContents = document.querySelectorAll('.content-tab');
  
  tabButtons.forEach(button => {
    button.addEventListener('click', function() {
      const tabName = this.dataset.tab;
      switchTab(tabName);
    });
  });
  
  // Initialize energy slider
  const energySlider = document.getElementById('energyLevel');
  const energyValue = document.getElementById('energyValue');
  
  if (energySlider && energyValue) {
    energySlider.addEventListener('input', function() {
      energyValue.textContent = this.value;
    });
  }
  
  // Initialize mood chart
  initializeMoodChart();
});

function switchTab(tabName) {
  // Update active tab button
  document.querySelectorAll('.sidebar-btn').forEach(btn => {
    btn.classList.remove('active');
  });
  document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
  
  // Update active tab content
  document.querySelectorAll('.content-tab').forEach(tab => {
    tab.classList.remove('active');
  });
  document.getElementById(`${tabName}-tab`).classList.add('active');
  
  currentTab = tabName;
}

// Mood selection functionality
document.addEventListener('DOMContentLoaded', function() {
  const moodOptions = document.querySelectorAll('.mood-option');
  
  moodOptions.forEach(option => {
    option.addEventListener('click', function() {
      // Remove previous selection
      moodOptions.forEach(opt => opt.classList.remove('selected'));
      
      // Add selection to clicked option
      this.classList.add('selected');
    });
  });
});

// Journal entry functions
function saveJournalEntry() {
  const mood = document.querySelector('.mood-option.selected');
  const entry = document.getElementById('journalEntry').value;
  const gratitude = document.getElementById('gratitudeEntry').value;
  const energy = document.getElementById('energyLevel').value;
  
  if (!mood || !entry.trim()) {
    showMessage('Please select a mood and write your journal entry.', 'error');
    return;
  }
  
  // Simulate saving
  showMessage('Journal entry saved successfully!', 'success');
  
  // Clear form after a delay
  setTimeout(() => {
    clearForm();
  }, 1500);
}

function clearForm() {
  document.querySelectorAll('.mood-option').forEach(opt => opt.classList.remove('selected'));
  document.getElementById('journalEntry').value = '';
  document.getElementById('gratitudeEntry').value = '';
  document.getElementById('energyLevel').value = '5';
  document.getElementById('energyValue').textContent = '5';
}

// Goal functions
function saveGoal() {
  const title = document.getElementById('goalTitle').value;
  const category = document.getElementById('goalCategory').value;
  const description = document.getElementById('goalDescription').value;
  const deadline = document.getElementById('goalDeadline').value;
  const priority = document.getElementById('goalPriority').value;
  
  if (!title.trim() || !category || !description.trim()) {
    showMessage('Please fill in all required fields.', 'error');
    return;
  }
  
  // Simulate saving
  showMessage('Goal created successfully!', 'success');
  
  // Clear form after a delay
  setTimeout(() => {
    clearGoalForm();
  }, 1500);
}

function clearGoalForm() {
  document.getElementById('goalTitle').value = '';
  document.getElementById('goalCategory').value = '';
  document.getElementById('goalDescription').value = '';
  document.getElementById('goalDeadline').value = '';
  document.getElementById('goalPriority').value = 'medium';
}

// Message display function
function showMessage(message, type) {
  // Remove existing message
  const existingMsg = document.querySelector('.message');
  if (existingMsg) {
    existingMsg.remove();
  }
  
  // Create message element
  const messageEl = document.createElement('div');
  messageEl.className = 'message';
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
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    max-width: 300px;
  `;
  
  document.body.appendChild(messageEl);
  
  // Remove message after 3 seconds
  setTimeout(() => {
    if (messageEl.parentNode) {
      messageEl.remove();
    }
  }, 3000);
}

// Mood chart initialization
function initializeMoodChart() {
  const canvas = document.getElementById('moodChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  const width = canvas.width;
  const height = canvas.height;
  
  // Clear canvas
  ctx.clearRect(0, 0, width, height);
  
  // Dummy data for mood trends
  const moodData = [7, 6, 8, 7, 9, 5, 8];
  const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
  
  // Chart dimensions
  const margin = 40;
  const chartWidth = width - 2 * margin;
  const chartHeight = height - 2 * margin;
  
  // Find max and min values for scaling
  const maxValue = Math.max(...moodData);
  const minValue = Math.min(...moodData);
  const range = maxValue - minValue;
  
  // Draw grid lines
  ctx.strokeStyle = '#e5e7eb';
  ctx.lineWidth = 1;
  for (let i = 0; i <= 5; i++) {
    const y = margin + (chartHeight / 5) * i;
    ctx.beginPath();
    ctx.moveTo(margin, y);
    ctx.lineTo(width - margin, y);
    ctx.stroke();
  }
  
  // Draw data line
  ctx.strokeStyle = '#4f46e5';
  ctx.lineWidth = 3;
  ctx.beginPath();
  
  labels.forEach((label, index) => {
    const x = margin + (chartWidth / (labels.length - 1)) * index;
    const normalizedValue = (moodData[index] - minValue) / range;
    const y = height - margin - normalizedValue * chartHeight;
    
    if (index === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }
  });
  ctx.stroke();
  
  // Draw data points
  ctx.fillStyle = '#4f46e5';
  labels.forEach((label, index) => {
    const x = margin + (chartWidth / (labels.length - 1)) * index;
    const normalizedValue = (moodData[index] - minValue) / range;
    const y = height - margin - normalizedValue * chartHeight;
    
    ctx.beginPath();
    ctx.arc(x, y, 5, 0, 2 * Math.PI);
    ctx.fill();
  });
  
  // Draw labels
  ctx.fillStyle = '#6b7280';
  ctx.font = '12px sans-serif';
  ctx.textAlign = 'center';
  labels.forEach((label, index) => {
    const x = margin + (chartWidth / (labels.length - 1)) * index;
    ctx.fillText(label, x, height - 20);
  });
}
</script>
