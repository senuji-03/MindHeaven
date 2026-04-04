<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — MindHeaven</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap"
        rel="stylesheet">
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
            --shadow-sm: 0 1px 3px rgba(30, 58, 52, 0.06);
            --shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);
            --shadow-lg: 0 12px 32px rgba(30, 58, 52, 0.10);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-full: 9999px;
        }

        /* ── Reset ── */
        *,
        *::before,
        *::after {
            margin: 0;
<<<<<<< HEAD
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.7;
            color: var(--text-primary);
            background: var(--bg-mid);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
=======
        }

        .signup-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            max-width: 90vw;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #374151;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
>>>>>>> origin/uni-representative
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ── Layout: Split Panel ── */
        .auth-wrapper {
            display: grid;
            grid-template-columns: 420px 1fr;
            min-height: 100vh;
        }

        /* ── Left Panel — Decorative (sticky) ── */
        .auth-panel {
            background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 36px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        /* Floating circles */
        .auth-panel::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            top: -80px;
            left: -60px;
            animation: float 10s ease-in-out infinite;
        }

        .auth-panel::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            bottom: -30px;
            right: -30px;
            animation: float 8s ease-in-out infinite reverse;
        }

        .panel-circle-accent {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(232, 168, 124, 0.12);
            top: 28%;
            right: 8%;
            animation: float 12s ease-in-out infinite 2s;
        }

        .panel-circle-calm {
            position: absolute;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(168, 197, 218, 0.1);
            bottom: 22%;
            left: 12%;
            animation: float 9s ease-in-out infinite 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.04);
            }
        }

        .panel-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            max-width: 340px;
        }

        .panel-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 40px;
        }

        .panel-logo .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .panel-heading {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .panel-text {
            font-size: 0.92rem;
            opacity: 0.8;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .panel-steps {
            list-style: none;
            text-align: left;
            counter-reset: step;
        }

        .panel-steps li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            font-size: 0.88rem;
            opacity: 0.85;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .panel-steps li .step-dot {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            margin-top: 1px;
        }

        /* ── Right Panel — Form ── */
        .auth-form-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 48px 48px 64px;
            background: var(--surface);
            overflow-y: auto;
        }

        .auth-form-container {
            width: 100%;
            max-width: 520px;
        }

        /* Mobile brand */
        .mobile-brand {
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 28px;
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

        @media (min-width: 901px) {
            .mobile-brand {
                display: none;
            }
        }

        @media (max-width: 900px) {
            .mobile-brand {
                display: flex;
            }
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 32px;
            transition: color 0.2s ease;
        }

        .auth-back:hover {
            color: var(--primary);
        }

        .auth-form-header {
            margin-bottom: 28px;
        }

        .auth-form-header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .auth-form-header p {
            font-size: 0.92rem;
            color: var(--text-secondary);
        }

        /* ── Step Indicator ── */
        .step-indicator {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 32px;
        }

        .step-indicator .step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .step-indicator .step.active {
            color: var(--primary);
        }

        .step-indicator .step.completed {
            color: var(--success);
        }

        .step-indicator .step .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .step-indicator .step.active .step-num {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .step-indicator .step.completed .step-num {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .step-connector {
            flex: 1;
            height: 2px;
            background: var(--border);
            margin: 0 12px;
        }

        .step-connector.active {
            background: var(--primary-light);
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

        .alert i {
            margin-top: 2px;
            flex-shrink: 0;
        }

        .alert-error {
            background: #fef2f2;
            color: var(--crisis);
            border: 1px solid #fecaca;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 16px;
        }

        .alert-error ul li {
            margin-bottom: 2px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-label .required {
            color: var(--crisis);
            margin-left: 2px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--surface);
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-secondary);
            opacity: 0.6;
        }

        .form-input.error-field,
        .form-select.error-field,
        .form-textarea.error-field {
            border-color: var(--crisis);
            box-shadow: 0 0 0 3px rgba(214, 79, 79, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236B8C7E' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .form-hint {
            font-size: 0.78rem;
            color: var(--text-secondary);
            margin-top: 4px;
            line-height: 1.4;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ── Role-specific sections ── */
        .role-section {
            background: var(--bg-mid);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px;
            margin-top: 8px;
            margin-bottom: 24px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .role-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .role-section-title i {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
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
            box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
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

<<<<<<< HEAD
        /* ── Footer ── */
        .auth-footer {
            text-align: center;
            margin-top: 24px;
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
=======
        .undergrad-fields,
        .counselor-fields {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #e5e7eb;
        }

        .undergrad-fields h3,
        .undergrad-fields h4,
        .counselor-fields h3,
        .counselor-fields h4 {
            color: #1f2937;
            margin-bottom: 15px;
        }

        .undergrad-fields h3,
        .counselor-fields h3 {
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
>>>>>>> origin/uni-representative
        }

        .auth-trust {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        .auth-trust span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .auth-trust i {
            color: var(--primary-light);
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
                padding: 32px 24px 48px;
                background: linear-gradient(180deg, var(--bg-mid) 0%, var(--surface) 15%);
            }
        }

<<<<<<< HEAD
        @media (max-width: 540px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .step-indicator .step span {
                display: none;
            }

            .auth-form-header h1 {
                font-size: 1.45rem;
            }
=======
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
>>>>>>> origin/uni-representative
        }
    </style>
</head>

<body>
<<<<<<< HEAD
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
                <h2 class="panel-heading">Start your<br>wellness journey</h2>
                <p class="panel-text">Join thousands of students who've chosen to prioritize their mental health.</p>
                <ol class="panel-steps">
                    <li>
                        <span class="step-dot">1</span>
                        Create your free account in under two minutes
                    </li>
                    <li>
                        <span class="step-dot">2</span>
                        Complete a quick wellness check-in
                    </li>
                    <li>
                        <span class="step-dot">3</span>
                        Access counseling, resources, and community support
                    </li>
                </ol>
=======
    <div class="signup-container">
        <h2>Create Account - MindHeaven</h2>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
>>>>>>> origin/uni-representative
            </div>
        </div>

<<<<<<< HEAD
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
                    <h1>Create your account</h1>
                    <p>Join MindHeaven — it's free, private, and takes less than 2 minutes.</p>
                </div>

                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" id="step1Indicator">
                        <span class="step-num">1</span>
                        <span>Account</span>
                    </div>
                    <div class="step-connector" id="connector1"></div>
                    <div class="step" id="step2Indicator">
                        <span class="step-num">2</span>
                        <span>Role</span>
                    </div>
                    <div class="step-connector" id="connector2"></div>
                    <div class="step" id="step3Indicator">
                        <span class="step-num">3</span>
                        <span>Details</span>
                    </div>
                </div>

                <!-- Error Alert -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
=======
        <form method="POST" action="<?= BASE_URL ?>/signup/register" id="signupForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                    value="<?= htmlspecialchars($form_data['username'] ?? '') ?>" placeholder="Choose a username"
                    required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
                    required>
            </div>

            <div class="form-group">
                <label for="role">Select Your Role</label>
                <select id="role" name="role" required>
                    <option value="">Choose your role...</option>
                    <option value="undergraduate" <?= ($form_data['role'] ?? '') === 'undergraduate' ? 'selected' : '' ?>>
                        Undergraduate Student
                    </option>
                    <option value="counselor" <?= ($form_data['role'] ?? '') === 'counselor' ? 'selected' : '' ?>>
                        Counselor
                    </option>
                </select>
                <div class="role-description">
                    Choose the role that best describes your position in the MindHeaven platform.
                </div>
            </div>

            <!-- Additional fields for Undergraduate Students -->
            <div id="undergradFields" class="undergrad-fields" style="display: none;">
                <h3 style="margin: 20px 0 15px 0; color: #1f2937; border-top: 2px solid #e5e7eb; padding-top: 15px;">
                    Student Information</h3>

                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name"
                        value="<?= htmlspecialchars($form_data['full_name'] ?? '') ?>"
                        placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email"
                        value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                        placeholder="your.email@university.edu">
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number *</label>
                    <input type="tel" id="phone_number" name="phone_number"
                        value="<?= htmlspecialchars($form_data['phone_number'] ?? '') ?>" placeholder="0718580160">
                </div>
>>>>>>> origin/uni-representative

                <!-- Sign Up Form -->
                <form method="POST" action="<?= BASE_URL ?>/signup/register" id="signupForm">

                    <!-- Account Fields -->
                    <div class="form-group">
<<<<<<< HEAD
                        <label class="form-label" for="username">Username <span class="required">*</span></label>
                        <div class="form-input-icon">
                            <i class="fas fa-user"></i>
                            <input class="form-input" type="text" id="username" name="username"
                                value="<?= htmlspecialchars($form_data['username'] ?? '') ?>"
                                placeholder="Choose a username" required autocomplete="username">
                        </div>
=======
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                            value="<?= htmlspecialchars($form_data['date_of_birth'] ?? '') ?>">
>>>>>>> origin/uni-representative
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-lock"></i>
                                <input class="form-input" type="password" id="password" name="password"
                                    placeholder="Create a password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm <span
                                    class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-lock"></i>
                                <input class="form-input" type="password" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm password" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-group">
<<<<<<< HEAD
                        <label class="form-label" for="role">I am a... <span class="required">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Choose your role</option>
                            <option value="undergrad" <?= ($form_data['role'] ?? '') === 'undergrad' ? 'selected' : '' ?>>
                                Undergraduate Student
                            </option>
                            <option value="counselor" <?= ($form_data['role'] ?? '') === 'counselor' ? 'selected' : '' ?>>
                                Counselor / Therapist
                            </option>
=======
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select gender...</option>
                            <option value="male" <?= ($form_data['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male
                            </option>
                            <option value="female" <?= ($form_data['gender'] ?? '') === 'female' ? 'selected' : '' ?>>
                                Female</option>
                            <option value="other" <?= ($form_data['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other
                            </option>
                            <option value="prefer_not_to_say" <?= ($form_data['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefer not to say</option>
>>>>>>> origin/uni-representative
                        </select>
                        <div class="form-hint" id="roleDescription">
                            Select the role that best describes you on the MindHeaven platform.
                        </div>
                    </div>

                    <!-- ═══ Undergraduate Student Fields ═══ -->
                    <div id="undergradFields" class="role-section" style="display: none;">
                        <div class="role-section-title">
                            <i class="fas fa-graduation-cap"></i>
                            Student Information
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name <span class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-id-card"></i>
                                <input class="form-input" type="text" id="full_name" name="full_name"
                                    value="<?= htmlspecialchars($form_data['full_name'] ?? '') ?>"
                                    placeholder="Enter your full name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-envelope"></i>
                                <input class="form-input" type="email" id="email" name="email"
                                    value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                                    placeholder="2023is030@stu.ucsc.cmb.ac.lk">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone_number">Phone Number <span
                                    class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-phone"></i>
                                <input class="form-input" type="tel" id="phone_number" name="phone_number"
                                    value="<?= htmlspecialchars($form_data['phone_number'] ?? '') ?>"
                                    placeholder="0718580160">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="date_of_birth">Date of Birth</label>
                                <input class="form-input" type="date" id="date_of_birth" name="date_of_birth"
                                    value="<?= htmlspecialchars($form_data['date_of_birth'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Select...</option>
                                    <option value="male" <?= ($form_data['gender'] ?? '') === 'male' ? 'selected' : '' ?>>
                                        Male</option>
                                    <option value="female" <?= ($form_data['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                                    <option value="other" <?= ($form_data['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                                    <option value="prefer_not_to_say" <?= ($form_data['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ═══ Counselor Fields ═══ -->
                    <div id="counselorFields" class="role-section" style="display: none;">
                        <div class="role-section-title">
                            <i class="fas fa-user-md"></i>
                            Professional Information
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="counselor_full_name">Full Name <span
                                    class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-id-card"></i>
                                <input class="form-input" type="text" id="counselor_full_name"
                                    name="counselor_full_name"
                                    value="<?= htmlspecialchars($form_data['counselor_full_name'] ?? '') ?>"
                                    placeholder="Enter your full name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="counselor_email">Email <span
                                        class="required">*</span></label>
                                <div class="form-input-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input class="form-input" type="email" id="counselor_email" name="counselor_email"
                                        value="<?= htmlspecialchars($form_data['counselor_email'] ?? '') ?>"
                                        placeholder="your.email@example.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="counselor_phone">Phone <span
                                        class="required">*</span></label>
                                <div class="form-input-icon">
                                    <i class="fas fa-phone"></i>
                                    <input class="form-input" type="tel" id="counselor_phone" name="counselor_phone"
                                        value="<?= htmlspecialchars($form_data['counselor_phone'] ?? '') ?>"
                                        placeholder="0718580160">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="license_number">SLMC License # <span
                                        class="required">*</span></label>
                                <div class="form-input-icon">
                                    <i class="fas fa-certificate"></i>
                                    <input class="form-input" type="text" id="license_number" name="license_number"
                                        value="<?= htmlspecialchars($form_data['license_number'] ?? '') ?>"
                                        placeholder="License number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="years_experience">Experience</label>
                                <div class="form-input-icon">
                                    <i class="fas fa-briefcase"></i>
                                    <input class="form-input" type="number" id="years_experience"
                                        name="years_experience"
                                        value="<?= htmlspecialchars($form_data['years_experience'] ?? '') ?>"
                                        placeholder="Years" min="0" max="50">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="specialization">Specialization <span
                                    class="required">*</span></label>
                            <select class="form-select" id="specialization" name="specialization">
                                <option value="">Select your specialization...</option>
                                <option value="Clinical Psychology" <?= ($form_data['specialization'] ?? '') === 'Clinical Psychology' ? 'selected' : '' ?>>Clinical Psychology</option>
                                <option value="Counseling Psychology" <?= ($form_data['specialization'] ?? '') === 'Counseling Psychology' ? 'selected' : '' ?>>Counseling Psychology</option>
                                <option value="Marriage and Family Therapy" <?= ($form_data['specialization'] ?? '') === 'Marriage and Family Therapy' ? 'selected' : '' ?>>Marriage and Family Therapy
                                </option>
                                <option value="Substance Abuse Counseling" <?= ($form_data['specialization'] ?? '') === 'Substance Abuse Counseling' ? 'selected' : '' ?>>Substance Abuse Counseling
                                </option>
                                <option value="Trauma Therapy" <?= ($form_data['specialization'] ?? '') === 'Trauma Therapy' ? 'selected' : '' ?>>Trauma Therapy</option>
                                <option value="Child and Adolescent Therapy" <?= ($form_data['specialization'] ?? '') === 'Child and Adolescent Therapy' ? 'selected' : '' ?>>Child and Adolescent
                                    Therapy</option>
                                <option value="Cognitive Behavioral Therapy" <?= ($form_data['specialization'] ?? '') === 'Cognitive Behavioral Therapy' ? 'selected' : '' ?>>Cognitive Behavioral
                                    Therapy</option>
                                <option value="Group Therapy" <?= ($form_data['specialization'] ?? '') === 'Group Therapy' ? 'selected' : '' ?>>Group Therapy</option>
                                <option value="Crisis Intervention" <?= ($form_data['specialization'] ?? '') === 'Crisis Intervention' ? 'selected' : '' ?>>Crisis Intervention</option>
                                <option value="Psychiatric Social Work" <?= ($form_data['specialization'] ?? '') === 'Psychiatric Social Work' ? 'selected' : '' ?>>Psychiatric Social Work
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bio">Professional Bio</label>
                            <textarea class="form-textarea" id="bio" name="bio" rows="3"
                                placeholder="Tell us about your background and approach to counseling..."><?= htmlspecialchars($form_data['bio'] ?? '') ?></textarea>
                        </div>

                        <div class="alert alert-success" style="margin-bottom:0;">
                            <i class="fas fa-info-circle"></i>
                            <span>Counselor accounts require admin approval before activation. You'll be notified once
                                approved.</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Create Account
                    </button>
                </form>

                <div class="divider">or</div>

                <div class="auth-footer">
                    Already have an account? <a href="<?= BASE_URL ?>/login">Log in</a>
                </div>

                <div class="auth-trust">
                    <span><i class="fas fa-shield-alt"></i> Encrypted</span>
                    <span><i class="fas fa-lock"></i> Private</span>
                    <span><i class="fas fa-heart"></i> Free</span>
                </div>
            </div>
<<<<<<< HEAD
=======

            <!-- Additional fields for Counselors -->
            <div id="counselorFields" class="counselor-fields" style="display: none;">
                <h3 style="margin: 20px 0 15px 0; color: #1f2937; border-top: 2px solid #e5e7eb; padding-top: 15px;">
                    Counselor Information</h3>

                <div class="form-group">
                    <label for="counselor_full_name">Full Name *</label>
                    <input type="text" id="counselor_full_name" name="counselor_full_name"
                        value="<?= htmlspecialchars($form_data['counselor_full_name'] ?? '') ?>"
                        placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="counselor_email">Email Address *</label>
                    <input type="email" id="counselor_email" name="counselor_email"
                        value="<?= htmlspecialchars($form_data['counselor_email'] ?? '') ?>"
                        placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label for="counselor_phone">Phone Number *</label>
                    <input type="tel" id="counselor_phone" name="counselor_phone"
                        value="<?= htmlspecialchars($form_data['counselor_phone'] ?? '') ?>" placeholder="0718580160">
                </div>

                <div class="form-group">
                    <label for="license_number">SLMC License Number *</label>
                    <input type="text" id="license_number" name="license_number"
                        value="<?= htmlspecialchars($form_data['license_number'] ?? '') ?>"
                        placeholder="Enter your professional license number">
                </div>

                <div class="form-group">
                    <label for="specialization">Mental Health Specialization *</label>
                    <select id="specialization" name="specialization">
                        <option value="">Select your specialization...</option>
                        <option value="Clinical Psychology" <?= ($form_data['specialization'] ?? '') === 'Clinical Psychology' ? 'selected' : '' ?>>Clinical Psychology</option>
                        <option value="Counseling Psychology" <?= ($form_data['specialization'] ?? '') === 'Counseling Psychology' ? 'selected' : '' ?>>Counseling Psychology</option>
                        <option value="Marriage and Family Therapy" <?= ($form_data['specialization'] ?? '') === 'Marriage and Family Therapy' ? 'selected' : '' ?>>Marriage and Family Therapy</option>
                        <option value="Substance Abuse Counseling" <?= ($form_data['specialization'] ?? '') === 'Substance Abuse Counseling' ? 'selected' : '' ?>>Substance Abuse Counseling</option>
                        <option value="Trauma Therapy" <?= ($form_data['specialization'] ?? '') === 'Trauma Therapy' ? 'selected' : '' ?>>Trauma Therapy</option>
                        <option value="Child and Adolescent Therapy" <?= ($form_data['specialization'] ?? '') === 'Child and Adolescent Therapy' ? 'selected' : '' ?>>Child and Adolescent Therapy</option>
                        <option value="Cognitive Behavioral Therapy" <?= ($form_data['specialization'] ?? '') === 'Cognitive Behavioral Therapy' ? 'selected' : '' ?>>Cognitive Behavioral Therapy
                        </option>
                        <option value="Group Therapy" <?= ($form_data['specialization'] ?? '') === 'Group Therapy' ? 'selected' : '' ?>>Group Therapy</option>
                        <option value="Crisis Intervention" <?= ($form_data['specialization'] ?? '') === 'Crisis Intervention' ? 'selected' : '' ?>>Crisis Intervention</option>
                        <option value="Psychiatric Social Work" <?= ($form_data['specialization'] ?? '') === 'Psychiatric Social Work' ? 'selected' : '' ?>>Psychiatric Social Work</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="years_experience">Years of Experience</label>
                    <input type="number" id="years_experience" name="years_experience"
                        value="<?= htmlspecialchars($form_data['years_experience'] ?? '') ?>"
                        placeholder="Number of years" min="0" max="50">
                </div>

                <div class="form-group">
                    <label for="bio">Professional Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                        placeholder="Tell us about your professional background and approach to counseling..."><?= htmlspecialchars($form_data['bio'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="<?= BASE_URL ?>/login">Sign In</a>
>>>>>>> origin/uni-representative
        </div>
    </div>

    <script>
<<<<<<< HEAD
        // ── Password Confirmation ──
        document.getElementById('confirm_password').addEventListener('input', function () {
            const password = document.getElementById('password').value;
            if (password !== this.value) {
=======
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function () {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password !== confirmPassword) {
>>>>>>> origin/uni-representative
                this.setCustomValidity('Passwords do not match');
                this.closest('.form-input-icon').querySelector('.form-input').classList.add('error-field');
            } else {
                this.setCustomValidity('');
                this.closest('.form-input-icon').querySelector('.form-input').classList.remove('error-field');
            }
        });

        // ── Email Validation (University Format) ──
        document.getElementById('email').addEventListener('input', function () {
            const emailPattern = /^.+@stu\.ucsc\.cmb\.ac\.lk$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.setCustomValidity('Please enter a valid university email (e.g., 2023is030@stu.ucsc.cmb.ac.lk)');
            } else {
                this.setCustomValidity('');
            }
        });

        // ── Role Descriptions & Conditional Fields ──
        const roleDescriptions = {
            'undergraduate': 'For students seeking mental health support and resources',
            'counselor': 'For licensed mental health professionals providing counseling services'
        };

<<<<<<< HEAD
        const roleSelect = document.getElementById('role');
        const undergradFields = document.getElementById('undergradFields');
        const counselorFields = document.getElementById('counselorFields');
        const step2 = document.getElementById('step2Indicator');
        const step3 = document.getElementById('step3Indicator');
        const connector1 = document.getElementById('connector1');
        const connector2 = document.getElementById('connector2');

        roleSelect.addEventListener('change', function () {
            const description = document.getElementById('roleDescription');
            const selectedRole = this.value;

            description.textContent = roleDescriptions[selectedRole] ||
                'Select the role that best describes you on the MindHeaven platform.';

            // Update step indicator
            if (selectedRole) {
                step2.classList.add('active');
                connector1.classList.add('active');
            }

            // Show/hide role-specific fields
            if (selectedRole === 'undergrad') {
=======
        document.getElementById('role').addEventListener('change', function () {
            const description = document.querySelector('.role-description');
            const undergradFields = document.getElementById('undergradFields');
            const counselorFields = document.getElementById('counselorFields');
            const selectedRole = this.value;

            if (roleDescriptions[selectedRole]) {
                description.textContent = roleDescriptions[selectedRole];
            } else {
                description.textContent = 'Choose the role that best describes your position in the MindHeaven platform.';
            }

            // Show/hide undergraduate fields
            if (selectedRole === 'undergraduate') {
>>>>>>> origin/uni-representative
                undergradFields.style.display = 'block';
                counselorFields.style.display = 'none';
                step3.classList.add('active');
                connector2.classList.add('active');
                // Required fields
                setRequired(['full_name', 'email', 'phone_number'], true);
                setRequired(['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number'], false);
            } else if (selectedRole === 'counselor') {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'block';
                step3.classList.add('active');
                connector2.classList.add('active');
                setRequired(['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'], true);
                setRequired(['full_name', 'email', 'phone_number'], false);
            } else {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'none';
                step3.classList.remove('active');
                connector2.classList.remove('active');
                setRequired(['full_name', 'email', 'phone_number', 'counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'], false);
            }
        });

<<<<<<< HEAD
        function setRequired(ids, required) {
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.required = required;
            });
        }

        // ── Form Validation ──
        document.getElementById('signupForm').addEventListener('submit', function (e) {
            const role = roleSelect.value;
            let hasErrors = false;
            let errorMessages = [];

            if (role === 'undergrad' && undergradFields.style.display !== 'none') {
                ['full_name', 'email', 'phone_number'].forEach(id => {
                    const field = document.getElementById(id);
=======
        // Form validation for undergraduate students and counselors
        document.getElementById('signupForm').addEventListener('submit', function (e) {
            const role = document.getElementById('role').value;
            const undergradFields = document.getElementById('undergradFields');
            const counselorFields = document.getElementById('counselorFields');
            let hasErrors = false;
            let errorMessages = [];

            if (role === 'undergraduate' && undergradFields.style.display !== 'none') {
                const requiredFields = ['full_name', 'email', 'phone_number'];

                // Check required fields
                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
>>>>>>> origin/uni-representative
                    if (!field.value.trim()) {
                        field.classList.add('error-field');
                        hasErrors = true;
                        const label = field.closest('.form-group').querySelector('.form-label');
                        errorMessages.push((label ? label.textContent.replace('*', '').trim() : id) + ' is required');
                    } else {
                        field.classList.remove('error-field');
                    }
                });

<<<<<<< HEAD
=======
                // Email validation
>>>>>>> origin/uni-representative
                const email = document.getElementById('email').value;
                if (email && !isValidUniversityEmail(email)) {
                    document.getElementById('email').classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Email must be a university address (e.g., 2023is030@stu.ucsc.cmb.ac.lk)');
                }

<<<<<<< HEAD
=======
                // Phone validation
>>>>>>> origin/uni-representative
                const phone = document.getElementById('phone_number').value;
                if (phone && !isValidPhone(phone)) {
                    document.getElementById('phone_number').classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Phone number must be 10 digits starting with 0');
                }

                if (hasErrors) {
                    e.preventDefault();
                    alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
                }
            } else if (role === 'counselor' && counselorFields.style.display !== 'none') {
<<<<<<< HEAD
                ['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'].forEach(id => {
                    const field = document.getElementById(id);
=======
                const requiredFields = ['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'];

                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
>>>>>>> origin/uni-representative
                    if (!field.value.trim()) {
                        field.classList.add('error-field');
                        hasErrors = true;
                    } else {
                        field.classList.remove('error-field');
                    }
                });

<<<<<<< HEAD
=======
                // Email validation
>>>>>>> origin/uni-representative
                const email = document.getElementById('counselor_email').value;
                if (email && !isValidCounselorEmail(email)) {
                    document.getElementById('counselor_email').classList.add('error-field');
                    hasErrors = true;
                }

<<<<<<< HEAD
=======
                // Phone validation
>>>>>>> origin/uni-representative
                const phone = document.getElementById('counselor_phone').value;
                if (phone && !isValidPhone(phone)) {
                    document.getElementById('counselor_phone').classList.add('error-field');
                    hasErrors = true;
                }

                if (hasErrors) {
                    e.preventDefault();
                    alert('Please fill in all required fields for counselors.');
                }
            }
        });

        function isValidUniversityEmail(email) {
            return /^.+@stu\.ucsc\.cmb\.ac\.lk$/.test(email);
        }

<<<<<<< HEAD
        function isValidCounselorEmail(email) {
            return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);
        }

=======
>>>>>>> origin/uni-representative
        function isValidPhone(phone) {
            return /^0[0-9]{9}$/.test(phone);
        }

        // ── Auto-show fields if form_data has role selected (after validation failure) ──
        if (roleSelect.value) {
            roleSelect.dispatchEvent(new Event('change'));
        }
    </script>
</body>

</html>