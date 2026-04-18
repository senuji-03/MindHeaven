<?php
$TITLE = 'Dashboard';
$CURRENT_PAGE = 'dashboard';
$PAGE_CSS = [];
$PAGE_JS = [];
?>

<style>
  /* ── Design System Tokens ── */
  :root {
    --primary: #3D8B6E;
    --primary-dark: #2A6B52;
    --primary-light: #6BB89A;
    --accent-warm: #E8A87C;
    --accent-calm: #A8C5DA;
    --bg-deep: #1C2B2A;
    --bg-soft: #F5F0E8;
    --bg-mid: #EEF6F2;
    --text-primary: #1E3A34;
    --text-secondary: #6B8C7E;
    --surface: #FFFFFF;
    --crisis: #D64F4F;
    --success: #4CAF82;
    --border: #D6E4DD;
    --shadow-sm: 0 1px 3px rgba(30, 58, 52, 0.06);
    --shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);
    --shadow-lg: 0 12px 32px rgba(30, 58, 52, 0.10);
    --radius-sm: 8px;
    --radius-md: 14px;
    --radius-lg: 20px;
    --radius-xl: 28px;
    --radius-full: 9999px;
  }

  /* ── Dashboard Layout ── */
  .dashboard-main {
    padding: 16px 28px;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* ── Hero Section ── */
  .dashboard-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
    color: white;
    padding: 20px 28px;
    border-radius: var(--radius-lg);
    margin-bottom: 16px;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
  }

  .dashboard-hero::before {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    top: -60px;
    right: -40px;
  }

  .dashboard-hero::after {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(232, 168, 124, 0.1);
    bottom: -30px;
    left: 20%;
  }

  .hero-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    position: relative;
    z-index: 1;
  }

  .hero-greeting {
    font-size: 0.85rem;
    opacity: 0.8;
    margin-bottom: 4px;
    font-weight: 500;
  }

  .hero-title {
    font-size: 1.8rem;
    margin: 0 0 6px 0;
    font-weight: 700;
    letter-spacing: -0.5px;
    font-family: 'DM Sans', system-ui, sans-serif;
  }

  .hero-subtitle {
    font-size: 0.92rem;
    opacity: 0.85;
    margin: 0 0 20px 0;
    line-height: 1.6;
  }

  .hero-stats {
    display: flex;
    gap: 24px;
  }

  .hero-stat {
    text-align: center;
    background: rgba(255, 255, 255, 0.12);
    border-radius: var(--radius-md);
    padding: 12px 20px;
    backdrop-filter: blur(8px);
  }

  .hero-stat .stat-number {
    display: block;
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 2px;
    color: white;
  }

  .hero-stat .stat-label {
    font-size: 0.78rem;
    opacity: 0.75;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
  }

  .hero-actions {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
  }

  /* ── Buttons ── */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: var(--radius-full);
    font-family: 'DM Sans', system-ui, sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
  }

  .btn-outline-white {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: 1.5px solid rgba(255, 255, 255, 0.35);
    backdrop-filter: blur(4px);
  }

  .btn-outline-white:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.6);
  }

  .btn-outline {
    background: transparent;
    color: var(--primary);
    border: 1.5px solid var(--border);
  }

  .btn-outline:hover {
    border-color: var(--primary);
    background: var(--bg-mid);
  }

  .btn-danger {
    background: var(--crisis);
    color: white;
  }

  .btn-danger:hover {
    background: #c14343;
    transform: translateY(-1px);
  }

  .btn-small {
    padding: 8px 16px;
    font-size: 0.82rem;
  }

  .btn-icon {
    font-size: 1rem;
  }

  /* ── Stats Grid ── */
  .dashboard-stats {
    margin-bottom: 16px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }

  .stat-card {
    background: var(--surface);
    padding: 16px 20px;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
  }

  .stat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .stat-icon-box {
    width: 42px;
    height: 42px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: white;
  }

  .stat-icon-box.teal {
    background: var(--primary);
  }

  .stat-icon-box.warm {
    background: var(--accent-warm);
  }

  .stat-icon-box.calm {
    background: var(--accent-calm);
  }

  .stat-icon-box.green {
    background: var(--success);
  }

  .stat-icon-box.red {
    background: var(--crisis);
  }

  .stat-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 2px 0;
    color: var(--text-primary);
  }

  .stat-subtitle {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin: 0;
  }

  .stat-content {
    margin-bottom: 10px;
  }

  .stat-number {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 6px;
    font-family: 'DM Sans', system-ui, sans-serif;
  }

  .progress-bar {
    width: 100%;
    height: 6px;
    background: var(--bg-mid);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-bottom: 6px;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: var(--radius-full);
    transition: width 0.6s ease;
  }

  .progress-text {
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 500;
  }

  .mood-display {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 6px;
  }

  .mood-emoji {
    font-size: 2rem;
  }

  .mood-text {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
  }

  .mood-time {
    font-size: 0.8rem;
    color: var(--text-secondary);
  }

  .appointment-info {
    color: var(--text-primary);
  }

  .appointment-time {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .appointment-time i {
    color: var(--primary);
    font-size: 0.85rem;
  }

  .appointment-type,
  .appointment-location {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-bottom: 2px;
  }

  .stat-actions {
    padding-top: 10px;
    border-top: 1px solid var(--border);
  }

  /* ── Analytics Grid ── */
  .dashboard-analytics {
    margin-bottom: 16px;
  }

  .section-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--primary);
    margin-bottom: 10px;
    display: block;
  }

  .analytics-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }

  .analytics-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
  }

  .card-header {
    padding: 14px 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
  }

  .time-filter {
    padding: 4px 10px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    font-family: inherit;
    font-size: 0.8rem;
    color: var(--text-secondary);
    cursor: pointer;
    outline: none;
    transition: border-color 0.2s;
  }

  .time-filter:focus {
    border-color: var(--primary);
  }

  .card-content {
    padding: 12px 20px;
  }

  /* ── Quick Actions ── */
  .dashboard-actions {
    margin-bottom: 16px;
  }

  .actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
  }

  .action-card {
    background: var(--surface);
    padding: 24px 20px;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .action-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
  }

  .action-icon-box {
    width: 52px;
    height: 52px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    margin-bottom: 14px;
  }

  .action-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 6px 0;
  }

  .action-description {
    color: var(--text-secondary);
    margin: 0 0 16px 0;
    line-height: 1.55;
    font-size: 0.83rem;
    flex: 1;
  }

  /* ── Modal ── */
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(28, 43, 42, 0.5);
    backdrop-filter: blur(4px);
    z-index: 2000;
    align-items: center;
    justify-content: center;
  }

  .modal.show {
    display: flex;
  }

  .modal-content {
    background: var(--surface);
    border-radius: var(--radius-xl);
    max-width: 520px;
    width: 92%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: modalIn 0.25s ease;
  }

  @keyframes modalIn {
    from {
      opacity: 0;
      transform: translateY(12px) scale(0.98);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .modal-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
  }

  .modal-close {
    background: var(--bg-mid);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.2s;
  }

  .modal-close:hover {
    background: var(--border);
    color: var(--text-primary);
  }

  .modal-body {
    padding: 24px;
  }

  .mood-selector {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 24px;
  }

  .mood-option {
    background: var(--bg-mid);
    border: 2px solid transparent;
    border-radius: var(--radius-md);
    padding: 14px 8px;
    cursor: pointer;
    transition: all 0.25s ease;
    text-align: center;
    font-family: inherit;
  }

  .mood-option:hover {
    border-color: var(--primary-light);
    background: var(--surface);
    transform: translateY(-2px);
  }

  .mood-option.selected {
    border-color: var(--primary);
    background: var(--surface);
    box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
  }

  .mood-option .mood-emoji {
    font-size: 1.8rem;
    display: block;
    margin-bottom: 6px;
  }

  .mood-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-primary);
  }

  .mood-details {
    margin-top: 20px;
  }

  .form-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 6px;
    font-size: 0.85rem;
  }

  .intensity-slider {
    width: 100%;
    margin-bottom: 6px;
    accent-color: var(--primary);
  }

  .intensity-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    color: var(--text-secondary);
    margin-bottom: 16px;
  }

  .form-textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: inherit;
    font-size: 0.9rem;
    color: var(--text-primary);
    resize: vertical;
    min-height: 80px;
    outline: none;
    transition: border-color 0.25s ease;
  }

  .form-textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
  }

  .modal-footer {
    padding: 16px 24px 20px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 10px;
    justify-content: flex-end;
  }

  /* ── Responsive ── */
  @media (max-width: 1024px) {
    .stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .analytics-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .dashboard-main {
      padding: 16px;
    }

    .hero-content {
      flex-direction: column;
      text-align: center;
    }

    .hero-stats {
      justify-content: center;
    }

    .hero-actions {
      justify-content: center;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .actions-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .mood-selector {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 480px) {
    .actions-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<main id="main" class="dashboard-main">
  <!-- Welcome Hero -->
  <section class="dashboard-hero">
    <div class="hero-content">
      <div class="hero-text">
        <div class="hero-greeting">Good day 👋</div>
        <h1 class="hero-title">Welcome back, <?= htmlspecialchars($studentName ?? 'Student') ?>!</h1>
        <p class="hero-subtitle">Here's your mental health overview for today</p>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="stat-number"><?= $habitStats['scheduled_today'] ?? 0 ?></span>
            <span class="stat-label">Tasks Today</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number"><?= $habitStats['completion_rate'] ?? 0 ?>%</span>
            <span class="stat-label">Completion Rate</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <a href="<?= BASE_URL ?>/ug/mood?log=1" class="btn btn-outline-white">
          <span class="btn-icon">😊</span> Log Mood
        </a>
        <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-outline-white">
          <span class="btn-icon">✨</span> Add Habit
        </a>
      </div>
    </div>
  </section>

  <!-- Stats Grid -->
  <section class="dashboard-stats">
    <span class="section-label">Overview</span>
    <div class="stats-grid">
      <!-- Habits Card -->
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon-box teal">✓</div>
          <div class="stat-info">
            <h3 class="stat-title">Today's Habits</h3>
            <p class="stat-subtitle">Keep building healthy routines</p>
          </div>
        </div>
        <div class="stat-content">
          <?php
          $habitsCompleted = $habitStats['completed_today'] ?? 0;
          $habitsScheduled = $habitStats['scheduled_today'] ?? 0;
          $habitRatio = $habitsScheduled > 0 ? "{$habitsCompleted}/{$habitsScheduled}" : "0/0";
          $habitPercent = $habitsScheduled > 0 ? min(100, round(($habitsCompleted / $habitsScheduled) * 100)) : 0;
          ?>
          <div class="stat-number"><?= $habitRatio ?></div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: <?= $habitPercent ?>%"></div>
          </div>
          <span class="progress-text"><?= $habitPercent ?>% Complete</span>
        </div>
        <div class="stat-actions">
          <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-small btn-outline">View All</a>
        </div>
      </div>

      <!-- Mood Card -->
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon-box warm">☀️</div>
          <div class="stat-info">
            <h3 class="stat-title">Current Mood</h3>
            <p class="stat-subtitle">How are you feeling?</p>
          </div>
        </div>
        <div class="stat-content">
          <?php
          $moodText = "Not logged today";
          $moodEmoji = "😐";
          $moodTime = "Never";
          if (!empty($currentMood)) {
            $moodTime = date('g:i A', strtotime($currentMood['created_at']));
            $moodType = strtolower($currentMood['mood_type']);
            $moodMap = [
              'happy' => ['emoji' => '😄', 'text' => 'Happy'],
              'sad' => ['emoji' => '😢', 'text' => 'Sad'],
              'anxious' => ['emoji' => '😬', 'text' => 'Anxious'],
              'calm' => ['emoji' => '😌', 'text' => 'Calm'],
              'angry' => ['emoji' => '😠', 'text' => 'Angry'],
              'stressed' => ['emoji' => '😫', 'text' => 'Stressed'],
              'tired' => ['emoji' => '😴', 'text' => 'Tired'],
              'neutral' => ['emoji' => '😐', 'text' => 'Neutral'],
            ];
            if (isset($moodMap[$moodType])) {
              $moodEmoji = $moodMap[$moodType]['emoji'];
              $moodText = $moodMap[$moodType]['text'];
            } else {
              $moodText = ucfirst($moodType);
            }
          }
          ?>
          <div class="mood-display">
            <span class="mood-emoji" id="currentMoodEmoji"><?= $moodEmoji ?></span>
            <span class="mood-text" id="currentMoodText"><?= htmlspecialchars($moodText) ?></span>
          </div>
          <div class="mood-time" id="moodTime">Last logged:
            <?= empty($currentMood) ? 'Never' : "Today at " . htmlspecialchars($moodTime) ?></div>
        </div>
        <div class="stat-actions">
          <a href="<?= BASE_URL ?>/ug/mood" class="btn btn-small btn-primary">Log Mood</a>
        </div>
      </div>

      <!-- Appointments Card -->
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon-box calm">📅</div>
          <div class="stat-info">
            <h3 class="stat-title">Next Appointment</h3>
            <p class="stat-subtitle">Upcoming sessions</p>
          </div>
        </div>
        <div class="stat-content">
          <?php
          if (!empty($nextAppointment)) {
            $aptDate = '';
            $dateObj = new DateTime($nextAppointment['date']);
            $today = new DateTime('today');
            $tomorrow = new DateTime('tomorrow');
            if ($dateObj == $today)
              $aptDate = 'Today';
            elseif ($dateObj == $tomorrow)
              $aptDate = 'Tomorrow';
            else
              $aptDate = $dateObj->format('F j');

            $aptTime = date('g:i A', strtotime($nextAppointment['time']));
            $aptType = htmlspecialchars($nextAppointment['type']);
            $counselor = htmlspecialchars($nextAppointment['counselor_name'] ?? 'Counselor');
            $aptMode = $nextAppointment['mode'] ?? 'audio_video';

            $modeText = 'Online Meeting';
            if ($aptMode == 'in_person')
              $modeText = 'In-Person';
            elseif ($aptMode == 'audio_video')
              $modeText = 'Online';
            ?>
            <div class="appointment-info">
              <div class="appointment-time"><i class="fas fa-clock"></i> <?= $aptDate ?>, <?= $aptTime ?></div>
              <div class="appointment-type"><?= $aptType ?> (<?= htmlspecialchars($modeText) ?>)</div>
              <div class="appointment-location" style="color:var(--text-secondary);font-size:0.85rem;margin-top:4px;">with
                <?= $counselor ?></div>
            </div>
          <?php } else { ?>
            <div class="appointment-info">
              <div class="appointment-time">No upcoming appointments</div>
              <div class="appointment-type">Ready to talk?</div>
              <div class="appointment-location" style="color:var(--text-secondary);font-size:0.85rem;margin-top:4px;">Book
                a session today</div>
            </div>
          <?php } ?>
        </div>
        <div class="stat-actions">
          <a href="<?= BASE_URL ?>/ug/appointment" class="btn btn-small btn-outline">Manage</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Analytics -->
  <section class="dashboard-analytics">
    <span class="section-label">Analytics</span>
    <div class="analytics-grid">
      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Habit Progress</h3>
          <select class="time-filter" id="habitTimeFilter">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
          </select>
        </div>
        <div class="card-content">
          <canvas id="habitChart" width="400" height="150"></canvas>
        </div>
      </div>

      <div class="analytics-card">
        <div class="card-header">
          <h3 class="card-title">Mood Trends</h3>
          <select class="time-filter" id="moodTimeFilter">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
          </select>
        </div>
        <div class="card-content">
          <canvas id="moodChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <!-- Quick Actions -->
  <section class="dashboard-actions">
    <span class="section-label">Quick Actions</span>
    <div class="actions-grid">
      <div class="action-card">
        <div class="action-icon-box" style="background:var(--primary);">🎯</div>
        <h4 class="action-title">Set Goals</h4>
        <p class="action-description">Create new wellness goals for this week</p>
        <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-small btn-outline">Get Started</a>
      </div>

      <div class="action-card">
        <div class="action-icon-box" style="background:var(--accent-calm);">📚</div>
        <h4 class="action-title">Resources</h4>
        <p class="action-description">Explore mental health resources and tools</p>
        <a href="<?= BASE_URL ?>/ug/resources" class="btn btn-small btn-outline">Browse</a>
      </div>

      <div class="action-card">
        <div class="action-icon-box" style="background:var(--accent-warm);">🤝</div>
        <h4 class="action-title">Support</h4>
        <p class="action-description">Connect with counselors and book sessions</p>
        <a href="<?= BASE_URL ?>/ug/appointment" class="btn btn-small btn-outline">Connect</a>
      </div>

      <div class="action-card">
        <div class="action-icon-box" style="background:var(--primary-light);">📋</div>
        <h4 class="action-title">Self-Assessment</h4>
        <p class="action-description">Take a quick mental health check-in</p>
        <a href="<?= BASE_URL ?>/ug/quiz" class="btn btn-small btn-outline">Start Quiz</a>
      </div>

      <div class="action-card">
        <div class="action-icon-box" style="background:var(--crisis);">🆘</div>
        <h4 class="action-title">Crisis Support</h4>
        <p class="action-description">Immediate help when you need it most</p>
        <a href="<?= BASE_URL ?>/ug/crisis" class="btn btn-small btn-danger">Get Help</a>
      </div>
    </div>
  </section>
</main>

<!-- Mood Modal -->
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ── Chart Colors (Design System) ──
    const primaryColor = '#3D8B6E';
    const primaryLightColor = 'rgba(61,139,110,0.12)';
    const successColor = '#4CAF82';
    const successLightColor = 'rgba(76,175,130,0.12)';
    const gridColor = '#D6E4DD';
    const labelColor = '#6B8C7E';

    // Dynamic chart data passed from backend
    const habitData = <?= json_encode($habitChartData ?? ['labels' => [], 'data' => []]) ?>;
    const moodData = <?= json_encode($moodChartData ?? ['labels' => [], 'data' => []]) ?>;

    function drawChart(canvasId, data, color, fillColor) {
      const canvas = document.getElementById(canvasId);
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      const W = canvas.width, H = canvas.height;
      ctx.clearRect(0, 0, W, H);
      const m = 40, cw = W - 2 * m, ch = H - 2 * m;
      const max = Math.max(...data.data);
      const min = Math.min(...data.data);
      const range = max - min || 1;

      // Grid
      ctx.strokeStyle = gridColor; ctx.lineWidth = 1;
      for (let i = 0; i <= 4; i++) {
        const y = m + (ch / 4) * i;
        ctx.beginPath(); ctx.moveTo(m, y); ctx.lineTo(W - m, y); ctx.stroke();
      }

      // Area fill
      ctx.fillStyle = fillColor;
      ctx.beginPath();
      data.data.forEach((v, i) => {
        const x = m + (cw / (data.data.length - 1)) * i;
        const y = H - m - ((v - min) / range) * ch;
        i === 0 ? (ctx.moveTo(x, H - m), ctx.lineTo(x, y)) : ctx.lineTo(x, y);
      });
      ctx.lineTo(W - m, H - m); ctx.closePath(); ctx.fill();

      // Line
      ctx.strokeStyle = color; ctx.lineWidth = 2.5; ctx.beginPath();
      data.data.forEach((v, i) => {
        const x = m + (cw / (data.data.length - 1)) * i;
        const y = H - m - ((v - min) / range) * ch;
        i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
      });
      ctx.stroke();

      // Dots
      ctx.fillStyle = color;
      data.data.forEach((v, i) => {
        const x = m + (cw / (data.data.length - 1)) * i;
        const y = H - m - ((v - min) / range) * ch;
        ctx.beginPath(); ctx.arc(x, y, 4, 0, 2 * Math.PI); ctx.fill();
        // White inner
        ctx.fillStyle = '#fff'; ctx.beginPath(); ctx.arc(x, y, 2, 0, 2 * Math.PI); ctx.fill();
        ctx.fillStyle = color;
      });

      // X labels
      ctx.fillStyle = labelColor; ctx.font = '12px DM Sans, sans-serif'; ctx.textAlign = 'center';
      data.labels.forEach((l, i) => {
        ctx.fillText(l, m + (cw / (data.labels.length - 1)) * i, H - 16);
      });

      // Y labels
      ctx.textAlign = 'right';
      for (let i = 0; i <= 4; i++) {
        const val = Math.round(min + (range / 4) * i);
        ctx.fillText(val, m - 8, H - m - (ch / 4) * i + 4);
      }
    }

    drawChart('habitChart', habitData, primaryColor, primaryLightColor);
    drawChart('moodChart', moodData, successColor, successLightColor);

    // Time filter redraws
    document.getElementById('habitTimeFilter')?.addEventListener('change', () => drawChart('habitChart', habitData, primaryColor, primaryLightColor));
    document.getElementById('moodTimeFilter')?.addEventListener('change', () => drawChart('moodChart', moodData, successColor, successLightColor));
  });
</script>