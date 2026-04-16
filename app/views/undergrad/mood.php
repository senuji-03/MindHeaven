<?php
$TITLE = 'MindHeaven — Mood Tracker';
$CURRENT_PAGE = 'mood';
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

/* ── Base ─────────────────────────────────── */
.mp {
  font-family: inherit;
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
  padding: 20px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: var(--shadow-lg);
  margin-bottom: 16px;
  position: relative;
  overflow: hidden;
}
.mp-header::after {
  content: '';
  position: absolute;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: rgba(232,168,124,0.1);
  bottom: -30px;
  left: 20%;
}
.mp-header__inner {
  width: 100%;
  margin: 0;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  z-index: 1;
  position: relative;
}
.mp-header__eyebrow {
  display: none;
}
.mp-header__title {
  color: #fff;
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0 0 6px;
  letter-spacing: -0.5px;
}
.mp-header__sub {
  color: rgba(255,255,255,.85);
  font-size: .92rem;
  margin: 0;
}

/* ── Stats row ───────────────────────────── */
.mp-body {
  width: 100%;
  margin: 0;
  padding: 0;
}
.mp-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 16px;
}
.mp-stat {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 16px 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  box-shadow: var(--shadow-sm);
  transition: all 0.3s ease;
}
.mp-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--primary-light); }
.mp-stat__label {
  font-size: .78rem;
  color: var(--text-secondary);
  font-weight: 500;
  text-transform: none;
  letter-spacing: normal;
  margin-bottom: 8px;
}
.mp-stat__val {
  font-size: 1.6rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1;
  font-family: 'DM Sans', system-ui, sans-serif;
}
.mp-stat__dot {
  display: inline-block;
  width: 8px; height: 8px;
  border-radius: 50%;
  background: var(--primary);
  margin-right: 6px;
  vertical-align: middle;
}
.mp-stat__dot--warm { background: var(--accent-warm); }
.mp-stat__dot--sky  { background: var(--accent-calm); }
.mp-stat__dot--mint { background: var(--success); }

/* ── Section card ────────────────────────── */
.mc {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  margin-bottom: 20px;
}
.mc__hd {
  padding: 20px 24px 16px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.mc__title {
  font-size: .93rem;
  font-weight: 700;
  color: var(--text-primary);
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
}
.mc__title i { color: var(--primary); font-size: .85rem; }
.mc__sub { font-size: .78rem; color: var(--text-secondary); margin: 2px 0 0; }
.mc__bd { padding: 20px 24px; }

/* ── Log form ────────────────────────────── */
.log-form {
  display: none;
  animation: slideDown .22s ease;
}
.log-form.open { display: block; }
@keyframes slideDown {
  from { opacity:0; transform:translateY(-8px); }
  to   { opacity:1; transform:translateY(0); }
}

/* Mood picker */
.mood-grid {
  display: grid;
  grid-template-columns: repeat(11,1fr);
  gap: 6px;
}
.m-pill {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
  padding: 10px 4px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius-md);
  background: var(--surface);
  cursor: pointer;
  transition: all .18s ease;
  font-family: inherit;
}
.m-pill:hover {
  border-color: var(--primary-light);
  background: var(--bg-mid);
  transform: translateY(-2px);
}
.m-pill.sel {
  border-color: var(--primary);
  background: var(--bg-mid);
  box-shadow: 0 0 0 3px rgba(61,139,110,.10);
}
.m-pill__em { font-size: 1.5rem; line-height: 1; }
.m-pill__lbl { font-size: .64rem; font-weight: 600; color: var(--text-secondary); }
.m-pill.sel .m-pill__lbl { color: var(--primary); }

/* Detail area */
.log-detail {
  margin-top: 18px;
  padding-top: 18px;
  border-top: 1px solid var(--border);
  display: none;
}
.log-detail.vis { display: block; }

