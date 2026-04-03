<?php
$TITLE = 'MindHeaven - Habits';
$CURRENT_PAGE = 'habits';

require BASE_PATH . '/app/views/layouts/header.php';
?>

<style>
  :root {
    --primary: #3D8B6E;
    --primary-dark: #2A6B52;
    --primary-light: #6BB89A;
    --surface: #FFFFFF;
    --bg-mid: #EEF6F2;
    --text-primary: #1E3A34;
    --text-secondary: #6B8C7E;
    --border: #D6E4DD;
    --shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);
    --radius-lg: 20px;
    --radius-md: 12px;
  }

  .habits-main {
    padding: 30px;
    max-width: 1000px;
    margin: 0 auto;
    font-family: inherit;
  }

  .habits-hero {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
    color: white;
    padding: 40px;
    border-radius: var(--radius-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow-md);
    margin-bottom: 40px;
  }

  .hero-text h1 {
    font-size: 2rem;
    margin-bottom: 10px;
  }

  .hero-text p {
    opacity: 0.9;
  }

  .btn {
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
  }

  .btn-primary {
    background: white;
    color: var(--primary-dark);
    font-size: 1rem;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }

  .btn-submit {
    background: var(--primary);
    color: white;
    width: 100%;
    margin-top: 10px;
  }

  .btn-submit:hover {
    background: var(--primary-dark);
  }

  /* Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(5px);
    display: none; 
    align-items: center; justify-content: center;
    z-index: 9999;
  }

  .modal-overlay.active {
    display: flex; /* triggers visibility */
  }

  .modal-content {
    background: white;
    width: 100%;
    max-width: 450px;
    border-radius: var(--radius-lg);
    padding: 30px;
    position: relative;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
  }

  .close-btn {
    position: absolute;
    top: 20px; right: 20px;
    background: none; border: none;
    font-size: 1.5rem; color: var(--text-secondary);
    cursor: pointer;
  }

  .modal-title {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block; margin-bottom: 5px;
    font-weight: 600; color: var(--text-primary);
  }

  .form-control {
    width: 100%; padding: 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 1rem;
  }
</style>

<div class="habits-main">
  <!-- Hero Section -->
  <div class="habits-hero">
    <div class="hero-text">
      <h1>Your Habit Dashboard</h1>
      <p>Log your activities and build a better routine.</p>
    </div>
    <button class="btn btn-primary" onclick="openHabitModal()">
      + Add Habit
    </button>
  </div>
</div>

<!-- Modal Popup -->
<div class="modal-overlay" id="addHabitModal">
  <div class="modal-content">
    <button class="close-btn" onclick="closeHabitModal()">X</button>
    <h2 class="modal-title">Add New Habit</h2>
    
    <form id="addHabitForm">
      <div class="form-group">
        <label>Habit Name</label>
        <input type="text" id="habitName" name="name" class="form-control" placeholder="e.g. Drink Water" required>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select id="habitCategory" name="category" class="form-control" required>
          <option value="health">Health</option>
          <option value="fitness">Fitness</option>
          <option value="learning">Learning</option>
          <option value="mindfulness">Mindfulness</option>
        </select>
      </div>

      <div class="form-group">
        <label>Description (Optional)</label>
        <textarea id="habitDesc" name="description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
      </div>

      <div class="form-group">
        <label>Frequency</label>
        <select id="habitFrequency" name="frequency" class="form-control" required onchange="toggleTargetDays()">
          <option value="daily">Daily</option>
          <option value="weekly">Weekly</option>
        </select>
      </div>

      <div class="form-group" id="targetDaysGroup" style="display: none;">
        <label>Target Days per Week</label>
        <input type="number" id="habitTargetDays" name="target_days" class="form-control" min="1" max="7" value="1">
      </div>

      <div class="form-group">
        <label>Color</label>
        <input type="color" id="habitColor" name="color" class="form-control" value="#10b981" style="height:45px; padding:5px;">
      </div>

      <div class="form-group">
        <label>Icon (Emoji)</label>
        <input type="text" id="habitIcon" name="icon" class="form-control" placeholder="e.g. 🎯" value="🎯">
      </div>

      <button type="submit" class="btn btn-submit" id="submitHabitBtn">Save Habit</button>
    </form>
  </div>
</div>

<!-- Integrated Scripts for Modal & Submission -->
<script>
  const habitModal = document.getElementById('addHabitModal');
  const addHabitForm = document.getElementById('addHabitForm');
  const submitHabitBtn = document.getElementById('submitHabitBtn');

  function openHabitModal() {
    habitModal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Stop background scrolling
  }

  function closeHabitModal() {
    habitModal.classList.remove('active');
    document.body.style.overflow = 'auto'; // Restore background scrolling
    addHabitForm.reset();
  }

  function toggleTargetDays() {
    const frequency = document.getElementById('habitFrequency').value;
    const targetGroup = document.getElementById('targetDaysGroup');
    if (frequency === 'weekly') {
      targetGroup.style.display = 'block';
    } else {
      targetGroup.style.display = 'none';
      document.getElementById('habitTargetDays').value = 1;
    }
  }

  // Handle Form Submission smoothly
  addHabitForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    submitHabitBtn.textContent = 'Saving...';
    submitHabitBtn.disabled = true;

    // Gather JSON payload based on database schema requirements
    const payload = {
      name: document.getElementById('habitName').value,
      category: document.getElementById('habitCategory').value,
      description: document.getElementById('habitDesc').value,
      frequency: document.getElementById('habitFrequency').value,
      target_days: document.getElementById('habitTargetDays').value,
      color: document.getElementById('habitColor').value,
      icon: document.getElementById('habitIcon').value
    };

    try {
      // Send secure request directly to backend API file
      const response = await fetch('/MindHeaven/app/controllers/HabitApiControl.php?action=create', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error || 'Unknown backend error.');
      }

      alert('Habit successfully saved to your database!');
      closeHabitModal();

      // Optionally reload here to render new habits once you build a render loop
      window.location.reload(); 

    } catch (error) {
      alert('Error saving habit:\n\n' + error.message);
      console.error('Submission Error:', error);
    } finally {
      submitHabitBtn.textContent = 'Save Habit';
      submitHabitBtn.disabled = false;
    }
  });

  // Also close modal if they click outside the white card
  window.onclick = function(event) {
    if (event.target == habitModal) {
      closeHabitModal();
    }
  }
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
