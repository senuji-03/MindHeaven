<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - MindHeaven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .signup-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
        }

        .role-description {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4338ca;
        }

        .error {
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .error ul {
            margin: 0;
            padding-left: 20px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
        }

        .login-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .success {
            color: #059669;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .undergrad-fields, .counselor-fields {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid #e5e7eb;
        }

        .undergrad-fields h3, .undergrad-fields h4, .counselor-fields h3, .counselor-fields h4 {
            color: #1f2937;
            margin-bottom: 15px;
        }

        .undergrad-fields h3, .counselor-fields h3 {
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Ensure counselor fields have consistent styling */
        .counselor-fields input[type="text"],
        .counselor-fields input[type="email"],
        .counselor-fields input[type="tel"],
        .counselor-fields input[type="number"],
        .counselor-fields textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .counselor-fields input:focus,
        .counselor-fields textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        input[type="email"], input[type="tel"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="email"]:focus, input[type="tel"]:focus, input[type="date"]:focus, input[type="number"]:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Create Account - MindHeaven</h2>

        <?php if(isset($errors) && !empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/signup/register" id="signupForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="<?= htmlspecialchars($form_data['username'] ?? '') ?>"
                       placeholder="Choose a username" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Create a password" 
                       required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       placeholder="Confirm your password" 
                       required>
            </div>

            <div class="form-group">
                <label for="role">Select Your Role</label>
                <select id="role" name="role" required>
                    <option value="">Choose your role...</option>
                    <option value="undergrad" <?= ($form_data['role'] ?? '') === 'undergrad' ? 'selected' : '' ?>>
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
                <h3 style="margin: 20px 0 15px 0; color: #1f2937; border-top: 2px solid #e5e7eb; padding-top: 15px;">Student Information</h3>
                
                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" 
                           id="full_name" 
                           name="full_name" 
                           value="<?= htmlspecialchars($form_data['full_name'] ?? '') ?>"
                           placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                           placeholder="your.email@university.edu">
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number *</label>
                    <input type="tel" 
                           id="phone_number" 
                           name="phone_number" 
                           value="<?= htmlspecialchars($form_data['phone_number'] ?? '') ?>"
                           placeholder="0718580160">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="<?= htmlspecialchars($form_data['date_of_birth'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select gender...</option>
                            <option value="male" <?= ($form_data['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= ($form_data['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= ($form_data['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                            <option value="prefer_not_to_say" <?= ($form_data['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefer not to say</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Additional fields for Counselors -->
            <div id="counselorFields" class="counselor-fields" style="display: none;">
                <h3 style="margin: 20px 0 15px 0; color: #1f2937; border-top: 2px solid #e5e7eb; padding-top: 15px;">Counselor Information</h3>
                
                <div class="form-group">
                    <label for="counselor_full_name">Full Name *</label>
                    <input type="text" 
                           id="counselor_full_name" 
                           name="counselor_full_name" 
                           value="<?= htmlspecialchars($form_data['counselor_full_name'] ?? '') ?>"
                           placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="counselor_email">Email Address *</label>
                    <input type="email" 
                           id="counselor_email" 
                           name="counselor_email" 
                           value="<?= htmlspecialchars($form_data['counselor_email'] ?? '') ?>"
                           placeholder="your.email@example.com">
                </div>

                <div class="form-group">
                    <label for="counselor_phone">Phone Number *</label>
                    <input type="tel" 
                           id="counselor_phone" 
                           name="counselor_phone" 
                           value="<?= htmlspecialchars($form_data['counselor_phone'] ?? '') ?>"
                           placeholder="0718580160">
                </div>

                <div class="form-group">
                    <label for="license_number">SLMC License Number *</label>
                    <input type="text" 
                           id="license_number" 
                           name="license_number" 
                           value="<?= htmlspecialchars($form_data['license_number'] ?? '') ?>"
                           placeholder="Enter your professional license number">
                </div>

                <div class="form-group">
                    <label for="specialization">Mental Health Specialization *</label>
                    <select id="specialization" name="specialization" required>
                        <option value="">Select your specialization...</option>
                        <option value="Clinical Psychology" <?= ($form_data['specialization'] ?? '') === 'Clinical Psychology' ? 'selected' : '' ?>>Clinical Psychology</option>
                        <option value="Counseling Psychology" <?= ($form_data['specialization'] ?? '') === 'Counseling Psychology' ? 'selected' : '' ?>>Counseling Psychology</option>
                        <option value="Marriage and Family Therapy" <?= ($form_data['specialization'] ?? '') === 'Marriage and Family Therapy' ? 'selected' : '' ?>>Marriage and Family Therapy</option>
                        <option value="Substance Abuse Counseling" <?= ($form_data['specialization'] ?? '') === 'Substance Abuse Counseling' ? 'selected' : '' ?>>Substance Abuse Counseling</option>
                        <option value="Trauma Therapy" <?= ($form_data['specialization'] ?? '') === 'Trauma Therapy' ? 'selected' : '' ?>>Trauma Therapy</option>
                        <option value="Child and Adolescent Therapy" <?= ($form_data['specialization'] ?? '') === 'Child and Adolescent Therapy' ? 'selected' : '' ?>>Child and Adolescent Therapy</option>
                        <option value="Cognitive Behavioral Therapy" <?= ($form_data['specialization'] ?? '') === 'Cognitive Behavioral Therapy' ? 'selected' : '' ?>>Cognitive Behavioral Therapy</option>
                        <option value="Group Therapy" <?= ($form_data['specialization'] ?? '') === 'Group Therapy' ? 'selected' : '' ?>>Group Therapy</option>
                        <option value="Crisis Intervention" <?= ($form_data['specialization'] ?? '') === 'Crisis Intervention' ? 'selected' : '' ?>>Crisis Intervention</option>
                        <option value="Psychiatric Social Work" <?= ($form_data['specialization'] ?? '') === 'Psychiatric Social Work' ? 'selected' : '' ?>>Psychiatric Social Work</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="years_experience">Years of Experience</label>
                    <input type="number" 
                           id="years_experience" 
                           name="years_experience" 
                           value="<?= htmlspecialchars($form_data['years_experience'] ?? '') ?>"
                           placeholder="Number of years"
                           min="0"
                           max="50">
                </div>

                <div class="form-group">
                    <label for="bio">Professional Bio</label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4" 
                              placeholder="Tell us about your professional background and approach to counseling..."><?= htmlspecialchars($form_data['bio'] ?? '') ?></textarea>
                </div>
            </div>

            <button type="submit">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="<?= BASE_URL ?>/login">Sign In</a>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Role descriptions
        const roleDescriptions = {
            'undergrad': 'For students seeking mental health support and resources',
            'counselor': 'For licensed mental health professionals providing counseling services'
        };

        document.getElementById('role').addEventListener('change', function() {
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
            if (selectedRole === 'undergrad') {
                undergradFields.style.display = 'block';
                counselorFields.style.display = 'none';
                // Make required fields for undergrad
                document.getElementById('full_name').required = true;
                document.getElementById('email').required = true;
                document.getElementById('phone_number').required = true;
                // Remove required from counselor fields
                document.getElementById('counselor_full_name').required = false;
                document.getElementById('counselor_email').required = false;
                document.getElementById('counselor_phone').required = false;
                document.getElementById('license_number').required = false;
            } else if (selectedRole === 'counselor') {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'block';
                // Make required fields for counselor
                document.getElementById('counselor_full_name').required = true;
                document.getElementById('counselor_email').required = true;
                document.getElementById('counselor_phone').required = true;
                document.getElementById('license_number').required = true;
                document.getElementById('specialization').required = true;
                // Remove required from undergrad fields
                document.getElementById('full_name').required = false;
                document.getElementById('email').required = false;
                document.getElementById('phone_number').required = false;
            } else {
                undergradFields.style.display = 'none';
                counselorFields.style.display = 'none';
                // Remove required attribute for other roles
                document.getElementById('full_name').required = false;
                document.getElementById('email').required = false;
                document.getElementById('phone_number').required = false;
                document.getElementById('counselor_full_name').required = false;
                document.getElementById('counselor_email').required = false;
                document.getElementById('counselor_phone').required = false;
                document.getElementById('license_number').required = false;
                document.getElementById('specialization').required = false;
            }
        });

        // Form validation for undergraduate students and counselors
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const role = document.getElementById('role').value;
            const undergradFields = document.getElementById('undergradFields');
            const counselorFields = document.getElementById('counselorFields');
            let hasErrors = false;
            let errorMessages = [];
            
            if (role === 'undergrad' && undergradFields.style.display !== 'none') {
                const requiredFields = ['full_name', 'email', 'phone_number'];
                
                // Check required fields
                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (!field.value.trim()) {
                        field.style.borderColor = '#dc2626';
                        hasErrors = true;
                        errorMessages.push(`${field.previousElementSibling.textContent.replace('*', '').trim()} is required`);
                    } else {
                        field.style.borderColor = '#d1d5db';
                    }
                });
                
                // Email validation
                const email = document.getElementById('email').value;
                if (email && !isValidGmail(email)) {
                    document.getElementById('email').style.borderColor = '#dc2626';
                    hasErrors = true;
                    errorMessages.push('Email must be a Gmail address (e.g., yourname@gmail.com)');
                }
                
                // Phone validation
                const phone = document.getElementById('phone_number').value;
                if (phone && !isValidPhone(phone)) {
                    document.getElementById('phone_number').style.borderColor = '#dc2626';
                    hasErrors = true;
                    errorMessages.push('Phone number must be in format 0718580160 (10 digits starting with 0)');
                }
                
                if (hasErrors) {
                    e.preventDefault();
                    alert('Please fix the following errors:\n\n' + errorMessages.join('\n'));
                }
            } else if (role === 'counselor' && counselorFields.style.display !== 'none') {
                const requiredFields = ['counselor_full_name', 'counselor_email', 'counselor_phone', 'license_number', 'specialization'];
                
                requiredFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (!field.value.trim()) {
                        field.style.borderColor = '#dc2626';
                        hasErrors = true;
                    } else {
                        field.style.borderColor = '#d1d5db';
                    }
                });
                
                // Email validation
                const email = document.getElementById('counselor_email').value;
                if (email && !isValidGmail(email)) {
                    document.getElementById('counselor_email').style.borderColor = '#dc2626';
                    hasErrors = true;
                }
                
                // Phone validation
                const phone = document.getElementById('counselor_phone').value;
                if (phone && !isValidPhone(phone)) {
                    document.getElementById('counselor_phone').style.borderColor = '#dc2626';
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    e.preventDefault();
                    alert('Please fill in all required fields for counselors.');
                }
            }
        });

        function isValidGmail(email) {
            const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            return gmailRegex.test(email);
        }
        
        function isValidPhone(phone) {
            // Allow 10 digits starting with 0 (like 0718580160)
            const phoneRegex = /^0[0-9]{9}$/;
            return phoneRegex.test(phone);
        }
    </script>
</body>
</html>
