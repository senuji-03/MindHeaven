// assets/js/main.js - Modern Sidebar Navigation
(function(){
  // Sidebar functionality
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const mainWrapper = document.querySelector('.main-wrapper');
  const backToTop = document.getElementById('backToTop');

  // Sidebar toggle functionality
  function toggleSidebar() {
    if (sidebar && mainWrapper) {
      sidebar.classList.toggle('collapsed');
      mainWrapper.classList.toggle('sidebar-collapsed');
      
      // Save preference
      const isCollapsed = sidebar.classList.contains('collapsed');
      localStorage.setItem('sidebarCollapsed', isCollapsed);
    }
  }

  // Mobile menu toggle
  function toggleMobileMenu() {
    if (sidebar) {
      sidebar.classList.toggle('open');
      const isOpen = sidebar.classList.contains('open');
      mobileMenuToggle.setAttribute('aria-expanded', isOpen);
      
      // Prevent body scroll when menu is open
      document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    }
  }

  // Initialize sidebar state
  function initializeSidebar() {
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed && sidebar && mainWrapper) {
      sidebar.classList.add('collapsed');
      mainWrapper.classList.add('sidebar-collapsed');
    }
  }

  // Back to top functionality
  function handleBackToTop() {
    if (backToTop) {
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      
      if (scrollTop > 300) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
    }
  }

  // Scroll to top
  function scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }

  // Theme toggle functionality
  function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update theme toggle icon
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
      const icon = themeToggle.querySelector('.btn-icon');
      if (icon) {
        icon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
      }
    }
  }

  // Initialize theme
  function initializeTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
      const icon = themeToggle.querySelector('.btn-icon');
      if (icon) {
        icon.textContent = savedTheme === 'dark' ? '☀️' : '🌙';
      }
    }
  }

  // Event listeners
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', toggleSidebar);
  }

  if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', toggleMobileMenu);
  }

  if (backToTop) {
    backToTop.addEventListener('click', scrollToTop);
  }

  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', toggleTheme);
  }

  // Scroll event for back to top button
  window.addEventListener('scroll', handleBackToTop);

  // Close mobile menu when clicking outside
  document.addEventListener('click', (e) => {
    if (sidebar && sidebar.classList.contains('open')) {
      const isClickInsideSidebar = sidebar.contains(e.target);
      const isClickOnMobileToggle = mobileMenuToggle && mobileMenuToggle.contains(e.target);
      
      if (!isClickInsideSidebar && !isClickOnMobileToggle) {
        sidebar.classList.remove('open');
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = 'auto';
      }
    }
  });

  // Close mobile menu on escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      mobileMenuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = 'auto';
    }
  });

  // Handle window resize
  window.addEventListener('resize', () => {
    if (window.innerWidth > 900 && sidebar) {
      sidebar.classList.remove('open');
      if (mobileMenuToggle) {
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
      }
      document.body.style.overflow = 'auto';
    }
  });

  // Initialize everything when DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    initializeSidebar();
    initializeTheme();
    handleBackToTop();
  });

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Add loading states to buttons
  document.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', function() {
      if (this.form && this.form.checkValidity()) {
        this.classList.add('loading');
        this.disabled = true;
        
        // Re-enable after a delay (for demo purposes)
        setTimeout(() => {
          this.classList.remove('loading');
          this.disabled = false;
        }, 2000);
      }
    });
  });

})();
