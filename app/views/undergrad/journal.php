<?php
$TITLE = 'MindHeaven — Personal Journal';
$CURRENT_PAGE = 'journal';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/journal.css'];
require BASE_PATH . '/app/views/layouts/header.php';
?>

<main class="mp journal-page">
    <!-- Header Section -->
    <header class="mp-header">
        <div class="mp-header__inner">
            <div class="mp-header__left">
                <h1 class="mp-header__title fade-in">Morning, <?= htmlspecialchars($currentUser['full_name'] ?? $currentUser['username'] ?? 'User') ?>.</h1>
                <p class="mp-header__sub fade-in">Capture your thoughts, celebrate your wins, and find your peace.</p>
            </div>
            <div class="mp-header__right">
                <button id="newEntryBtn" class="btn btn--primary shadow-glow">
                    <i class="fas fa-plus"></i> New Reflection
                </button>
            </div>
        </div>
    </header>

    <div class="mp-body">
        <!-- Stats Section -->
        <div class="mp-stats">
            <div class="mp-stat">
                <span class="mp-stat__label">Total Reflections</span>
                <span class="mp-stat__val"><span class="mp-stat__dot"></span><span id="totalEntriesCount">0</span></span>
            </div>
            <div class="mp-stat">
                <span class="mp-stat__label">Writing Streak</span>
                <span class="mp-stat__val"><span class="mp-stat__dot mp-stat__dot--warm"></span><span id="currentStreak">0</span> Days</span>
            </div>
            <div class="mp-stat hide-on-mobile">
                <span class="mp-stat__label">Habit Momentum</span>
                <span class="mp-stat__val"><span class="mp-stat__dot mp-stat__dot--sky"></span><?= $habitStats['completion_rate'] ?>%</span>
            </div>
            <div class="mp-stat hide-on-mobile">
                <span class="mp-stat__label">Primary Mood</span>
                <span class="mp-stat__val" style="font-size: 1rem;"><span class="mp-stat__dot mp-stat__dot--mint"></span><?= ucfirst($todayMood ?? 'Neutral') ?></span>
            </div>
        </div>

        <div class="viz-grid">
            <!-- Sidebar: Insights & Prompts -->
            <aside class="viz-sidebar">
                <div class="mc">
                    <div class="mc__hd">
                        <h3 class="mc__title"><i class="fas fa-sparkles"></i> Wellness Insights</h3>
                    </div>
                    <div class="mc__bd">
                        <div class="insight-item">
                            <?php if ($habitStats['completed_today'] > 0): ?>
                                <p class="insight-text">You've done amazing today, completing <strong><?= $habitStats['completed_today'] ?> habits</strong> already. Keep up the great work!</p>
                            <?php else: ?>
                                <p class="insight-text">Journaling is a great first step to a productive day. Write freely.</p>
                            <?php endif; ?>
                        </div>
                        <?php if ($todayMood): ?>
                            <div class="insight-item" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                                <p class="insight-text">You logged feeling <strong><?= $todayMood ?></strong> earlier. How has that feeling evolved?</p>
                            </div>
                        <?php endif; ?>

                        <!-- Daily Inspiration Quote -->
                        <div class="insight-item" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border);">
                            <label class="flabel" style="margin-bottom: 8px; font-size: 0.7rem; color: var(--primary);"><i class="fas fa-quote-left"></i> Daily Inspiration</label>
                            <p class="insight-text" style="font-style: italic; font-size: 0.85rem; color: var(--text-secondary);">"<?= $dailyQuote ?>"</p>
                        </div>
                    </div>
                </div>

                <div class="mc">
                    <div class="mc__hd">
                        <h3 class="mc__title"><i class="fas fa-lightbulb"></i> Daily Prompt</h3>
                    </div>
                    <div class="mc__bd">
                        <p id="dailyPromptText" class="prompt-text">What's one thing you're looking forward to this week?</p>
                        <button id="usePromptBtn" class="btn btn--outline btn--sm" style="width: 100%;">Use Prompt</button>
                    </div>
                </div>
            </aside>

            <!-- Main: Entries -->
            <section class="viz-main">
                <div class="mc">
                    <div class="mc__hd">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <h3 class="mc__title"><i class="fas fa-feather-alt"></i> Recent Reflections</h3>
                            <div class="toolbar-actions" style="display: flex; gap: 10px;">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="journalSearch" placeholder="Search...">
                                </div>
                                <select id="categoryFilter" class="finput" style="padding: 4px 10px; font-size: 0.8rem; width: auto;">
                                    <option value="all">All Topics</option>
                                    <option value="stress">Processing a Challenge</option>
                                    <option value="exams">Academic Focus</option>
                                    <option value="relationships">Social Connection</option>
                                    <option value="health">Body & Mind</option>
                                    <option value="social">Shared Moment</option>
                                    <option value="other">General reflection</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mc__bd">
                        <div id="journalEntriesList" class="mh-list">
                            <!-- Data populated by JS -->
                            <div class="empty-state" style="padding: 40px; text-align: center;">
                                <div class="empty-icon" style="font-size: 3rem; opacity: 0.3; margin-bottom: 20px;"><i class="fas fa-feather-alt"></i></div>
                                <h2 style="font-size: 1.2rem; color: var(--text-secondary);">Silence is the canvas...</h2>
                                <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 20px;">Your first entry is waiting to be written.</p>
                                <button class="btn btn--primary" onclick="window.journalApp.openEditor()">Start Journaling</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Redesigned 'Safe Space' Editor Modal -->
    <div id="journalModal" class="modal-overlay">
        <div class="modal-content journal-editor">
            <header class="editor-header">
                <div class="editor-meta">
                    <span id="editorDate"><?= date('F j, Y') ?></span>
                    <span class="editor-sep" style="margin: 0 10px; opacity: 0.4;">|</span>
                    <span id="wordCount">0 words</span>
                </div>
                <button id="closeEditorBtn" class="close-btn" aria-label="Close">&times;</button>
            </header>

            <form id="journalForm" class="editor-form">
                <input type="hidden" id="entryId">
                
                <!-- 1. Context Area: Mood & Tags -->
                <div class="editor-controls">
                    <div class="mood-box">
                        <label class="flabel"><i class="fas fa-heart"></i> Heart Status</label>
                        <div class="mood-grid" style="display: flex; gap: 8px;">
                            <button type="button" class="m-pill" data-mood="ecstatic" title="Ecstatic"><span class="m-pill__em">🤩</span></button>
                            <button type="button" class="m-pill" data-mood="happy" title="Happy"><span class="m-pill__em">😊</span></button>
                            <button type="button" class="m-pill" data-mood="calm" title="Calm"><span class="m-pill__em">😌</span></button>
                            <button type="button" class="m-pill" data-mood="neutral" title="Neutral"><span class="m-pill__em">😐</span></button>
                            <button type="button" class="m-pill" data-mood="tired" title="Tired"><span class="m-pill__em">😴</span></button>
                            <button type="button" class="m-pill" data-mood="sad" title="Sad"><span class="m-pill__em">😔</span></button>
                            <button type="button" class="m-pill" data-mood="anxious" title="Anxious"><span class="m-pill__em">😰</span></button>
                        </div>
                    </div>
                    <div class="tags-box">
                        <label class="flabel"><i class="fas fa-tags"></i> Narrative Focus</label>
                        <div class="tags-grid" id="categoryTags" style="display: flex; flex-wrap: wrap; gap: 6px;">
                            <button type="button" class="tag" data-tag="stress">Challenge</button>
                            <button type="button" class="tag" data-tag="exams">Academics</button>
                            <button type="button" class="tag" data-tag="relationships">Social</button>
                            <button type="button" class="tag" data-tag="health">Wellness</button>
                            <button type="button" class="tag" data-tag="social">Friendship</button>
                            <button type="button" class="tag" data-tag="other">General</button>
                        </div>
                    </div>
                </div>

                <!-- 2. Writing Canvas (Main Area) -->
                <div class="writing-canvas">
                    <div class="title-input-wrapper">
                        <input type="text" id="entryTitle" placeholder="The title of your chapter..." required>
                    </div>
                    <textarea id="entryContent" class="main-content-textarea" placeholder="There are no wrong words... just start writing." required></textarea>
                </div>

                <!-- 3. Reflection Box (Secondary Area) -->
                <div class="reflection-box">
                    <div class="reflection-item">
                        <label class="flabel" style="color: var(--accent-warm);"><i class="fas fa-hand-holding-heart"></i> Gratitude</label>
                        <textarea id="entryGratitude" class="finput" style="min-height: 80px; border: none; background: transparent; padding: 0;" placeholder="3 small things from today..."></textarea>
                    </div>
                    <div class="reflection-item">
                        <label class="flabel" style="color: var(--accent-calm);"><i class="fas fa-star"></i> Highlight</label>
                        <textarea id="entryHighlight" class="finput" style="min-height: 80px; border: none; background: transparent; padding: 0;" placeholder="Something that made you smile..."></textarea>
                    </div>
                </div>

                <footer class="editor-footer">
                    <div class="footer-left">
                        <p class="save-status" id="saveStatus">Autosaving to MindHeaven...</p>
                    </div>
                    <div class="footer-right" style="display: flex; gap: 12px;">
                        <button type="button" id="deleteEntryBtn" class="btn btn--outline btn--danger hide" style="border: none;">Delete</button>
                        <button type="submit" class="btn btn--primary btn-wide shadow-glow">Save Reflection</button>
                    </div>
                </footer>
            </form>
        </div>
    </div>
</main>

<script>
    window.INITIAL_JOURNAL_ENTRIES = <?= json_encode($initialEntries ?? []) ?>;
</script>
<script src="/MindHeaven/public/js/undergrad/journal.js" defer></script>
