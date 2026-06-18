<?php
session_start();
require_once 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($email) && !empty($password)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Please enter a valid email address!";
        } else {
            try {
                $authResponse = supabase_auth_request('signup', 'POST', [
                    'email' => $email,
                    'password' => $password,
                    'options' => [
                        'data' => [
                            'username' => $username
                        ]
                    ]
                ]);

                if (!empty($authResponse['user'])) {
                    $_SESSION['user_id'] = $authResponse['user']['id'];
                    $_SESSION['username'] = $username;
                    $_SESSION['supabase_token'] = $authResponse['access_token'] ?? null;
                    $message = "Registration successful! <a href='dashboard.php'>Continue to dashboard</a>";
                } else {
                    $message = "Registration successful! Please login.";
                }
            } catch (Exception $e) {
                if (is_missing_table_error($e->getMessage())) {
                    $users = load_auth_users();
                    if (isset($users[$email])) {
                        $message = "An account with that email already exists!";
                    } else {
                        $users[$email] = [
                            'username' => $username,
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        save_auth_users($users);
                        $message = "Registration successful! <a href='login.php'>Login here</a>";
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
