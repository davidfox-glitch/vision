<?php
session_start();
require_once 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = normalize_email($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($email) && !empty($password)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Please enter a valid email address!";
        } else {
            try {
                $redirectTo = app_url('login.php?confirmed=1');
                $authResponse = supabase_auth_request('signup?redirect_to=' . rawurlencode($redirectTo), 'POST', [
                    'email' => $email,
                    'password' => $password,
                    'options' => [
                        'data' => [
                            'username' => $username
                        ]
                    ]
                ]);

                if (empty($authResponse['user'])) {
                    throw new Exception('Invalid Supabase registration response');
                }

                unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['supabase_token']);
                header("Location: login.php?registered=1&email=" . rawurlencode($email));
                exit();
            } catch (Exception $e) {
                $errorMessage = supabase_auth_error_message($e->getMessage());
                if (stripos($errorMessage, 'already registered') !== false || stripos($errorMessage, 'already exists') !== false) {
                    $message = "An account with that email already exists!";
                } elseif (stripos($errorMessage, 'rate limit') !== false) {
                    $message = "Supabase email rate limit reached. Set up custom SMTP in Supabase Auth email settings, then try again.";
                } else {
                    $message = "Registration failed: " . htmlspecialchars($errorMessage);
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
    <title>Register - Space Exploration</title>
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
        <h2>Join the Mission</h2>
        <p>Create an account to explore the universe</p>
        <?php if($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>
