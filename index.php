<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPACEEDU - Premium Space Exploration</title>
    <!-- Cinematic Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        /* Base Reset & Variables */
        :root {
            --primary: #00d2ff;
            --accent: #112038;
            --text-light: #ffffff;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #02050A; /* Deep dark blue and black space background */
            color: var(--text-light);
            scroll-behavior: smooth;
        }

        /* --- Loading Animation --- */
        #loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #02050A;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        .loader-ring {
            width: 50px; height: 50px;
            border: 3px solid rgba(255,255,255,0.1);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        #loader h2 {
            font-family: 'Cinzel', serif;
            letter-spacing: 5px;
            color: #fff;
            margin: 0;
            font-size: 1.2rem;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* --- Navbar UI --- */
        .landing-nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 2.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-sizing: border-box;
            /* Modern transparent glassmorphism navbar */
            background: linear-gradient(to bottom, rgba(2,5,10,0.8), transparent);
        }

        .landing-logo {
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: #fff;
            text-shadow: 0 0 15px rgba(255,255,255,0.3);
        }

        .landing-links {
            display: flex;
            gap: 3rem;
            align-items: center;
        }

        .landing-links a {
            color: #fff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s ease;
            position: relative;
        }

        .landing-links a:hover {
            color: var(--primary);
            text-shadow: 0 0 15px var(--primary);
        }

        /* Rounded Enroll Button & Glowing effects */
        .btn-glass {
            padding: 0.9rem 2.8rem;
            border-radius: 40px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            color: white !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        
        .btn-glass:hover {
            background: var(--primary);
            color: #000 !important;
            box-shadow: 0 0 30px var(--primary);
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        /* --- Hero Text Area --- */
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
            pointer-events: none; /* Let clicks pass through to 3D scene */
        }
        
        .hero > * {
            pointer-events: auto; /* Re-enable clicks on text/buttons */
        }

        .subtitle {
            font-size: 1.1rem;
            letter-spacing: 15px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            color: var(--primary);
            font-weight: 500;
        }

        /* Massive Cinematic Title */
        .massive-title {
            font-family: 'Cinzel', serif;
            font-size: 18vw;
            line-height: 1;
            margin: 0;
            font-weight: 800;
            letter-spacing: 15px;
            /* Stunning metallic gradient text */
            background: linear-gradient(180deg, #ffffff 0%, #8b9bb4 70%, #2f405c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 30px 60px rgba(0,0,0,0.8);
            transform: translateX(10px); /* Adjust optical balance */
        }

        /* Short cinematic description text */
        .hero-desc {
            max-width: 600px;
            font-size: 1.2rem;
            line-height: 1.6;
            color: #a0aec0;
            margin-top: 2rem;
            margin-bottom: 3rem;
            font-weight: 300;
        }

        /* Premium glowing GET STARTED button */
        .get-started {
            padding: 1.2rem 4rem;
            border-radius: 50px;
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 210, 255, 0.2);
        }

        .get-started:hover {
            background: var(--primary);
            color: #000;
            box-shadow: 0 0 40px rgba(0, 210, 255, 0.8);
            transform: scale(1.05);
        }

        /* Floating Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 4vh;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .scroll-indicator:hover { opacity: 1; }

        .mouse {
            width: 25px;
            height: 45px;
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 15px;
            position: relative;
        }

        .wheel {
            width: 3px;
            height: 8px;
            background: var(--primary);
            border-radius: 2px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            animation: scroll 2s cubic-bezier(0.15, 0.41, 0.69, 0.94) infinite;
            box-shadow: 0 0 10px var(--primary);
        }

        @keyframes scroll {
            0% { top: 8px; opacity: 1; }
            100% { top: 25px; opacity: 0; }
        }

        /* --- Floating Foreground Planets (Parallax elements) --- */
        /* Venus on left side */
        .float-venus {
            position: absolute;
            left: 8%;
            top: 35%;
            width: 130px;
            border-radius: 50%;
            filter: drop-shadow(0 0 30px rgba(255, 200, 0, 0.4));
            animation: float 14s ease-in-out infinite;
            z-index: 5;
            pointer-events: none;
        }

        /* Mars on right side */
        .float-mars {
            position: absolute;
            right: 10%;
            top: 25%;
            width: 140px;
            border-radius: 50%;
            filter: drop-shadow(0 0 30px rgba(255, 60, 0, 0.4));
            animation: float 18s ease-in-out infinite reverse;
            z-index: 5;
            pointer-events: none;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-35px) rotate(8deg); }
        }

        /* --- 3D Render Canvas --- */
        #landing-3d {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 0;
            overflow: hidden;
            background-color: transparent;
        }

        /* --- Scrollable Content Sections --- */
        .content-section {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            padding: 6rem 10%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .section-title {
            font-family: 'Cinzel', serif;
            font-size: 4rem;
            color: #fff;
            margin-bottom: 3rem;
            text-align: center;
            background: linear-gradient(180deg, #ffffff 0%, #8b9bb4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Glass Cards */
        .glass-panel {
            background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4));
            backdrop-filter: blur(25px) saturate(200%);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3rem;
            color: white;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        }

        /* Trailer Container */
        .trailer-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            aspect-ratio: 16/9;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(0,210,255,0.2);
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.8);
        }
        .play-btn {
            width: 80px; height: 80px;
            background: rgba(0, 210, 255, 0.2);
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            cursor: pointer; transition: all 0.3s;
            z-index: 2;
        }
        .play-btn:hover { background: var(--primary); box-shadow: 0 0 40px var(--primary); transform: scale(1.1); }
        .play-btn div { width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-left: 25px solid white; margin-left: 5px; }

        /* Grid Layouts for Tickets & Blog */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            width: 100%;
        }

        .ticket-card, .blog-card {
            transition: all 0.4s ease;
        }
        .ticket-card:hover, .blog-card:hover {
            transform: translateY(-10px);
            border-color: rgba(0, 210, 255, 0.5);
            box-shadow: 0 15px 40px rgba(0,210,255,0.2);
        }

        .ticket-card h3 { font-size: 2rem; margin-top: 0; color: var(--primary); font-family: 'Cinzel', serif; }
        .ticket-card h2 { font-size: 2.5rem; margin: 1rem 0; font-family: 'Orbitron', sans-serif; }
        .ticket-card ul { padding-left: 20px; color: #a0aec0; margin-bottom: 2rem; line-height: 1.8; }
        .ticket-btn {
            display: block; text-align: center; padding: 1rem;
            border: 1px solid var(--primary); border-radius: 30px; color: #fff;
            text-decoration: none; text-transform: uppercase; letter-spacing: 2px;
            transition: 0.3s;
        }
        .ticket-btn:hover { background: var(--primary); color: #000; }

        .blog-img { width: 100%; height: 200px; border-radius: 15px; margin-bottom: 1.5rem; object-fit: cover; }
        .blog-card h3 { font-size: 1.4rem; margin-bottom: 1rem; color: #fff; }
        .blog-card p { color: #a0aec0; line-height: 1.6; margin-bottom: 1.5rem; }
        .read-more { color: var(--primary); text-transform: uppercase; font-weight: bold; letter-spacing: 1px; text-decoration: none; }

        /* Product Scroll */
        .product-scroll-container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        .product-track {
            display: flex;
            gap: 4rem;
            padding: 0 10%;
            width: max-content;
        }
        .product-card {
            width: 350px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transform: scale(0.95);
            transition: transform 0.5s ease;
        }
        .product-card:hover {
            transform: scale(1.05);
            border-color: var(--primary);
            box-shadow: 0 0 30px rgba(0, 210, 255, 0.3);
        }
        .product-image {
            width: 100%;
            height: 250px;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        .product-card h3 {
            font-size: 1.8rem;
            color: var(--primary);
            font-family: 'Cinzel', serif;
            margin: 0.5rem 0;
        }

        /* Marquee Animation */
        .marquee-wrapper {
            display: flex;
            width: max-content;
            animation: marquee 30s linear infinite;
        }
        .marquee-content {
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: 5px;
            padding-right: 20px;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Mobile adjustments */
        @media (max-width: 900px) {
            .landing-links { display: none; }
            .massive-title { font-size: 25vw; letter-spacing: 5px; transform: translateX(0); }
            .subtitle { font-size: 0.9rem; letter-spacing: 8px; }
            .hero-desc { padding: 0 20px; font-size: 1rem; }
            .float-mars, .float-venus { display: none; }
            .content-section { padding: 4rem 5%; }
        }
    </style>
</head>
<body>

    <!-- Loading Screen -->
    <div id="loader">
        <div class="loader-ring"></div>
        <h2>INITIALIZING SEQUENCE</h2>
    </div>

    <!-- Space Navigation -->
    <nav class="landing-nav hidden-init">
        <div class="landing-logo">SPACEEDU</div>
        <div class="landing-links">
            <a href="dashboard.php">Planets</a>
            <a href="news.php">News</a>
            <a href="#tickets">Tickets</a>
            <a href="#blog">Blog</a>
            <a href="register.php" class="btn-glass">Enroll</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="hero">
        <div class="subtitle hidden-init">Origin Point</div>
        <h1 class="massive-title hidden-init">EARTH</h1>
        
        <p class="hero-desc hidden-init">Experience the cosmos like never before. Journey through our meticulously simulated universe and unravel the profound mysteries of deep space exploration.</p>

        <a href="dashboard.php" class="get-started hidden-init">GET STARTED</a>
        
        <div class="scroll-indicator hidden-init">
            <div class="mouse"><div class="wheel"></div></div>
            <span style="font-size: 0.75rem; letter-spacing: 3px; color: var(--text-muted); font-weight: bold;">SCROLL</span>
        </div>
    </div>

    <!-- Parallax Flanking Planets -->
    <img src="images/planets/venus.png" class="float-venus hidden-init" id="venus" alt="Venus">
    <img src="images/planets/mars.png" class="float-mars hidden-init" id="mars" alt="Mars">

    <!-- Scrollable Content Block -->
    <div style="position: relative; z-index: 10;">
        
        <!-- Tickets Section -->
        <section id="tickets" class="content-section">
            <h2 class="section-title gs-reveal">Interplanetary Flights</h2>
            <div class="grid-3">
                <div class="glass-panel ticket-card gs-reveal">
                    <h3>Lunar Base</h3>
                    <h2>$250k</h2>
                    <ul>
                        <li>3-Day Orbital Journey</li>
                        <li>Luxury Zero-G Cabin</li>
                        <li>Lunar Rover Excursion</li>
                        <li>Return Flight Included</li>
                    </ul>
                    <a href="register.php" class="ticket-btn">Book Flight</a>
                </div>
                <div class="glass-panel ticket-card gs-reveal" style="border-color: var(--primary);">
                    <h3 style="color: #fff;">Mars Colony</h3>
                    <h2 style="color: var(--primary);">$1.2M</h2>
                    <ul>
                        <li>7-Month Deep Space Flight</li>
                        <li>Cryo-Stasis Options</li>
                        <li>Terraforming Center Access</li>
                        <li>Olympus Mons Hike</li>
                    </ul>
                    <a href="register.php" class="ticket-btn" style="background: var(--primary); color: #000;">Book Flight</a>
                </div>
                <div class="glass-panel ticket-card gs-reveal">
                    <h3>Orbital Hotel</h3>
                    <h2>$50k</h2>
                    <ul>
                        <li>24-Hour Shuttle Ascent</li>
                        <li>Earth Observation Deck</li>
                        <li>Fine Dining in Zero-G</li>
                        <li>Photography Packages</li>
                    </ul>
                    <a href="register.php" class="ticket-btn">Book Flight</a>
                </div>
            </div>
        </section>

        <!-- Marquee -->
        <div style="background: var(--primary); color: #000; padding: 20px 0; overflow: hidden; margin: 4rem 0; transform: rotate(-2deg) scale(1.05); box-shadow: 0 0 40px rgba(0, 210, 255, 0.4); z-index: 20; position: relative;">
            <div class="marquee-wrapper">
                <div class="marquee-content">
                    NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • 
                </div>
                <div class="marquee-content">
                    NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • 
                </div>
            </div>
        </div>

        <!-- Product Scroll Section -->
        <section id="products" style="padding: 0; min-height: 100vh; position: relative; z-index: 10;">
            <h2 class="section-title gs-reveal" style="padding-top: 5rem; margin-bottom: -2rem;">Advanced Tech</h2>
            
            <div class="product-scroll-container">
                <div class="product-track">
                    <div class="product-card glass-panel gs-reveal">
                        <div class="product-image"><img src="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" alt="Spacesuit"></div>
                        <h3>Aero-Suit V4</h3>
                        <p>Next-gen extravehicular activity suit with integrated HUD.</p>
                        <a href="register.php" class="btn-glass" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$12.5k</a>
                    </div>
                    <div class="product-card glass-panel gs-reveal">
                        <div class="product-image"><img src="images/images/nasa-vhSz50AaFAs-unsplash.jpg" alt="Rover"></div>
                        <h3>Terra-Rover</h3>
                        <p>All-terrain personal mobility vehicle for rocky exoplanets.</p>
                        <a href="register.php" class="btn-glass" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$85k</a>
                    </div>
                    <div class="product-card glass-panel gs-reveal">
                        <div class="product-image"><img src="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" alt="Drone"></div>
                        <h3>Recon Drone</h3>
                        <p>Atmospheric probe drone with quantum-link telemetry.</p>
                        <a href="register.php" class="btn-glass" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$4.2k</a>
                    </div>
                    <div class="product-card glass-panel gs-reveal">
                        <div class="product-image"><img src="images/images/nasa-JHyiw_dpALk-unsplash.jpg" alt="Telescope"></div>
                        <h3>Deep View Scope</h3>
                        <p>Personal orbital observatory module for private stations.</p>
                        <a href="register.php" class="btn-glass" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$150k</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section id="blog" class="content-section" style="padding-bottom: 10rem;">
            <h2 class="section-title gs-reveal">Mission Logs</h2>
            <div class="grid-3">
                <div class="glass-panel blog-card gs-reveal">
                    <img src="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" class="blog-img" alt="Blog Image">
                    <h3>Finding Water on Extraterrestrial Rocks</h3>
                    <p>Recent probes have discovered immense subsurface ice reserves, fundamentally changing our understanding of survival in the cosmos...</p>
                    <a href="#" class="read-more">Read Full Log →</a>
                </div>
                <div class="glass-panel blog-card gs-reveal">
                    <img src="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" class="blog-img" alt="Blog Image">
                    <h3>The Next Generation of Warp Drives</h3>
                    <p>Propulsion technology is accelerating. How the newest iterations of ion and theoretical warp drives are making deep space accessible.</p>
                    <a href="#" class="read-more">Read Full Log →</a>
                </div>
                <div class="glass-panel blog-card gs-reveal">
                    <img src="images/images/nasa-vhSz50AaFAs-unsplash.jpg" class="blog-img" alt="Blog Image">
                    <h3>A Day in the Life of a Mars Rover</h3>
                    <p>Discover the immense challenges and incredible successes of operating a multimillion-dollar robotic vehicle continuously on another planet.</p>
                    <a href="#" class="read-more">Read Full Log →</a>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer style="background: rgba(2, 5, 10, 0.9); border-top: 1px solid rgba(0, 210, 255, 0.2); padding: 4rem 10% 2rem; margin-top: 5rem; position: relative; z-index: 20; color: #a0aec0; font-family: 'Inter', sans-serif;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 3rem; margin-bottom: 3rem;">
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="color: #fff; font-family: 'Orbitron', sans-serif; font-size: 1.5rem; letter-spacing: 2px; margin-bottom: 1.5rem; text-shadow: 0 0 10px rgba(255,255,255,0.3);">SPACEEDU</h3>
                    <p style="line-height: 1.6; font-size: 0.95rem;">Pioneering the future of deep space exploration and offering unparalleled simulated cosmic experiences for the next generation of astronauts.</p>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <h4 style="color: var(--primary); font-family: 'Cinzel', serif; font-size: 1.2rem; letter-spacing: 1px; margin-bottom: 1.5rem;">Navigation</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.8rem;">
                        <li><a href="index.php" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Home Node</a></li>
                        <li><a href="planets.php" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Planets Database</a></li>
                        <li><a href="galaxies.php" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Galaxies Explorer</a></li>
                        <li><a href="missions.php" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Missions Log</a></li>
                        <li><a href="news.php" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">News & Events</a></li>
                    </ul>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <h4 style="color: var(--primary); font-family: 'Cinzel', serif; font-size: 1.2rem; letter-spacing: 1px; margin-bottom: 1.5rem;">Legal & Support</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.8rem;">
                        <li><a href="#" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Privacy Transmissions</a></li>
                        <li><a href="#" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Terms of Orbit</a></li>
                        <li><a href="#" style="color: #a0aec0; text-decoration: none; transition: color 0.3s;">Comm-Link Support</a></li>
                    </ul>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; font-size: 0.85rem;">
                <p>&copy; <?php echo date('Y'); ?> SPACEEDU. All rights reserved across the galaxy.</p>
                <div style="display: flex; gap: 1rem;">
                    <span class="status-indicator" style="display: flex; align-items: center; gap: 8px;"><span style="display: block; width: 8px; height: 8px; background: #00ff88; border-radius: 50%; box-shadow: 0 0 10px #00ff88;"></span> Systems Online</span>
                </div>
            </div>
            <style>
                footer a:hover { color: var(--primary) !important; text-shadow: 0 0 10px rgba(0, 210, 255, 0.5); }
            </style>
        </footer>
    </div>

    <!-- ThreeJS Scene Canvas Container (Fixed Background) -->
    <div id="landing-3d"></div>

    <!-- Technical Libraries Requirements -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <script>
        // --- 1. System Initialization & Loading Animation ---
        gsap.registerPlugin(ScrollTrigger);
        
        window.addEventListener('load', () => {
            const tl = gsap.timeline();
            
            // Fade out loader
            tl.to("#loader", {opacity: 0, duration: 1, ease: "power2.inOut", onComplete: () => {
                document.getElementById('loader').style.display = 'none';
            }})
            // Cinematic staggered entrance
            .fromTo(".landing-nav", {y: -50, opacity: 0}, {y: 0, opacity: 1, duration: 1.5, ease: "power4.out"}, "-=0.3")
            .fromTo(".subtitle", {y: 30, opacity: 0}, {y: 0, opacity: 1, duration: 1.5, ease: "power4.out"}, "-=1")
            .fromTo(".massive-title", {y: 60, opacity: 0, scale: 0.9}, {y: 0, opacity: 1, scale: 1, duration: 2, ease: "expo.out"}, "-=1.2")
            .fromTo(".hero-desc", {y: 20, opacity: 0}, {y: 0, opacity: 1, duration: 1.2, ease: "power3.out"}, "-=1.4")
            .fromTo(".get-started", {y: 20, opacity: 0}, {y: 0, opacity: 1, duration: 1, ease: "back.out(1.7)"}, "-=1.2")
            .fromTo(".float-venus", {x: -80, opacity: 0}, {x: 0, opacity: 1, duration: 2.5, ease: "power3.out"}, "-=1.5")
            .fromTo(".float-mars", {x: 80, opacity: 0}, {x: 0, opacity: 1, duration: 2.5, ease: "power3.out"}, "-=2")
            .fromTo(".scroll-indicator", {y: 20, opacity: 0}, {y: 0, opacity: 0.7, duration: 1, ease: "power2.out"}, "-=1")
            .eventCallback("onComplete", initScrollAnimations);
        });

        function initScrollAnimations() {
            // Apply ScrollTrigger to all elements with class .gs-reveal
            gsap.utils.toArray('.gs-reveal').forEach(function(elem) {
                gsap.fromTo(elem, 
                    { y: 100, opacity: 0 }, 
                    {
                        scrollTrigger: {
                            trigger: elem,
                            start: "top 85%", // Trigger when element is 85% from top of screen
                            toggleActions: "play none none reverse"
                        },
                        y: 0, opacity: 1, 
                        duration: 1.2, 
                        ease: "power3.out"
                    }
                );
            });
            
            // Horizontal Product Scroll Animation
            const productTrack = document.querySelector('.product-track');
            if (productTrack) {
                let getToValue = () => -(productTrack.scrollWidth - window.innerWidth + 200);
                
                gsap.fromTo(productTrack, 
                    { x: 0 },
                    {
                        x: getToValue,
                        ease: "none",
                        scrollTrigger: {
                            trigger: ".product-scroll-container",
                            pin: true,
                            scrub: 1,
                            start: "center center",
                            end: () => "+=" + (productTrack.scrollWidth - window.innerWidth + 200),
                            invalidateOnRefresh: true
                        }
                    }
                );
            }

            // Link smooth scrolling for nav anchors
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        }

        // --- 2. Smooth Deep Parallax Mouse Tracking (GSAP) ---
        let targetCameraX = 0;
        let targetCameraY = 0;

        document.addEventListener("mousemove", (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 50;
            const y = (e.clientY / window.innerHeight - 0.5) * 50;
            
            // GSAP DOM Parallax for UI
            gsap.to("#venus", { x: -x*1.2, y: -y*0.8, duration: 2, ease: "power2.out" });
            gsap.to("#mars", { x: x*1.5, y: -y*0.6, duration: 2, ease: "power2.out" });
            gsap.to(".massive-title", { x: x*0.3, y: y*0.1, duration: 2, ease: "power2.out" });

            // Feed camera targets for ThreeJS Parallax
            targetCameraX = x * 0.03;
            targetCameraY = y * 0.03;
        });

        // --- 3. THREE.JS Cinematic 3D Scene ---
        const container = document.getElementById('landing-3d');
        const scene = new THREE.Scene();
        
        // Deep space nebula fog
        scene.fog = new THREE.FogExp2(0x02050A, 0.0012);

        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 2000);
        camera.position.z = 100;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1); // High res optimization
        container.appendChild(renderer.domElement);

        // Core Lighting Setup
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.15);
        scene.add(ambientLight);
        
        const sunLight = new THREE.DirectionalLight(0xffeedd, 1.3);
        sunLight.position.set(50, 100, 50);
        scene.add(sunLight);
        
        // Premium blue atmospheric rim light
        const rimLight = new THREE.DirectionalLight(0x00d2ff, 2.5);
        rimLight.position.set(-60, -80, -40);
        scene.add(rimLight);

        // --- Huge Realistic Rotating Earth ---
        const earthGeometry = new THREE.SphereGeometry(75, 64, 64);
        const textureLoader = new THREE.TextureLoader();
        
        const earthMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.7,
            metalness: 0.1
        });
        
        // Bind generated Earth texture 
        textureLoader.load('images/planets/earth.png', (texture) => {
            texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
            earthMaterial.map = texture;
            earthMaterial.needsUpdate = true;
        });

        const earth = new THREE.Mesh(earthGeometry, earthMaterial);
        // Placed at bottom center, partially visible
        earth.position.set(0, -85, 0); 
        earth.rotation.z = Math.PI / 12;
        scene.add(earth);

        // --- Glowing Atmosphere Shell ---
        const atmosphereGeometry = new THREE.SphereGeometry(77, 64, 64);
        const atmosphereMaterial = new THREE.MeshPhongMaterial({
            color: 0x00d2ff,
            transparent: true,
            opacity: 0.12,
            side: THREE.BackSide,
            blending: THREE.AdditiveBlending
        });
        const atmosphere = new THREE.Mesh(atmosphereGeometry, atmosphereMaterial);
        earth.add(atmosphere);

        // --- Animated Star Particles ---
        const starGeo = new THREE.BufferGeometry();
        const starCount = 4000;
        const posArray = new Float32Array(starCount * 3);
        const colorArray = new Float32Array(starCount * 3);
        const color1 = new THREE.Color(0xffffff); // White
        const color2 = new THREE.Color(0x00d2ff); // Cyan
        
        for(let i=0; i<starCount*3; i+=3) {
            const radius = 200 + Math.random() * 800; // Deep distribution
            const theta = Math.random() * Math.PI * 2;
            const phi = Math.acos(2 * Math.random() - 1);
            
            posArray[i] = radius * Math.sin(phi) * Math.cos(theta);
            posArray[i+1] = radius * Math.sin(phi) * Math.sin(theta);
            posArray[i+2] = radius * Math.cos(phi);
            
            const mix = Math.random();
            const mixedColor = color1.clone().lerp(color2, mix > 0.8 ? 1 : 0);
            colorArray[i] = mixedColor.r;
            colorArray[i+1] = mixedColor.g;
            colorArray[i+2] = mixedColor.b;
        }
        
        starGeo.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        starGeo.setAttribute('color', new THREE.BufferAttribute(colorArray, 3));
        
        const starMat = new THREE.PointsMaterial({
            size: 1.2, vertexColors: true, transparent: true, opacity: 0.9, sizeAttenuation: true
        });
        const starMesh = new THREE.Points(starGeo, starMat);
        scene.add(starMesh);

        // --- Resize Engine ---
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // --- Render Animation Loop ---
        function animate() {
            requestAnimationFrame(animate);
            // 3D Objects continuous motion
            earth.rotation.y += 0.001; 
            starMesh.rotation.y += 0.00015;
            starMesh.rotation.z += 0.00005;
            
            // Smooth Camera Interpolation Parallax
            camera.position.x += (targetCameraX - camera.position.x) * 0.05;
            camera.position.y += (-targetCameraY - camera.position.y) * 0.05;
            camera.lookAt(scene.position);
            
            renderer.render(scene, camera);
        }
        animate();
    </script>

    <!-- Chatbot Widget -->
    <div id="chat-widget-container" class="hidden">
        <div id="chat-header">
            <span>AI Space Guide</span>
            <button id="close-chat">&times;</button>
        </div>
        <div id="chat-messages"></div>
        <div id="chat-input-area">
            <input type="text" id="chat-input" placeholder="Ask about space...">
            <button id="chat-send">&#10148;</button>
        </div>
    </div>
    <button id="chat-widget-button">&#128172;</button>
    <script src="js/chat.js"></script>
</body>
</html>