.fg { display: flex; flex-direction: column; }
.fg-grid { display: grid; grid-template-columns:1fr 1fr; gap: 14px; }
.fg-full { grid-column: 1/-1; }
.flabel {
  font-size: .78rem;
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 5px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.flabel i { color: var(--primary); font-size: .72rem; }
.finput {
  width: 100%;
  padding: 10px 12px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  font-family: inherit;
  font-size: .875rem;
  color: var(--text-primary);
  background: var(--surface);
  transition: border-color .2s, box-shadow .2s;
  box-sizing: border-box;
  appearance: none;
  -webkit-appearance: none;
}
.finput:focus { outline:none; border-color:var(--primary); box-shadow:0 0 0 3px rgba(61,139,110,.10); }
.finput::placeholder { color: var(--text-secondary); opacity:.65; }
textarea.finput { resize: vertical; min-height: 72px; }

/* Slider */
.sl-row { display: flex; align-items: center; gap: 10px; }
.sl-row input[type=range] {
  flex:1; -webkit-appearance:none; height:5px;
  border-radius: var(--radius-full);
  background: linear-gradient(to right, var(--primary) 0%, var(--border) 0%);
  cursor: pointer;
}
.sl-row input[type=range]::-webkit-slider-thumb {
  -webkit-appearance:none; width:16px; height:16px;
  border-radius:50%; background:var(--primary);
  border:2px solid #fff; box-shadow:var(--shadow-sm); cursor:pointer;
}
.sl-val {
  min-width:28px; height:28px; border-radius:var(--radius-full);
  background:var(--primary); color:#fff;
  display:flex; align-items:center; justify-content:center;
  font-size:.78rem; font-weight:700; flex-shrink:0;
}
.sl-ticks { display:flex; justify-content:space-between; font-size:.67rem; color:var(--text-secondary); margin-top:3px; }

/* Tag pills */
.tags { display:flex; flex-wrap:wrap; gap:6px; }
.tag {
  padding: 4px 11px;
  border-radius: var(--radius-full);
  border: 1.5px solid var(--border);
  background: var(--surface);
  font-size: .72rem;
  font-weight: 600;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all .15s;
  font-family: inherit;
}
.tag:hover { border-color:var(--primary-light); color:var(--primary); }
.tag.on { background:var(--primary); color:#fff; border-color:var(--primary); }

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 9px 20px;
  border-radius: var(--radius-full);
  font-family: inherit;
  font-size: .85rem;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: all .22s ease;
  white-space: nowrap;
}
.btn--primary { background:var(--primary); color:#fff; box-shadow:0 2px 8px rgba(61,139,110,.20); }
.btn--primary:hover { background:var(--primary-dark); transform:translateY(-1px); box-shadow:0 5px 16px rgba(61,139,110,.30); }
.btn--outline { background:transparent; color:var(--primary); border:1.5px solid var(--border); }
.btn--outline:hover { border-color:var(--primary-light); background:var(--bg-mid); }
.btn--ghost { background:transparent; color:var(--text-secondary); border:1.5px solid var(--border); }
.btn--ghost:hover { border-color:var(--border); background:var(--bg-mid); color:var(--text-primary); }
.btn--danger { background:transparent; color:var(--crisis); border:1.5px solid var(--border); }
.btn--danger:hover { background:#FEF2F2; border-color:#FECACA; }
.btn--sm { padding:6px 14px; font-size:.78rem; }
.btn:disabled { opacity:.55; cursor:not-allowed; transform:none !important; }

/* Log actions */
.log-actions { display:flex; gap:8px; margin-top:18px; }

/* ── Two-col viz ─────────────────────────── */
.viz-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

/* Calendar */
.cal-nav { display:flex; align-items:center; gap:10px; }
.cal-btn {
  width:28px; height:28px; border-radius:50%;
  border:1.5px solid var(--border); background:var(--surface);
  color:var(--text-secondary); cursor:pointer; font-size:.9rem;
  display:flex; align-items:center; justify-content:center;
  transition: all .15s;
}
.cal-btn:hover { background:var(--bg-mid); border-color:var(--primary); color:var(--primary); }
.cal-month { font-size:.85rem; font-weight:700; color:var(--text-primary); }
.cal-wdays { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; margin-bottom:3px; }
.cal-wd { text-align:center; font-size:.6rem; font-weight:700; text-transform:uppercase; letter-spacing:.7px; color:var(--text-secondary); padding:3px 0; }
.cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:3px; }
.cal-cell {
  aspect-ratio:1;
  border-radius: 6px;
  background: var(--bg-mid);
  border: 1.5px solid transparent;
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:1px; cursor:default;
  transition: border-color .15s;
  min-height:36px;
}
.cal-cell.has-mood { cursor:pointer; }
.cal-cell.has-mood:hover { border-color:var(--primary-light); }
.cal-cell--today { border-color:var(--primary) !important; }
.cal-cell.other-m { opacity:.3; }
.cal-dn { font-size:.58rem; font-weight:600; color:var(--text-secondary); }
.cal-em { font-size:.8rem; line-height:1; }

/* Chart */
.chart-wrap { position:relative; height:190px; }

/* Distribution bars */
.dist-bars { margin-top:16px; display:flex; flex-direction:column; gap:7px; }
.dist-item { display:flex; align-items:center; gap:8px; }
.dist-label { width:60px; font-size:.72rem; font-weight:600; color:var(--text-primary); flex-shrink:0; }
.dist-bar-bg { flex:1; background:var(--border); border-radius:var(--radius-full); height:5px; overflow:hidden; }
.dist-bar-fill { height:100%; background:var(--primary); border-radius:var(--radius-full); transition:width .5s ease; }
.dist-pct { font-size:.67rem; color:var(--text-secondary); min-width:26px; text-align:right; }

/* ── Mood history list ────────────────────── */
.mh-list { display:flex; flex-direction:column; gap:0; }
.mh-row {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 24px;
  border-bottom: 1px solid rgba(214,228,221,.5);
  transition: background .15s;
}
.mh-row:last-child { border-bottom: none; }
.mh-row:hover { background: #FAFCFB; }

.mh-emoji {
  font-size: 1.6rem;
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-mid);
  border-radius: var(--radius-md);
}
.mh-info { flex: 1; min-width: 0; }
.mh-mood-name {
  font-size: .88rem;
  font-weight: 700;
  color: var(--text-primary);
  text-transform: capitalize;
}
.mh-meta {
  font-size: .75rem;
  color: var(--text-secondary);
  margin-top: 2px;
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.mh-meta-sep { opacity:.4; }
.mh-notes-text {
  font-size: .78rem;
  color: var(--text-secondary);
  margin-top: 3px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 320px;
}
.mh-tags { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
.mh-chip {
  font-size: .65rem;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: var(--radius-full);
  background: var(--bg-mid);
  color: var(--text-secondary);
}

/* Intensity mini */
.mh-intensity {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  flex-shrink: 0;
}
.mh-int-segs {
  display: flex;
  gap: 2px;
}
.mh-seg {
  width: 5px;
  height: 14px;
  border-radius: 2px;
  background: var(--border);
}
.mh-int-num {
  font-size: .65rem;
  font-weight: 700;
  color: var(--text-secondary);
}

.mh-date {
  font-size: .72rem;
  color: var(--text-secondary);
  flex-shrink: 0;
  white-space: nowrap;
  text-align: right;
  min-width: 70px;
}
.mh-actions { display:flex; gap:5px; flex-shrink:0; }
.act-btn {
  width:28px; height:28px;
  display:flex; align-items:center; justify-content:center;
  border-radius: var(--radius-sm);
  border: 1.5px solid var(--border);
  background: transparent;
  color: var(--text-secondary);
  cursor: pointer;
  transition: all .18s;
  font-size: .75rem;
}
.act-btn:hover { background:var(--bg-mid); color:var(--primary); border-color:var(--primary-light); }
.act-btn--del:hover { background:#FEF2F2; color:var(--crisis); border-color:#FECACA; }

/* Empty state */
.empty {
  text-align: center;
  padding: 52px 28px;
}
.empty__em { font-size: 2.4rem; margin-bottom: 12px; }
.empty__t { font-size:.95rem; font-weight:700; color:var(--text-primary); margin:0 0 6px; }
.empty__s { font-size:.85rem; color:var(--text-secondary); }

/* Spinner */
.spin {
  display:inline-block; width:15px; height:15px;
  border:2px solid var(--border); border-top-color:var(--primary);
  border-radius:50%; animation:rot .6s linear infinite; vertical-align:middle;
}
@keyframes rot { to { transform:rotate(360deg); } }

/* ── Edit modal ──────────────────────────── */
.mo-overlay {
  position:fixed; inset:0;
  background:rgba(28,43,42,.45);
  backdrop-filter:blur(8px);
  z-index:9000;
  display:none; align-items:center; justify-content:center;
  padding:20px;
}
.mo-overlay.open { display:flex; }
.mo-box {
  background:var(--surface);
  border-radius:var(--radius-xl);
  box-shadow:var(--shadow-xl);
  width:100%; max-width:520px;
  max-height:90vh; overflow-y:auto;
  border:1px solid var(--border);
  animation:moPop .2s cubic-bezier(.34,1.56,.64,1);
}
@keyframes moPop { from{opacity:0;transform:scale(.95) translateY(8px);} to{opacity:1;transform:scale(1) translateY(0);} }
.mo-hd {
  display:flex; align-items:center; justify-content:space-between;
  padding:20px 24px 16px;
  border-bottom:1px solid var(--border);
}
.mo-title { font-size:.95rem; font-weight:700; color:var(--text-primary); margin:0; display:flex; align-items:center; gap:8px; }
.mo-title i { color:var(--primary); }
.mo-close {
  width:28px; height:28px; border-radius:var(--radius-sm);
  border:1.5px solid var(--border); background:transparent;
  color:var(--text-secondary); cursor:pointer; font-size:.8rem;
  display:flex; align-items:center; justify-content:center; transition:all .18s;
}
.mo-close:hover { background:#FEF2F2; border-color:#FECACA; color:var(--crisis); }
.mo-bd { padding:20px 24px; }
.mo-ft { display:flex; gap:8px; margin-top:18px; padding-top:16px; border-top:1px solid var(--border); justify-content:flex-end; }

/* ── Toast ───────────────────────────────── */
.toast-wrap {
  position:fixed; bottom:24px; right:24px; z-index:99999;
  display:flex; flex-direction:column; gap:7px; pointer-events:none;
}
.toast {
  display:flex; align-items:center; gap:9px;
  padding:11px 16px; border-radius:var(--radius-md);
  font-size:.82rem; font-weight:600; color:#fff;
  box-shadow:var(--shadow-lg);
  animation:tIn .28s cubic-bezier(.34,1.56,.64,1);
  max-width:300px; pointer-events:auto;
}
.toast--success { background:var(--success); }
.toast--error   { background:var(--crisis); }
.toast--info    { background:var(--primary); }
@keyframes tIn { from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:translateY(0);} }

/* ── Log-btn in header ───────────────────── */
.btn-log {
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
  z-index: 1;
  position: relative;
}
.btn-log:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,0,0,.2); }
.btn-log.active { background: #f0f0f0; box-shadow: none; }

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .mp-stats { grid-template-columns:repeat(2,1fr); }
  .viz-grid  { grid-template-columns:1fr; }
  .mood-grid { grid-template-columns:repeat(6,1fr); }
  .fg-grid   { grid-template-columns:1fr; }
}
@media (max-width: 640px) {
  .mp-header__inner { flex-direction:column; align-items:flex-start; gap:14px; }
  .mp-header__title { font-size:1.45rem; }
  .mp-body { padding:20px 16px 0; }
  .mc__bd { padding:16px; }
  .mc__hd { padding:14px 16px 12px; }
  .mh-row { padding:12px 16px; }
  .mood-grid { grid-template-columns:repeat(4,1fr); gap:5px; }
  .mp-stats { grid-template-columns:1fr 1fr; }
}
</style>

<?php
$today = date('Y-m-d');
$year  = (int)date('Y');
$month = (int)date('n');
$moods = [
  ['happy','😊','Happy'], ['calm','😌','Calm'], ['excited','🤩','Excited'],
  ['grateful','🙏','Grateful'], ['neutral','😐','Neutral'], ['tired','😴','Tired'],
  ['anxious','😰','Anxious'], ['sad','😢','Sad'],
  ['angry','😡','Angry'], ['stressed','😤','Stressed'], ['confused','😕','Confused'],
];
$tags = ['Work','School','Relationships','Health','Sleep','Exercise','Weather','Social','Finance','Family'];
?>

<div class="mp">

  <!-- ── Page header ── -->
  <div class="mp-header">
    <div class="mp-header__inner">
      <div>
        <span class="mp-header__eyebrow">Wellness Tracker</span>
        <h1 class="mp-header__title">Mood Journal</h1>
        <p class="mp-header__sub">Track your emotions and discover patterns over time.</p>
      </div>
      <button class="btn-log" id="logToggleBtn">
        <i class="fas fa-plus"></i> Log Mood
      </button>
    </div>
  </div>

  <div class="mp-body">

    <!-- ── Stats ── -->
    <div class="mp-stats">
      <div class="mp-stat">
        <div class="mp-stat__label"><span class="mp-stat__dot"></span>Total Entries</div>
        <div class="mp-stat__val" id="statTotal">—</div>
      </div>
      <div class="mp-stat">
        <div class="mp-stat__label"><span class="mp-stat__dot mp-stat__dot--warm"></span>Current Streak</div>
        <div class="mp-stat__val" id="statStreak">—</div>
      </div>
      <div class="mp-stat">
        <div class="mp-stat__label"><span class="mp-stat__dot mp-stat__dot--sky"></span>Avg Intensity (7d)</div>
        <div class="mp-stat__val" id="statAvg">—</div>
      </div>
      <div class="mp-stat">
        <div class="mp-stat__label"><span class="mp-stat__dot mp-stat__dot--mint"></span>Top Mood (month)</div>
        <div class="mp-stat__val" id="statTop">—</div>
      </div>
    </div>

    <!-- ── Log form (toggle) ── -->
    <div class="mc" id="logCard">
      <div class="mc__hd">
        <div>
          <p class="mc__title"><i class="fas fa-pen-to-square"></i> Log Your Mood</p>
          <p class="mc__sub">How are you feeling right now?</p>
        </div>
        <button class="btn btn--ghost btn--sm" id="cancelLogBtn"><i class="fas fa-xmark"></i> Cancel</button>
      </div>
      <div class="mc__bd log-form open" id="logForm">

        <!-- Mood picker -->
        <div class="mood-grid" id="moodPicker">
          <?php foreach ($moods as [$val,$emoji,$label]): ?>
          <button type="button" class="m-pill" data-mood="<?= $val ?>">
            <span class="m-pill__em"><?= $emoji ?></span>
            <span class="m-pill__lbl"><?= $label ?></span>
          </button>
          <?php endforeach; ?>
        </div>

        <input type="hidden" id="selectedMood" value="">

        <!-- Detail (shown after picking mood) -->
        <div class="log-detail" id="logDetail">
          <div class="fg-grid">

            <!-- Intensity -->
            <div class="fg fg-full">
              <label class="flabel"><i class="fas fa-gauge-high"></i> Intensity</label>
              <div class="sl-row">
                <input type="range" id="moodIntensity" min="1" max="10" value="5"
                  oninput="updateSlider(this)">
                <div class="sl-val" id="intensityVal">5</div>
              </div>
              <div class="sl-ticks"><span>Mild (1)</span><span>Moderate (5)</span><span>Intense (10)</span></div>
            </div>

            <!-- Notes -->
            <div class="fg fg-full">
              <label class="flabel"><i class="fas fa-note-sticky"></i> Notes <span style="font-weight:400;color:var(--text-secondary)">(optional)</span></label>
              <textarea class="finput" id="moodNotes" rows="2" placeholder="What's contributing to how you feel?"></textarea>
            </div>

            <!-- Triggers -->
            <div class="fg fg-full">
              <label class="flabel"><i class="fas fa-tags"></i> Triggers</label>
              <div class="tags" id="triggerCloud">
                <?php foreach ($tags as $t): ?>
                <button type="button" class="tag" data-tag="<?= strtolower($t) ?>"><?= $t ?></button>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Sleep + Exercise -->
            <div class="fg">
              <label class="flabel"><i class="fas fa-moon"></i> Sleep Hours</label>
              <input type="number" class="finput" id="sleepHours" min="0" max="24" step=".5" placeholder="e.g. 7.5">
            </div>
            <div class="fg">
              <label class="flabel"><i class="fas fa-dumbbell"></i> Exercise (min)</label>
              <input type="number" class="finput" id="exerciseMin" min="0" max="300" placeholder="e.g. 30">
            </div>

            <!-- Social -->
            <div class="fg fg-full">
              <label class="flabel"><i class="fas fa-users"></i> Social Interaction</label>
              <select class="finput" id="socialInteraction">
                <option value="">— select —</option>
                <option value="none">None</option>
                <option value="minimal">Minimal</option>
                <option value="moderate">Moderate</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <div class="log-actions">
            <button class="btn btn--primary" id="saveMoodBtn" onclick="saveMood()">
              <i class="fas fa-check"></i> Save Entry
            </button>
            <button class="btn btn--ghost" onclick="resetLog()">
              <i class="fas fa-rotate-left"></i> Reset
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Visualizations ── -->
    <div class="viz-grid">

      <!-- Calendar heatmap -->
      <div class="mc">
        <div class="mc__hd">
          <div>
            <p class="mc__title"><i class="fas fa-calendar-days"></i> Mood Calendar</p>
            <p class="mc__sub">Your pattern this month</p>
          </div>
          <div class="cal-nav">
            <button class="cal-btn" id="prevMonthBtn">&#8249;</button>
            <span class="cal-month" id="calMonthLabel"></span>
            <button class="cal-btn" id="nextMonthBtn">&#8250;</button>
          </div>
        </div>
        <div class="mc__bd">
          <div class="cal-wdays">
            <?php foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $d): ?>
            <div class="cal-wd"><?= $d ?></div>
            <?php endforeach; ?>
          </div>
          <div class="cal-grid" id="calGrid"></div>
        </div>
      </div>

      <!-- Trend chart -->
      <div class="mc">
        <div class="mc__hd">
          <div>
            <p class="mc__title"><i class="fas fa-chart-line"></i> Intensity Trend</p>
            <p class="mc__sub">Last 14 days</p>
          </div>
        </div>
        <div class="mc__bd">
          <div class="chart-wrap">
            <canvas id="moodChart"></canvas>
          </div>
          <div class="dist-bars" id="moodDistribution"></div>
        </div>
      </div>

    </div>

    <!-- ── Mood History ── -->
    <div class="mc">
      <div class="mc__hd">
        <div>
          <p class="mc__title"><i class="fas fa-clock-rotate-left"></i> Mood History</p>
          <p class="mc__sub">All your past entries</p>
        </div>
        <button class="btn btn--outline btn--sm" id="exportCsvBtn"><i class="fas fa-file-csv"></i> Export</button>
      </div>
      <div class="mh-list" id="historyList">
        <div style="text-align:center;padding:48px;color:var(--text-secondary);">
          <span class="spin"></span> Loading…
        </div>
      </div>
    </div>

  </div><!-- /mp-body -->
</div><!-- /mp -->

<!-- ═══ EDIT MODAL ═══ -->
<div class="mo-overlay" id="editModal">
  <div class="mo-box">
    <div class="mo-hd">
      <h3 class="mo-title"><i class="fas fa-pen"></i> Edit Entry</h3>
      <button class="mo-close" onclick="closeEdit()"><i class="fas fa-times"></i></button>
    </div>
    <div class="mo-bd">
      <input type="hidden" id="editId">

      <!-- Mood picker -->
      <div class="fg" style="margin-bottom:14px;">
        <label class="flabel"><i class="fas fa-face-smile"></i> Mood</label>
        <div class="mood-grid" id="editMoodPicker" style="margin-top:4px;">
          <?php foreach ($moods as [$val,$emoji,$label]): ?>
          <button type="button" class="m-pill" data-mood="<?= $val ?>" onclick="pickEditMood('<?= $val ?>',this)">
            <span class="m-pill__em"><?= $emoji ?></span>
            <span class="m-pill__lbl"><?= $label ?></span>
          </button>
          <?php endforeach; ?>
        </div>
        <input type="hidden" id="editMood">
      </div>

      <div class="fg-grid">
        <div class="fg fg-full">
          <label class="flabel"><i class="fas fa-gauge-high"></i> Intensity</label>
          <div class="sl-row">
            <input type="range" id="editIntensity" min="1" max="10" value="5"
              oninput="updateSlider(this,'editIntensityVal')">
            <div class="sl-val" id="editIntensityVal">5</div>
          </div>
        </div>
        <div class="fg fg-full">
          <label class="flabel"><i class="fas fa-note-sticky"></i> Notes</label>
          <textarea class="finput" id="editNotes" rows="2"></textarea>
        </div>
        <div class="fg fg-full">
          <label class="flabel"><i class="fas fa-tags"></i> Triggers</label>
          <div class="tags" id="editTriggerCloud">
            <?php foreach ($tags as $t): ?>
            <button type="button" class="tag" data-tag="<?= strtolower($t) ?>"
              onclick="this.classList.toggle('on')"><?= $t ?></button>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="fg">
          <label class="flabel"><i class="fas fa-moon"></i> Sleep Hours</label>
          <input type="number" class="finput" id="editSleep" min="0" max="24" step=".5">
        </div>
        <div class="fg">
          <label class="flabel"><i class="fas fa-dumbbell"></i> Exercise (min)</label>
          <input type="number" class="finput" id="editExercise" min="0" max="300">
        </div>
        <div class="fg fg-full">
          <label class="flabel"><i class="fas fa-users"></i> Social Interaction</label>
          <select class="finput" id="editSocial">
            <option value="">— select —</option>
            <option value="none">None</option>
            <option value="minimal">Minimal</option>
            <option value="moderate">Moderate</option>
            <option value="high">High</option>
          </select>
        </div>
      </div>

      <div class="mo-ft">
        <button class="btn btn--ghost" onclick="closeEdit()"><i class="fas fa-xmark"></i> Cancel</button>
        <button class="btn btn--primary" onclick="updateMood()"><i class="fas fa-check"></i> Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast container -->
<div class="toast-wrap" id="toastWrap"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
// ─── Config ────────────────────────────────────────────────────────
const BASE  = '/MindHeaven/public/api/mood';
let records = [];

const MOOD_META = {
  happy:    { emoji:'😊' },
  calm:     { emoji:'😌' },
  excited:  { emoji:'🤩' },
  grateful: { emoji:'🙏' },
  neutral:  { emoji:'😐' },
  tired:    { emoji:'😴' },
  anxious:  { emoji:'😰' },
  sad:      { emoji:'😢' },
  angry:    { emoji:'😡' },
  stressed: { emoji:'😤' },
  confused: { emoji:'😕' },
};

let calYear  = <?= $year ?>;
let calMonth = <?= $month ?>;
let chart    = null;
let logOpen  = false;

// ─── Init ──────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  loadRecords();
  renderCalendar();
  hideLogPanel(); // start hidden

  document.getElementById('logToggleBtn').addEventListener('click', toggleLog);
  document.getElementById('cancelLogBtn').addEventListener('click', hideLogPanel);
  document.getElementById('prevMonthBtn').addEventListener('click', () => shiftCal(-1));
  document.getElementById('nextMonthBtn').addEventListener('click', () => shiftCal(1));
  document.getElementById('exportCsvBtn').addEventListener('click', exportCsv);

  // mood picker
  document.querySelectorAll('#moodPicker .m-pill').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('#moodPicker .m-pill').forEach(b => b.classList.remove('sel'));
      btn.classList.add('sel');
      document.getElementById('selectedMood').value = btn.dataset.mood;
      document.getElementById('logDetail').classList.add('vis');
    });
  });

  // tag pills
  document.querySelectorAll('#triggerCloud .tag').forEach(p => {
    p.addEventListener('click', () => p.classList.toggle('on'));
  });

  updateSlider(document.getElementById('moodIntensity'));

  // backdrop close
  document.getElementById('editModal').addEventListener('click', e => {
    if (e.target === document.getElementById('editModal')) closeEdit();
  });
});

