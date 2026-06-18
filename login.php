<?php
session_start();
require_once 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Please enter a valid email address!";
        } else {
            try {
                $tokenResponse = supabase_auth_request('token?grant_type=password', 'POST', [
                    'email' => $email,
                    'password' => $password
                ]);

                if (!empty($tokenResponse['access_token']) && !empty($tokenResponse['user'])) {
                    $_SESSION['user_id'] = $tokenResponse['user']['id'];
                    $_SESSION['username'] = $tokenResponse['user']['user_metadata']['username'] ?? $email;
                    $_SESSION['supabase_token'] = $tokenResponse['access_token'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $message = "Login failed!";
                }
            } catch (Exception $e) {
                if (is_missing_table_error($e->getMessage())) {
                    $users = load_auth_users();
                    if (isset($users[$email]) && password_verify($password, $users[$email]['password'])) {
                        $_SESSION['user_id'] = md5($email);
                        $_SESSION['username'] = $users[$email]['username'] ?? $email;
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        $message = "User not found or invalid password!";
                    }
                } else {
                    $message = "Error: " . $e->getMessage();
                }
            }
        }
    } else {
        $message = "Please fill all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Space Exploration</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SPACEEDU</div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="planets.php">Planets</a></li>
            <li><a href="galaxies.php">Galaxies</a></li>
            <li><a href="missions.php">Missions</a></li>
            <li><a href="news.php">News & Live</a></li>
            <li><a href="analysis.php">Analysis</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="btn-small">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-small">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>
    
    <div class="container auth-container glassmorphism">
        <h2>Welcome Back Explorer</h2>
        <p>Login to continue your journey</p>
        <?php if($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p class="auth-link">Don't have an account? <a href="register.php">Register here</a></p>
        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>
