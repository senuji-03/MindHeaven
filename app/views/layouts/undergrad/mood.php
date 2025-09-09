<?php
$TITLE = 'MindHeaven — Mood Tracker';
$CURRENT_PAGE = 'mood';
$PAGE_CSS = ['/MindHeaven/Undergrad_student/assets/css/mood.css'];
$PAGE_JS  = ['/MindHeaven/Undergrad_student/assets/js/mood.js'];

include __DIR__ . '/layout/header.php';
?>

<main id="main" class="container mood">
  <!-- Mood Tracker Hero -->
  <section class="hero mood-hero">
    <div class="hero-content">
      <h1>😊 Mood Tracker</h1>
      <p class="hero-subtitle">Track your emotional well-being and discover patterns over time.</p>
    </div>
  </section>

  <!-- Quick Mood Entry -->
  <section class="quick-mood-entry">
    <div class="card">
      <div class="card-header">
        <h2>📝 How are you feeling today?</h2>
        <p class="card-subtitle">Log your current mood</p>
      </div>
      <div class="card-body">
        <div class="mood-selector">
          <button class="mood-btn" data-mood="happy" onclick="logMood('happy')">
            <span class="mood-emoji">😊</span>
            <span class="mood-label">Happy</span>
          </button>
          <button class="mood-btn" data-mood="neutral" onclick="logMood('neutral')">
            <span class="mood-emoji">😐</span>
            <span class="mood-label">Neutral</span>
          </button>
          <button class="mood-btn" data-mood="sad" onclick="logMood('sad')">
            <span class="mood-emoji">😢</span>
            <span class="mood-label">Sad</span>
          </button>
          <button class="mood-btn" data-mood="angry" onclick="logMood('angry')">
            <span class="mood-emoji">😡</span>
            <span class="mood-label">Angry</span>
          </button>
          <button class="mood-btn" data-mood="tired" onclick="logMood('tired')">
            <span class="mood-emoji">😴</span>
            <span class="mood-label">Tired</span>
          </button>
          <button class="mood-btn" data-mood="anxious" onclick="logMood('anxious')">
            <span class="mood-emoji">😰</span>
            <span class="mood-label">Anxious</span>
          </button>
          <button class="mood-btn" data-mood="excited" onclick="logMood('excited')">
            <span class="mood-emoji">🤩</span>
            <span class="mood-label">Excited</span>
          </button>
          <button class="mood-btn" data-mood="calm" onclick="logMood('calm')">
            <span class="mood-emoji">😌</span>
            <span class="mood-label">Calm</span>
          </button>
        </div>
        <div class="mood-details" id="moodDetails" style="display: none;">
          <h3>Tell us more about your mood</h3>
          <textarea id="moodNotes" class="input" rows="3" placeholder="What's contributing to how you're feeling today? (optional)"></textarea>
          <div class="mood-actions">
            <button class="btn primary" onclick="saveMoodEntry()">Save Mood</button>
            <button class="btn outline" onclick="cancelMoodEntry()">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mood Statistics -->
  <section class="mood-stats">
    <div class="grid">
      <div class="card col-4">
        <div class="card-header">
          <h2>📊 This Week</h2>
        </div>
        <div class="card-body">
          <div class="stat-item">
            <div class="stat-value" id="weeklyAverage">--</div>
            <div class="stat-label">Average Mood</div>
          </div>
          <div class="stat-item">
            <div class="stat-value" id="weeklyEntries">0</div>
            <div class="stat-label">Entries</div>
          </div>
        </div>
      </div>
      
      <div class="card col-4">
        <div class="card-header">
          <h2>📈 This Month</h2>
        </div>
        <div class="card-body">
          <div class="stat-item">
            <div class="stat-value" id="monthlyAverage">--</div>
            <div class="stat-label">Average Mood</div>
          </div>
          <div class="stat-item">
            <div class="stat-value" id="monthlyEntries">0</div>
            <div class="stat-label">Entries</div>
          </div>
        </div>
      </div>
      
      <div class="card col-4">
        <div class="card-header">
          <h2>🎯 Streak</h2>
        </div>
        <div class="card-body">
          <div class="stat-item">
            <div class="stat-value" id="currentStreak">0</div>
            <div class="stat-label">Days in a Row</div>
          </div>
          <div class="stat-item">
            <div class="stat-value" id="bestStreak">0</div>
            <div class="stat-label">Best Streak</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mood Calendar -->
  <section class="mood-calendar-section">
    <div class="card">
      <div class="card-header">
        <h2>📅 Monthly Mood Calendar</h2>
        <p class="card-subtitle">Track your mood patterns over time</p>
        <div class="calendar-controls">
          <button class="btn small outline" onclick="previousMonth()">← Previous</button>
          <span class="current-month" id="currentMonth"></span>
          <button class="btn small outline" onclick="nextMonth()">Next →</button>
        </div>
      </div>
      <div class="card-body">
        <div id="moodCalendar" class="calendar-grid"></div>
      </div>
    </div>
  </section>

  <!-- Mood Trends -->
  <section class="mood-trends">
    <div class="grid">
      <div class="card col-6">
        <div class="card-header">
          <h2>📈 Mood Trends</h2>
          <p class="card-subtitle">Your mood over the last 30 days</p>
        </div>
        <div class="card-body">
          <canvas id="moodChart" width="400" height="200"></canvas>
        </div>
      </div>
      
      <div class="card col-6">
        <div class="card-header">
          <h2>🎨 Mood Distribution</h2>
          <p class="card-subtitle">Most common moods this month</p>
        </div>
        <div class="card-body">
          <div class="mood-distribution" id="moodDistribution">
            <!-- Will be populated by JavaScript -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mood Insights -->
  <section class="mood-insights">
    <div class="card">
      <div class="card-header">
        <h2>💡 Mood Insights</h2>
        <p class="card-subtitle">AI-powered insights about your mood patterns</p>
      </div>
      <div class="card-body">
        <div class="insights-grid" id="moodInsights">
          <div class="insight-item">
            <div class="insight-icon">📊</div>
            <div class="insight-content">
              <h3>Pattern Recognition</h3>
              <p>Start logging your mood daily to unlock personalized insights about your emotional patterns.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Mood Entry Modal -->
