<?php
$title = 'MindHeaven — Mental Health Support for Students';
ob_start();
?>

<style>
/* =========================================================
   LANDING PAGE — MINIMALISTIC MODERN DESIGN
   All values use design-system CSS variables from landing.php
   ========================================================= */

/* ── Hero ── */
.hero {
    position: relative;
    padding: 100px 0 96px;
    background: var(--surface);
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    top: -140px; right: -180px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(61,139,110,0.10) 0%, transparent 70%);
    pointer-events: none;
}
.hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -100px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(232,168,124,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.hero-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(61,139,110,0.08);
    border: 1px solid rgba(61,139,110,0.18);
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: var(--radius-full);
    margin-bottom: 20px;
    letter-spacing: 0.3px;
}
.hero-badge i { font-size: 0.75rem; }
.hero-title {
    font-size: clamp(2.4rem, 4.5vw, 3.4rem);
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.12;
    letter-spacing: -1px;
    margin-bottom: 20px;
}
.hero-title em {
    font-style: normal;
    color: var(--primary);
}
.hero-subtitle {
    font-size: 1.05rem;
    color: var(--text-secondary);
    line-height: 1.7;
    max-width: 440px;
    margin-bottom: 36px;
}
.hero-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.hero-trust {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 36px;
}
.hero-trust-avatars { display: flex; }
.hero-trust-avatars span {
    width: 32px; height: 32px;
    border-radius: 50%;
    border: 2px solid white;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    color: white;
    margin-left: -8px;
}
.hero-trust-avatars span:first-child { margin-left: 0; }
.hero-trust-text { font-size: 0.82rem; color: var(--text-secondary); }
.hero-trust-text strong { color: var(--text-primary); font-weight: 600; }

/* Hero right — visual card stack */
.hero-visual {
    position: relative;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-card {
    position: absolute;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px;
    box-shadow: var(--shadow-lg);
}
.hero-card--main {
    width: 280px;
    z-index: 3;
    animation: float 8s ease-in-out infinite;
}
.hero-card--mood {
    top: 24px; left: 0;
    width: 180px;
    z-index: 2;
    animation: float 8s ease-in-out infinite;
    animation-delay: -2s;
}
.hero-card--stat {
    bottom: 40px; right: 10px;
    width: 160px;
    z-index: 2;
    animation: float 8s ease-in-out infinite;
    animation-delay: -4s;
}
.hc-label { font-size: 0.72rem; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.8px; text-transform: uppercase; margin-bottom: 10px; }
.hc-bars { display: flex; flex-direction: column; gap: 7px; }
.hc-bar { display: flex; align-items: center; gap: 8px; font-size: 0.75rem; color: var(--text-secondary); }
.hc-bar-fill { height: 6px; border-radius: 3px; background: var(--primary); opacity: 0.75; flex-shrink: 0; }
.hc-bar-fill--calm   { width: 80%; background: var(--primary); }
.hc-bar-fill--focus  { width: 65%; background: var(--accent-warm); }
.hc-bar-fill--sleep  { width: 90%; background: var(--success); }

.mood-row { display: flex; align-items: center; justify-content: space-between; }
.mood-emoji { font-size: 1.6rem; }
.mood-score { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
.mood-sub   { font-size: 0.72rem; color: var(--text-secondary); margin-top: 2px; }
.mood-trend { font-size: 0.75rem; color: var(--success); font-weight: 600; }

.stat-number-big { font-size: 1.8rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px; }
.stat-sub        { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }
.stat-icon-row   { display: flex; gap: 6px; margin-top: 10px; }
.stat-dot {
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.55rem; color: white;
}

/* ── Stats band ── */
.stats-band {
    padding: 56px 0;
    background: var(--bg-mid);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}
.stats-band .container { display: block; }
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    text-align: center;
    gap: 0;
}
.stat-block {
    padding: 8px 24px;
    border-right: 1px solid var(--border);
}
.stat-block:last-child { border-right: none; }
.stat-value {
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--primary);
    letter-spacing: -1px;
    line-height: 1;
    margin-bottom: 6px;
}
.stat-label {
    font-size: 0.85rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* ── Features grid ── */
.features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.feature-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    transition: all 0.3s ease;
}
.feature-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-light);
}
.feature-card h3 {
    font-size: 1.02rem;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.2px;
    margin-bottom: 8px;
}
.feature-card p {
    font-size: 0.88rem;
    color: var(--text-secondary);
    line-height: 1.65;
}
.feature-icon {
    width: 48px; height: 48px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem;
    margin-bottom: 18px;
    color: white;
}
.feature-icon--teal    { background: var(--primary); }
.feature-icon--apricot { background: var(--accent-warm); }
.feature-icon--sky     { background: var(--accent-calm); color: var(--text-primary); }
.feature-icon--mint    { background: var(--success); }
.feature-icon--red     { background: var(--crisis); }
.feature-icon--forest  { background: var(--primary-dark); }