// ─── Log panel ─────────────────────────────────────────────────────
function toggleLog() {
  logOpen ? hideLogPanel() : showLogPanel();
}
function showLogPanel() {
  logOpen = true;
  document.getElementById('logCard').style.display = '';
  const btn = document.getElementById('logToggleBtn');
  btn.innerHTML = '<i class="fas fa-xmark"></i> Close';
  btn.classList.add('active');
  resetLog();
}
function hideLogPanel() {
  logOpen = false;
  document.getElementById('logCard').style.display = 'none';
  const btn = document.getElementById('logToggleBtn');
  btn.innerHTML = '<i class="fas fa-plus"></i> Log Mood';
  btn.classList.remove('active');
}

function resetLog() {
  document.querySelectorAll('#moodPicker .m-pill').forEach(b => b.classList.remove('sel'));
  document.getElementById('selectedMood').value = '';
  document.getElementById('logDetail').classList.remove('vis');
  document.getElementById('moodNotes').value = '';
  document.getElementById('moodIntensity').value = 5;
  document.getElementById('intensityVal').textContent = 5;
  document.getElementById('sleepHours').value = '';
  document.getElementById('exerciseMin').value = '';
  document.getElementById('socialInteraction').value = '';
  document.querySelectorAll('#triggerCloud .tag').forEach(p => p.classList.remove('on'));
  updateSlider(document.getElementById('moodIntensity'));
}

