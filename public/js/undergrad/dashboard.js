// Dashboard JavaScript
(function() {
  'use strict';

  // Chart instances
  let habitChart = null;
  let moodChart = null;

  // Initialize dashboard
  function init() {
    setupEventListeners();
    loadDashboardData();
    initializeCharts();
  }

  // Setup event listeners
  function setupEventListeners() {
    // Mood logging
    const quickMoodBtn = document.getElementById('quickMoodBtn');
    const logMoodBtn = document.getElementById('logMoodBtn');
    const moodModal = document.getElementById('moodModal');
    const closeMoodModal = document.getElementById('closeMoodModal');
    const cancelMoodLog = document.getElementById('cancelMoodLog');
    const saveMoodLog = document.getElementById('saveMoodLog');

    if (quickMoodBtn) {
      quickMoodBtn.addEventListener('click', openMoodModal);
    }
    if (logMoodBtn) {
      logMoodBtn.addEventListener('click', openMoodModal);
    }
    if (closeMoodModal) {
      closeMoodModal.addEventListener('click', closeMoodModal);
    }
    if (cancelMoodLog) {
      cancelMoodLog.addEventListener('click', closeMoodModal);
    }
    if (saveMoodLog) {
      saveMoodLog.addEventListener('click', saveMoodEntry);
    }

    // Mood selector
    const moodOptions = document.querySelectorAll('.mood-option');
    moodOptions.forEach(option => {
      option.addEventListener('click', selectMood);
    });

    // Time filters
    const habitTimeFilter = document.getElementById('habitTimeFilter');
    const moodTimeFilter = document.getElementById('moodTimeFilter');

    if (habitTimeFilter) {
      habitTimeFilter.addEventListener('change', updateHabitChart);
    }
    if (moodTimeFilter) {
      moodTimeFilter.addEventListener('change', updateMoodChart);
    }

    // Close modal on outside click
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('modal')) {
        closeModal(e.target);
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const openModal = document.querySelector('.modal.open');
        if (openModal) {
          closeModal(openModal);
        }
      }
    });
  }

  // Load dashboard data
  function loadDashboardData() {
    // Load today's mood
    loadTodayMood();
    
    // Load habit progress
    loadHabitProgress();
    
    // Load appointment info
    loadAppointmentInfo();
  }

  // Load today's mood
  function loadTodayMood() {
    const today = new Date().toISOString().split('T')[0];
    const moods = JSON.parse(localStorage.getItem('moods') || '{}');
    const todayMood = moods[today];

    const currentMoodEmoji = document.getElementById('currentMoodEmoji');
    const currentMoodText = document.getElementById('currentMoodText');
    const moodTime = document.getElementById('moodTime');

    if (todayMood) {
      if (currentMoodEmoji) currentMoodEmoji.textContent = todayMood.emoji;
      if (currentMoodText) currentMoodText.textContent = todayMood.mood;
      if (moodTime) moodTime.textContent = `Last logged: ${formatTime(todayMood.timestamp)}`;
    } else {
      if (currentMoodEmoji) currentMoodEmoji.textContent = '😐';
      if (currentMoodText) currentMoodText.textContent = 'Not logged today';
      if (moodTime) moodTime.textContent = 'Last logged: Never';
    }
  }

  // Load habit progress
  function loadHabitProgress() {
    const habits = JSON.parse(localStorage.getItem('habits') || '[]');
    const today = new Date().toISOString().split('T')[0];
    const todayHabits = JSON.parse(localStorage.getItem('todayHabits') || '{}');
    const completedHabits = todayHabits[today] || [];

    const totalHabits = habits.length;
    const completedCount = completedHabits.length;
    const completionRate = totalHabits > 0 ? Math.round((completedCount / totalHabits) * 100) : 0;

    // Update progress display
    const todayProgress = document.getElementById('todayProgress');
    const todayCompletion = document.getElementById('todayCompletion');
    
    if (todayProgress) {
      todayProgress.style.width = completionRate + '%';
    }
    if (todayCompletion) {
      todayCompletion.textContent = `${completedCount}/${totalHabits} completed`;
    }

    // Update hero stats
    const totalHabitsEl = document.getElementById('totalHabits');
    const completionRateEl = document.getElementById('completionRate');
    
    if (totalHabitsEl) totalHabitsEl.textContent = totalHabits;
    if (completionRateEl) completionRateEl.textContent = completionRate + '%';
  }

  // Load appointment info
  function loadAppointmentInfo() {
    const appointments = JSON.parse(localStorage.getItem('appointments') || '[]');
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const nextAppointment = appointments.find(apt => {
      const aptDate = new Date(apt.date);
      return aptDate >= today && apt.status === 'scheduled';
    });

    // Update appointment display if needed
    // This would update the appointment info in the dashboard
  }

  // Initialize charts
  function initializeCharts() {
    initializeHabitChart();
    initializeMoodChart();
  }

  // Initialize habit chart
  function initializeHabitChart() {
    const ctx = document.getElementById('habitChart');
    if (!ctx) return;

    const habitData = generateHabitData(30);
    
    habitChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: habitData.labels,
        datasets: [{
          label: 'Habit Completion Rate',
          data: habitData.data,
          borderColor: 'rgb(99, 102, 241)',
          backgroundColor: 'rgba(99, 102, 241, 0.1)',
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: {
              callback: function(value) {
                return value + '%';
              }
            }
          }
        }
      }
    });
  }

  // Initialize mood chart
  function initializeMoodChart() {
    const ctx = document.getElementById('moodChart');
    if (!ctx) return;

    const moodData = generateMoodData(30);
    
    moodChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: moodData.labels,
        datasets: [{
          label: 'Mood Score',
          data: moodData.data,
          borderColor: 'rgb(16, 185, 129)',
          backgroundColor: 'rgba(16, 185, 129, 0.1)',
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 10,
            ticks: {
              callback: function(value) {
                return value;
              }
            }
          }
        }
      }
    });
  }

  // Generate habit data
  function generateHabitData(days) {
    const labels = [];
    const data = [];
    const today = new Date();

    for (let i = days - 1; i >= 0; i--) {
      const date = new Date(today);
      date.setDate(date.getDate() - i);
      const dateStr = date.toISOString().split('T')[0];
      
      labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
      
      // Get habit completion for this date
      const todayHabits = JSON.parse(localStorage.getItem('todayHabits') || '{}');
      const completedHabits = todayHabits[dateStr] || [];
      const totalHabits = JSON.parse(localStorage.getItem('habits') || '[]').length;
      
      const completionRate = totalHabits > 0 ? Math.round((completedHabits.length / totalHabits) * 100) : 0;
      data.push(completionRate);
    }

    return { labels, data };
  }

  // Generate mood data
  function generateMoodData(days) {
    const labels = [];
    const data = [];
    const today = new Date();

    for (let i = days - 1; i >= 0; i--) {
      const date = new Date(today);
      date.setDate(date.getDate() - i);
      const dateStr = date.toISOString().split('T')[0];
      
      labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
      
      // Get mood for this date
      const moods = JSON.parse(localStorage.getItem('moods') || '{}');
      const mood = moods[dateStr];
      
      if (mood && mood.intensity) {
        data.push(mood.intensity);
      } else {
        data.push(null);
      }
    }

    return { labels, data };
  }

  // Update habit chart
  function updateHabitChart() {
    const filter = document.getElementById('habitTimeFilter');
    const days = parseInt(filter.value);
    
    if (habitChart) {
      const data = generateHabitData(days);
      habitChart.data.labels = data.labels;
      habitChart.data.datasets[0].data = data.data;
      habitChart.update();
    }
  }

  // Update mood chart
  function updateMoodChart() {
    const filter = document.getElementById('moodTimeFilter');
    const days = parseInt(filter.value);
    
    if (moodChart) {
      const data = generateMoodData(days);
      moodChart.data.labels = data.labels;
      moodChart.data.datasets[0].data = data.data;
      moodChart.update();
    }
  }

  // Mood modal functions
  function openMoodModal() {
    const modal = document.getElementById('moodModal');
    if (modal) {
      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeMoodModal() {
    const modal = document.getElementById('moodModal');
    if (modal) {
      modal.classList.remove('open');
      document.body.style.overflow = 'auto';
    }
  }

  function selectMood(e) {
    // Remove previous selection
    document.querySelectorAll('.mood-option').forEach(option => {
      option.classList.remove('selected');
    });
    
    // Add selection to clicked option
    e.currentTarget.classList.add('selected');
  }

  function saveMoodEntry() {
    const selectedMood = document.querySelector('.mood-option.selected');
    const intensity = document.getElementById('moodIntensity').value;
    const notes = document.getElementById('moodNotes').value;

    if (!selectedMood) {
      alert('Please select a mood');
      return;
    }

    const mood = {
      mood: selectedMood.dataset.mood,
      emoji: selectedMood.dataset.emoji,
      intensity: parseInt(intensity),
      notes: notes,
      timestamp: new Date().toISOString()
    };

    // Save to localStorage
    const today = new Date().toISOString().split('T')[0];
    const moods = JSON.parse(localStorage.getItem('moods') || '{}');
    moods[today] = mood;
    localStorage.setItem('moods', JSON.stringify(moods));

    // Update display
    loadTodayMood();
    
    // Close modal
    closeMoodModal();
    
    // Show success message
    showToast('Mood logged successfully!');
  }

  // Utility functions
  function formatTime(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleTimeString('en-US', { 
      hour: 'numeric', 
      minute: '2-digit',
      hour12: true 
    });
  }

  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.remove();
    }, 3000);
  }

  function closeModal(modal) {
    if (modal) {
      modal.classList.remove('open');
      document.body.style.overflow = 'auto';
    }
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();