<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MindHeaven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/main.css"> <!-- your global CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5a67f2;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #4348d8;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>MindHeaven Login</h2>

        <?php if(isset($error)) : ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if(isset($success)) : ?>
            <div style="color: #059669; background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login/authenticate">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
            <p>Don't have an account? <a href="<?= BASE_URL ?>/signup" style="color: #5a67f2; text-decoration: none;">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
