<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Database - Space Exploration</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Background animations -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>
    
    <nav class="navbar">
        <div class="logo">Cosmic Horizons</div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="explore.php">Explore</a></li>
            <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
        </ul>
    </nav>
    
    <div class="immersive-explore">
        <div class="explore-sidebar glassmorphism">
            <h2 style="margin-bottom: 2rem; color: var(--primary); font-family: 'Orbitron', sans-serif;">Destinations</h2>
            <ul class="planet-list">
                <li data-image="images/images/nasa-JHyiw_dpALk-unsplash.jpg" data-title="Andromeda Galaxy" data-desc="The Andromeda Galaxy, also known as Messier 31, is a barred spiral galaxy approximately 2.5 million light-years from Earth." class="active">Andromeda</li>
                <li data-image="images/planets/mars.png" data-title="Mars Terrain" data-desc="Mars is the fourth planet from the Sun. It carries the name of the Roman god of war and is often referred to as the 'Red Planet'.">Mars</li>
                <li data-image="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" data-title="Exoplanet Kepler-186f" data-desc="The first Earth-size planet discovered in the potentially habitable zone around another star.">Kepler-186f</li>
                <li data-image="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" data-title="Orion Nebula" data-desc="The Orion Nebula is a diffuse nebula situated in the Milky Way, being south of Orion's Belt in the constellation of Orion.">Orion Nebula</li>
            </ul>
        </div>
        
        <div class="explore-viewer">
            <div class="planet-sphere-container">
                <div id="planet-sphere" class="planet-sphere">
                    <img id="planet-image" src="images/images/nasa-JHyiw_dpALk-unsplash.jpg" alt="Celestial Body">
                </div>
                <div class="planet-glow"></div>
                <!-- Mini orbit animation element around the planet -->
                <div class="mini-satellite"><div class="sat-dot"></div></div>
            </div>
            
            <div class="planet-info-overlay">
                <h1 id="planet-title" class="glitch-effect">Andromeda Galaxy</h1>
                <p id="planet-desc">The Andromeda Galaxy, also known as Messier 31, is a barred spiral galaxy approximately 2.5 million light-years from Earth.</p>
                <button class="btn btn-outline" style="margin-top: 1.5rem;" onclick="window.location.href='index.php'">Return to Mission Control</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
