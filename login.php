<?php
session_start();
require_once 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        try {
            $users = supabase_request("registered_accounts?username=eq." . urlencode($username) . "&select=id,password");
            
            if (!empty($users)) {
                $user = $users[0];
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $username;
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "User not found!";
            }
        } catch(Exception $e) {
            $error = "Error: " . $e->getMessage();
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
                <label>Username</label>
                <input type="text" name="username" required>
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