// ─── Slider ────────────────────────────────────────────────────────
function updateSlider(el, valId = 'intensityVal') {
  const pct = ((el.value - el.min) / (el.max - el.min)) * 100;
  el.style.background = `linear-gradient(to right, var(--primary) ${pct}%, var(--border) ${pct}%)`;
  const v = document.getElementById(valId);
  if (v) v.textContent = el.value;
}

// ─── Load records ──────────────────────────────────────────────────
async function loadRecords() {
  try {
    const res  = await fetch(BASE + '/list', { credentials: 'same-origin' });
    const data = await res.json();
    records = data.records || [];
    renderHistory();
    renderStats();
    renderCalendar();
    renderChart();
    updateSlider(document.getElementById('moodIntensity'));
  } catch(e) {
    document.getElementById('historyList').innerHTML =
      '<div style="text-align:center;padding:40px;color:var(--crisis);">Failed to load records.</div>';
  }
}

// ─── Save ──────────────────────────────────────────────────────────
async function saveMood() {
  const mood = document.getElementById('selectedMood').value;
  if (!mood) { toast('Please select a mood first.', 'info'); return; }

  const triggers = [...document.querySelectorAll('#triggerCloud .tag.on')]
    .map(p => p.dataset.tag).join(',');

  const payload = {
    mood_type:          mood,
    mood_level:         parseInt(document.getElementById('moodIntensity').value),
    notes:              document.getElementById('moodNotes').value.trim() || null,
    triggers:           triggers || null,
    sleep_hours:        document.getElementById('sleepHours').value || null,
    exercise_minutes:   document.getElementById('exerciseMin').value  || null,
    social_interaction: document.getElementById('socialInteraction').value || null,
  };

  const btn = document.getElementById('saveMoodBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spin"></span> Saving…';

  try {
    const res  = await fetch(BASE + '/create', {
      method: 'POST', credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.error || 'Server error');
    toast('Mood logged! 🌿', 'success');
    hideLogPanel();
    loadRecords();
  } catch(e) {
    toast(e.message, 'error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-check"></i> Save Entry';
  }
}

// ─── Delete ────────────────────────────────────────────────────────
async function deleteMood(id) {
  if (!confirm('Delete this mood entry?')) return;
  try {
    const res  = await fetch(BASE + '/delete', {
      method: 'DELETE', credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.error || 'Error');
    toast('Entry deleted.', 'info');
    loadRecords();
  } catch(e) { toast(e.message, 'error'); }
}

// ─── Edit ──────────────────────────────────────────────────────────
function openEdit(id) {
  const r = records.find(x => x.id == id);
  if (!r) return;

  document.getElementById('editId').value       = r.id;
  document.getElementById('editMood').value      = r.mood_type;
  document.getElementById('editNotes').value     = r.notes || '';
  document.getElementById('editIntensity').value = r.mood_level || 5;
  document.getElementById('editSleep').value     = r.sleep_hours || '';
  document.getElementById('editExercise').value  = r.exercise_minutes || '';
  document.getElementById('editSocial').value    = r.social_interaction || '';

  document.querySelectorAll('#editMoodPicker .m-pill').forEach(b => {
    b.classList.toggle('sel', b.dataset.mood === r.mood_type);
  });

  const trigs = (r.triggers || '').split(',').map(s => s.trim());
  document.querySelectorAll('#editTriggerCloud .tag').forEach(p => {
    p.classList.toggle('on', trigs.includes(p.dataset.tag));
  });

  updateSlider(document.getElementById('editIntensity'), 'editIntensityVal');
  document.getElementById('editModal').classList.add('open');
}
function closeEdit() {
  document.getElementById('editModal').classList.remove('open');
}
function pickEditMood(val, btn) {
  document.querySelectorAll('#editMoodPicker .m-pill').forEach(b => b.classList.remove('sel'));
  btn.classList.add('sel');
  document.getElementById('editMood').value = val;
}

async function updateMood() {
  const id   = document.getElementById('editId').value;
  const mood = document.getElementById('editMood').value;
  if (!mood) { toast('Please select a mood.', 'info'); return; }

  const triggers = [...document.querySelectorAll('#editTriggerCloud .tag.on')]
    .map(p => p.dataset.tag).join(',');

  const payload = {
    id:                 parseInt(id),
    mood_type:          mood,
    mood_level:         parseInt(document.getElementById('editIntensity').value),
    notes:              document.getElementById('editNotes').value.trim() || null,
    triggers:           triggers || null,
    sleep_hours:        document.getElementById('editSleep').value    || null,
    exercise_minutes:   document.getElementById('editExercise').value || null,
    social_interaction: document.getElementById('editSocial').value   || null,
  };

  try {
    const res  = await fetch(BASE + '/update', {
      method: 'PUT', credentials: 'same-origin',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.error || 'Error');
    toast('Entry updated! ✏️', 'success');
    closeEdit();
    loadRecords();
  } catch(e) { toast(e.message, 'error'); }
}

// ─── Render history list ───────────────────────────────────────────
function renderHistory() {
  const list = document.getElementById('historyList');
  if (!records.length) {
    list.innerHTML = `
      <div class="empty">
        <div class="empty__em">📭</div>
        <p class="empty__t">No entries yet</p>
        <p class="empty__s">Click "Log Mood" to start tracking your emotional well-being.</p>
      </div>`;
    return;
  }
  list.innerHTML = records.map(r => {
    const meta = MOOD_META[r.mood_type] || { emoji:'🙂' };
    const lvl  = Math.min(10, Math.max(1, parseInt(r.mood_level) || 5));
    const segs = Array.from({length:10}, (_,i) =>
      `<div class="mh-seg" style="background:${i < lvl ? 'var(--primary)' : 'var(--border)'}"></div>`
    ).join('');
    const date = r.recorded_at
      ? new Date(r.recorded_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})
      : '—';
    const trigs = r.triggers
      ? r.triggers.split(',').filter(Boolean).map(t =>
          `<span class="mh-chip">${escHtml(t.trim())}</span>`).join('')
      : '';

    let meta2 = [];
    if (r.sleep_hours)        meta2.push(`<i class="fas fa-moon" style="font-size:.65rem;"></i> ${r.sleep_hours}h`);
    if (r.exercise_minutes)   meta2.push(`<i class="fas fa-dumbbell" style="font-size:.65rem;"></i> ${r.exercise_minutes}min`);
    if (r.social_interaction) meta2.push(`<i class="fas fa-users" style="font-size:.65rem;"></i> ${r.social_interaction}`);

    return `<div class="mh-row">
      <div class="mh-emoji">${meta.emoji}</div>
      <div class="mh-info">
        <div class="mh-mood-name">${escHtml(r.mood_type)}</div>
        ${r.notes ? `<div class="mh-notes-text">${escHtml(r.notes)}</div>` : ''}
        ${trigs ? `<div class="mh-tags">${trigs}</div>` : ''}
        ${meta2.length ? `<div class="mh-meta">${meta2.join('<span class="mh-meta-sep">·</span>')}</div>` : ''}
      </div>
      <div class="mh-intensity">
        <div class="mh-int-segs">${segs}</div>
        <div class="mh-int-num">${lvl}/10</div>
      </div>
      <div class="mh-date">${date}</div>
      <div class="mh-actions">
        <button class="act-btn" onclick="openEdit(${r.id})" title="Edit"><i class="fas fa-pen"></i></button>
        <button class="act-btn act-btn--del" onclick="deleteMood(${r.id})" title="Delete"><i class="fas fa-trash-can"></i></button>
      </div>
    </div>`;
  }).join('');
}

// ─── Stats ─────────────────────────────────────────────────────────
function renderStats() {
  document.getElementById('statTotal').textContent = records.length;

  // streak
  const dates = [...new Set(records.map(r => (r.recorded_at||'').slice(0,10)))].sort().reverse();
  let streak = 0;
  const today = new Date(); today.setHours(0,0,0,0);
  for (let i=0; i<dates.length; i++) {
    const d = new Date(dates[i]+'T00:00:00');
    if (Math.round((today - d) / 86400000) === i) streak++;
    else break;
  }
  document.getElementById('statStreak').textContent = streak + ' 🔥';

  // avg 7 days
  const since7 = new Date(); since7.setDate(since7.getDate()-7);
  const recent = records.filter(r => r.recorded_at && new Date(r.recorded_at) >= since7);
  const avg = recent.length
    ? (recent.reduce((s,r) => s + (parseInt(r.mood_level)||5), 0) / recent.length).toFixed(1)
    : '—';
  document.getElementById('statAvg').textContent = avg;

  // top mood this month
  const currMonth = new Date().toISOString().slice(0,7);
  const monthRecs = records.filter(r => (r.recorded_at||'').startsWith(currMonth));
  const freq = {};
  monthRecs.forEach(r => { freq[r.mood_type] = (freq[r.mood_type]||0)+1; });
  const top = Object.entries(freq).sort((a,b) => b[1]-a[1])[0];
  document.getElementById('statTop').textContent = top
    ? (MOOD_META[top[0]]?.emoji || '—') + ' ' + top[0]
    : '—';

  // distribution bars
  const total = monthRecs.length;
  const distEl = document.getElementById('moodDistribution');
  distEl.innerHTML = total
    ? Object.entries(freq).sort((a,b)=>b[1]-a[1]).slice(0,5).map(([m,c]) => {
        const pct  = Math.round((c/total)*100);
        const meta = MOOD_META[m] || { emoji:'🙂' };
        return `<div class="dist-item">
          <span class="dist-label">${meta.emoji} ${m}</span>
          <div class="dist-bar-bg"><div class="dist-bar-fill" style="width:${pct}%"></div></div>
          <span class="dist-pct">${pct}%</span>
        </div>`;
      }).join('')
    : '<p style="color:var(--text-secondary);font-size:.82rem;margin:0;">No data this month.</p>';
}

// ─── Calendar ──────────────────────────────────────────────────────
function shiftCal(delta) {
  calMonth += delta;
  if (calMonth > 12) { calMonth=1; calYear++; }
  if (calMonth < 1)  { calMonth=12; calYear--; }
  renderCalendar();
}
function renderCalendar() {
  const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  document.getElementById('calMonthLabel').textContent = `${MONTHS[calMonth-1]} ${calYear}`;

  const grid  = document.getElementById('calGrid');
  const today = new Date().toISOString().slice(0,10);
  const moodMap = {};
  records.forEach(r => {
    const d = (r.recorded_at||'').slice(0,10);
    if (d && !moodMap[d]) moodMap[d] = r.mood_type;
  });

  const firstDay    = new Date(calYear, calMonth-1, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth, 0).getDate();
  const prevDays    = new Date(calYear, calMonth-1, 0).getDate();
  const pad = n => String(n).padStart(2,'0');
  const makeDate = (y,m,d) => `${y}-${pad(m)}-${pad(d)}`;

  let cells = '';

  for (let i = firstDay-1; i >= 0; i--) {
    const y = calMonth===1 ? calYear-1 : calYear;
    const m = calMonth===1 ? 12 : calMonth-1;
    const ds = makeDate(y,m,prevDays-i);
    const mood = moodMap[ds];
    cells += `<div class="cal-cell other-m${mood?' has-mood':''}" title="${ds}">
      <span class="cal-dn">${prevDays-i}</span>
      ${mood ? `<span class="cal-em">${MOOD_META[mood]?.emoji||''}</span>` : ''}
    </div>`;
  }
  for (let d=1; d<=daysInMonth; d++) {
    const ds   = makeDate(calYear, calMonth, d);
    const mood = moodMap[ds];
    const isT  = ds===today;
    cells += `<div class="cal-cell${mood?' has-mood':''}${isT?' cal-cell--today':''}" title="${ds}${mood?' — '+mood:''}">
      <span class="cal-dn" style="${isT?'color:var(--primary);font-weight:800;':''}">${d}</span>
      ${mood ? `<span class="cal-em">${MOOD_META[mood]?.emoji||''}</span>` : ''}
    </div>`;
  }
  grid.innerHTML = cells;
}

// ─── Chart ─────────────────────────────────────────────────────────
function renderChart() {
  const ctx  = document.getElementById('moodChart').getContext('2d');
  const days = 14;
  const labels = [], data = [];
  const today  = new Date(); today.setHours(0,0,0,0);

  for (let i=days-1; i>=0; i--) {
    const d  = new Date(today); d.setDate(d.getDate()-i);
    const ds = d.toISOString().slice(0,10);
    labels.push(d.toLocaleDateString('en-US',{month:'short',day:'numeric'}));
    const recs = records.filter(r => (r.recorded_at||'').startsWith(ds));
    data.push(recs.length
      ? (recs.reduce((s,r)=>s+(parseInt(r.mood_level)||5),0)/recs.length).toFixed(1)
      : null);
  }

  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Avg Intensity',
        data,
        borderColor: '#3D8B6E',
        backgroundColor: 'rgba(61,139,110,.06)',
        borderWidth: 2,
        pointBackgroundColor: '#3D8B6E',
        pointBorderColor: '#fff',
        pointRadius: 4,
        fill: true,
        tension: .4,
        spanGaps: true
      }]
    },
    options: {
      responsive:true, maintainAspectRatio:false,
      plugins: { legend:{ display:false } },
      scales: {
        y: {
          min:0, max:10,
          grid: { color:'rgba(214,228,221,.5)' },
          ticks: { color:'#6B8C7E', font:{ size:10 } }
        },
        x: {
          grid: { display:false },
          ticks: { color:'#6B8C7E', font:{ size:9 }, maxRotation:0 }
        }
      }
    }
  });
}

