<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'] ?? '';
    $admin_pass = $_POST['admin_pass'] ?? '';
    // Hardcoded credentials
    if ($admin_id === 'admin' && $admin_pass === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ../Admin/admin.php');
        exit();
    } else {
        $error = 'Invalid ID or Password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Harsh Kumar</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #23233a 0%, #6366f1 100%);
            color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(35, 35, 58, 0.92);
            border-radius: 24px;
            box-shadow: 0 8px 48px #6366f1aa, 0 2px 16px #23233a88;
            padding: 40px 32px 32px 32px;
            min-width: 320px;
            max-width: 360px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            color: #fbbf24;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            letter-spacing: 1px;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        input[type="text"], input[type="password"] {
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: #23233a;
            color: #f3f4f6;
            font-size: 1rem;
            box-shadow: 0 1px 4px #6366f122;
        }
        button {
            background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
            font-weight: 600;
            box-shadow: 0 2px 8px #6366f1aa;
        }
        button:hover {
            background: #fbbf24;
            color: #23233a;
        }
        .error {
            color: #ef4444;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
            <input type="text" name="admin_id" placeholder="Admin ID" required autofocus>
            <input type="password" name="admin_pass" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
