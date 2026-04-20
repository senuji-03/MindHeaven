<?php
$TITLE = 'MindHeaven — Clinical Self-Assessment (DASS-21)';
$CURRENT_PAGE = 'quiz';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/quiz.css']; // We will create this
require BASE_PATH . '/app/views/layouts/header.php';
?>

<div class="mp quiz-page">
    <div class="mp-header">
        <div class="mp-header__inner">
            <div class="mp-header__left">
                <span class="mp-header__eyebrow">Self-Assessment</span>
                <h1 class="mp-header__title fade-in">Wellness Quiz</h1>
                <p class="mp-header__sub fade-in">Based on the globally recognized DASS-21 clinical standard.</p>
            </div>
        </div>
    </div>

    <div class="mp-body fade-in">
        <div class="quiz-layout">
            <!-- Left Side: Assessment Engine -->
            <div class="quiz-card main-card">
                <div id="quiz-intro" class="quiz-step">
                    <div class="step-icon">🧘</div>
                    <h2>How have you been lately?</h2>
                    <p>This assessment measures Depression, Anxiety, and Stress. Please base your answers on how you have felt over the <strong>past week</strong>.</p>
                    <div class="dass-info">
                        <div class="info-tag">21 Questions</div>
                        <div class="info-tag">~5 Minutes</div>
                        <div class="info-tag">Clinically Validated</div>
                    </div>
                    <button class="btn btn--primary btn--large" onclick="app.start()">Start Assessment</button>
                </div>

                <div id="quiz-questions" class="quiz-step" style="display: none;">
                    <div class="quiz-progress-container">
                        <div class="quiz-progress-bar">
                            <div id="progress-fill" class="progress-fill"></div>
                        </div>
                        <span id="progress-text">Question 1 of 21</span>
                    </div>

                    <div class="question-anchor">
                        <h3 id="question-text" class="question-text">Loading question...</h3>
                        <div class="options-grid" id="options-container">
                            <!-- Options injected by JS -->
                        </div>
                    </div>

                    <div class="quiz-nav">
                        <button id="prev-btn" class="btn btn--secondary" onclick="app.prev()" disabled>Back</button>
                        <span class="step-counter"><span id="curr-idx">1</span>/21</span>
                    </div>
                </div>

                <div id="quiz-results" class="quiz-step" style="display: none;">
                    <div class="results-header">
                        <div class="results-badge">Assessment Complete</div>
                        <h2>Your Wellness Profile</h2>
                    </div>

                    <div class="results-grid">
                        <div class="res-card dass-d">
                            <div class="res-label">Emotional Vitality</div>
                            <div class="res-val" id="res-d-val">Steady</div>
                            <div class="res-score">Points: <span id="res-d-score">0</span></div>
                        </div>
                        <div class="res-card dass-a">
                            <div class="res-label">Inner Calm</div>
                            <div class="res-val" id="res-a-val">Steady</div>
                            <div class="res-score">Points: <span id="res-a-score">0</span></div>
                        </div>
                        <div class="res-card dass-s">
                            <div class="res-label">Persistence</div>
                            <div class="res-val" id="res-s-val">Steady</div>
                            <div class="res-score">Points: <span id="res-s-score">0</span></div>
                        </div>
                    </div>

                    <!-- Recommendations Section -->
                    <div class="recommendations-box">
                        <h4 class="rec-title"><i class="fas fa-sparkles"></i> Personalized Action Plan</h4>
                        <div id="quiz-recommendations" class="rec-list">
                            <!-- Dynamic recommendations will go here -->
                        </div>
                    </div>

                    <div class="results-insight" id="results-insight">
                        <!-- Insight text injected here -->
                    </div>

                    <div class="results-actions">
                        <button class="btn btn--primary" onclick="location.reload()">New Assessment</button>
                        <a href="/MindHeaven/public/ug/appointment" class="btn btn--secondary">Talk to someone</a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Trends & History -->
            <div class="quiz-sidebar">
                <div class="quiz-card trend-card">
                    <div class="card-header">
                        <h3>Your Progress</h3>
                        <span class="trend-icon">📈</span>
                    </div>
                    
                    <?php if (empty($history)): ?>
                        <div class="empty-trend">
                            <div class="empty-icon">✨</div>
                            <p>Take your first assessment to start tracking your mental health journey.</p>
                        </div>
                    <?php else: ?>
                        <div class="trend-chart-container">
                            <div class="trend-chart">
                                <?php 
                                $maxVal = 42; // DASS-42 Max
                                foreach ($history as $record): 
                                    $date = date('M d', strtotime($record['created_at']));
                                    $avg = ($record['depression_score'] + $record['anxiety_score'] + $record['stress_score']) / 3;
                                    $h = ($avg / 21) * 100; // Simplified for visual
                                ?>
                                    <div class="chart-bar-group" title="<?= $date ?>">
                                        <div class="chart-bar" style="height: <?= $h ?>%;">
                                            <div class="bar-segment d" style="height: <?= ($record['depression_score'] / 21) * 100 ?>%"></div>
                                            <div class="bar-segment a" style="height: <?= ($record['anxiety_score'] / 21) * 100 ?>%"></div>
                                            <div class="bar-segment s" style="height: <?= ($record['stress_score'] / 21) * 100 ?>%"></div>
                                        </div>
                                        <span class="bar-label"><?= $date ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="chart-legend">
                                <span><i class="dot d"></i> Dep.</span>
                                <span><i class="dot a"></i> Anx.</span>
                                <span><i class="dot s"></i> Str.</span>
                            </div>
                        </div>

                        <div class="history-list">
                            <h4>Past Records</h4>
                            <?php foreach (array_reverse($history) as $record): ?>
                                <div class="history-item">
                                    <div class="hist-date"><?= date('F d, Y', strtotime($record['created_at'])) ?></div>
                                    <div class="hist-summary">Score: <?= $record['total_score'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const DASS_QUESTIONS = [
    { q: "I found it hard to wind down", cat: "stress" },
    { q: "I was aware of dryness of my mouth", cat: "anxiety" },
    { q: "I couldn't seem to experience any positive feeling at all", cat: "depression" },
    { q: "I experienced breathing difficulty", cat: "anxiety" },
    { q: "I found it difficult to work up the initiative to do things", cat: "depression" },
    { q: "I tended to over-react to situations", cat: "stress" },
    { q: "I experienced trembling (e.g. in the hands)", cat: "anxiety" },
    { q: "I felt that I was using a lot of nervous energy", cat: "stress" },
    { q: "I was worried about situations in which I might panic", cat: "anxiety" },
    { q: "I felt that I had nothing to look forward to", cat: "depression" },
    { q: "I found myself getting agitated", cat: "stress" },
    { q: "I found it difficult to relax", cat: "stress" },
    { q: "I felt down-hearted and blue", cat: "depression" },
    { q: "I was intolerant of anything that kept me from getting on with what I was doing", cat: "stress" },
    { q: "I felt I was close to panic", cat: "anxiety" },
    { q: "I was unable to become enthusiastic about anything", cat: "depression" },
    { q: "I felt I wasn't worth much as a person", cat: "depression" },
    { q: "I felt that I was rather touchy", cat: "stress" },
    { q: "I was aware of the action of my heart in the absence of physical exertion", cat: "anxiety" },
    { q: "I felt scared without any good reason", cat: "anxiety" },
    { q: "I felt that life was meaningless", cat: "depression" }
];

const OPTIONS = [
    { text: "Did not apply to me at all", val: 0 },
    { text: "Applied to me to some degree", val: 1 },
    { text: "Applied to me to a considerable degree", val: 2 },
    { text: "Applied to me very much", val: 3 }
];

const app = {
    currIndex: 0,
    answers: [],
    scores: { depression: 0, anxiety: 0, stress: 0 },

    start() {
        document.getElementById('quiz-intro').style.display = 'none';
        document.getElementById('quiz-questions').style.display = 'block';
        this.renderQuestion();
    },

    renderQuestion() {
        const q = DASS_QUESTIONS[this.currIndex];
        document.getElementById('question-text').textContent = q.q;
        document.getElementById('progress-text').textContent = `Question ${this.currIndex + 1} of 21`;
        document.getElementById('progress-fill').style.width = `${((this.currIndex + 1) / 21) * 100}%`;
        document.getElementById('curr-idx').textContent = this.currIndex + 1;
        document.getElementById('prev-btn').disabled = this.currIndex === 0;

        const container = document.getElementById('options-container');
        container.innerHTML = '';
        OPTIONS.forEach(opt => {
            const btn = document.createElement('button');
            btn.className = 'option-btn';
            btn.textContent = opt.text;
            if (this.answers[this.currIndex]?.val === opt.val) btn.classList.add('selected');
            btn.onclick = () => this.select(opt.val);
            container.appendChild(btn);
        });
    },

    select(val) {
        this.answers[this.currIndex] = {
            val: val,
            cat: DASS_QUESTIONS[this.currIndex].cat
        };
        
        setTimeout(() => {
            if (this.currIndex < 20) {
                this.currIndex++;
                this.renderQuestion();
            } else {
                this.finish();
            }
        }, 300);
    },

    prev() {
        if (this.currIndex > 0) {
            this.currIndex--;
            this.renderQuestion();
        }
    },

    async finish() {
        // Calculate
        this.scores = { depression: 0, anxiety: 0, stress: 0 };
        this.answers.forEach(a => this.scores[a.cat] += a.val);

        // UI Results
        document.getElementById('quiz-questions').style.display = 'none';
        document.getElementById('quiz-results').style.display = 'block';

        // Helper for clinical labels with wellness terminology
        const getLabel = (cat, score) => {
            const s = score * 2;
            const scales = {
                dep: [9, 13, 20, 27],
                anx: [7, 9, 14, 19],
                str: [14, 18, 25, 33]
            };
            const labels = ['Steady', 'Gentle Awareness', 'Mindful Focus', 'Priority Care', 'Support Essential'];
            
            const key = cat === 'depression' ? 'dep' : (cat === 'anxiety' ? 'anx' : 'str');
            const thresholds = scales[key];
            
            for (let i = 0; i < thresholds.length; i++) {
                if (s <= thresholds[i]) return labels[i];
            }
            return labels[4]; // Extremely Severe
        };

        const getRecommendations = () => {
            const top = Object.keys(this.scores).reduce((a, b) => this.scores[a] > this.scores[b] ? a : b);
            const list = [];
            
            if (top === 'depression') {
                list.push({icon: 'fa-feather-pen', text: 'Try a Gratitude Journal entry to shift your focus to small wins.'});
                list.push({icon: 'fa-sun', text: 'Aim for 10 minutes of morning sunlight to boost natural mood energy.'});
                list.push({icon: 'fa-users', text: 'Reach out to one friend today; social connection is vital for vitality.'});
            } else if (top === 'anxiety') {
                list.push({icon: 'fa-wind', text: 'Practice the 4-7-8 Breathing technique to soothe your nervous system.'});
                list.push({icon: 'fa-hand-dots', text: 'Use our 5-4-3-2-1 Grounding tool if you feel overwhelmed.'});
                list.push({icon: 'fa-coffee', text: 'Consider reducing caffeine intake to maintain a calm physical state.'});
            } else if (top === 'stress') {
                list.push({icon: 'fa-calendar-check', text: 'Break down your tasks into smaller, manageable "micro-goals".'});
                list.push({icon: 'fa-person-running', text: 'Even a 5-minute walk can help burn off excess cortisol (stress hormone).'});
                list.push({icon: 'fa-moon', text: 'Prioritize a "digital sunset" 30 minutes before bed to reset your balance.'});
            }
            
            const html = list.map(item => `
                <div class="rec-item">
                    <i class="fas ${item.icon}"></i>
                    <span>${item.text}</span>
                </div>
            `).join('');
            document.getElementById('quiz-recommendations').innerHTML = html;
        };

        // Set scores and labels
        document.getElementById('res-d-score').textContent = this.scores.depression * 2;
        document.getElementById('res-d-val').textContent = getLabel('depression', this.scores.depression);
        
        document.getElementById('res-a-score').textContent = this.scores.anxiety * 2;
        document.getElementById('res-a-val').textContent = getLabel('anxiety', this.scores.anxiety);
        
        document.getElementById('res-s-score').textContent = this.scores.stress * 2;
        document.getElementById('res-s-val').textContent = getLabel('stress', this.scores.stress);

        // Populate Recommendations
        getRecommendations();

        // Fetch backends
        try {
            const res = await fetch('/MindHeaven/public/ug/quiz/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(this.scores)
            });
            const result = await res.json();
        } catch (e) {
            console.error('Failed to save', e);
        }
    }
};
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
