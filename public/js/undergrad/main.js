// assets/js/main.js - Modern Sidebar Navigation
(function () {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const mainWrapper = document.querySelector('.main-wrapper');
  const backToTop = document.getElementById('backToTop');

  function toggleSidebar() {
    if (sidebar && mainWrapper && window.innerWidth <= 768) {
      sidebar.classList.toggle('collapsed');
      mainWrapper.classList.toggle('sidebar-collapsed');

      const isCollapsed = sidebar.classList.contains('collapsed');
      localStorage.setItem('sidebarCollapsed', isCollapsed);
    }
  }

  function toggleMobileMenu() {
    if (sidebar) {
      sidebar.classList.toggle('open');
      const isOpen = sidebar.classList.contains('open');
      mobileMenuToggle.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : 'auto';
    }
  }

  function initializeSidebar() {
    if (sidebar && mainWrapper) {
      if (window.innerWidth > 768) {
        sidebar.classList.remove('collapsed');
        mainWrapper.classList.remove('sidebar-collapsed');
        localStorage.removeItem('sidebarCollapsed');
      } else {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
          sidebar.classList.add('collapsed');
          mainWrapper.classList.add('sidebar-collapsed');
        }
      }
    }
  }

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

  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);

    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
      const icon = themeToggle.querySelector('.btn-icon');
      if (icon) {
        icon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
      }
    }
  }

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

  if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
  if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', toggleMobileMenu);
  if (backToTop) backToTop.addEventListener('click', scrollToTop);

  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) themeToggle.addEventListener('click', toggleTheme);

  window.addEventListener('scroll', handleBackToTop);

  document.addEventListener('click', (e) => {
    if (sidebar && sidebar.classList.contains('open')) {
      const inside = sidebar.contains(e.target);
      const toggle = mobileMenuToggle && mobileMenuToggle.contains(e.target);
      if (!inside && !toggle) {
        sidebar.classList.remove('open');
        mobileMenuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = 'auto';
      }
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      mobileMenuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = 'auto';
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 900 && sidebar) {
      sidebar.classList.remove('open');
      if (mobileMenuToggle) mobileMenuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = 'auto';
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    initializeSidebar();
    initializeTheme();
    handleBackToTop();
  });

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // ✅ CLEAN MERGE: keep uni-representative behavior
  document.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', function () {
      if (this.form && this.form.checkValidity()) {
        this.classList.add('loading');

        const btn = this;
        setTimeout(() => {
          btn.disabled = true;
        }, 0);

        setTimeout(() => {
          btn.classList.remove('loading');
          btn.disabled = false;
        }, 2000);
      }
    });
  });

})();