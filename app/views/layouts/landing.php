<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'MindHeaven - Mental Health Care for Students'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #06b6d4;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
            scrollbar-width: thin;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-md);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
            background: rgba(79, 70, 229, 0.1);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
            border: none;
        }

        .btn-primary { background: var(--primary-color); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        
        .btn-outline { background: transparent; color: var(--primary-color); border: 2px solid var(--primary-color); }
        .btn-outline:hover { background: var(--primary-color); color: white; }

        .btn-donate { background: var(--success-color); color: white; }
        .btn-donate:hover { background: #059669; transform: translateY(-1px); }

        .btn-crisis { background: var(--danger-color); color: white; }
        .btn-crisis:hover { background: #dc2626; transform: translateY(-1px); }

        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .btn-profile {
            background: transparent;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            min-width: 180px;
            display: none;
            margin-top: 0.5rem;
            z-index: 1000;
        }
        .profile-menu.show { display: block; }
        .profile-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: background 0.2s;
        }
        .profile-item:hover { background: var(--light-color); }

        /* Main Content */
        .main-content { margin-top: 80px; }

        /* Footer */
        .footer { background: var(--dark-color); color: white; padding: 4rem 0 2rem; }
        .footer-content { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem; margin-bottom: 3rem; }
        .footer-section h5 { color: white; font-size: 1.1rem; margin-bottom: 1.5rem; }
        .footer-section p, .footer-section a { color: #94a3b8; text-decoration: none; font-size: 0.95rem; }
        .footer-section a:hover { color: white; }
        .footer-bottom { border-top: 1px solid #334155; padding-top: 2rem; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; color: #64748b; font-size: 0.9rem; }

        @media (max-width: 768px) {
            .navbar-nav { display: none; }
            .navbar-actions { gap: 0.5rem; }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                <i class="fas fa-leaf"></i> MindHeaven
            </a>

            <div class="navbar-nav">
                <a href="<?php echo BASE_URL; ?>/" class="nav-link active">Home</a>
                <a href="<?php echo BASE_URL; ?>/ug/resources" class="nav-link">Resources</a>
                <a href="<?php echo BASE_URL; ?>/forum" class="nav-link">Forum</a>
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-donate">Donate</a>
                <a href="<?php echo BASE_URL; ?>/ug/crisis" class="btn btn-crisis">Crisis Support</a>
            </div>

            <div class="navbar-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="profile-dropdown">
                        <button class="btn-profile" onclick="toggleProfileDropdown()">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <a href="<?php echo BASE_URL; ?>/ug" class="profile-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            <a href="<?php echo BASE_URL; ?>/ug/profile" class="profile-item"><i class="fas fa-user"></i> Profile</a>
                            <a href="<?php echo BASE_URL; ?>/logout" class="profile-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
            <div class="footer-content">
                <div class="footer-section">
                    <h5>MindHeaven</h5>
                    <p>Comprehensive mental health support for university students. Your wellness is our mission.</p>
                </div>
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <p><a href="<?php echo BASE_URL; ?>/">Home</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/ug/resources">Resource Hub</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/forum">Forum Discussion</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/donation">Donate</a></p>
                </div>
                <div class="footer-section">
                    <h5>Support</h5>
                    <p><a href="<?php echo BASE_URL; ?>/ug/crisis">Crisis Support</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/signup">Create Account</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/login">Log In</a></p>
                </div>
                <div class="footer-section">
                    <h5>Contact</h5>
                    <p><i class="fas fa-envelope"></i> support@mindheaven.edu</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-HELP</p>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> MindHeaven. All rights reserved.</span>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a> &middot; <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Profile dropdown
        function toggleProfileDropdown() {
            document.getElementById('profileMenu').classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                document.getElementById('profileMenu').classList.remove('show');
            }
        });
    </script>
</body>
</html>