/* Old features-grid classes used by PHP sections */
.features-grid.stagger-children { gap: 20px; }

/* ── Empathy Band ── */
.empathy-band {
    padding: 80px 0;
    background: var(--primary);
    text-align: center;
    position: relative;
    overflow: hidden;
}
.empathy-band::before {
    content: '';
    position: absolute;
    top: -60%; left: 50%;
    transform: translateX(-50%);
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.empathy-band .container { display: block; position: relative; z-index: 1; }
.empathy-band h2 {
    font-size: clamp(1.75rem, 3.5vw, 2.8rem);
    font-weight: 700;
    color: white;
    line-height: 1.25;
    letter-spacing: -0.5px;
    margin-bottom: 16px;
}
.empathy-band p {
    font-size: 1rem;
    color: rgba(255,255,255,0.80);
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── How it works ── */
.steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; position: relative; }
.steps-grid::before {
    content: '';
    position: absolute;
    top: 32px; left: calc(16.67% + 12px);
    right: calc(16.67% + 12px);
    height: 1px;
    background: var(--border);
    z-index: 0;
}
.step-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    text-align: center;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}
.step-card:hover { box-shadow: var(--shadow-md); border-color: var(--primary-light); transform: translateY(-3px); }
.step-number {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    font-size: 1.15rem;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    box-shadow: 0 4px 14px rgba(61,139,110,0.30);
}
.step-card h3 { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
.step-card p  { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.65; }

/* ── Testimonials ── */
.testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.testimonial-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    transition: all 0.3s ease;
}
.testimonial-card:hover { box-shadow: var(--shadow-md); border-color: var(--primary-light); transform: translateY(-3px); }
.testimonial-quote {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--primary);
    line-height: 1;
    margin-bottom: 12px;
    opacity: 0.5;
}
.testimonial-card p {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 16px;
}
.testimonial-author {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--primary);
}

/* ── Quiz preview ── */
.quiz-preview-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.quiz-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    transition: all 0.3s ease;
}
.quiz-card:hover { box-shadow: var(--shadow-md); border-color: var(--primary-light); transform: translateY(-3px); }
.quiz-card-icon {
    width: 48px; height: 48px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 16px;
}
.quiz-card h3 { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
.quiz-card p  { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 18px; }

/* ── CTA grid ── */
.cta-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.cta-card { text-align: center; }
.cta-card h3 { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
.cta-card p  { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 20px; }

/* ── Crisis Banner ── */
.crisis-banner {
    padding: 64px 0;
    background: var(--bg-deep);
    position: relative;
    overflow: hidden;
}
.crisis-banner::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(ellipse at top right, rgba(214,79,79,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.crisis-banner .container { display: block; position: relative; z-index: 1; }
.crisis-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
}
.crisis-text h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700;
    color: white;
    letter-spacing: -0.3px;
    line-height: 1.3;
    margin-bottom: 10px;
}
.crisis-text p { font-size: 0.95rem; color: rgba(255,255,255,0.65); max-width: 440px; line-height: 1.65; }
.crisis-actions { display: flex; gap: 12px; flex-shrink: 0; flex-wrap: wrap; }

/* ── Donation Section ── */
.donation-section {
    padding: 80px 0;
    background: var(--bg-soft);
    position: relative;
    overflow: hidden;
}
.donation-section .container { display: block; }
.donation-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: center;
}
.donation-content .section-label { display: inline-block; margin-bottom: 12px; }
.donation-content h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.4rem);
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.5px;
    line-height: 1.25;
    margin-bottom: 16px;
}
.donation-content > p {
    font-size: 0.95rem;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 28px;
}
.donation-stats { display: flex; gap: 32px; margin-bottom: 32px; }
.donation-stat .stat-number { font-size: 2rem; font-weight: 700; color: var(--primary); letter-spacing: -0.5px; line-height: 1; }
.donation-stat .stat-label  { font-size: 0.82rem; color: var(--text-secondary); margin-top: 4px; }
.donation-visual { position: relative; height: 280px; display: flex; align-items: center; justify-content: center; }
.donation-circle {
    position: absolute;
    border-radius: 50%;
    border: 1.5px solid var(--border);
}
.donation-circle--lg {
    width: 260px; height: 260px;
    border-color: rgba(61,139,110,0.18);
    background: rgba(61,139,110,0.04);
    animation: float 9s ease-in-out infinite;
}
.donation-circle--sm {
    width: 140px; height: 140px;
    background: rgba(61,139,110,0.08);
    border-color: rgba(61,139,110,0.25);
    animation: float 9s ease-in-out infinite;
    animation-delay: -3s;
}
.donation-circle-icon {
    position: relative;
    z-index: 2;
    width: 72px; height: 72px;
    border-radius: 50%;
    background: var(--primary);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 8px 24px rgba(61,139,110,0.35);
}

