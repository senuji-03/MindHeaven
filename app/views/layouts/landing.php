<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'MindHeaven - Mental Health Care for Students'; ?></title>
    <meta name="description"
        content="MindHeaven — comprehensive mental health support platform for undergraduate students. Counseling, mood tracking, resources, and 24/7 crisis support.">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap"
        rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/../app/views/layouts/styles/landing.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                <span class="logo-icon"><i class="fas fa-leaf"></i></span>
                MindHeaven
            </a>

            <button class="hamburger" id="hamburger" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="navbar-nav" id="navMenu">
                <a href="<?php echo BASE_URL; ?>/" class="nav-link active">Home</a>
                <a href="<?php echo BASE_URL; ?>/public/resources" class="nav-link">Resources</a>
                <a href="<?php echo BASE_URL; ?>/public/forum" class="nav-link">Forum</a>
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-donate">
                    <i class="fas fa-heart"></i> Donate
                </a>
                <a href="<?php echo BASE_URL; ?>/public/crisis" class="btn btn-crisis">
                    <i class="fas fa-phone-alt"></i> Crisis Support
                </a>
            </div>

            <div class="navbar-actions" id="navActions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="profile-dropdown">
                        <button class="btn btn-profile" onclick="toggleProfileDropdown()">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                            <i class="fas fa-chevron-down" style="font-size:0.7rem"></i>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <a href="<?php echo BASE_URL; ?>/ug" class="profile-item">
                                <i class="fas fa-columns"></i> Dashboard
                            </a>
                            <a href="<?php echo BASE_URL; ?>/ug/profile" class="profile-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="<?php echo BASE_URL; ?>/logout" class="profile-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">Log In</a>
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <?php echo $content; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="<?php echo BASE_URL; ?>/" class="navbar-brand" style="color:white;">
                        <span class="logo-icon"><i class="fas fa-leaf"></i></span>
                        MindHeaven
                    </a>
                    <p>Comprehensive mental health support for undergraduate students. Your wellness is our priority.
                    </p>
                </div>

                <div class="footer-section">
                    <h5>Platform</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo BASE_URL; ?>/">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/public/resources">Resource Hub</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/public/forum">Forum</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/donation">Donate</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5>Support</h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo BASE_URL; ?>/public/crisis">Crisis Support</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/signup">Create Account</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/login">Log In</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5>Contact</h5>
                    <ul class="footer-links">
                        <li><a href="mailto:support@mindheaven.edu"><i class="fas fa-envelope"
                                    style="width:16px;margin-right:6px;"></i>support@mindheaven.edu</a></li>
                        <li><a href="tel:+15551234567"><i class="fas fa-phone"
                                    style="width:16px;margin-right:6px;"></i>+1 (555) 123-HELP</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"
                                    style="width:16px;margin-right:6px;"></i>University Campus</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> MindHeaven. All rights reserved.</span>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Mobile menu
        function toggleMobileMenu() {
            const hamburger = document.getElementById('hamburger');
            const navMenu = document.getElementById('navMenu');
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('open');
        }

        // Profile dropdown
        function toggleProfileDropdown() {
            const menu = document.getElementById('profileMenu');
            if (menu) menu.classList.toggle('show');
        }

        document.addEventListener('click', (e) => {
            const dropdown = document.querySelector('.profile-dropdown');
            const menu = document.getElementById('profileMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // Scroll animations — progressive enhancement
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

        document.addEventListener('DOMContentLoaded', () => {
            // Mark body so CSS knows JS is active
            document.body.classList.add('js-loaded');
            const els = document.querySelectorAll('.animate-on-scroll');
            els.forEach(el => {
                observer.observe(el);
                // Immediately reveal elements already in viewport
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.classList.add('visible');
                }
            });
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                const t = document.querySelector(a.getAttribute('href'));
                if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>

</html>