<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - MindHeaven</title>
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

        .forgot-container {
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

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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

        .success {
            color: #059669;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.5;
        }

        .success a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            word-break: break-all;
            display: inline-block;
            margin: 5px 0;
            padding: 5px;
            background-color: #f3f4f6;
            border-radius: 4px;
            border: 1px solid #d1d5db;
        }

        .success a:hover {
            background-color: #e5e7eb;
            text-decoration: underline;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .back-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .info-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h2>Forgot Password</h2>
        
        <div class="info-text">
            Enter your Gmail address and we'll send you a link to reset your password.
        </div>

        <?php if(isset($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="success">
                <?= htmlspecialchars($success) ?>
                <?php if(isset($reset_link)): ?>
                    <br><br>
                    <strong>Reset Link:</strong><br>
                    <a href="<?= htmlspecialchars($reset_link) ?>" style="color: #4f46e5; text-decoration: none; font-weight: 600; word-break: break-all;">
                        <?= htmlspecialchars($reset_link) ?>
                    </a>
                    <br><br>
                    <small style="color: #6b7280;">Click the link above to reset your password. This link will expire in 1 hour.</small>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login/forgot-password" id="forgotPasswordForm">
            <div class="form-group">
                <label for="email">Gmail Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="your.email@gmail.com"
                       value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                       required>
            </div>

            <button type="submit">Send Reset Link</button>
        </form>
        
        <div class="back-link">
            <a href="<?= BASE_URL ?>/login">← Back to Login</a>
        </div>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            // Validate Gmail format
            if (email && !isValidGmail(email)) {
                e.preventDefault();
                document.getElementById('email').style.borderColor = '#dc2626';
                alert('Please enter a valid Gmail address (e.g., yourname@gmail.com)');
            } else {
                document.getElementById('email').style.borderColor = '#d1d5db';
            }
        });

        function isValidGmail(email) {
            const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            return gmailRegex.test(email);
        }
    </script>
</body>
</html>