/* ── University Events ── */
.events-section {
    padding: 80px 0;
    background: var(--surface);
}
.events-section .container { display: block; }
.events-uni-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
}
.events-uni-label i { color: var(--primary); }
.event-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex; flex-direction: column;
    height: 100%;
}
.event-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.event-card-img {
    width: 100%; height: 180px;
    object-fit: cover;
    background: var(--bg-mid);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-secondary);
    font-size: 2rem;
}
.event-card-img img { width: 100%; height: 100%; object-fit: cover; }
.event-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
.event-card-body h4 { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px; }
.event-card-body p  { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; flex: 1; margin-bottom: 14px; }
.event-date { font-size: 0.8rem; font-weight: 600; color: var(--primary); margin-bottom: 16px; }
.event-date i { margin-right: 4px; }
.event-card-actions { display: flex; gap: 8px; }
.event-card-actions .btn { flex: 1; justify-content: center; }

/* ── Counselors ── */
.counselors-section { padding: 80px 0; background: var(--bg-mid); }
.counselors-section .container { display: block; }
.counselors-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.counselor-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.3s ease;
}
.counselor-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
.counselor-card-inner { display: flex; flex-direction: column; height: 100%; }
.counselor-avatar-wrap {
    position: relative;
    width: 80px; height: 80px;
    margin: 28px auto 0;
}
.counselor-avatar-img,
.counselor-avatar-initials {
    width: 80px; height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
}
.counselor-avatar-initials {
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 700; color: white;
}
.counselor-status-dot {
    position: absolute;
    bottom: 4px; right: 4px;
    width: 14px; height: 14px;
    border-radius: 50%;
    background: var(--success);
    border: 2px solid var(--surface);
}
.counselor-card-body { padding: 18px 22px; flex: 1; text-align: center; }
.counselor-name { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; }
.counselor-spec-badge {
    display: inline-block;
    background: var(--bg-mid);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: var(--radius-full);
    margin-bottom: 10px;
    border: 1px solid var(--border);
}
.counselor-exp {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-bottom: 10px;
}
.counselor-exp i { color: var(--primary); margin-right: 4px; }
.counselor-bio { font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6; }
.counselor-card-footer { padding: 16px 22px; border-top: 1px solid var(--border); }
.counselor-book-btn { width: 100%; justify-content: center; }

/* ── Final CTA ── */
.final-cta {
    padding: 96px 0;
    background: var(--bg-deep);
    text-align: center;
    position: relative;
    overflow: hidden;
}
.final-cta::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(61,139,110,0.12) 0%, transparent 70%);
    pointer-events: none;
}
.final-cta .container { display: block; position: relative; z-index: 1; }
.final-cta h2 {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: white;
    letter-spacing: -0.8px;
    line-height: 1.2;
    margin-bottom: 16px;
}
.final-cta p {
    font-size: 1rem;
    color: rgba(255,255,255,0.60);
    margin-bottom: 36px;
}
.final-cta-actions { display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap; }

