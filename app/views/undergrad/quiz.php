<?php
require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>📋 Mental Health Self-Assessment</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/ug">Home</a></li>
        <li class="breadcrumb-item active">Self-Assessment Quiz</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div id="quizContainer">
              <div id="quizIntro" class="quiz-section">
                <div class="quiz-intro">
                  <h4>Welcome to the Mental Health Self-Assessment</h4>
                  <p>This quiz will help you understand your current mental health status. Please answer honestly for the most accurate results.</p>
                  <div class="quiz-info">
                    <div class="info-item">
                      <span class="info-icon">⏱️</span>
                      <span>Duration: 5-10 minutes</span>
                    </div>
                    <div class="info-item">
                      <span class="info-icon">🔒</span>
                      <span>Your answers are private</span>
                    </div>
                    <div class="info-item">
                      <span class="info-icon">📊</span>
                      <span>Get instant feedback</span>
                    </div>
                  </div>
                  <button class="btn btn-primary" onclick="startQuizQuestions()">Start Assessment</button>
                </div>
              </div>
              
              <div id="quizQuestions" class="quiz-section" style="display: none;">
                <div class="quiz-progress">
                  <div class="progress-bar">
                    <div class="progress-fill" id="quizProgress"></div>
                  </div>
                  <span class="progress-text" id="progressText">Question 1 of 10</span>
                </div>
                
                <div class="question-container">
                  <h4 class="question-title" id="questionTitle">How often do you feel anxious or worried?</h4>
                  <div class="question-options" id="questionOptions">
                    <!-- Options will be populated by JavaScript -->
                  </div>
                </div>
                
                <div class="quiz-navigation">
                  <button class="btn btn-outline" id="prevQuestion" onclick="previousQuestion()" style="display: none;">Previous</button>
                  <button class="btn btn-primary" id="nextQuestion" onclick="nextQuestion()">Next</button>
                </div>
              </div>
              
              <div id="quizResults" class="quiz-section" style="display: none;">
                <div class="results-container">
                  <div class="results-header">
                    <h4>Your Assessment Results</h4>
                    <div class="overall-score">
                      <div class="score-circle" id="overallScoreCircle">
                        <span class="score-number" id="overallScore">75</span>
                        <span class="score-label">/100</span>
                      </div>
                      <div class="score-description">
                        <h5 id="scoreTitle">Good Mental Health</h5>
                        <p id="scoreDescription">You're doing well overall with some areas for improvement.</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="results-breakdown">
                    <h5>Assessment Breakdown</h5>
                    <div class="breakdown-item">
                      <span class="breakdown-label">Anxiety Level</span>
                      <div class="breakdown-bar">
                        <div class="breakdown-fill" id="anxietyScore" style="width: 60%"></div>
                      </div>
                      <span class="breakdown-value">Moderate</span>
                    </div>
                    <div class="breakdown-item">
                      <span class="breakdown-label">Depression Risk</span>
                      <div class="breakdown-bar">
                        <div class="breakdown-fill" id="depressionScore" style="width: 30%"></div>
                      </div>
                      <span class="breakdown-value">Low</span>
                    </div>
                    <div class="breakdown-item">
                      <span class="breakdown-label">Stress Level</span>
                      <div class="breakdown-bar">
                        <div class="breakdown-fill" id="stressScore" style="width: 70%"></div>
                      </div>
                      <span class="breakdown-value">Moderate</span>
                    </div>
                  </div>
                  
                  <div class="recommendations">
                    <h5>Recommendations</h5>
                    <ul id="recommendationsList">
                      <li>Consider practicing mindfulness or meditation</li>
                      <li>Maintain regular sleep schedule</li>
                      <li>Engage in physical activity</li>
                      <li>Consider speaking with a counselor if symptoms persist</li>
                    </ul>
                  </div>
                  
                  <div class="results-actions">
                    <button class="btn btn-primary" onclick="retakeQuiz()">Retake Quiz</button>
                    <a href="<?php echo BASE_URL; ?>/ug" class="btn btn-outline">Back to Dashboard</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
/* Quiz Styles */
.quiz-section {
  min-height: 400px;
}

.quiz-intro {
  text-align: center;
  padding: 2rem;
}

.quiz-intro h4 {
  color: #1f2937;
  margin-bottom: 1rem;
}

