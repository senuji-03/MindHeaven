<?php
$TITLE = 'MindHeaven - Habit Tracker';
$CURRENT_PAGE = 'habits';
require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
  /* ── Design tokens ─────────────────────────────────────────────── */
  :root {
    --primary: #3D8B6E;
    --primary-dark: #2A6B52;
    --primary-light: #6BB89A;
    --surface: #FFFFFF;
    --bg-mid: #EEF6F2;
    --text-primary: #1E3A34;
    --text-secondary: #6B8C7E;
    --border: #D6E4DD;
    --shadow-sm: 0 2px 8px rgba(30, 58, 52, 0.06);
    --shadow-md: 0 4px 20px rgba(30, 58, 52, 0.10);
    --shadow-lg: 0 12px 40px rgba(30, 58, 52, 0.16);
    --radius-lg: 20px;
    --radius-md: 12px;
    --radius-sm: 8px;
  }

  /* ── Page wrapper ──────────────────────────────────────────────── */
  .habits-page {
    padding: 16px 28px;
    max-width: 1200px;
    margin: 0 auto;
    font-family: inherit;
  }

  /* ── Hero bar ──────────────────────────────────────────────────── */
  .habits-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
    border-radius: var(--radius-lg);
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-lg);
    margin-bottom: 16px;
    gap: 16px;
    position: relative;
    overflow: hidden;
  }

  .habits-hero::after {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(232, 168, 124, 0.1);
    bottom: -30px;
    left: 20%;
  }

  .hero-title {
    color: #fff;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 6px;
    letter-spacing: -0.5px;
    position: relative;
    z-index: 1;
  }

  .hero-sub {
    color: rgba(255, 255, 255, .85);
    font-size: .92rem;
    margin: 0;
    position: relative;
    z-index: 1;
  }

  .btn-hero {
    background: #fff;
    color: var(--primary-dark);
    border: none;
    border-radius: var(--radius-full);
    padding: 10px 22px;
    font-weight: 700;
    font-size: .88rem;
    cursor: pointer;
    white-space: nowrap;
    transition: transform .2s, box-shadow .2s;
    position: relative;
    z-index: 1;
  }

  .btn-hero:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
  }

  /* ── Stats strip ───────────────────────────────────────────────── */
  .stats-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 16px;
  }

  .stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
  }

  .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-sm);
    background: var(--bg-mid);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
  }

  .stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
    font-family: 'DM Sans', system-ui, sans-serif;
    margin-bottom: 2px;
  }

  .stat-label {
    font-size: .78rem;
    color: var(--text-secondary);
    margin-top: 2px;
  }

  /* ── Calendar card ─────────────────────────────────────────────── */
  .calendar-card {
    background: var(--surface);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    border: 1px solid var(--border);
  }

  .cal-nav {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
  }

  .cal-nav-btn {
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .25);
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
  }

  .cal-nav-btn:hover {
    background: rgba(255, 255, 255, .32);
  }

  .cal-month-label {
    color: #fff;
    font-size: 1.25rem;
    font-weight: 700;
  }

  .cal-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: var(--bg-mid);
    border-bottom: 1px solid var(--border);
  }

  .cal-weekday {
    text-align: center;
    padding: 10px 0;
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: .8px;
  }

  .cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
  }

  .cal-day {
    min-height: 76px;
    border-right: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 8px 10px 6px;
    cursor: pointer;
    transition: background .15s;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .cal-day:nth-child(7n) {
    border-right: none;
  }

  .cal-day.other-month {
    background: #f9fbfa;
  }

  .cal-day.other-month .day-num {
    color: #c0d4cc;
  }

  .cal-day:hover:not(.other-month) {
    background: #f0faf5;
  }

  .cal-day.is-today .day-num {
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }

  .cal-day.selected {
    background: #e6f5ee !important;
    box-shadow: inset 0 0 0 2px var(--primary);
  }

  .day-num {
    font-size: .85rem;
    font-weight: 600;
    color: var(--text-primary);
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .day-dots {
    display: flex;
    flex-wrap: wrap;
    gap: 3px;
    margin-top: 2px;
  }

  .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
  }

  .dot-more {
    font-size: .6rem;
    color: var(--text-secondary);
    font-weight: 600;
    align-self: center;
  }

  /* ── Day panel ─────────────────────────────────────────────────── */
  .day-panel-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 30, 25, .45);
    backdrop-filter: blur(4px);
    z-index: 8000;
    display: none;
    opacity: 0;
    transition: opacity .25s;
  }

  .day-panel-overlay.active {
    display: block;
    opacity: 1;
  }

  .day-panel {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 400px;
    max-width: 95vw;
    background: #fff;
    box-shadow: -8px 0 40px rgba(0, 0, 0, .15);
    z-index: 8001;
    transform: translateX(100%);
    transition: transform .3s cubic-bezier(.4, 0, .2, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .day-panel.open {
    transform: translateX(0);
  }

  .panel-header {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    color: #fff;
    padding: 24px 24px 20px;
    flex-shrink: 0;
    position: relative;
  }

  .panel-date-big {
    font-size: 1.3rem;
    font-weight: 800;
    margin: 0 0 4px;
  }

  .panel-date-sub {
    font-size: .85rem;
    opacity: .85;
    margin: 0;
  }

  .panel-close {
    position: absolute;
    top: 18px;
    right: 18px;
    background: rgba(255, 255, 255, .2);
    border: none;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
  }

  .panel-close:hover {
    background: rgba(255, 255, 255, .35);
  }

  .panel-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    scrollbar-width: thin;
    scrollbar-color: var(--border) transparent;
  }

  .panel-section-title {
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: .8px;
    margin: 0 0 10px;
  }

  .habit-row {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 11px 13px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    margin-bottom: 8px;
    background: #fff;
    transition: border-color .15s, box-shadow .15s;
    min-height: 64px;
  }

  .habit-row:hover {
    border-color: var(--primary-light);
    box-shadow: var(--shadow-sm);
  }

  .habit-row.completed-row {
    background: #f0faf5;
    border-color: #a8d8c0;
  }

  .habit-row-top {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .habit-icon-badge {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .habit-row-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .habit-row-name {
    font-size: .88rem;
    font-weight: 600;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .habit-row-sub {
    font-size: .7rem;
    color: var(--text-secondary);
    margin-top: 1px;
    text-transform: capitalize;
  }

  .habit-toggle {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    border: 2px solid var(--border);
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all .15s;
    font-size: .8rem;
    color: transparent;
  }

  .habit-toggle.checked {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
  }

  .habit-toggle:hover {
    border-color: var(--primary);
  }

  .empty-day {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-secondary);
  }

  .empty-day .empty-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
  }

  .empty-day p {
    font-size: .9rem;
    margin: 0;
  }

  .panel-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
  }

  .btn-add-habit-day {
    width: 100%;
    padding: 13px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: .95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, transform .15s;
  }

  .btn-add-habit-day:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
  }

  .panel-loader {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px 20px;
  }

  .spinner {
    width: 32px;
    height: 32px;
    border: 3px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin .7s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  /* ── Add Habit Modal ────────────────────────────────────────────── */
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .5);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .modal-overlay.active {
    display: flex;
  }

  .modal-content {
    background: #fff;
    width: 100%;
    max-width: 480px;
    border-radius: var(--radius-lg);
    padding: 32px;
    position: relative;
    box-shadow: var(--shadow-lg);
    max-height: 94vh;
    overflow-y: auto;
  }

  .modal-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 22px;
  }

  .close-btn {
    position: absolute;
    top: 18px;
    right: 18px;
    background: var(--bg-mid);
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 1.1rem;
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
  }

  .close-btn:hover {
    background: var(--border);
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group>label {
    display: block;
    margin-bottom: 6px;
    font-size: .82rem;
    font-weight: 700;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: .4px;
  }

  .form-control {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: .92rem;
    color: var(--text-primary);
    background: #fff;
    transition: border-color .15s, box-shadow .15s;
    box-sizing: border-box;
  }

  .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(61, 139, 110, .1);
  }

  /* ── Frequency tab selector ─────────────────────────────────────── */
  .freq-tabs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 12px;
  }

  .freq-tab {
    padding: 8px 16px;
    border-radius: 50px;
    border: 1.5px solid var(--border);
    background: white;
    color: var(--text-secondary);
    cursor: pointer;
    font-size: .82rem;
    font-weight: 700;
    transition: all .15s;
    line-height: 1;
  }

  .freq-tab.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .freq-tab:hover:not(.active) {
    border-color: var(--primary);
    color: var(--primary);
  }

  /* Frequency sub-sections */
  .freq-sub {
    background: var(--bg-mid);
    border-radius: var(--radius-md);
    padding: 14px 16px;
    margin-top: 0;
    border: 1px solid var(--border);
  }

  .freq-info {
    font-size: .88rem;
    color: var(--text-secondary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .freq-info strong {
    color: var(--primary-dark);
  }

  /* Date range row */
  .date-range-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .date-range-row label {
    display: block;
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: .4px;
  }

  /* Weekday pills */
  .weekday-pills {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    margin-bottom: 14px;
  }

  .weekday-pill {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .72rem;
    font-weight: 800;
    cursor: pointer;
    transition: all .15s;
    color: var(--text-secondary);
    user-select: none;
  }

  .weekday-pill.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .weekday-pill:hover:not(.active) {
    border-color: var(--primary);
    color: var(--primary);
  }

  /* Interval input group */
  .interval-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
  }

  .interval-num {
    width: 80px;
    text-align: center;
    font-weight: 700;
    padding: 10px 8px;
    font-size: .95rem;
  }

  .interval-label {
    font-size: .88rem;
    color: var(--text-secondary);
  }

  /* Submit button */
  .btn-submit {
    width: 100%;
    margin-top: 10px;
    padding: 14px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: .95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s, transform .15s;
  }

  .btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
  }

  .btn-submit:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
  }

  /* ── Toast notification ──────────────────────────────────────────── */
  .toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: var(--text-primary);
    color: #fff;
    padding: 12px 20px;
    border-radius: var(--radius-md);
    font-size: .88rem;
    font-weight: 600;
    z-index: 99999;
    box-shadow: var(--shadow-lg);
    transform: translateY(80px);
    opacity: 0;
    transition: all .3s cubic-bezier(.4, 0, .2, 1);
    max-width: 320px;
  }

  .toast.show {
    transform: translateY(0);
    opacity: 1;
  }

  .toast.success {
    background: var(--primary);
  }

  .toast.error {
    background: #e53e3e;
  }

  /* Freq summary badge under each habit in panel */
  .freq-badge {
    display: inline-block;
    padding: 1px 7px;
    border-radius: 50px;
    font-size: .62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-left: 4px;
    vertical-align: middle;
  }

  .freq-today {
    background: #dcfce7;
    color: #15803d;
  }

  .freq-daily {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .freq-weekly {
    background: #fef3c7;
    color: #92400e;
  }

  .freq-custom {
    background: #ede9fe;
    color: #5b21b6;
  }

  .habit-action-group {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
    align-self: flex-end;
  }

  .habit-action-btn {
    appearance: none;
    border: 1px solid transparent;
    background: rgba(61, 139, 110, .08);
    color: var(--primary-dark);
    border-radius: 999px;
    padding: 8px 12px;
    font-size: .78rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s, transform .15s;
  }

  .habit-action-btn:hover {
    background: rgba(61, 139, 110, .18);
  }

  .habit-action-btn.update-btn {
    background: var(--primary);
    color: #fff;
  }

  .habit-action-btn.delete-btn {
    background: #e53e3e;
    color: #fff;
  }

  .habit-detail-card {
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 16px;
    margin: 10px 0 8px;
    background: #f8fcf8;
  }

  .habit-detail-row {
    display: grid;
    grid-template-columns: 130px 1fr;
    gap: 6px 14px;
    margin-bottom: 10px;
  }

  .habit-detail-row:last-child {
    margin-bottom: 0;
  }

  .habit-detail-title {
    font-size: .78rem;
    font-weight: 700;
    color: var(--text-primary);
  }

  .habit-detail-value {
    font-size: .86rem;
    color: var(--text-secondary);
  }

  @media (max-width: 640px) {
    .habits-page {
      padding: 16px;
    }

    .stats-strip {
      grid-template-columns: 1fr;
    }

    .day-panel {
      width: 100%;
    }

    .date-range-row {
      grid-template-columns: 1fr;
    }
  }
</style>

<?php
$todayStr = date('Y-m-d');
$currentYear = (int) date('Y');
$currentMonth = (int) date('n');
?>

<div class="habits-page">

  <!-- ── Hero ──────────────────────────────────────────────────────── -->
  <div class="habits-hero">
    <div>
      <h1 class="hero-title">Habit Calendar</h1>
      <p class="hero-sub">Click any day to log or view your habits. Habits appear on scheduled days.</p>
    </div>
    <button class="btn-hero" id="openAddHabitBtn">+ New Habit</button>
  </div>

  <!-- ── Stats strip ───────────────────────────────────────────────── -->
  <div class="stats-strip">
    <div class="stat-card">
      <div class="stat-icon">📋</div>
      <div>
        <div class="stat-value" id="statTotal">—</div>
        <div class="stat-label">Total Habits</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">✅</div>
      <div>
        <div class="stat-value" id="statToday">—</div>
        <div class="stat-label">Done Today</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">🔥</div>
      <div>
        <div class="stat-value" id="statRate">—</div>
        <div class="stat-label">Today's Rate</div>
      </div>
    </div>
  </div>

  <!-- ── Calendar ──────────────────────────────────────────────────── -->
  <div class="calendar-card">
    <div class="cal-nav">
      <button class="cal-nav-btn" id="prevMonthBtn">&#8249;</button>
      <span class="cal-month-label" id="calMonthLabel">Loading…</span>
      <button class="cal-nav-btn" id="nextMonthBtn">&#8250;</button>
    </div>
    <div class="cal-weekdays">
      <div class="cal-weekday">Sun</div>
      <div class="cal-weekday">Mon</div>
      <div class="cal-weekday">Tue</div>
      <div class="cal-weekday">Wed</div>
      <div class="cal-weekday">Thu</div>
      <div class="cal-weekday">Fri</div>
      <div class="cal-weekday">Sat</div>
    </div>
    <div class="cal-grid" id="calGrid"></div>
  </div>

</div><!-- /.habits-page -->

<!-- ════════ DAY DETAIL PANEL ════════ -->
<div class="day-panel-overlay" id="dayPanelOverlay"></div>
<div class="day-panel" id="dayPanel">
  <div class="panel-header">
    <p class="panel-date-big" id="panelDateBig"></p>
    <p class="panel-date-sub" id="panelDateSub"></p>
    <button class="panel-close" id="panelCloseBtn">✕</button>
  </div>
  <div class="panel-body" id="panelBody">
    <div class="panel-loader">
      <div class="spinner"></div>
    </div>
  </div>
  <div class="panel-footer">
    <button class="btn-add-habit-day" id="panelAddHabitBtn">+ Add New Habit for This Day</button>
  </div>
</div>

<!-- ════════ ADD HABIT MODAL ════════ -->
<div class="modal-overlay" id="addHabitModal">
  <div class="modal-content">
    <button class="close-btn" id="closeHabitModalBtn">✕</button>
    <h2 class="modal-title">Add New Habit</h2>

    <form id="addHabitForm" autocomplete="off">

      <!-- Name -->
      <div class="form-group">
        <label for="habitName">Habit Name *</label>
        <input type="text" id="habitName" class="form-control" placeholder="e.g. Morning Run" required>
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="habitCategory">Category *</label>
        <select id="habitCategory" class="form-control" required>
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

      <!-- Description -->
      <div class="form-group">
        <label for="habitDesc">Description (Optional)</label>
        <textarea id="habitDesc" class="form-control" rows="2" placeholder="Additional details…"></textarea>
      </div>

      <!-- ── FREQUENCY ──────────────────────────────────────────── -->
      <div class="form-group">
        <label>Frequency *</label>
        <!-- Tab buttons -->
        <div class="freq-tabs">
          <button type="button" class="freq-tab active" id="ftToday" onclick="selectFreq('today',  this)">Today</button>
          <button type="button" class="freq-tab" id="ftDaily" onclick="selectFreq('daily',  this)">Daily</button>
          <button type="button" class="freq-tab" id="ftWeekly" onclick="selectFreq('weekly', this)">Weekly</button>
          <button type="button" class="freq-tab" id="ftCustom" onclick="selectFreq('custom', this)">Custom</button>
        </div>
        <input type="hidden" id="habitFrequency" value="today">
        <input type="hidden" id="habitIdInput" value="">

        <!-- TODAY sub-form -->
        <div class="freq-sub" id="freqSubToday">
          <p class="freq-info">
            📅 This habit will appear <strong>only on</strong>
            <strong id="todayDateDisplay">—</strong>
          </p>
        </div>

        <!-- DAILY sub-form -->
        <div class="freq-sub" id="freqSubDaily" style="display:none;">
          <p class="freq-info" style="margin-bottom:12px;">
            📆 Appears <strong>every day</strong> between the selected dates.
          </p>
          <div class="date-range-row">
            <div>
              <label>From</label>
              <input type="date" id="dailyStart" class="form-control">
            </div>
            <div>
              <label>To (optional)</label>
              <input type="date" id="dailyEnd" class="form-control">
            </div>
          </div>
        </div>

        <!-- WEEKLY sub-form -->
        <div class="freq-sub" id="freqSubWeekly" style="display:none;">
          <p class="freq-info" style="margin-bottom:10px;">
            📅 Appears on selected <strong>days of the week</strong>.
          </p>
          <label
            style="font-size:.72rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:8px;">Select
            Days</label>
          <div class="weekday-pills" id="weekdayPills">
            <div class="weekday-pill" data-day="0" onclick="toggleDay(this)">Su</div>
            <div class="weekday-pill" data-day="1" onclick="toggleDay(this)">Mo</div>
            <div class="weekday-pill" data-day="2" onclick="toggleDay(this)">Tu</div>
            <div class="weekday-pill" data-day="3" onclick="toggleDay(this)">We</div>
            <div class="weekday-pill" data-day="4" onclick="toggleDay(this)">Th</div>
            <div class="weekday-pill" data-day="5" onclick="toggleDay(this)">Fr</div>
            <div class="weekday-pill" data-day="6" onclick="toggleDay(this)">Sa</div>
          </div>
          <div class="date-range-row">
            <div>
              <label>From</label>
              <input type="date" id="weeklyStart" class="form-control">
            </div>
            <div>
              <label>To (optional)</label>
              <input type="date" id="weeklyEnd" class="form-control">
            </div>
          </div>
        </div>

        <!-- CUSTOM sub-form -->
        <div class="freq-sub" id="freqSubCustom" style="display:none;">
          <p class="freq-info" style="margin-bottom:10px;">
            🔁 Appears every <strong>N days</strong> from the start date.
          </p>
          <label
            style="font-size:.72rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.4px;display:block;margin-bottom:6px;">Repeat
            Interval</label>
          <div class="interval-row">
            <span class="interval-label">Every</span>
            <input type="number" id="repeatInterval" class="form-control interval-num" min="1" max="365" value="2">
            <span class="interval-label">days</span>
          </div>
          <div class="date-range-row">
            <div>
              <label>From</label>
              <input type="date" id="customStart" class="form-control">
            </div>
            <div>
              <label>To (optional)</label>
              <input type="date" id="customEnd" class="form-control">
            </div>
          </div>
        </div>
      </div><!-- /.form-group frequency -->

      <!-- Color & Icon -->
      <div class="form-group" style="display:flex;gap:14px;">
        <div style="flex:1;">
          <label for="habitColor">Color</label>
          <input type="color" id="habitColor" class="form-control" value="#10b981"
            style="height:44px;padding:5px 8px;cursor:pointer;">
        </div>
        <div style="flex:2;">
          <label for="habitIcon">Icon (Emoji)</label>
          <input type="text" id="habitIcon" class="form-control" placeholder="🎯" value="🎯">
          <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:10px;">
            <?php foreach(['🎯','📚','🏋️','💧','🧘','🏃','💻','🥗','🎨','🎸','🚭','😴','💰','📝','📖','🧠','🌱','🧹','🍳','🍎','🚲','🐕','⚕️','🌤️','🎵','💼','💡','⏳','🌍','❤️','🔥'] as $em): ?>
              <span style="cursor:pointer; font-size:1.15rem; transition:transform .15s;" 
                    onmouseover="this.style.transform='scale(1.25)'" 
                    onmouseout="this.style.transform='scale(1)'"
                    onclick="document.getElementById('habitIcon').value='<?= $em ?>'"><?= $em ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-submit" id="submitHabitBtn">Save Habit</button>
    </form>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<!-- ════════════════════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════════════════ -->
<script>
  const API = '/MindHeaven/public/api/habits';

  /* ── State ──────────────────────────────────────────────────────── */
  let calYear = <?= $currentYear ?>;
  let calMonth = <?= $currentMonth ?>;   // 1-based
  let calData = {};
  let allHabits = [];
  let selectedDate = null;
  let panelOpen = false;

  const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'];
  const DAY_NAMES = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const TODAY = '<?= $todayStr ?>';

  /* ── Init ───────────────────────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    loadStats();
    loadHabits().then(() => {
      renderCalendar();
      loadCalendarData();
    });

    document.getElementById('prevMonthBtn').addEventListener('click', () => shiftMonth(-1));
    document.getElementById('nextMonthBtn').addEventListener('click', () => shiftMonth(1));
    document.getElementById('panelCloseBtn').addEventListener('click', closePanel);
    document.getElementById('dayPanelOverlay').addEventListener('click', closePanel);
    document.getElementById('panelAddHabitBtn').addEventListener('click', () => { closePanel(); openAddHabitModal(); });
    document.getElementById('openAddHabitBtn').addEventListener('click', () => openAddHabitModal());
    document.getElementById('closeHabitModalBtn').addEventListener('click', closeAddHabitModal);
    document.getElementById('addHabitModal').addEventListener('click', e => {
      if (e.target === document.getElementById('addHabitModal')) closeAddHabitModal();
    });
    document.getElementById('addHabitForm').addEventListener('submit', handleCreateHabit);

    // Default today date display
    document.getElementById('todayDateDisplay').textContent = formatDisplayDate(TODAY);
    document.getElementById('dailyStart').value = TODAY;
    document.getElementById('weeklyStart').value = TODAY;
    document.getElementById('customStart').value = TODAY;
  });

  /* ── Stats ───────────────────────────────────────────────────────── */
  async function loadStats() {
    try {
      const res = await fetch(`${API}/stats`);
      const data = await res.json();
      if (data.stats) {
        document.getElementById('statTotal').textContent = data.stats.total_habits;
        document.getElementById('statToday').textContent = data.stats.completed_today;
        document.getElementById('statRate').textContent = data.stats.completion_rate + '%';
      }
    } catch (e) { }
  }

  /* ── Load habits ─────────────────────────────────────────────────── */
  async function loadHabits() {
    try {
      const res = await fetch(API);
      const data = await res.json();
      allHabits = data.habits || [];
    } catch (e) { allHabits = []; }
  }

  /* ── Calendar meta-data ──────────────────────────────────────────── */
  async function loadCalendarData() {
    try {
      const res = await fetch(`${API}/calendar?year=${calYear}&month=${calMonth}`);
      const data = await res.json();
      calData = data.data || {};
      renderDots();
    } catch (e) { }
  }

  /* ── Month navigation ────────────────────────────────────────────── */
  function shiftMonth(delta) {
    calMonth += delta;
    if (calMonth > 12) { calMonth = 1; calYear++; }
    if (calMonth < 1) { calMonth = 12; calYear--; }
    calData = {};
    renderCalendar();
    loadCalendarData();
  }

  /* ── Render calendar grid ────────────────────────────────────────── */
  function renderCalendar() {
    document.getElementById('calMonthLabel').textContent = `${MONTH_NAMES[calMonth - 1]} ${calYear}`;
    const grid = document.getElementById('calGrid');
    grid.innerHTML = '';

    const firstDay = new Date(calYear, calMonth - 1, 1).getDay();
    const daysInMonth = new Date(calYear, calMonth, 0).getDate();
    const prevDays = new Date(calYear, calMonth - 1, 0).getDate();

    for (let i = firstDay - 1; i >= 0; i--) {
      grid.appendChild(makeCell(calYear, calMonth - 1, prevDays - i, true));
    }
    for (let d = 1; d <= daysInMonth; d++) {
      grid.appendChild(makeCell(calYear, calMonth, d, false));
    }
    const total = firstDay + daysInMonth;
    const remaining = (7 - (total % 7)) % 7;
    for (let d = 1; d <= remaining; d++) {
      grid.appendChild(makeCell(calYear, calMonth + 1, d, true));
    }
  }

  function makeCell(year, month, day, isOther) {
    let y = year, m = month;
    if (m > 12) { m = 1; y++; }
    if (m < 1) { m = 12; y--; }
    const dateStr = `${y}-${String(m).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

    const cell = document.createElement('div');
    cell.className = 'cal-day' + (isOther ? ' other-month' : '');
    cell.dataset.date = dateStr;

    if (dateStr === TODAY) cell.classList.add('is-today');
    if (dateStr === selectedDate) cell.classList.add('selected');

    const numEl = document.createElement('div');
    numEl.className = 'day-num';
    numEl.textContent = day;
    cell.appendChild(numEl);

    const dotsEl = document.createElement('div');
    dotsEl.className = 'day-dots';
    dotsEl.dataset.dotsFor = dateStr;
    cell.appendChild(dotsEl);

    if (!isOther) cell.addEventListener('click', () => openPanel(dateStr));
    return cell;
  }

  /* ── Render dots per day ─────────────────────────────────────────── */
  function renderDots() {
    document.querySelectorAll('.day-dots').forEach(el => {
      const date = el.dataset.dotsFor;
      const count = calData[date] || 0;
      el.innerHTML = '';
      if (!count) return;

      // Use habit colors where possible
      for (let i = 0; i < Math.min(count, 3); i++) {
        const dot = document.createElement('span');
        dot.className = 'dot';
        dot.style.background = (allHabits[i] && allHabits[i].color) ? allHabits[i].color : '#10b981';
        el.appendChild(dot);
      }
      if (count > 3) {
        const m = document.createElement('span');
        m.className = 'dot-more';
        m.textContent = `+${count - 3}`;
        el.appendChild(m);
      }
    });
  }

  /* ── Open day panel ──────────────────────────────────────────────── */
  async function openPanel(dateStr) {
    selectedDate = dateStr;

    document.querySelectorAll('.cal-day.selected').forEach(el => el.classList.remove('selected'));
    const cell = document.querySelector(`.cal-day[data-date="${dateStr}"]`);
    if (cell) cell.classList.add('selected');

    const d = new Date(dateStr + 'T00:00:00');
    document.getElementById('panelDateBig').textContent =
      `${DAY_NAMES[d.getDay()]}, ${MONTH_NAMES[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
    document.getElementById('panelDateSub').textContent = dateStr === TODAY ? '📍 Today' : '';

    document.getElementById('dayPanelOverlay').classList.add('active');
    document.getElementById('dayPanel').classList.add('open');
    document.body.style.overflow = 'hidden';
    panelOpen = true;

    await refreshPanelBody(dateStr);
  }

  function closePanel() {
    document.getElementById('dayPanelOverlay').classList.remove('active');
    document.getElementById('dayPanel').classList.remove('open');
    document.body.style.overflow = '';
    panelOpen = false;
  }

  /* ── Refresh panel body ──────────────────────────────────────────── */
  async function refreshPanelBody(dateStr) {
    const body = document.getElementById('panelBody');
    body.innerHTML = '<div class="panel-loader"><div class="spinner"></div></div>';
    try {
      const res = await fetch(`${API}/for-date?date=${dateStr}`);
      const data = await res.json();
      renderPanelHabits(data.habits || [], dateStr);
    } catch (e) {
      body.innerHTML = '<p style="color:#e53e3e;padding:20px;font-size:.85rem;">Failed to load habits.</p>';
    }
  }

  function renderPanelHabits(habits, dateStr) {
    const body = document.getElementById('panelBody');
    body.innerHTML = '';

    if (!habits.length) {
      body.innerHTML = `
      <div class="empty-day">
        <div class="empty-icon">📭</div>
        <p>No habits scheduled for this day.<br>Tap the button below to add one!</p>
      </div>`;
      return;
    }

    const completed = habits.filter(h => h.completed_on_date == 1);
    const pending = habits.filter(h => h.completed_on_date != 1);

    if (pending.length) {
      body.appendChild(makeSection('Pending', pending, dateStr));
    }
    if (completed.length) {
      if (pending.length) {
        const sep = document.createElement('div');
        sep.style.marginTop = '18px';
        body.appendChild(sep);
      }
      body.appendChild(makeSection('Completed ✓', completed, dateStr));
    }
  }

  function makeSection(label, habits, dateStr) {
    const wrap = document.createElement('div');
    const title = document.createElement('p');
    title.className = 'panel-section-title';
    title.textContent = label;
    wrap.appendChild(title);
    habits.forEach(h => wrap.appendChild(makeHabitRow(h, dateStr)));
    return wrap;
  }

  function makeHabitRow(habit, dateStr) {
    const isDone = habit.completed_on_date == 1;
    const row = document.createElement('div');
    row.className = 'habit-row' + (isDone ? ' completed-row' : '');

    const topRow = document.createElement('div');
    topRow.className = 'habit-row-top';

    const badge = document.createElement('div');
    badge.className = 'habit-icon-badge';
    badge.style.background = (habit.color ? habit.color + '22' : '#10b98122');
    badge.innerHTML = `<span>${habit.icon || '🎯'}</span>`;

    const info = document.createElement('div');
    info.className = 'habit-row-info';
    const name = document.createElement('div');
    name.className = 'habit-row-name';
    name.textContent = habit.name || '';
    const sub = document.createElement('div');
    sub.className = 'habit-row-sub';
    sub.innerHTML = `${escHtml(habit.category)} <span class="freq-badge freq-${habit.frequency || 'daily'}">${habit.frequency || ''}</span>`;
    info.appendChild(name);
    info.appendChild(sub);

    const toggle = document.createElement('div');
    toggle.className = 'habit-toggle' + (isDone ? ' checked' : '');
    toggle.title = isDone ? 'Mark incomplete' : 'Mark complete';
    toggle.textContent = isDone ? '✓' : '';
    toggle.addEventListener('click', () => toggleHabit(habit.id, isDone ? 1 : 0, dateStr, toggle));

    const actions = document.createElement('div');
    actions.className = 'habit-action-group';

    const viewBtn = document.createElement('button');
    viewBtn.type = 'button';
    viewBtn.className = 'habit-action-btn';
    viewBtn.textContent = 'View more';
    viewBtn.addEventListener('click', () => toggleHabitDetails(row, habit, dateStr));

    const editBtn = document.createElement('button');
    editBtn.type = 'button';
    editBtn.className = 'habit-action-btn update-btn';
    editBtn.textContent = 'Update';
    editBtn.addEventListener('click', () => openEditHabit(habit));

    const deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.className = 'habit-action-btn delete-btn';
    deleteBtn.textContent = 'Delete';
    deleteBtn.addEventListener('click', () => deleteHabit(habit));

    actions.appendChild(viewBtn);
    actions.appendChild(editBtn);
    actions.appendChild(deleteBtn);

    topRow.appendChild(badge);
    topRow.appendChild(info);
    topRow.appendChild(toggle);

    row.appendChild(topRow);
    row.appendChild(actions);
    return row;
  }

  function toggleHabitDetails(row, habit, dateStr) {
    const existing = row.nextElementSibling;
    if (existing && existing.classList.contains('habit-detail-card')) {
      existing.remove();
      return;
    }
    document.querySelectorAll('.habit-detail-card').forEach(el => el.remove());

    const detailCard = document.createElement('div');
    detailCard.className = 'habit-detail-card';

    const scheduleText = getHabitScheduleSummary(habit);
    const completedText = habit.completed_on_date == 1 ? 'Yes' : 'No';
    const notes = habit.completion_notes ? habit.completion_notes : 'No notes';
    const mood = habit.mood_rating ? habit.mood_rating : 'None';

    const fields = [
      ['Description', habit.description || 'No description'],
      ['Scheduled', scheduleText],
      ['Start Date', habit.start_date || '—'],
      ['End Date', habit.end_date || '—'],
      ['Completed', completedText],
      ['Notes', notes],
      ['Mood rating', mood]
    ];

    fields.forEach(([label, value]) => {
      const rowEl = document.createElement('div');
      rowEl.className = 'habit-detail-row';
      rowEl.innerHTML = `
      <div class="habit-detail-title">${label}</div>
      <div class="habit-detail-value">${escHtml(value)}</div>`;
      detailCard.appendChild(rowEl);
    });

    const actionRow = document.createElement('div');
    actionRow.style.display = 'flex';
    actionRow.style.justifyContent = 'flex-end';

    const editBtn = document.createElement('button');
    editBtn.type = 'button';
    editBtn.className = 'habit-action-btn update-btn';
    editBtn.textContent = 'Update';
    editBtn.addEventListener('click', () => openEditHabit(habit));

    actionRow.appendChild(editBtn);

    const deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.className = 'habit-action-btn delete-btn';
    deleteBtn.textContent = 'Delete';
    deleteBtn.addEventListener('click', () => deleteHabit(habit));
    actionRow.appendChild(deleteBtn);

    detailCard.appendChild(actionRow);
    row.insertAdjacentElement('afterend', detailCard);
  }

  async function deleteHabit(habit) {
    try {
      const res = await fetch(`${API}/delete`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: habit.id })
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Failed to delete habit');

      showToast('Habit deleted.', 'success');
      await loadHabits();
      await loadCalendarData();
      await loadStats();
      if (panelOpen && selectedDate) {
        await refreshPanelBody(selectedDate);
      }
    } catch (err) {
      showToast('Error: ' + err.message, 'error');
    }
  }

  function getHabitScheduleSummary(habit) {
    const freq = habit.frequency || 'daily';
    if (freq === 'today') {
      return `Only on ${formatDisplayDate(habit.start_date || TODAY)}`;
    }
    if (freq === 'daily') {
      return `Every day${habit.start_date ? ' from ' + habit.start_date : ''}`;
    }
    if (freq === 'weekly') {
      const days = (habit.days_of_week || '')
        .split(',')
        .map(d => DAY_NAMES[parseInt(d, 10)]?.slice(0, 3) || '')
        .filter(Boolean)
        .join(', ');
      return `Weekly on ${days || 'selected days'}`;
    }
    if (freq === 'custom') {
      return `Every ${habit.repeat_interval || 1} day(s)${habit.start_date ? ' from ' + habit.start_date : ''}`;
    }
    return freq;
  }

  function openEditHabit(habit) {
    openAddHabitModal(habit);
  }

  /* ── Toggle habit completion ─────────────────────────────────────── */
  async function toggleHabit(habitId, currentlyDone, dateStr, toggleEl) {
    if (dateStr !== TODAY) {
      showToast('you only can select complete as today habits', 'error');
      return;
    }

    toggleEl.style.opacity = '.4';
    toggleEl.style.pointerEvents = 'none';

    const endpoint = currentlyDone ? 'unlog-date' : 'log-date';
    try {
      const res = await fetch(`${API}/${endpoint}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ habit_id: habitId, date: dateStr })
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Request failed');

      showToast(currentlyDone ? 'Unmarked ✓' : 'Marked complete! 🎉', 'success');
      await refreshPanelBody(dateStr);
      await loadCalendarData();
      await loadStats();
    } catch (err) {
      showToast('Error: ' + err.message, 'error');
      toggleEl.style.opacity = '1';
      toggleEl.style.pointerEvents = 'auto';
    }
  }

  /* ── Frequency selector ──────────────────────────────────────────── */
  function selectFreq(freq, btn) {
    document.getElementById('habitFrequency').value = freq;

    document.querySelectorAll('.freq-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    ['Today', 'Daily', 'Weekly', 'Custom'].forEach(f =>
      document.getElementById(`freqSub${f}`).style.display = 'none'
    );
    document.getElementById(`freqSub${freq.charAt(0).toUpperCase() + freq.slice(1)}`).style.display = 'block';
  }

  function toggleDay(el) {
    el.classList.toggle('active');
  }

  /* ── Add Habit Modal ─────────────────────────────────────────────── */
  function resetHabitForm() {
    document.getElementById('addHabitForm').reset();
    document.getElementById('habitColor').value = '#10b981';
    document.getElementById('habitIcon').value = '🎯';
    document.getElementById('habitIdInput').value = '';
    document.querySelectorAll('.weekday-pill').forEach(p => p.classList.remove('active'));
    document.getElementById('repeatInterval').value = 2;
    selectFreq('today', document.getElementById('ftToday'));
  }

  function openAddHabitModal(habit = null) {
    resetHabitForm();
    const base = selectedDate || TODAY;

    document.getElementById('todayDateDisplay').textContent = formatDisplayDate(base);
    document.getElementById('dailyStart').value = base;
    document.getElementById('weeklyStart').value = base;
    document.getElementById('customStart').value = base;

    if (habit) {
      document.getElementById('habitIdInput').value = habit.id;
      document.getElementById('habitName').value = habit.name || '';
      document.getElementById('habitCategory').value = habit.category || 'other';
      document.getElementById('habitDesc').value = habit.description || '';
      document.getElementById('habitColor').value = habit.color || '#10b981';
      document.getElementById('habitIcon').value = habit.icon || '🎯';

      const freq = habit.frequency || 'today';
      const tab = document.getElementById(`ft${freq.charAt(0).toUpperCase() + freq.slice(1)}`) || document.getElementById('ftToday');
      selectFreq(freq, tab);
      document.getElementById('habitFrequency').value = freq;

      document.getElementById('dailyStart').value = habit.start_date || base;
      document.getElementById('dailyEnd').value = habit.end_date || '';
      document.getElementById('weeklyStart').value = habit.start_date || base;
      document.getElementById('weeklyEnd').value = habit.end_date || '';
      document.querySelectorAll('#weekdayPills .weekday-pill').forEach(p => {
        p.classList.toggle('active', (habit.days_of_week || '').split(',').includes(p.dataset.day));
      });
      document.getElementById('customStart').value = habit.start_date || base;
      document.getElementById('customEnd').value = habit.end_date || '';
      document.getElementById('repeatInterval').value = habit.repeat_interval || 2;
      document.getElementById('todayDateDisplay').textContent = formatDisplayDate(habit.start_date || base);
      document.getElementById('submitHabitBtn').textContent = 'Update Habit';
    } else {
      document.getElementById('habitIdInput').value = '';
      document.getElementById('submitHabitBtn').textContent = 'Save Habit';
      if (selectedDate) {
        selectFreq('today', document.getElementById('ftToday'));
      }
    }

    document.getElementById('addHabitModal').classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeAddHabitModal() {
    document.getElementById('addHabitModal').classList.remove('active');
    resetHabitForm();
    if (!panelOpen) document.body.style.overflow = '';
  }

  async function handleCreateHabit(e) {
    e.preventDefault();
    const btn = document.getElementById('submitHabitBtn');
    btn.textContent = 'Saving…';
    btn.disabled = true;

    const habitId = document.getElementById('habitIdInput').value;
    const isEdit = Boolean(habitId);
    const freq = document.getElementById('habitFrequency').value;
    let start_date, end_date = null, days_of_week = null, repeat_interval = 1;

    if (freq === 'today') {
      start_date = selectedDate || TODAY;
      end_date = start_date;

    } else if (freq === 'daily') {
      start_date = document.getElementById('dailyStart').value;
      end_date = document.getElementById('dailyEnd').value || null;
      if (!start_date) { showToast('Please select a start date', 'error'); btn.textContent = isEdit ? 'Update Habit' : 'Save Habit'; btn.disabled = false; return; }

    } else if (freq === 'weekly') {
      start_date = document.getElementById('weeklyStart').value;
      end_date = document.getElementById('weeklyEnd').value || null;
      const activePills = [...document.querySelectorAll('#weekdayPills .weekday-pill.active')];
      if (!activePills.length) { showToast('Select at least one day of the week', 'error'); btn.textContent = isEdit ? 'Update Habit' : 'Save Habit'; btn.disabled = false; return; }
      days_of_week = activePills.map(p => p.dataset.day).join(',');
      if (!start_date) { showToast('Please select a start date', 'error'); btn.textContent = isEdit ? 'Update Habit' : 'Save Habit'; btn.disabled = false; return; }

    } else if (freq === 'custom') {
      start_date = document.getElementById('customStart').value;
      end_date = document.getElementById('customEnd').value || null;
      repeat_interval = parseInt(document.getElementById('repeatInterval').value) || 2;
      if (!start_date) { showToast('Please select a start date', 'error'); btn.textContent = isEdit ? 'Update Habit' : 'Save Habit'; btn.disabled = false; return; }
    }

    const payload = {
      id: isEdit ? parseInt(habitId, 10) : undefined,
      name: document.getElementById('habitName').value.trim(),
      category: document.getElementById('habitCategory').value,
      description: document.getElementById('habitDesc').value,
      frequency: freq,
      start_date,
      end_date,
      days_of_week,
      repeat_interval,
      color: document.getElementById('habitColor').value,
      icon: document.getElementById('habitIcon').value
    };

    try {
      const res = await fetch(`${API}/${isEdit ? 'update' : 'create'}`, {
        method: isEdit ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Unknown error');

      if (!isEdit && freq === 'today' && data.id && start_date) {
        await fetch(`${API}/log-date`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ habit_id: data.id, date: start_date })
        });
      }

      showToast(isEdit ? 'Habit updated! ✨' : 'Habit created! 🌱', 'success');
      closeAddHabitModal();
      await loadHabits();
      await loadCalendarData();
      await loadStats();

      if (panelOpen && selectedDate) {
        await refreshPanelBody(selectedDate);
      }
    } catch (err) {
      showToast('Error: ' + err.message, 'error');
    } finally {
      btn.textContent = isEdit ? 'Update Habit' : 'Save Habit';
      btn.disabled = false;
    }
  }

  /* ── Helpers ─────────────────────────────────────────────────────── */
  function formatDisplayDate(dateStr) {
    if (!dateStr) return '—';
    const d = new Date(dateStr + 'T00:00:00');
    return `${MONTH_NAMES[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
  }

  let toastTimer;
  function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3200);
  }

  function escHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>