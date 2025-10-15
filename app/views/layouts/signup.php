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

        <form method="POST" action="<?= BASE_URL ?>/signup/register">
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
                    <option value="admin" <?= ($form_data['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                        Administrator
                    </option>
                    <option value="moderator" <?= ($form_data['role'] ?? '') === 'moderator' ? 'selected' : '' ?>>
                        Moderator
                    </option>
                    <option value="call_responder" <?= ($form_data['role'] ?? '') === 'call_responder' ? 'selected' : '' ?>>
                        Call Responder
                    </option>
                    <option value="donor" <?= ($form_data['role'] ?? '') === 'donor' ? 'selected' : '' ?>>
                        Donor
                    </option>
                </select>
                <div class="role-description">
                    Choose the role that best describes your position in the MindHeaven platform.
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
            'counselor': 'For licensed mental health professionals providing counseling services',
            'admin': 'For system administrators managing the platform',
            'moderator': 'For content moderators ensuring platform safety',
            'call_responder': 'For crisis hotline responders providing emergency support',
            'donor': 'For individuals or organizations supporting the platform financially'
        };

        document.getElementById('role').addEventListener('change', function() {
            const description = document.querySelector('.role-description');
            const selectedRole = this.value;
            
            if (roleDescriptions[selectedRole]) {
                description.textContent = roleDescriptions[selectedRole];
            } else {
                description.textContent = 'Choose the role that best describes your position in the MindHeaven platform.';
            }
        });
    </script>
</body>
</html>