<div id="moodModal" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3>📝 Log Your Mood</h3>
      <button class="modal-close" onclick="closeMoodModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="selected-mood" id="selectedMoodDisplay"></div>
      <div class="mood-intensity">
        <h4>How intense is this feeling?</h4>
        <div class="intensity-slider">
          <input type="range" id="moodIntensity" min="1" max="10" value="5" class="slider">
          <div class="intensity-labels">
            <span>Mild</span>
            <span>Moderate</span>
            <span>Intense</span>
          </div>
        </div>
      </div>
      <div class="mood-tags">
        <h4>What's contributing to this mood?</h4>
        <div class="tag-selector">
          <button class="tag-btn" data-tag="work">Work</button>
          <button class="tag-btn" data-tag="school">School</button>
          <button class="tag-btn" data-tag="relationships">Relationships</button>
          <button class="tag-btn" data-tag="health">Health</button>
          <button class="tag-btn" data-tag="weather">Weather</button>
          <button class="tag-btn" data-tag="sleep">Sleep</button>
          <button class="tag-btn" data-tag="exercise">Exercise</button>
          <button class="tag-btn" data-tag="social">Social</button>
        </div>
      </div>
      <div class="mood-notes">
        <h4>Additional Notes</h4>
        <textarea id="modalMoodNotes" class="input" rows="3" placeholder="Any additional thoughts about your mood today?"></textarea>
      </div>
      <div class="modal-actions">
        <button class="btn primary" onclick="saveDetailedMood()">Save Mood Entry</button>
        <button class="btn outline" onclick="closeMoodModal()">Cancel</button>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
