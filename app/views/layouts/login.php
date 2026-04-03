<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In — MindHeaven</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    <style>
        /* ── Design System Tokens ── */
        :root {
            --primary: #3D8B6E;
            --primary-dark: #2A6B52;
            --primary-light: #6BB89A;
            --accent-warm: #E8A87C;
            --accent-calm: #A8C5DA;
            --bg-deep: #1C2B2A;
            --bg-soft: #F5F0E8;
            --bg-mid: #EEF6F2;
            --text-primary: #1E3A34;
            --text-secondary: #6B8C7E;
            --surface: #FFFFFF;
            --crisis: #D64F4F;
            --success: #4CAF82;
            --border: #D6E4DD;
            --shadow-sm: 0 1px 3px rgba(30,58,52,0.06);
            --shadow-md: 0 4px 12px rgba(30,58,52,0.08);
            --shadow-lg: 0 12px 32px rgba(30,58,52,0.10);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-full: 9999px;
        }

        /* ── Reset ── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            background: var(--bg-mid);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        /* ── Layout: Split Panel ── */
        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left Panel — Decorative ── */
        .auth-panel {
            background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        /* Floating circles */
        .auth-panel::before {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            top: -80px;
            left: -80px;
            animation: float 10s ease-in-out infinite;
        }

        .auth-panel::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -40px;
            right: -40px;
            animation: float 8s ease-in-out infinite reverse;
        }

        .panel-circle-accent {
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(232,168,124,0.12);
            top: 30%;
            right: 10%;
            animation: float 12s ease-in-out infinite 2s;
        }

        .panel-circle-calm {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(168,197,218,0.1);
            bottom: 25%;
            left: 15%;
            animation: float 9s ease-in-out infinite 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.04); }
        }

        .panel-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            max-width: 380px;
        }

        .panel-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            margin-bottom: 40px;
        }

        .panel-logo .logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .panel-heading {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .panel-text {
            font-size: 0.95rem;
            opacity: 0.8;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .panel-features {
            list-style: none;
            text-align: left;
        }

        .panel-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            opacity: 0.85;
            margin-bottom: 14px;
        }

        .panel-features li i {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        /* ── Right Panel — Form ── */
        .auth-form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background: var(--surface);
        }

        .auth-form-container {
            width: 100%;
            max-width: 400px;
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            transition: color 0.2s ease;
        }

        .auth-back:hover {
            color: var(--primary);
        }

        .auth-form-header {
            margin-bottom: 32px;
        }

        .auth-form-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .auth-form-header p {
            font-size: 0.92rem;
            color: var(--text-secondary);
        }

        /* ── Alerts ── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.87rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.5;
        }

        .alert i { margin-top: 2px; flex-shrink: 0; }

        .alert-error {
            background: #fef2f2;
            color: var(--crisis);
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--surface);
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61,139,110,0.12);
        }

        .form-input::placeholder {
            color: var(--text-secondary);
            opacity: 0.65;
        }

        .form-input-icon {
            position: relative;
        }

        .form-input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .form-input-icon .form-input {
            padding-left: 40px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .form-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .form-link {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .form-link:hover {
            color: var(--primary-dark);
        }

        /* ── Button ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 24px;
            border-radius: var(--radius-full);
            font-family: inherit;
            font-weight: 600;
            font-size: 0.92rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(61,139,110,0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 24px 0;
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Footer ── */
        .auth-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 0.88rem;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: var(--primary-dark);
        }

        .auth-crisis {
            margin-top: 24px;
            padding: 12px 16px;
            background: #fef2f2;
            border-radius: var(--radius-sm);
            text-align: center;
            font-size: 0.82rem;
            color: var(--crisis);
        }

        .auth-crisis a {
            color: var(--crisis);
            font-weight: 600;
            text-decoration: underline;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
            }

            .auth-panel {
                display: none;
            }

            .auth-form-panel {
                padding: 32px 24px;
                min-height: 100vh;
                background: linear-gradient(180deg, var(--bg-mid) 0%, var(--surface) 30%);
            }

            .auth-form-container {
                max-width: 440px;
            }

            /* Show mobile brand */
            .mobile-brand {
                display: flex;
            }
        }

        @media (min-width: 901px) {
            .mobile-brand {
                display: none;
            }
        }

        .mobile-brand {
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 32px;
        }

        .mobile-brand .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <!-- Left Decorative Panel -->
        <div class="auth-panel">
            <div class="panel-circle-accent"></div>
            <div class="panel-circle-calm"></div>
            <div class="panel-content">
                <a href="<?= BASE_URL ?>/" class="panel-logo">
                    <span class="logo-icon"><i class="fas fa-leaf"></i></span>
                    MindHeaven
                </a>
                <h2 class="panel-heading">Welcome back.<br>We're glad you're here.</h2>
                <p class="panel-text">Your safe space for mental wellness. Pick up right where you left off.</p>
                <ul class="panel-features">
                    <li><i class="fas fa-calendar-check"></i> Manage your counseling sessions</li>
                    <li><i class="fas fa-chart-line"></i> Track mood & daily habits</li>
                    <li><i class="fas fa-comments"></i> Reconnect with the community</li>
                    <li><i class="fas fa-shield-alt"></i> 100% private & confidential</li>
                </ul>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="auth-form-panel">
            <div class="auth-form-container">
                <!-- Mobile-only brand -->
                <a href="<?= BASE_URL ?>/" class="mobile-brand">
                    <span class="logo-icon"><i class="fas fa-leaf"></i></span>
                    MindHeaven
                </a>

                <!-- Back link -->
                <a href="<?= BASE_URL ?>/" class="auth-back">
                    <i class="fas fa-arrow-left"></i> Back to home
                </a>

                <!-- Header -->
                <div class="auth-form-header">
                    <h1>Log in to your account</h1>
                    <p>Enter your credentials to access your dashboard</p>
                </div>

                <!-- Error Alert -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= $error ?></span>
                    </div>
                <?php endif; ?>

                <!-- Success Alert -->
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= htmlspecialchars($success) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="<?= BASE_URL ?>/login/authenticate">
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="form-input-icon">
                            <i class="fas fa-user"></i>
                            <input class="form-input" type="text" id="username" name="username"
                                placeholder="Enter your username"
                                value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"
                                required autocomplete="username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-input-icon">
                            <i class="fas fa-lock"></i>
                            <input class="form-input" type="password" id="password" name="password"
                                placeholder="Enter your password"
                                required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-checkbox">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                        <a href="<?= BASE_URL ?>/login/forgot-password" class="form-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </button>
                </form>

                <div class="divider">or</div>

                <!-- Footer -->
                <div class="auth-footer">
                    Don't have an account? <a href="<?= BASE_URL ?>/signup">Sign up for free</a>
                </div>

                <!-- Crisis link -->
                <div class="auth-crisis">
                    <i class="fas fa-phone-alt"></i>
                    Need help now? <a href="<?= BASE_URL ?>/public/crisis">Access crisis support</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
