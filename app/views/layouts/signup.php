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

        *,
        *::before,
        *::after {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: var(--text-primary);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .auth-wrapper {
            display: grid;
            grid-template-columns: 420px 1fr;
            min-height: 100vh;
        }

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

        .alert-success {
            background: #f0fdf4;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

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

        .form-hint,
        .role-description {
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

        .form-input-icon .toggle-password {
            left: auto;
            right: 14px;
            pointer-events: auto;
            cursor: pointer;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .role-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .role-card {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            background: var(--surface);
        }

        .role-card:hover {
            border-color: var(--primary-light);
            background: var(--bg-mid);
        }

        .role-card.active {
            border-color: var(--primary);
            background: rgba(61, 139, 110, 0.05);
            box-shadow: 0 4px 12px rgba(61, 139, 110, 0.1);
        }

        .role-card i {
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
        }

        .role-card span {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

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

        .auth-trust {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            font-size: 0.78rem;
            color: var(--text-secondary);
            flex-wrap: wrap;
        }

        .auth-trust span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .auth-trust i {
            color: var(--primary-light);
        }

        .auth-footer {
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
        }

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

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <aside class="auth-panel">
            <div class="panel-circle-accent"></div>
            <div class="panel-circle-calm"></div>
            <div class="panel-content">
                <div class="panel-logo">
                    <div class="logo-icon"><i class="fas fa-heart"></i></div>
                    MindHeaven
                </div>
                <h2 class="panel-heading">Your mental wellness journey starts here</h2>
                <p class="panel-text">Join MindHeaven to access support, resources, and guidance tailored to your role.
                </p>
                <ul class="panel-steps">
                    <li><span class="step-dot">1</span><span>Create your account</span></li>
                    <li><span class="step-dot">2</span><span>Select your role and provide your information</span></li>
                    <li><span class="step-dot">3</span><span>Access the right support and tools</span></li>
                </ul>
            </div>
        </aside>

        <main class="auth-form-panel">
            <div class="auth-form-container">
                <div class="mobile-brand">
                    <div class="logo-icon"><i class="fas fa-heart"></i></div>
                    MindHeaven
                </div>

                <a href="<?= BASE_URL ?>/login" class="auth-back">
                    <i class="fas fa-arrow-left"></i> Back to login
                </a>

                <div class="auth-form-header">
                    <h1>Create Account</h1>
                    <p>Choose your role and fill in your details to get started.</p>
                </div>

                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= htmlspecialchars($success) ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/signup/register" id="signupForm">
                    <div class="form-group">
                        <label class="form-label" for="username">Username <span class="required">*</span></label>
                        <div class="form-input-icon">
                            <i class="fas fa-user"></i>
                            <input class="form-input" type="text" id="username" name="username"
                                value="<?= htmlspecialchars($form_data['username'] ?? '') ?>"
                                placeholder="Choose a username" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="password">Password <span class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-lock"></i>
                                <input class="form-input" type="password" id="password" name="password"
                                    placeholder="Create a password" required autocomplete="new-password" style="padding-right: 40px;">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="confirm_password">Confirm Password <span
                                    class="required">*</span></label>
                            <div class="form-input-icon">
                                <i class="fas fa-lock"></i>
                                <input class="form-input" type="password" id="confirm_password" name="confirm_password"
                                    placeholder="Confirm your password" required autocomplete="new-password" style="padding-right: 40px;">
                                <i class="fas fa-eye toggle-password"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label" style="text-align: center; font-size: 1.05rem; margin-bottom: 16px;">Join us as <span class="required">*</span></label>
                        <input type="hidden" id="role" name="role" value="<?= htmlspecialchars($form_data['role'] ?? '') ?>" required>
                        
                        <div class="role-selection">
                            <div class="role-card <?= ($form_data['role'] ?? '') === 'undergraduate' ? 'active' : '' ?>" data-role="undergraduate">
                                <i class="fas fa-user-graduate"></i>
                                <span>Undergraduate Student</span>
                            </div>
                            <div class="role-card <?= ($form_data['role'] ?? '') === 'counselor' ? 'active' : '' ?>" data-role="counselor">
                                <i class="fas fa-stethoscope"></i>
                                <span>Counselor</span>
                            </div>
                        </div>
                        <div class="role-description" style="text-align: center;">
                            Choose the role that best describes your position in the MindHeaven platform.
                        </div>
                    </div>

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
        </main>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        function setRequired(ids, required) {
            ids.forEach(function (id) {
                const field = document.getElementById(id);
                if (field) {
                    field.required = required;
                }
            });
        }

        function isValidUniversityEmail(email) {
            return /^.+@stu\.ucsc\.cmb\.ac\.lk$/.test(email);
        }

        function isValidCounselorEmail(email) {
            return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);
        }

        function isValidPhone(phone) {
            return /^0[0-9]{9}$/.test(phone);
        }

        const roleDescriptions = {
            undergraduate: 'For students seeking mental health support and resources',
            counselor: 'For licensed mental health professionals providing counseling services'
        };

        const roleSelect = document.getElementById('role');
        const roleDescription = document.querySelector('.role-description');
        const undergradFields = document.getElementById('undergradFields');
        const counselorFields = document.getElementById('counselorFields');
        const roleCards = document.querySelectorAll('.role-card');

        function updateRoleFields() {
            const selectedRole = roleSelect.value;

            roleDescription.textContent = roleDescriptions[selectedRole] ||
                'Choose the role that best describes your position in the MindHeaven platform.';

            if (selectedRole === 'undergraduate') {
                undergradFields.style.display = 'block';
                counselorFields.style.display = 'none';
                setRequired(['full_name', 'email', 'phone_number'], true);
                setRequired(['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'], false);
            } else if (selectedRole === 'counselor') {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'block';
                setRequired(['full_name', 'email', 'phone_number'], false);
                setRequired(['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'], true);
            } else {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'none';
                setRequired(['full_name', 'email', 'phone_number'], false);
                setRequired(['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'], false);
            }
        }

        roleCards.forEach(card => {
            card.addEventListener('click', function() {
                roleCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                roleSelect.value = this.dataset.role;
                updateRoleFields();
            });
        });

        const confirmPasswordField = document.getElementById('confirm_password');
        confirmPasswordField.addEventListener('input', function () {
            const password = document.getElementById('password').value;
            if (this.value && password !== this.value) {
                this.setCustomValidity('Passwords do not match');
                this.classList.add('error-field');
            } else {
                this.setCustomValidity('');
                this.classList.remove('error-field');
            }
        });

        const studentEmailField = document.getElementById('email');
        studentEmailField.addEventListener('input', function () {
            if (this.value && !isValidUniversityEmail(this.value)) {
                this.setCustomValidity('Please enter a valid university email (e.g., 2023is030@stu.ucsc.cmb.ac.lk)');
                this.classList.add('error-field');
            } else {
                this.setCustomValidity('');
                this.classList.remove('error-field');
            }
        });

        document.getElementById('signupForm').addEventListener('submit', function (e) {
            const role = roleSelect.value;
            let hasErrors = false;
            let errorMessages = [];

            if (role === 'undergraduate') {
                ['full_name', 'email', 'phone_number'].forEach(function (fieldId) {
                    const field = document.getElementById(fieldId);
                    if (field && !field.value.trim()) {
                        field.classList.add('error-field');
                        hasErrors = true;
                        errorMessages.push(fieldId.replaceAll('_', ' ') + ' is required');
                    } else if (field) {
                        field.classList.remove('error-field');
                    }
                });

                const email = studentEmailField.value.trim();
                if (email && !isValidUniversityEmail(email)) {
                    studentEmailField.classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Email must be a university address');
                }

                const phone = document.getElementById('phone_number').value.trim();
                if (phone && !isValidPhone(phone)) {
                    document.getElementById('phone_number').classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Phone number must be 10 digits starting with 0');
                }
            } else if (role === 'counselor') {
                ['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'].forEach(function (fieldId) {
                    const field = document.getElementById(fieldId);
                    if (field && !field.value.trim()) {
                        field.classList.add('error-field');
                        hasErrors = true;
                        errorMessages.push(fieldId.replaceAll('_', ' ') + ' is required');
                    } else if (field) {
                        field.classList.remove('error-field');
                    }
                });

                const counselorEmail = document.getElementById('counselor_email').value.trim();
                if (counselorEmail && !isValidCounselorEmail(counselorEmail)) {
                    document.getElementById('counselor_email').classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Counselor email must be a valid email address');
                }

                const counselorPhone = document.getElementById('counselor_phone').value.trim();
                if (counselorPhone && !isValidPhone(counselorPhone)) {
                    document.getElementById('counselor_phone').classList.add('error-field');
                    hasErrors = true;
                    errorMessages.push('Phone number must be 10 digits starting with 0');
                }
            } else {
                hasErrors = true;
                errorMessages.push('Please select a role');
            }

            if (hasErrors) {
                e.preventDefault();
                alert('Please fix the following:\n\n' + errorMessages.join('\n'));
            }
        });

        updateRoleFields();
    </script>
</body>

</html>