// ─── Export CSV ────────────────────────────────────────────────────
function exportCsv() {
  if (!records.length) { toast('No entries to export.','info'); return; }
  const rows = [
    ['Date','Mood','Intensity','Notes','Triggers','Sleep(h)','Exercise(min)','Social'],
    ...records.map(r => [
      (r.recorded_at||'').slice(0,10), r.mood_type, r.mood_level,
      r.notes||'', r.triggers||'', r.sleep_hours||'', r.exercise_minutes||'', r.social_interaction||''
    ])
  ];
  const csv  = rows.map(row => row.map(f=>`"${String(f||'').replace(/"/g,'""')}"`).join(',')).join('\n');
  const blob = new Blob([csv],{type:'text/csv'});
  const a    = Object.assign(document.createElement('a'),{href:URL.createObjectURL(blob),download:'mood_log.csv'});
  a.click(); URL.revokeObjectURL(a.href);
}

// ─── Toast ─────────────────────────────────────────────────────────
function toast(msg, type='info') {
  const wrap = document.getElementById('toastWrap');
  const div  = document.createElement('div');
  div.className = `toast toast--${type}`;
  div.innerHTML = `<i class="fas fa-${type==='success'?'circle-check':type==='error'?'circle-xmark':'circle-info'}"></i><span>${msg}</span>`;
  wrap.appendChild(div);
  setTimeout(() => {
    div.style.transition='opacity .3s';
    div.style.opacity='0';
    setTimeout(()=>div.remove(),300);
  }, 3500);
}

function escHtml(s) {
  return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>