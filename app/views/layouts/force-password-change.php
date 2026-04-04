<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Password - MindHeaven</title>
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

        .reset-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            max-width: 90vw;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #1f2937;
        }

        p.info {
            text-align: center;
            color: #4b5563;
            margin-bottom: 20px;
            font-size: 14px;
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

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="password"]:focus {
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

        .password-requirements {
            color: #6b7280;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <h2>Update Your Password</h2>
        <p class="info">For your security, you must change your temporary password before proceeding.</p>

        <?php if (isset($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login/forcePasswordChange" id="resetPasswordForm">

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required>
                <div class="password-requirements">
                    Password must be at least 6 characters long
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password"
                    required>
            </div>

            <button type="submit">Update Password</button>
        </form>
    </div>

    <script>
        document.getElementById('confirm_password').addEventListener('input', function () {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password.length < 6) {
                e.preventDefault();
                document.getElementById('password').style.borderColor = '#dc2626';
                alert('Password must be at least 6 characters long');
            } else if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('confirm_password').style.borderColor = '#dc2626';
                alert('Passwords do not match');
            } else {
                document.getElementById('password').style.borderColor = '#d1d5db';
                document.getElementById('confirm_password').style.borderColor = '#d1d5db';
            }
        });
    </script>
</body>

</html>