.quiz-intro p {
  color: #6b7280;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.quiz-info {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 2rem;
}

.quiz-info .info-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #6b7280;
}

.info-icon {
  font-size: 1.2rem;
}

.quiz-progress {
  margin-bottom: 2rem;
}

.progress-text {
  display: block;
  text-align: center;
  margin-top: 0.5rem;
  color: #6b7280;
  font-size: 0.9rem;
}

.question-container {
  margin-bottom: 2rem;
}

.question-title {
  color: #1f2937;
  margin-bottom: 1.5rem;
  font-size: 1.2rem;
  line-height: 1.5;
}

.question-options {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.option-btn {
  padding: 1rem;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  background: white;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: left;
  font-size: 1rem;
}

.option-btn:hover {
  border-color: #4f46e5;
  background: #f0f9ff;
}

.option-btn.selected {
  border-color: #4f46e5;
  background: #eef2ff;
  color: #4f46e5;
}

.quiz-navigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.results-container {
  padding: 1rem;
}

.results-header {
  text-align: center;
  margin-bottom: 2rem;
}

.results-header h4 {
  color: #1f2937;
  margin-bottom: 1.5rem;
}

.overall-score {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 2rem;
}

.score-circle {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: white;
  box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
}

.score-number {
  font-size: 2rem;
  font-weight: bold;
}

.score-label {
  font-size: 0.9rem;
  opacity: 0.8;
}

.score-description h5 {
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.score-description p {
  color: #6b7280;
  margin: 0;
}

.results-breakdown {
  margin-bottom: 2rem;
}

.results-breakdown h5 {
  color: #1f2937;
  margin-bottom: 1rem;
}

.breakdown-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.breakdown-label {
  min-width: 120px;
  color: #374151;
  font-weight: 500;
}

.breakdown-bar {
  flex: 1;
  height: 8px;
  background: #e5e7eb;
  border-radius: 4px;
  overflow: hidden;
}

.breakdown-fill {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #059669);
  transition: width 0.3s ease;
}

.breakdown-value {
  min-width: 80px;
  text-align: right;
  color: #6b7280;
  font-weight: 500;
}

.recommendations {
  margin-bottom: 2rem;
}

.recommendations h5 {
  color: #1f2937;
  margin-bottom: 1rem;
}

.recommendations ul {
  list-style: none;
  padding: 0;
}

.recommendations li {
  padding: 0.75rem;
  background: #f9fafb;
  border-left: 4px solid #4f46e5;
  margin-bottom: 0.5rem;
  border-radius: 0 4px 4px 0;
  color: #374151;
}

.results-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

@media (max-width: 768px) {
  .quiz-info {
    flex-direction: column;
    gap: 1rem;
  }
  
  .overall-score {
    flex-direction: column;
    gap: 1rem;
  }
  
  .breakdown-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  
  .breakdown-label {
    min-width: auto;
  }
  
  .breakdown-value {
    min-width: auto;
    text-align: left;
  }
}
</style>

<script>
// Quiz functionality
let currentQuestion = 0;
let quizAnswers = [];
let quizScores = { anxiety: 0, depression: 0, stress: 0 };

const quizQuestions = [
  {
    question: "How often do you feel anxious or worried?",
    options: [
      { text: "Never", value: 0, category: "anxiety" },
      { text: "Rarely", value: 1, category: "anxiety" },
      { text: "Sometimes", value: 2, category: "anxiety" },
      { text: "Often", value: 3, category: "anxiety" },
      { text: "Always", value: 4, category: "anxiety" }
    ]
  },
  {
    question: "How would you rate your overall mood today?",
    options: [
      { text: "Excellent", value: 0, category: "depression" },
      { text: "Good", value: 1, category: "depression" },
      { text: "Fair", value: 2, category: "depression" },
      { text: "Poor", value: 3, category: "depression" },
      { text: "Very Poor", value: 4, category: "depression" }
    ]
  },
  {
    question: "How well are you sleeping?",
    options: [
      { text: "Very well", value: 0, category: "stress" },
      { text: "Well", value: 1, category: "stress" },
      { text: "Okay", value: 2, category: "stress" },
      { text: "Poorly", value: 3, category: "stress" },
      { text: "Very poorly", value: 4, category: "stress" }
    ]
  },
  {
    question: "How often do you feel overwhelmed by daily tasks?",
    options: [
      { text: "Never", value: 0, category: "stress" },
      { text: "Rarely", value: 1, category: "stress" },
      { text: "Sometimes", value: 2, category: "stress" },
      { text: "Often", value: 3, category: "stress" },
      { text: "Always", value: 4, category: "stress" }
    ]
  },
  {
    question: "How often do you feel sad or hopeless?",
    options: [
      { text: "Never", value: 0, category: "depression" },
      { text: "Rarely", value: 1, category: "depression" },
      { text: "Sometimes", value: 2, category: "depression" },
      { text: "Often", value: 3, category: "depression" },
      { text: "Always", value: 4, category: "depression" }
    ]
  },
  {
    question: "How often do you experience panic attacks or intense fear?",
    options: [
      { text: "Never", value: 0, category: "anxiety" },
      { text: "Rarely", value: 1, category: "anxiety" },
      { text: "Sometimes", value: 2, category: "anxiety" },
      { text: "Often", value: 3, category: "anxiety" },
      { text: "Always", value: 4, category: "anxiety" }
    ]
  },
  {
    question: "How is your appetite?",
    options: [
      { text: "Normal", value: 0, category: "depression" },
      { text: "Slightly decreased", value: 1, category: "depression" },
      { text: "Moderately decreased", value: 2, category: "depression" },
      { text: "Significantly decreased", value: 3, category: "depression" },
      { text: "No appetite", value: 4, category: "depression" }
    ]
  },
  {
    question: "How often do you feel irritable or angry?",
    options: [
      { text: "Never", value: 0, category: "stress" },
      { text: "Rarely", value: 1, category: "stress" },
      { text: "Sometimes", value: 2, category: "stress" },
      { text: "Often", value: 3, category: "stress" },
      { text: "Always", value: 4, category: "stress" }
    ]
  },
  {
    question: "How often do you avoid social situations?",
    options: [
      { text: "Never", value: 0, category: "anxiety" },
      { text: "Rarely", value: 1, category: "anxiety" },
      { text: "Sometimes", value: 2, category: "anxiety" },
      { text: "Often", value: 3, category: "anxiety" },
      { text: "Always", value: 4, category: "anxiety" }
    ]
  },
  {
    question: "How would you rate your ability to concentrate?",
    options: [
      { text: "Excellent", value: 0, category: "depression" },
      { text: "Good", value: 1, category: "depression" },
      { text: "Fair", value: 2, category: "depression" },
      { text: "Poor", value: 3, category: "depression" },
      { text: "Very Poor", value: 4, category: "depression" }
    ]
  }
];

function startQuizQuestions() {
  document.getElementById('quizIntro').style.display = 'none';
  document.getElementById('quizQuestions').style.display = 'block';
  showQuestion();
}

function showQuestion() {
  const question = quizQuestions[currentQuestion];
  document.getElementById('questionTitle').textContent = question.question;
  
  const optionsContainer = document.getElementById('questionOptions');
  optionsContainer.innerHTML = '';
  
  question.options.forEach((option, index) => {
    const button = document.createElement('button');
    button.className = 'option-btn';
    button.textContent = option.text;
    button.onclick = () => selectOption(index);
    optionsContainer.appendChild(button);
  });
  
  updateProgress();
  updateNavigation();
}

function selectOption(optionIndex) {
  // Remove previous selection
  document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
  
  // Add selection to clicked option
  document.querySelectorAll('.option-btn')[optionIndex].classList.add('selected');
  
  // Store answer
  quizAnswers[currentQuestion] = optionIndex;
  
  // Enable next button
  document.getElementById('nextQuestion').disabled = false;
}

function updateProgress() {
  const progress = ((currentQuestion + 1) / quizQuestions.length) * 100;
  document.getElementById('quizProgress').style.width = progress + '%';
  document.getElementById('progressText').textContent = `Question ${currentQuestion + 1} of ${quizQuestions.length}`;
}

function updateNavigation() {
  const prevBtn = document.getElementById('prevQuestion');
  const nextBtn = document.getElementById('nextQuestion');
  
  prevBtn.style.display = currentQuestion > 0 ? 'block' : 'none';
  nextBtn.textContent = currentQuestion === quizQuestions.length - 1 ? 'Finish' : 'Next';
  nextBtn.disabled = quizAnswers[currentQuestion] === undefined;
}

function nextQuestion() {
  if (currentQuestion < quizQuestions.length - 1) {
    currentQuestion++;
    showQuestion();
  } else {
    calculateResults();
    showResults();
  }
}

function previousQuestion() {
  if (currentQuestion > 0) {
    currentQuestion--;
    showQuestion();
    
    // Restore previous selection
    if (quizAnswers[currentQuestion] !== undefined) {
      document.querySelectorAll('.option-btn')[quizAnswers[currentQuestion]].classList.add('selected');
    }
  }
}

function calculateResults() {
  // Reset scores
  quizScores = { anxiety: 0, depression: 0, stress: 0 };
  
  // Calculate category scores
  quizQuestions.forEach((question, index) => {
    const answerIndex = quizAnswers[index];
    if (answerIndex !== undefined) {
      const option = question.options[answerIndex];
      quizScores[option.category] += option.value;
    }
  });
  
  // Normalize scores to 0-100 scale
  const maxScores = { anxiety: 20, depression: 20, stress: 16 };
  Object.keys(quizScores).forEach(category => {
    quizScores[category] = Math.round((quizScores[category] / maxScores[category]) * 100);
  });
}

function showResults() {
  document.getElementById('quizQuestions').style.display = 'none';
  document.getElementById('quizResults').style.display = 'block';
  
  // Calculate overall score (lower is better)
  const overallScore = Math.round(100 - ((quizScores.anxiety + quizScores.depression + quizScores.stress) / 3));
  
  // Update overall score
  document.getElementById('overallScore').textContent = overallScore;
  
  // Update score description
  const scoreTitle = document.getElementById('scoreTitle');
  const scoreDescription = document.getElementById('scoreDescription');
  
  if (overallScore >= 80) {
    scoreTitle.textContent = 'Excellent Mental Health';
    scoreDescription.textContent = 'You\'re doing great! Keep up the good work with your mental health practices.';
  } else if (overallScore >= 60) {
    scoreTitle.textContent = 'Good Mental Health';
    scoreDescription.textContent = 'You\'re doing well overall with some areas for improvement.';
  } else if (overallScore >= 40) {
    scoreTitle.textContent = 'Moderate Concerns';
    scoreDescription.textContent = 'You may benefit from additional support and self-care practices.';
  } else {
    scoreTitle.textContent = 'Consider Professional Help';
    scoreDescription.textContent = 'It may be helpful to speak with a mental health professional.';
  }
  
  // Update breakdown scores
  updateBreakdownScore('anxietyScore', quizScores.anxiety);
  updateBreakdownScore('depressionScore', quizScores.depression);
  updateBreakdownScore('stressScore', quizScores.stress);
  
  // Update recommendations
  updateRecommendations();
}

function updateBreakdownScore(elementId, score) {
  const element = document.getElementById(elementId);
  const parent = element.parentElement;
  const valueElement = parent.nextElementSibling;
  
  element.style.width = score + '%';
  
  let level = 'Low';
  if (score >= 70) level = 'High';
  else if (score >= 40) level = 'Moderate';
  
  valueElement.textContent = level;
}

function updateRecommendations() {
  const recommendations = [];
  
  if (quizScores.anxiety >= 50) {
    recommendations.push('Practice deep breathing exercises or meditation');
    recommendations.push('Consider mindfulness techniques');
  }
  
  if (quizScores.depression >= 50) {
    recommendations.push('Maintain regular sleep schedule');
    recommendations.push('Engage in physical activity daily');
    recommendations.push('Consider speaking with a counselor');
  }
  
  if (quizScores.stress >= 50) {
    recommendations.push('Practice time management techniques');
    recommendations.push('Take regular breaks throughout the day');
    recommendations.push('Consider stress-reduction activities');
  }
  
  if (recommendations.length === 0) {
    recommendations.push('Continue your current healthy practices');
    recommendations.push('Maintain regular self-care routines');
  }
  
  const list = document.getElementById('recommendationsList');
  list.innerHTML = recommendations.map(rec => `<li>${rec}</li>`).join('');
}

function retakeQuiz() {
  currentQuestion = 0;
  quizAnswers = [];
  quizScores = { anxiety: 0, depression: 0, stress: 0 };
  
  document.getElementById('quizIntro').style.display = 'block';
  document.getElementById('quizQuestions').style.display = 'none';
  document.getElementById('quizResults').style.display = 'none';
}
</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>
