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
    --shadow-md: 0 4px 16px rgba(30, 58, 52, 0.10);
    --shadow-lg: 0 12px 36px rgba(30, 58, 52, 0.12);
    --radius-sm: 8px;
    --radius-md: 14px;
    --radius-lg: 18px;
    --radius-xl: 26px;
    --radius-full: 9999px;
  }

  /* ── Dashboard Layout ── */
  .dashboard-main {
    padding: 16px 28px;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* ── Section Headers ── */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .section-label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.8px;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .section-label::before {
    content: '';
    display: inline-block;
    width: 14px;
    height: 3px;
    background: var(--primary);
    border-radius: var(--radius-full);
  }

  .section-link {
    font-size: 0.82rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
  }

  .section-link:hover {
    color: var(--primary);
  }

  /* ── Hero Section ── */
  .dashboard-hero {
    background: linear-gradient(135deg, #1e4a38 0%, var(--primary) 50%, #5aab88 100%);
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
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.045);
    top: -120px;
    right: -80px;
  }

  .dashboard-hero::after {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(232, 168, 124, 0.08);
    bottom: -60px;
    left: 30%;
  }

  .hero-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 28px;
    position: relative;
    z-index: 1;
  }

  .hero-eyebrow {
    font-size: 0.78rem;
    opacity: 0.7;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
  }

  .hero-title {
    font-size: 2rem;
    margin: 0 0 8px 0;
    font-weight: 700;
    letter-spacing: -0.5px;
    font-family: 'DM Sans', system-ui, sans-serif;
    line-height: 1.2;
    color: #ffffff;
  }

  .hero-subtitle {
    font-size: 0.9rem;
    opacity: 0.8;
    margin: 0 0 24px 0;
    line-height: 1.6;
  }

  .hero-pills {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .hero-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.13);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    padding: 8px 16px;
    backdrop-filter: blur(8px);
    font-size: 0.82rem;
    font-weight: 600;
  }

  .hero-pill i {
    font-size: 0.85rem;
    opacity: 0.85;
  }

  .hero-pill-value {
    font-size: 1rem;
    font-weight: 700;
  }

  .hero-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
    flex-shrink: 0;
  }

  .hero-actions {
    display: flex;
    gap: 10px;
  }

  .hero-date-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    padding: 6px 14px;
    font-size: 0.8rem;
    opacity: 0.85;
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
    transition: all 0.25s ease;
    text-decoration: none;
    white-space: nowrap;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-primary:hover,
  .btn-primary:active,
  .btn-primary:focus {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
    color: white !important;
  }

  .btn-outline-white {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: 1.5px solid rgba(255, 255, 255, 0.35);
    backdrop-filter: blur(4px);
  }

  .btn-outline-white:hover,
  .btn-outline-white:active,
  .btn-outline-white:focus {
    background: rgba(255, 255, 255, 0.28);
    color: white !important;
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
    box-shadow: 0 6px 20px rgba(214, 79, 79, 0.3);
  }

  .btn-sm {
    padding: 7px 16px;
    font-size: 0.8rem;
  }

  /* ── Overview Stats Grid ── */
  .dashboard-stats {
    margin-bottom: 24px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }

  .stat-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    transition: all 0.28s ease;
    overflow: hidden;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
  }

  .stat-card-inner {
    padding: 20px 22px;
  }

  .stat-card-footer {
    padding: 12px 22px;
    border-top: 1px solid var(--bg-mid);
    background: var(--bg-mid);
  }

  .stat-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .stat-icon-box {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
  }

  .stat-icon-box.teal    { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); }
  .stat-icon-box.warm    { background: linear-gradient(135deg, #d48a5d, var(--accent-warm)); }
  .stat-icon-box.calm    { background: linear-gradient(135deg, #7aaec7, var(--accent-calm)); }
  .stat-icon-box.green   { background: linear-gradient(135deg, #37936a, var(--success)); }
  .stat-icon-box.red     { background: linear-gradient(135deg, #b83b3b, var(--crisis)); }

  .stat-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: var(--radius-full);
    letter-spacing: 0.3px;
  }

  .stat-badge.positive {
    background: rgba(76, 175, 130, 0.12);
    color: var(--success);
  }

  .stat-badge.neutral {
    background: var(--bg-mid);
    color: var(--text-secondary);
  }

  .stat-badge.pending {
    background: rgba(232, 168, 124, 0.18);
    color: #c47a3d;
  }

  .stat-title {
    font-size: 0.82rem;
    font-weight: 600;
    margin: 0 0 4px 0;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    font-family: 'DM Sans', system-ui, sans-serif;
    line-height: 1;
    margin-bottom: 4px;
  }

  .stat-value-sub {
    font-size: 0.82rem;
    color: var(--text-secondary);
    font-weight: 500;
  }

  .progress-bar {
    width: 100%;
    height: 5px;
    background: var(--border);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin: 12px 0 6px;
  }

  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: var(--radius-full);
    transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .progress-text {
    font-size: 0.78rem;
    color: var(--text-secondary);
    font-weight: 500;
  }

  /* Mood chip display */
  .mood-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: var(--radius-full);
    background: var(--bg-mid);
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
  }

  .mood-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
  }

  .mood-dot.happy   { background: #4CAF82; }
  .mood-dot.calm    { background: #4CAF82; }
  .mood-dot.content { background: #4CAF82; }
  .mood-dot.excited { background: #4CAF82; }
  .mood-dot.neutral { background: var(--accent-calm); }
  .mood-dot.tired   { background: var(--accent-warm); }
  .mood-dot.sad     { background: #A8C5DA; }
  .mood-dot.anxious { background: var(--accent-warm); }
  .mood-dot.stressed{ background: var(--crisis); }
  .mood-dot.angry   { background: var(--crisis); }
  .mood-dot.default { background: var(--border); }

  .mood-timestamp {
    font-size: 0.78rem;
    color: var(--text-secondary);
  }

  /* Appointment detail */
  .appt-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--primary-dark);
    background: rgba(61, 139, 110, 0.1);
    padding: 5px 12px;
    border-radius: var(--radius-full);
    margin-bottom: 8px;
  }

  .appt-time {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
  }

  .appt-meta {
    font-size: 0.82rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .appt-meta i {
    font-size: 0.75rem;
    color: var(--primary);
  }

  /* ── Analytics Grid ── */
  .dashboard-analytics {
    margin-bottom: 24px;
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
    transition: box-shadow 0.25s;
  }

  .analytics-card:hover {
    box-shadow: var(--shadow-md);
  }

  .card-header {
    padding: 18px 22px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
  }

  .card-subtitle {
    font-size: 0.78rem;
    color: var(--text-secondary);
    margin: 2px 0 0 0;
    font-weight: 500;
  }

  .time-filter {
    padding: 5px 10px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    font-family: inherit;
    font-size: 0.78rem;
    color: var(--text-secondary);
    cursor: pointer;
    outline: none;
    transition: border-color 0.2s;
  }

  .time-filter:focus {
    border-color: var(--primary);
  }

  .card-content {
    padding: 14px 22px 18px;
  }

  .chart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 150px;
    color: var(--text-secondary);
    font-size: 0.85rem;
    gap: 8px;
  }

  .chart-empty i {
    font-size: 2rem;
    opacity: 0.3;
  }

  /* ── Quick Actions ── */
  .dashboard-actions {
    margin-bottom: 8px;
  }

  .actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px;
  }

  .action-card {
    background: var(--surface);
    padding: 22px 18px 18px;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    transition: all 0.28s ease;
    position: relative;
    overflow: hidden;
  }

  .action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--card-accent, var(--primary));
    opacity: 0;
    transition: opacity 0.25s;
  }

  .action-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: transparent;
  }

  .action-card:hover::before {
    opacity: 1;
  }

  .action-icon-box {
    width: 46px;
    height: 46px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    margin-bottom: 14px;
    flex-shrink: 0;
  }

  .action-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 6px 0;
  }

  .action-description {
    color: var(--text-secondary);
    margin: 0 0 16px 0;
    line-height: 1.55;
    font-size: 0.8rem;
    flex: 1;
  }

  /* Crisis action card */
  .action-card.crisis-card {
    --card-accent: var(--crisis);
    background: linear-gradient(135deg, #fff5f5, #fff);
    border-color: rgba(214, 79, 79, 0.18);
  }

  .action-card.crisis-card:hover {
    border-color: rgba(214, 79, 79, 0.3);
  }

  /* ── Responsive ── */
  @media (max-width: 1024px) {
    .stats-grid        { grid-template-columns: repeat(2, 1fr); }
    .analytics-grid    { grid-template-columns: 1fr; }
  }

  @media (max-width: 768px) {
    .dashboard-main    { padding: 16px; }
    .hero-content      { flex-direction: column; align-items: flex-start; }
    .hero-right        { align-items: flex-start; }
    .stats-grid        { grid-template-columns: 1fr; }
    .actions-grid      { grid-template-columns: repeat(2, 1fr); }
  }

  @media (max-width: 480px) {
    .actions-grid      { grid-template-columns: 1fr; }
    .hero-title        { font-size: 1.5rem; }
  }
</style>

<main id="main" class="dashboard-main">

  <!-- ── Welcome Hero ── -->
  <section class="dashboard-hero">
    <div class="hero-content">
      <div class="hero-text">
        <div class="hero-eyebrow">Welcome back</div>
        <h1 class="hero-title"><?= htmlspecialchars($studentName ?? 'Student') ?></h1>
        <p class="hero-subtitle">Here is your mental wellness overview for today.</p>
        <div class="hero-pills">
          <div class="hero-pill">
            <i class="fas fa-check-circle"></i>
            <span class="hero-pill-value"><?= $habitStats['scheduled_today'] ?? 0 ?></span>
            <span>Tasks Today</span>
          </div>
          <div class="hero-pill">
            <i class="fas fa-fire"></i>
            <span class="hero-pill-value"><?= $habitStats['completion_rate'] ?? 0 ?>%</span>
            <span>Completion Rate</span>
          </div>
        </div>
      </div>

      <div class="hero-right">
        <div class="hero-date-chip">
          <i class="fas fa-calendar-day"></i>
          <?= date('l, F j') ?>
        </div>
        <div class="hero-actions">
          <a href="<?= BASE_URL ?>/ug/mood" class="btn btn-outline-white btn-sm">
            <i class="fas fa-smile"></i> Log Mood
          </a>
          <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-outline-white btn-sm">
            <i class="fas fa-plus"></i> Add Habit
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Overview Stats ── -->
  <section class="dashboard-stats">
    <div class="section-header">
      <span class="section-label">Overview</span>
    </div>
    <div class="stats-grid">

      <!-- Habits Card -->
      <div class="stat-card">
        <div class="stat-card-inner">
          <div class="stat-header">
            <div class="stat-icon-box teal"><i class="fas fa-check-double"></i></div>
            <span class="stat-badge positive">Today</span>
          </div>
          <div class="stat-title">Habits Completed</div>
          <?php
            $habitsCompleted = $habitStats['completed_today'] ?? 0;
            $habitsScheduled = $habitStats['scheduled_today'] ?? 0;
            $habitRatio      = $habitsScheduled > 0 ? "{$habitsCompleted}/{$habitsScheduled}" : "0/0";
            $habitPercent    = $habitsScheduled > 0 ? min(100, round(($habitsCompleted / $habitsScheduled) * 100)) : 0;
          ?>
          <div class="stat-value"><?= $habitRatio ?></div>
          <div class="stat-value-sub">habits done today</div>
          <div class="progress-bar">
            <div class="progress-fill" style="width:<?= $habitPercent ?>%"></div>
          </div>
          <span class="progress-text"><?= $habitPercent ?>% complete</span>
        </div>
        <div class="stat-card-footer">
          <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-right"></i> View Habits
          </a>
        </div>
      </div>

      <!-- Mood Card -->
      <div class="stat-card">
        <div class="stat-card-inner">
          <div class="stat-header">
            <div class="stat-icon-box warm"><i class="fas fa-smile-beam"></i></div>
            <?php if (!empty($currentMood)): ?>
              <span class="stat-badge positive">Logged</span>
            <?php else: ?>
              <span class="stat-badge neutral">Not Logged</span>
            <?php endif; ?>
          </div>
          <div class="stat-title">Today's Mood</div>
          <?php
            $moodLabel = "Not logged today";
            $moodClass = 'default';
            $moodTime  = '';
            if (!empty($currentMood)) {
              $moodTime  = date('g:i A', strtotime($currentMood['created_at']));
              $moodType  = strtolower($currentMood['mood_type']);
              $moodMap   = [
                'happy'   => ['label' => 'Happy',    'class' => 'happy'],
                'sad'     => ['label' => 'Sad',      'class' => 'sad'],
                'anxious' => ['label' => 'Anxious',  'class' => 'anxious'],
                'calm'    => ['label' => 'Calm',     'class' => 'calm'],
                'angry'   => ['label' => 'Angry',    'class' => 'angry'],
                'stressed'=> ['label' => 'Stressed', 'class' => 'stressed'],
                'tired'   => ['label' => 'Tired',    'class' => 'tired'],
                'neutral' => ['label' => 'Neutral',  'class' => 'neutral'],
                'content' => ['label' => 'Content',  'class' => 'content'],
                'excited' => ['label' => 'Excited',  'class' => 'excited'],
              ];
              if (isset($moodMap[$moodType])) {
                $moodLabel = $moodMap[$moodType]['label'];
                $moodClass = $moodMap[$moodType]['class'];
              } else {
                $moodLabel = ucfirst($moodType);
              }
            }
          ?>
          <div class="mood-chip">
            <span class="mood-dot <?= $moodClass ?>"></span>
            <span id="currentMoodText"><?= htmlspecialchars($moodLabel) ?></span>
          </div>
          <div class="mood-timestamp" id="moodTime">
            <?= empty($currentMood) ? 'Log your mood to start tracking trends.' : 'Logged today at ' . htmlspecialchars($moodTime) ?>
          </div>
        </div>
        <div class="stat-card-footer">
          <a href="<?= BASE_URL ?>/ug/mood" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Log Mood
          </a>
        </div>
      </div>

      <!-- Appointments Card -->
      <div class="stat-card">
        <div class="stat-card-inner">
          <div class="stat-header">
            <div class="stat-icon-box calm"><i class="fas fa-calendar-check"></i></div>
            <?php if (!empty($nextAppointment)): ?>
              <span class="stat-badge pending">Upcoming</span>
            <?php else: ?>
              <span class="stat-badge neutral">None</span>
            <?php endif; ?>
          </div>
          <div class="stat-title">Next Appointment</div>
          <?php if (!empty($nextAppointment)):
            $dateObj  = new DateTime($nextAppointment['date']);
            $today    = new DateTime('today');
            $tomorrow = new DateTime('tomorrow');
            if ($dateObj == $today)          $aptDate = 'Today';
            elseif ($dateObj == $tomorrow)   $aptDate = 'Tomorrow';
            else                             $aptDate = $dateObj->format('F j');
            $aptTime    = date('g:i A', strtotime($nextAppointment['time']));
            $aptType    = htmlspecialchars($nextAppointment['type']);
            $counselor  = htmlspecialchars($nextAppointment['counselor_name'] ?? 'Counselor');
            $aptMode    = $nextAppointment['mode'] ?? 'audio_video';
            $modeText   = ($aptMode == 'in_person') ? 'In-Person' : 'Online';
          ?>
            <div class="appt-date-badge"><i class="fas fa-calendar-alt"></i> <?= $aptDate ?></div>
            <div class="appt-time"><?= $aptTime ?></div>
            <div class="appt-meta"><i class="fas fa-user-md"></i> <?= $counselor ?></div>
            <div class="appt-meta" style="margin-top:4px;"><i class="fas fa-video"></i> <?= $aptType ?> &mdash; <?= htmlspecialchars($modeText) ?></div>
          <?php else: ?>
            <div class="stat-value" style="font-size:1.1rem;margin-bottom:6px;">No upcoming sessions</div>
            <div class="appt-meta">Schedule a session with a counselor whenever you are ready.</div>
          <?php endif; ?>
        </div>
        <div class="stat-card-footer">
          <a href="<?= BASE_URL ?>/ug/appointment" class="btn btn-outline btn-sm">
            <i class="fas fa-calendar-plus"></i> Manage
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- ── Analytics ── -->
  <section class="dashboard-analytics">
    <div class="section-header">
      <span class="section-label">Analytics</span>
      <a href="<?= BASE_URL ?>/ug/mood" class="section-link">View full history</a>
    </div>
    <div class="analytics-grid">

      <div class="analytics-card">
        <div class="card-header">
          <div>
            <h3 class="card-title">Habit Progress</h3>
            <p class="card-subtitle">Daily completion over time</p>
          </div>
          <select class="time-filter" id="habitTimeFilter">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
          </select>
        </div>
        <div class="card-content">
          <?php if (!empty($habitChartData['data'])): ?>
            <canvas id="habitChart" width="400" height="150"></canvas>
          <?php else: ?>
            <div class="chart-empty">
              <i class="fas fa-chart-line"></i>
              <span>No habit data yet. Start tracking habits to see progress.</span>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="analytics-card">
        <div class="card-header">
          <div>
            <h3 class="card-title">Mood Trends</h3>
            <p class="card-subtitle">Emotional pattern overview</p>
          </div>
          <select class="time-filter" id="moodTimeFilter">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
          </select>
        </div>
        <div class="card-content">
          <?php if (!empty($moodChartData['data'])): ?>
            <canvas id="moodChart" width="400" height="150"></canvas>
          <?php else: ?>
            <div class="chart-empty">
              <i class="fas fa-smile"></i>
              <span>No mood data yet. Log your mood daily to build insights.</span>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>

  <!-- ── Quick Actions ── -->
  <section class="dashboard-actions">
    <div class="section-header">
      <span class="section-label">Quick Actions</span>
    </div>
    <div class="actions-grid">

      <div class="action-card" style="--card-accent:var(--primary);">
        <div class="action-icon-box" style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));">
          <i class="fas fa-bullseye"></i>
        </div>
        <h4 class="action-title">Set Goals</h4>
        <p class="action-description">Create and manage wellness habits to build consistent routines.</p>
        <a href="<?= BASE_URL ?>/ug/habits" class="btn btn-outline btn-sm">Get Started</a>
      </div>

      <div class="action-card" style="--card-accent:var(--accent-calm);">
        <div class="action-icon-box" style="background:linear-gradient(135deg,#7aaec7,var(--accent-calm));">
          <i class="fas fa-book-open"></i>
        </div>
        <h4 class="action-title">Resources</h4>
        <p class="action-description">Access curated mental health articles, tools and guides.</p>
        <a href="<?= BASE_URL ?>/ug/resources" class="btn btn-outline btn-sm">Browse</a>
      </div>

      <div class="action-card" style="--card-accent:var(--accent-warm);">
        <div class="action-icon-box" style="background:linear-gradient(135deg,#d48a5d,var(--accent-warm));">
          <i class="fas fa-user-md"></i>
        </div>
        <h4 class="action-title">Book a Session</h4>
        <p class="action-description">Connect with a counselor and schedule a support session.</p>
        <a href="<?= BASE_URL ?>/ug/appointment" class="btn btn-outline btn-sm">Schedule</a>
      </div>

      <div class="action-card" style="--card-accent:var(--primary-light);">
        <div class="action-icon-box" style="background:linear-gradient(135deg,#4a9c7e,var(--primary-light));">
          <i class="fas fa-clipboard-list"></i>
        </div>
        <h4 class="action-title">Self-Assessment</h4>
        <p class="action-description">Take a short mental health quiz to understand your wellbeing.</p>
        <a href="<?= BASE_URL ?>/ug/quiz" class="btn btn-outline btn-sm">Start Quiz</a>
      </div>

      <div class="action-card crisis-card">
        <div class="action-icon-box" style="background:linear-gradient(135deg,#b83b3b,var(--crisis));">
          <i class="fas fa-phone-alt"></i>
        </div>
        <h4 class="action-title">Crisis Support</h4>
        <p class="action-description">Reach a trained responder immediately if you need urgent help.</p>
        <a href="<?= BASE_URL ?>/ug/crisis" class="btn btn-danger btn-sm">Get Help Now</a>
      </div>

    </div>
  </section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const primaryColor      = '#3D8B6E';
    const primaryFill       = 'rgba(61,139,110,0.10)';
    const successColor      = '#4CAF82';
    const successFill       = 'rgba(76,175,130,0.10)';
    const gridColor         = '#D6E4DD';
    const labelColor        = '#6B8C7E';

    const habitData = <?= json_encode($habitChartData ?? ['labels' => [], 'data' => []]) ?>;
    const moodData  = <?= json_encode($moodChartData  ?? ['labels' => [], 'data' => []]) ?>;

    function drawChart(canvasId, data, lineColor, fillColor) {
      const canvas = document.getElementById(canvasId);
      if (!canvas) return;
      if (!data.data || data.data.length < 2) return;

      const ctx = canvas.getContext('2d');
      const W = canvas.width, H = canvas.height;
      const m = { top: 14, right: 16, bottom: 28, left: 36 };
      const cw = W - m.left - m.right;
      const ch = H - m.top - m.bottom;

      ctx.clearRect(0, 0, W, H);

      const vals  = data.data;
      const max   = Math.max(...vals);
      const min   = Math.min(...vals);
      const range = (max - min) || 1;

      const xOf = i => m.left + (cw / (vals.length - 1)) * i;
      const yOf = v => m.top + ch - ((v - min) / range) * ch;

      // Grid lines
      ctx.strokeStyle = gridColor;
      ctx.lineWidth   = 1;
      for (let i = 0; i <= 4; i++) {
        const y = m.top + (ch / 4) * i;
        ctx.beginPath();
        ctx.moveTo(m.left, y);
        ctx.lineTo(W - m.right, y);
        ctx.stroke();
      }

      // Fill area
      ctx.fillStyle = fillColor;
      ctx.beginPath();
      ctx.moveTo(xOf(0), H - m.bottom);
      ctx.lineTo(xOf(0), yOf(vals[0]));
      for (let i = 1; i < vals.length; i++) ctx.lineTo(xOf(i), yOf(vals[i]));
      ctx.lineTo(xOf(vals.length - 1), H - m.bottom);
      ctx.closePath();
      ctx.fill();

      // Line (smooth-ish using lineTo)
      ctx.strokeStyle = lineColor;
      ctx.lineWidth   = 2.5;
      ctx.lineJoin    = 'round';
      ctx.beginPath();
      vals.forEach((v, i) => {
        i === 0 ? ctx.moveTo(xOf(i), yOf(v)) : ctx.lineTo(xOf(i), yOf(v));
      });
      ctx.stroke();

      // Dots
      vals.forEach((v, i) => {
        const x = xOf(i), y = yOf(v);
        ctx.fillStyle  = '#fff';
        ctx.beginPath();
        ctx.arc(x, y, 5, 0, 2 * Math.PI);
        ctx.fill();
        ctx.fillStyle   = lineColor;
        ctx.beginPath();
        ctx.arc(x, y, 3.5, 0, 2 * Math.PI);
        ctx.fill();
      });

      // X labels
      ctx.fillStyle  = labelColor;
      ctx.font       = '11px DM Sans, sans-serif';
      ctx.textAlign  = 'center';
      data.labels.forEach((l, i) => {
        ctx.fillText(l, xOf(i), H - m.bottom + 16);
      });

      // Y labels
      ctx.textAlign = 'right';
      for (let i = 0; i <= 4; i++) {
        const val = Math.round(min + (range / 4) * i);
        ctx.fillText(val, m.left - 6, m.top + ch - (ch / 4) * i + 4);
      }
    }

    drawChart('habitChart', habitData, primaryColor, primaryFill);
    drawChart('moodChart',  moodData,  successColor, successFill);

    document.getElementById('habitTimeFilter')?.addEventListener('change', () =>
      drawChart('habitChart', habitData, primaryColor, primaryFill));
    document.getElementById('moodTimeFilter')?.addEventListener('change', () =>
      drawChart('moodChart', moodData, successColor, successFill));
  });
</script>