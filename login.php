<?php
session_start();
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - DelivrEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f6f8fa; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-box { background: #fff; padding: 2.5rem 2rem; border-radius: 1.5rem; box-shadow: 0 2px 12px 0 rgba(16,30,54,0.08); min-width: 320px; }
        .login-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1.2rem; }
        .form-label { display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500; }
        .form-input { width: 100%; padding: 0.7rem 1rem; border-radius: 0.8rem; border: 1px solid #e5e7eb; font-size: 1rem; }
        .form-btn { width: 100%; background: #5AC994; color: #fff; border: none; border-radius: 0.8rem; padding: 0.8rem; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .form-btn:hover { background: #4F46E5; }
        .error { color: #ef4444; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <form class="login-box" method="post">
        <div class="login-title">Delivr<span style="color:#5AC994">Ease</span> Login</div>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <div class="form-group">
            <label class="form-label">Username</label>
            <input class="form-input" type="text" name="username" required>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-input" type="password" name="password" required>
        </div>
        <button class="form-btn" type="submit">Login</button>
    </form>
</body>
</html>