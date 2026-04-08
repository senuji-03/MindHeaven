<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'MindHeaven — Mental Health Support for Students'; ?></title>
    <meta name="description" content="MindHeaven provides free, confidential mental health support, counseling, and community for undergraduate students.">

    <!-- Fonts & Icons (Design System §17) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Root (§1, §4, §5) ── */
        :root {
            --primary:        #3D8B6E;
            --primary-dark:   #2A6B52;
            --primary-light:  #6BB89A;
            --accent-warm:    #E8A87C;
            --accent-calm:    #A8C5DA;
            --bg-deep:        #1C2B2A;
            --bg-soft:        #F5F0E8;
            --bg-mid:         #EEF6F2;
            --text-primary:   #1E3A34;
            --text-secondary: #6B8C7E;
            --surface:        #FFFFFF;
            --border:         #D6E4DD;
            --crisis:         #D64F4F;
            --success:        #4CAF82;

            --shadow-sm: 0 1px 3px rgba(30,58,52,0.06);
            --shadow-md: 0 4px 12px rgba(30,58,52,0.08);
            --shadow-lg: 0 12px 32px rgba(30,58,52,0.10);
            --shadow-xl: 0 20px 48px rgba(30,58,52,0.12);

            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-xl:   28px;
            --radius-full: 9999px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 1rem;
            line-height: 1.7;
            color: var(--text-primary);
            background: var(--surface);
            overflow-x: hidden;
        }

        /* ── Container (§3) ── */
        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── Navbar (§10) ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 16px 0;
            background: rgba(255,255,255,0.70);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            background: rgba(255,255,255,0.95);
            border-bottom-color: var(--border);
            box-shadow: var(--shadow-sm);
            padding: 12px 0;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: -0.3px;
        }
        .brand-icon {
            width: 32px; height: 32px;
            background: var(--primary);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 0.9rem;
        }
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 7px 14px;
            border-radius: var(--radius-full);
            transition: color 0.2s ease, background 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-dark);
            background: var(--bg-mid);
        }
        .navbar-actions { display: flex; align-items: center; gap: 10px; }

        /* ── Buttons (§6) ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius-full);
            font-family: inherit;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.28s ease;
            white-space: nowrap;
            line-height: 1;
        }
        .btn-lg { padding: 14px 32px; font-size: 0.95rem; }
        .btn-sm { padding: 8px 18px; font-size: 0.85rem; }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(61,139,110,0.30);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--border);
        }
        .btn-outline:hover {
            border-color: var(--primary);
            background: var(--bg-mid);
        }
        .btn-ghost {
            background: rgba(255,255,255,0.15);
            color: white;
            border: 1.5px solid rgba(255,255,255,0.30);
        }
        .btn-ghost:hover { background: rgba(255,255,255,0.25); }
        .btn-white { background: white; color: var(--primary-dark); }
        .btn-white:hover { background: var(--bg-soft); transform: translateY(-1px); box-shadow: var(--shadow-md); }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { background: #3a9e6e; transform: translateY(-1px); }
        .btn-danger { background: var(--crisis); color: white; }
        .btn-danger:hover { background: #bf3f3f; transform: translateY(-1px); }

        /* Donate / Crisis nav pills */
        .btn-nav-donate {
            background: rgba(76,175,130,0.12);
            color: var(--success);
            border: 1.5px solid rgba(76,175,130,0.25);
            padding: 7px 16px;
            font-size: 0.85rem;
        }
        .btn-nav-donate:hover { background: var(--success); color: white; }
        .btn-nav-crisis {
            background: rgba(214,79,79,0.10);
            color: var(--crisis);
            border: 1.5px solid rgba(214,79,79,0.22);
            padding: 7px 16px;
            font-size: 0.85rem;
        }
        .btn-nav-crisis:hover { background: var(--crisis); color: white; }

        /* Profile dropdown */
        .profile-dropdown { position: relative; }
        .btn-profile {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 14px;
            border-radius: var(--radius-full);
            background: var(--bg-mid);
            border: 1.5px solid var(--border);
            cursor: pointer;
            font-family: inherit;
            font-size: 0.88rem; font-weight: 600;
            color: var(--text-primary);
            transition: all 0.2s ease;
        }
        .btn-profile:hover { border-color: var(--primary); background: var(--surface); }
        .profile-menu {
            position: absolute; top: calc(100% + 8px); right: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            min-width: 190px;
            display: none;
            z-index: 1001;
            overflow: hidden;
        }
        .profile-menu.show { display: block; }
        .profile-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 16px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.88rem;
            transition: background 0.15s ease;
        }
        .profile-item i { color: var(--primary); width: 16px; }
        .profile-item:hover { background: var(--bg-mid); }
        .profile-divider { height: 1px; background: var(--border); margin: 4px 0; }

        /* Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            border-radius: var(--radius-sm);
            background: none;
            border: none;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: var(--text-primary);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* ── Main content offset ── */
        .main-content { margin-top: 72px; }

        /* ── Sections (§13) ── */
        .section        { padding: 80px 0; background: var(--surface); }
        .section--alt   { padding: 80px 0; background: var(--bg-mid); }
        .section--cream { padding: 80px 0; background: var(--bg-soft); }

        /* ── Section Header (§12) ── */
        .section-header { text-align: center; margin-bottom: 48px; }
        .section-label {
            display: inline-block;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--primary);
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
            line-height: 1.25;
            margin-bottom: 12px;
        }
        .section-subtitle {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 540px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── Cards (§7) ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px 24px;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }
        .card-icon {
            width: 48px; height: 48px;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem;
            margin-bottom: 18px;
            color: white;
        }
        .card-icon--teal    { background: var(--primary); }
        .card-icon--apricot { background: var(--accent-warm); }
        .card-icon--sky     { background: var(--accent-calm); color: var(--text-primary); }
        .card-icon--mint    { background: var(--success); }
        .card-icon--red     { background: var(--crisis); }
        .card-icon--forest  { background: var(--primary-dark); }

        /* ── Grids (§9) ── */
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }

        /* ── Animations (§14) ── */
        .animate-on-scroll {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        body.js-loaded .animate-on-scroll {
            opacity: 0;
            transform: translateY(28px);
        }
        body.js-loaded .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .stagger-children .animate-on-scroll:nth-child(1) { transition-delay: 0s; }
        .stagger-children .animate-on-scroll:nth-child(2) { transition-delay: 0.07s; }
        .stagger-children .animate-on-scroll:nth-child(3) { transition-delay: 0.14s; }
        .stagger-children .animate-on-scroll:nth-child(4) { transition-delay: 0.21s; }
        .stagger-children .animate-on-scroll:nth-child(5) { transition-delay: 0.28s; }
        .stagger-children .animate-on-scroll:nth-child(6) { transition-delay: 0.35s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-16px) scale(1.03); }
        }

        /* ── Footer (§11) ── */
        .footer {
            background: var(--bg-deep);
            padding: 72px 0 0;
        }
        .footer .container { display: block; }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 56px;
        }
        .footer-brand-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 12px;
        }
        .footer-brand-icon {
            width: 28px; height: 28px;
            background: var(--primary);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; color: white;
        }
        .footer-desc {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            max-width: 260px;
        }
        .footer-heading {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.9);
            margin-bottom: 16px;
        }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.50);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-links a:hover { color: white; }
        .footer-contact-item {
            display: flex; align-items: center; gap: 9px;
            font-size: 0.88rem;
            color: rgba(255,255,255,0.50);
            margin-bottom: 10px;
        }
        .footer-contact-item i { color: var(--primary-light); font-size: 0.8rem; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .footer-copy { font-size: 0.82rem; color: rgba(255,255,255,0.35); }
        .footer-legal { display: flex; gap: 20px; }
        .footer-legal a { font-size: 0.82rem; color: rgba(255,255,255,0.35); text-decoration: none; transition: color 0.2s; }
        .footer-legal a:hover { color: rgba(255,255,255,0.7); }

        /* ── Responsive (§16) ── */
        @media (max-width: 1024px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
        }
        @media (max-width: 768px) {
            .navbar-nav, .navbar-actions .btn-nav-donate,
            .navbar-actions .btn-nav-crisis { display: none; }
            .hamburger { display: flex; }
            .section, .section--alt, .section--cream { padding: 56px 0; }
            .section-title { font-size: 1.8rem; }
            .grid-3, .grid-2, .grid-4 { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 28px; }
            .mobile-menu {
                display: flex;
                flex-direction: column;
                gap: 4px;
                padding: 16px 24px 20px;
                border-top: 1px solid var(--border);
                background: var(--surface);
            }
        }
        @media (max-width: 480px) {
            .btn-lg { padding: 12px 24px; font-size: 0.9rem; width: 100%; }
            .section-title { font-size: 1.6rem; }
        }

        /* Mobile menu */
        .mobile-menu { display: none; }
        .mobile-menu .nav-link {
            padding: 10px 14px;
            font-size: 0.95rem;
            border-radius: var(--radius-sm);
            display: block;
        }
        .mobile-menu-actions {
            display: flex; gap: 8px;
            padding: 8px 0 4px;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <!-- ── Navigation (§10) ── -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                <div class="brand-icon"><i class="fas fa-leaf"></i></div>
                MindHeaven
            </a>

            <div class="navbar-nav">
                <a href="<?php echo BASE_URL; ?>/" class="nav-link active">Home</a>
                <a href="<?php echo BASE_URL; ?>/ug/resources" class="nav-link">Resources</a>
                <a href="<?php echo BASE_URL; ?>/forum" class="nav-link">Forum</a>
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-nav-donate btn-sm"><i class="fas fa-heart"></i> Donate</a>
                <a href="<?php echo BASE_URL; ?>/ug/crisis" class="btn btn-nav-crisis btn-sm"><i class="fas fa-phone-alt"></i> Crisis</a>
            </div>

            <div class="navbar-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="profile-dropdown">
                        <button class="btn-profile" onclick="toggleProfileDropdown()" id="profileBtn">
                            <i class="fas fa-user-circle" style="color:var(--primary);"></i>
                            <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                            <i class="fas fa-chevron-down" style="font-size:0.7rem;"></i>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <a href="<?php echo BASE_URL; ?>/ug" class="profile-item"><i class="fas fa-th-large"></i> Dashboard</a>
                            <a href="<?php echo BASE_URL; ?>/ug/profile" class="profile-item"><i class="fas fa-user"></i> My Profile</a>
                            <div class="profile-divider"></div>
                            <a href="<?php echo BASE_URL; ?>/logout" class="profile-item" style="color:var(--crisis);"><i class="fas fa-sign-out-alt" style="color:var(--crisis);"></i> Log Out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-sm">Log In</a>
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary btn-sm">Sign Up</a>
                <?php endif; ?>

                <button class="hamburger" id="hamburger" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <!-- Mobile dropdown -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="<?php echo BASE_URL; ?>/" class="nav-link">Home</a>
            <a href="<?php echo BASE_URL; ?>/ug/resources" class="nav-link">Resources</a>
            <a href="<?php echo BASE_URL; ?>/forum" class="nav-link">Forum</a>
            <div class="mobile-menu-actions">
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-nav-donate btn-sm"><i class="fas fa-heart"></i> Donate</a>
                <a href="<?php echo BASE_URL; ?>/ug/crisis" class="btn btn-nav-crisis btn-sm"><i class="fas fa-phone-alt"></i> Crisis</a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-sm">Log In</a>
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary btn-sm">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- ── Main Content ── -->
    <main class="main-content">
        <?php echo $content; ?>
    </main>

    <!-- ── Footer (§11) ── -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand-name">
                        <div class="footer-brand-icon"><i class="fas fa-leaf"></i></div>
                        MindHeaven
                    </div>
                    <p class="footer-desc">Free, confidential mental health support built for university students. Your wellness is our mission.</p>
                </div>
                <div>
                    <p class="footer-heading">Platform</p>
                    <ul class="footer-links">
                        <li><a href="<?php echo BASE_URL; ?>/">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ug/resources">Resource Hub</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/forum">Forum</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/donation">Donate</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer-heading">Support</p>
                    <ul class="footer-links">
                        <li><a href="<?php echo BASE_URL; ?>/ug/crisis">Crisis Support</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/signup">Create Account</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/login">Log In</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer-heading">Contact</p>
                    <div class="footer-contact-item"><i class="fas fa-envelope"></i> support@mindheaven.edu</div>
                    <div class="footer-contact-item"><i class="fas fa-phone"></i> +1 (555) 123-HELP</div>
                    <div class="footer-contact-item"><i class="fas fa-clock"></i> 24/7 Crisis Line</div>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">&copy; <?php echo date('Y'); ?> MindHeaven. All rights reserved.</span>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // ── Navbar scroll effect ──
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        });

        // ── Profile dropdown ──
        function toggleProfileDropdown() {
            document.getElementById('profileMenu')?.classList.toggle('show');
        }
        window.addEventListener('click', (e) => {
            if (!e.target.closest('.profile-dropdown')) {
                document.getElementById('profileMenu')?.classList.remove('show');
            }
        });

        // ── Mobile menu ──
        let mobileOpen = false;
        function toggleMobileMenu() {
            mobileOpen = !mobileOpen;
            const m = document.getElementById('mobileMenu');
            const h = document.getElementById('hamburger');
            m.style.display = mobileOpen ? 'flex' : 'none';
            h.setAttribute('aria-expanded', mobileOpen);
        }

        // ── Scroll reveal animations (§14) ──
        document.body.classList.add('js-loaded');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>
</body>
</html>