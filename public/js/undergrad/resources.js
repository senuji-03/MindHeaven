// Resources Page JavaScript
(function() {
  'use strict';

  // Modal elements
  const breathingModal = document.getElementById('breathingModal');
  const groundingModal = document.getElementById('groundingModal');
  const closeBreathingModal = document.getElementById('closeBreathingModal');
  const closeGroundingModal = document.getElementById('closeGroundingModal');

  // Breathing exercise elements
  const breathingCircle = document.getElementById('breathingCircle');
  const breathingText = document.getElementById('breathingText');
  const startBreathing = document.getElementById('startBreathing');
  const stopBreathing = document.getElementById('stopBreathing');

  // Grounding exercise elements
  const groundingStep = document.getElementById('groundingStep');
  const stepNumber = document.getElementById('stepNumber');
  const stepTitle = document.getElementById('stepTitle');
  const stepDescription = document.getElementById('stepDescription');
  const stepInput = document.getElementById('stepInput');
  const nextStep = document.getElementById('nextStep');
  const groundingProgress = document.getElementById('groundingProgress');
  const groundingProgressText = document.getElementById('groundingProgressText');

  // Breathing exercise state
  let breathingInterval;
  let breathingPhase = 'inhale'; // inhale, hold, exhale, pause
  let breathingCycle = 0;
  let isBreathingActive = false;

  // Grounding exercise state
  let currentGroundingStep = 1;
  const groundingSteps = [
    {
      number: 1,
      title: '5 Things You Can See',
      description: 'Look around and name 5 things you can see. Take your time and really notice the details.',
      placeholder: 'Type what you see...'
    },
    {
      number: 2,
      title: '4 Things You Can Touch',
      description: 'Name 4 things you can physically touch. Feel their texture and temperature.',
      placeholder: 'Type what you can touch...'
    },
    {
      number: 3,
      title: '3 Things You Can Hear',
      description: 'Listen carefully and identify 3 sounds around you.',
      placeholder: 'Type what you hear...'
    },
    {
      number: 4,
      title: '2 Things You Can Smell',
      description: 'Take a deep breath and notice 2 different smells.',
      placeholder: 'Type what you smell...'
    },
    {
      number: 5,
      title: '1 Thing You Can Taste',
      description: 'Notice 1 thing you can taste right now.',
      placeholder: 'Type what you taste...'
    }
  ];

  // Initialize page
  function init() {
    setupEventListeners();
    updateGroundingStep();
  }

  // Setup event listeners
  function setupEventListeners() {
    // Modal close buttons
    if (closeBreathingModal) {
      closeBreathingModal.addEventListener('click', closeBreathingExercise);
    }
    if (closeGroundingModal) {
      closeGroundingModal.addEventListener('click', closeGroundingExercise);
    }

    // Breathing exercise controls
    if (startBreathing) {
      startBreathing.addEventListener('click', startBreathingExercise);
    }
    if (stopBreathing) {
      stopBreathing.addEventListener('click', stopBreathingExercise);
    }

    // Grounding exercise controls
    if (nextStep) {
      nextStep.addEventListener('click', nextGroundingStep);
    }
    if (stepInput) {
      stepInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          nextGroundingStep();
        }
      });
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('modal')) {
        closeModal(e.target);
      }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        if (breathingModal && breathingModal.classList.contains('open')) {
          closeBreathingExercise();
        }
        if (groundingModal && groundingModal.classList.contains('open')) {
          closeGroundingExercise();
        }
      }
    });
  }

  // Breathing exercise functions
  function startBreathingExercise() {
    isBreathingActive = true;
    breathingCycle = 0;
    breathingPhase = 'inhale';
    
    startBreathing.style.display = 'none';
    stopBreathing.style.display = 'inline-block';
    
    updateBreathingDisplay();
    breathingInterval = setInterval(updateBreathingCycle, 1000);
  }

  function stopBreathingExercise() {
    isBreathingActive = false;
    clearInterval(breathingInterval);
    
    breathingCircle.classList.remove('expand');
    breathingText.textContent = 'Exercise stopped. Click Start to begin again.';
    
    startBreathing.style.display = 'inline-block';
    stopBreathing.style.display = 'none';
  }

  function updateBreathingCycle() {
    if (!isBreathingActive) return;

    const cycle = breathingCycle % 8; // 8-second cycle: 4 inhale, 4 exhale
    
    if (cycle < 4) {
      // Inhale phase
      breathingPhase = 'inhale';
      breathingCircle.classList.add('expand');
      breathingText.textContent = 'Breathe In...';
    } else {
      // Exhale phase
      breathingPhase = 'exhale';
      breathingCircle.classList.remove('expand');
      breathingText.textContent = 'Breathe Out...';
    }
    
    breathingCycle++;
  }

  function updateBreathingDisplay() {
    if (breathingPhase === 'inhale') {
      breathingText.textContent = 'Breathe In...';
    } else {
      breathingText.textContent = 'Breathe Out...';
    }
  }

  function closeBreathingExercise() {
    stopBreathingExercise();
    closeModal(breathingModal);
  }

  // Grounding exercise functions
  function updateGroundingStep() {
    const step = groundingSteps[currentGroundingStep - 1];
    
    stepNumber.textContent = step.number;
    stepTitle.textContent = step.title;
    stepDescription.textContent = step.description;
    stepInput.placeholder = step.placeholder;
    stepInput.value = '';
    
    // Update progress
    const progress = (currentGroundingStep / groundingSteps.length) * 100;
    groundingProgress.style.width = progress + '%';
    groundingProgressText.textContent = `Step ${currentGroundingStep} of ${groundingSteps.length}`;
    
    // Focus on input
    stepInput.focus();
  }

  function nextGroundingStep() {
    if (currentGroundingStep < groundingSteps.length) {
      currentGroundingStep++;
      updateGroundingStep();
    } else {
      // Exercise complete
      completeGroundingExercise();
    }
  }

  function completeGroundingExercise() {
    stepTitle.textContent = 'Exercise Complete!';
    stepDescription.textContent = 'Great job! You\'ve completed the 5-4-3-2-1 grounding technique. How do you feel now?';
    stepInput.style.display = 'none';
    nextStep.textContent = 'Close';
    nextStep.onclick = closeGroundingExercise;
    
    groundingProgress.style.width = '100%';
    groundingProgressText.textContent = 'Complete!';
  }

  function closeGroundingExercise() {
    currentGroundingStep = 1;
    stepInput.style.display = 'block';
    nextStep.textContent = 'Next';
    nextStep.onclick = nextGroundingStep;
    closeModal(groundingModal);
  }

  // Modal utility functions
  function openModal(modal) {
    if (modal) {
      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeModal(modal) {
    if (modal) {
      modal.classList.remove('open');
      document.body.style.overflow = 'auto';
    }
  }

  // Global functions for onclick handlers
  window.openBreathingExercise = function() {
    openModal(breathingModal);
  };

  window.openGroundingExercise = function() {
    openModal(groundingModal);
    updateGroundingStep();
  };

  window.openGratitudePractice = function() {
    // Placeholder for gratitude practice
    alert('Gratitude Practice feature coming soon!');
  };

  window.openThoughtChallenge = function() {
    // Placeholder for thought challenge
    alert('Thought Challenge feature coming soon!');
  };

  window.openStressAssessment = function() {
    // Placeholder for stress assessment
    alert('Stress Assessment feature coming soon!');
  };

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();