/* ── Responsive overrides ── */
@media (max-width: 1024px) {
    .hero-inner { grid-template-columns: 1fr; gap: 48px; }
    .hero-visual { height: 320px; }
    .donation-inner { grid-template-columns: 1fr; gap: 40px; }
    .donation-visual { height: 200px; }
    .counselors-grid { grid-template-columns: repeat(2, 1fr); }
    .features-grid, .testimonials-grid, .quiz-preview-grid, .cta-grid, .steps-grid { grid-template-columns: repeat(2, 1fr); }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .stat-block { border-right: none; border-bottom: 1px solid var(--border); padding: 16px 0; }
    .stat-block:last-child { border-bottom: none; }
}
@media (max-width: 768px) {
    .hero { padding: 72px 0 60px; }
    .hero-visual { display: none; }
    .features-grid, .testimonials-grid, .quiz-preview-grid,
    .cta-grid, .steps-grid, .counselors-grid { grid-template-columns: 1fr; }
    .steps-grid::before { display: none; }
    .crisis-inner { flex-direction: column; text-align: center; }
    .crisis-text p { max-width: 100%; margin: 0 auto; }
    .donation-inner { grid-template-columns: 1fr; }
    .donation-visual { display: none; }
    .donation-stats { flex-direction: row; gap: 20px; }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .empathy-band { padding: 56px 0; }
    .final-cta { padding: 72px 0; }
}
@media (max-width: 480px) {
    .hero-actions { flex-direction: column; align-items: stretch; }
    .hero-actions .btn { justify-content: center; }
    .crisis-actions { flex-direction: column; width: 100%; }
    .crisis-actions .btn { justify-content: center; }
    .final-cta-actions { flex-direction: column; }
    .final-cta-actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ======== HERO ======== -->
<section class="hero">
    <div class="container">
        <div class="hero-inner">
            <!-- Left: Copy -->
            <div>
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    Free · Confidential · Student-first
                </div>
                <h1 class="hero-title">
                    Your mental health<br><em>matters here.</em>
                </h1>
                <p class="hero-subtitle">
                    MindHeaven connects undergraduate students with professional counseling, peer support, and tools to understand and improve their mental wellness — all in one private platform.
                </p>
                <div class="hero-actions">
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Get Started Free
                    </a>
                    <a href="<?php echo BASE_URL; ?>/ug/resources" class="btn btn-outline btn-lg">
                        <i class="fas fa-book-open"></i> Explore Resources
                    </a>
                </div>
                <div class="hero-trust">
                    <div class="hero-trust-avatars">
                        <span style="background:#3D8B6E;">A</span>
                        <span style="background:#E8A87C;">B</span>
                        <span style="background:#A8C5DA;color:#1E3A34;">C</span>
                        <span style="background:#4CAF82;">D</span>
                    </div>
                    <p class="hero-trust-text"><strong>5,000+ students</strong> supported so far</p>
                </div>
            </div>

            <!-- Right: Visual card stack -->
            <div class="hero-visual">
                <div class="hero-card hero-card--mood">
                    <div class="hc-label">Today's Mood</div>
                    <div class="mood-row">
                        <div>
                            <div class="mood-emoji">😊</div>
                            <div class="mood-trend">↑ Feeling better</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="mood-score">7.5</div>
                            <div class="mood-sub">/ 10</div>
                        </div>
                    </div>
                </div>

                <div class="hero-card hero-card--main">
                    <div class="hc-label">Weekly Wellness</div>
                    <div class="hc-bars">
                        <div class="hc-bar">
                            <div class="hc-bar-fill hc-bar-fill--calm"></div>
                            <span>Calm</span>
                        </div>
                        <div class="hc-bar">
                            <div class="hc-bar-fill hc-bar-fill--focus"></div>
                            <span>Focus</span>
                        </div>
                        <div class="hc-bar">
                            <div class="hc-bar-fill hc-bar-fill--sleep"></div>
                            <span>Sleep</span>
                        </div>
                    </div>
                    <div style="margin-top:16px; padding-top:14px; border-top:1px solid var(--border); font-size:0.78rem; color:var(--text-secondary);">
                        <i class="fas fa-calendar-check" style="color:var(--primary);"></i> Session with Dr. Sarah — Tomorrow 2 PM
                    </div>
                </div>

                <div class="hero-card hero-card--stat">
                    <div class="hc-label">Support Network</div>
                    <div class="stat-number-big">50+</div>
                    <div class="stat-sub">Licensed Counselors</div>
                    <div class="stat-icon-row">
                        <div class="stat-dot" style="background:var(--primary);">•</div>
                        <div class="stat-dot" style="background:var(--accent-warm);">•</div>
                        <div class="stat-dot" style="background:var(--success);">•</div>
                        <div style="font-size:0.72rem;color:var(--text-secondary);align-self:center;margin-left:2px;">Available now</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======== STATS BAND ======== -->
<section class="stats-band">
    <div class="container">
        <div class="stats-row">
            <div class="stat-block">
                <div class="stat-value">5,000+</div>
                <div class="stat-label">Students Helped</div>
            </div>
            <div class="stat-block">
                <div class="stat-value">50+</div>
                <div class="stat-label">Licensed Counselors</div>
            </div>
            <div class="stat-block">
                <div class="stat-value">24/7</div>
                <div class="stat-label">Crisis Availability</div>
            </div>
            <div class="stat-block">
                <div class="stat-value">95%</div>
                <div class="stat-label">Student Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- ======== EMPATHY BAND ======== -->
<section class="empathy-band animate-on-scroll">
    <div class="container">
        <h2>
            Whatever you're feeling right now — it's valid.<br>
            And you deserve support.
        </h2>
        <p>
            Whether it's stress, loneliness, anxiety, or something you can't name yet —
            you don't have to figure it out alone. MindHeaven was built for moments like this.
        </p>
    </div>
</section>

<!-- ======== FEATURES ======== -->
<section class="section">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">What we offer</span>
            <h2 class="section-title">One place for your whole well-being</h2>
            <p class="section-subtitle">Everything you need to understand, track, and improve your mental health — all in one platform.</p>
        </div>

        <div class="features-grid stagger-children">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--teal"><i class="fas fa-user-md"></i></div>
                <h3>Professional Counseling</h3>
                <p>Schedule private, secure sessions with licensed university counselors. Get real support from real professionals.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--apricot"><i class="fas fa-comments"></i></div>
                <h3>Peer Support Forum</h3>
                <p>Share anonymously with students who understand what you're going through. You're never the only one.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--sky"><i class="fas fa-brain"></i></div>
                <h3>Self-Assessment Quiz</h3>
                <p>Take a quick, private mental health check-in. Get instant feedback on anxiety, stress, and mood patterns.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--forest"><i class="fas fa-book-open"></i></div>
                <h3>Resource Hub</h3>
                <p>Curated articles, videos, and guides designed for the unique challenges that come with university life.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--red"><i class="fas fa-phone-alt"></i></div>
                <h3>24/7 Crisis Support</h3>
                <p>Immediate help when you need it most. No login required, no waiting — just reach out anytime.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon feature-icon--mint"><i class="fas fa-chart-line"></i></div>
                <h3>Progress Tracking</h3>
                <p>Log your mood, build healthy habits, and set wellness goals. Watch your growth over time — it matters.</p>
            </div>
        </div>
    </div>
</section>

<!-- ======== HOW IT WORKS ======== -->
<section class="section--alt">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">Getting started</span>
            <h2 class="section-title">You're three steps from feeling supported</h2>
        </div>
        <div class="steps-grid stagger-children">
            <div class="step-card animate-on-scroll">
                <div class="step-number">1</div>
                <h3>Create your account</h3>
                <p>Sign up with your university email in under two minutes. It's free, private, and completely confidential.</p>
            </div>
            <div class="step-card animate-on-scroll">
                <div class="step-number">2</div>
                <h3>Take a wellness check</h3>
                <p>Complete a short self-assessment to understand where you are right now. No judgement — just insight.</p>
            </div>
            <div class="step-card animate-on-scroll">
                <div class="step-number">3</div>
                <h3>Access your support</h3>
                <p>Book counseling, join the forum, track your mood, and explore resources tailored to your needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- ======== UNIVERSITY EVENTS ======== -->
<?php if (!empty($eventsByUniversity)): ?>
<section class="events-section">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">Community</span>
            <h2 class="section-title">University Fundraising Events</h2>
            <p class="section-subtitle">Support mental health initiatives across different universities.</p>
        </div>

        <?php foreach ($eventsByUniversity as $uniName => $events): ?>
        <div style="margin-bottom: 48px;">
            <div class="events-uni-label">
                <i class="fas fa-university"></i>
                <?= htmlspecialchars($uniName) ?>
            </div>
            <div class="features-grid">
                <?php foreach ($events as $event): ?>
                <div class="event-card animate-on-scroll">
                    <div class="event-card-img">
                        <?php if (!empty($event['image_path'])): ?>
                            <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Image">
                        <?php else: ?>
                            <i class="fas fa-calendar-star"></i>
                        <?php endif; ?>
                    </div>
                    <div class="event-card-body">
                        <h4><?= htmlspecialchars($event['event_title']) ?></h4>
                        <p><?= htmlspecialchars($event['short_description'] ?? 'Support this mental health initiative.') ?></p>
                        <div class="event-date">
                            <i class="far fa-calendar-alt"></i>
                            <?= (!empty($event['event_date']) && strpos($event['event_date'], '0000') === false)
                                ? htmlspecialchars(date('M d, Y', strtotime($event['event_date'])))
                                : 'To be announced' ?>
                        </div>
                        <div class="event-card-actions">
                            <a href="<?= BASE_URL ?>/university-rep/events/view/<?= $event['id'] ?>" class="btn btn-outline btn-sm">View Details</a>
                            <a href="<?= BASE_URL ?>/donation?event_id=<?= $event['id'] ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-heart"></i> Donate
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ======== COUNSELORS ======== -->
<?php
$counselors = isset($counselors) && is_array($counselors) ? $counselors : [];
if (!empty($counselors)):
?>
<section class="counselors-section">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">Our team</span>
            <h2 class="section-title">Meet our counselors</h2>
            <p class="section-subtitle">Our licensed mental health professionals are here to support your journey toward wellness.</p>
        </div>
        <div class="counselors-grid stagger-children">
            <?php foreach ($counselors as $counselor):
                $pic      = !empty($counselor['profile_picture']) ? htmlspecialchars($counselor['profile_picture']) : '';
                $name     = htmlspecialchars($counselor['full_name'] ?? 'Counselor');
                $spec     = htmlspecialchars($counselor['specialization'] ?? 'Mental Health');
                $exp      = !empty($counselor['years_experience']) ? (int)$counselor['years_experience'] : null;
                $bio      = !empty($counselor['bio']) ? htmlspecialchars($counselor['bio']) : 'Dedicated to helping students thrive emotionally and mentally.';
                $bioShort = mb_strlen($bio) > 120 ? mb_substr($bio, 0, 120) . '…' : $bio;
                $palette  = ['#3D8B6E','#E8A87C','#A8C5DA','#4CAF82','#2A6B52','#6BB89A'];
                $colorIdx = array_sum(array_map('ord', str_split(substr($name, 0, 3)))) % count($palette);
                $color    = $palette[$colorIdx];
                $initials = substr(implode('', array_map(fn($w) => strtoupper($w[0]), array_filter(explode(' ', $name)))), 0, 2);
            ?>
            <div class="counselor-card animate-on-scroll">
                <div class="counselor-card-inner">
                    <div class="counselor-avatar-wrap">
                        <?php if ($pic): ?>
                            <img src="<?php echo $pic; ?>" alt="<?php echo $name; ?>" class="counselor-avatar-img"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="counselor-avatar-initials" style="background:<?php echo $color; ?>; display:none;"><?php echo $initials; ?></div>
                        <?php else: ?>
                            <div class="counselor-avatar-initials" style="background:<?php echo $color; ?>;"><?php echo $initials; ?></div>
                        <?php endif; ?>
                        <div class="counselor-status-dot"></div>
                    </div>
                    <div class="counselor-card-body">
                        <h3 class="counselor-name"><?php echo $name; ?></h3>
                        <span class="counselor-spec-badge"><?php echo $spec; ?></span>
                        <?php if ($exp !== null): ?>
                        <div class="counselor-exp"><i class="fas fa-briefcase"></i> <?php echo $exp; ?> year<?php echo $exp !== 1 ? 's' : ''; ?> experience</div>
                        <?php endif; ?>
                        <p class="counselor-bio"><?php echo $bioShort; ?></p>
                    </div>
                    <div class="counselor-card-footer">
                        <a href="<?php echo BASE_URL; ?>/ug/appointment" class="btn btn-primary counselor-book-btn btn-sm">
                            <i class="fas fa-calendar-check"></i> Book Session
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ======== TESTIMONIALS ======== -->
<section class="section">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">Student voices</span>
            <h2 class="section-title">Words from people who've been where you are</h2>
            <p class="section-subtitle">Real experiences from students who found support through MindHeaven.</p>
        </div>
        <div class="testimonials-grid stagger-children">
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-quote">"</div>
                <p>I didn't think I needed help until I tried the self-assessment. Seeing my results helped me understand what I was feeling — and the counselor I connected with changed everything.</p>
                <span class="testimonial-author">— 2nd Year, Psychology Major</span>
            </div>
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-quote">"</div>
                <p>The forum gave me a space to say what I couldn't say out loud. Knowing other students were going through the same things made me feel less alone during the hardest semester of my life.</p>
                <span class="testimonial-author">— 3rd Year, Engineering</span>
            </div>
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-quote">"</div>
                <p>Tracking my mood every day seemed small, but after a month I could see patterns. It helped my counselor and me figure out what was triggering my anxiety. I'm doing so much better now.</p>
                <span class="testimonial-author">— 1st Year, Business</span>
            </div>
        </div>
    </div>
</section>

<!-- ======== SELF-DISCOVERY ======== -->
<section class="section--alt">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-label">Self-discovery tools</span>
            <h2 class="section-title">Knowledge that helps you understand yourself</h2>
            <p class="section-subtitle">Quick, private assessments designed to give you clarity — not a diagnosis.</p>
        </div>
        <div class="quiz-preview-grid stagger-children">
            <div class="quiz-card animate-on-scroll">
                <div class="quiz-card-icon" style="background:rgba(61,139,110,0.10); color:var(--primary);">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>Anxiety Check-in</h3>
                <p>Understand your anxiety patterns through targeted questions with instant, private feedback.</p>
                <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-outline btn-sm">Take Assessment</a>
            </div>
            <div class="quiz-card animate-on-scroll">
                <div class="quiz-card-icon" style="background:rgba(232,168,124,0.15); color:var(--accent-warm);">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <h3>Mood & Stress Review</h3>
                <p>A gentle check-in on how stress and mood are affecting your daily life and academic performance.</p>
                <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-outline btn-sm">Take Assessment</a>
            </div>
            <div class="quiz-card animate-on-scroll">
                <div class="quiz-card-icon" style="background:rgba(168,197,218,0.20); color:var(--accent-calm);">
                    <i class="fas fa-sun"></i>
                </div>
                <h3>Well-being Score</h3>
                <p>Get an overall picture of your mental wellness with personalised recommendations for next steps.</p>
                <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-outline btn-sm">Take Assessment</a>
            </div>
        </div>
    </div>
</section>

<!-- ======== CRISIS BANNER ======== -->
<section class="crisis-banner animate-on-scroll">
    <div class="container">
        <div class="crisis-inner">
            <div class="crisis-text">
                <h2>If you need help right now, we're here.</h2>
                <p>You don't need an account. You don't need to explain everything. Just reach out — 24/7, always free.</p>
            </div>
            <div class="crisis-actions">
                <a href="<?php echo BASE_URL; ?>/public/crisis" class="btn btn-white btn-lg">
                    <i class="fas fa-phone-alt"></i> Get Crisis Support
                </a>
                <a href="tel:+15551234567" class="btn btn-ghost btn-lg">
                    <i class="fas fa-headset"></i> Call Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ======== DONATION ======== -->
<section class="donation-section">
    <div class="container">
        <div class="donation-inner">
            <div class="donation-content animate-on-scroll">
                <span class="section-label">Support the mission</span>
                <h2>MindHeaven is free because it has to be.</h2>
                <p>No student should have to choose between their mental health and their budget. Your donation keeps counseling sessions, crisis support, and every resource on this platform completely free for every student who needs them.</p>
                <div class="donation-stats">
                    <div class="donation-stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Goes to student services</div>
                    </div>
                    <div class="donation-stat">
                        <div class="stat-number">5,000+</div>
                        <div class="stat-label">Students supported</div>
                    </div>
                </div>
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-primary btn-lg">
                    <i class="fas fa-heart"></i> Donate Now
                </a>
            </div>
            <div class="donation-visual animate-on-scroll">
                <div class="donation-circle donation-circle--lg"></div>
                <div class="donation-circle donation-circle--sm"></div>
                <div class="donation-circle-icon"><i class="fas fa-heart"></i></div>
            </div>
        </div>
    </div>
</section>

<!-- ======== FINAL CTA ======== -->
<section class="final-cta">
    <div class="container">
        <h2 class="animate-on-scroll">The hardest part is deciding you<br>deserve help. You do.</h2>
        <p class="animate-on-scroll">Free to join. Confidential. Built for students like you.</p>
        <div class="final-cta-actions animate-on-scroll">
            <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-right"></i> Create your free account
            </a>
            <a href="<?php echo BASE_URL; ?>/login" class="btn btn-ghost btn-lg">Already have an account?</a>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require BASE_PATH . '/app/views/layouts/landing.php';
?>