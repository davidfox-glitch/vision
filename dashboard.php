<?php
session_start();
require_once 'db.php';

// Fetch NASA Astronomy Picture of the Day from Supabase
function getApodFromDB() {
    try {
        $result = supabase_request('nasa_data?select=title,url,explanation,date,media_type&order=date.desc&limit=1');
        return !empty($result) ? $result[0] : false;
    } catch (Exception $e) {
        return false;
    }
}

$apod = getApodFromDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Horizons | Immersive Space</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
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

    <!-- Background animations -->
    <div id="star-canvas"></div>
    <div class="clouds"></div>

    <div class="immersive-explore">
        <div class="explore-sidebar glassmorphism">
            <h1 style="margin-bottom: 0.5rem; color: var(--text-main); font-family: 'Orbitron', sans-serif; font-size: 3rem;">SPACE</h1>
            <h1 style="margin-bottom: 2rem; color: var(--primary); font-family: 'Orbitron', sans-serif; font-size: 3rem;" class="glitch-effect">EDU</h1>
            <p style="margin-bottom: 2.5rem; color: var(--text-muted); font-size: 1.1rem;">Welcome to the most advanced simulated space exploration platform.</p>
            
            <ul class="planet-list">
                <li data-target="planets.php" data-image="images/planets/earth.png" data-title="Planets Database" data-desc="Explore our interactive database of our solar system's planets. Discover details like temperatures, gravitational forces, and history." class="active">Planets Database</li>
                <li data-target="galaxies.php" data-image="images/images/nasa-JHyiw_dpALk-unsplash.jpg" data-title="Galaxies Explorer" data-desc="Dive into the endless abyss of the cosmos and view breathtaking galaxies far beyond our reach.">Galaxies Explorer</li>
                <li data-target="missions.php" data-image="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" data-title="Missions Log" data-desc="Review historical and ongoing space missions. Track humanity's remarkable progress in conquering the stars.">Missions Log</li>
                <li data-target="analysis.php" data-image="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" data-title="Analytics & Progress" data-desc="Monitor your exploration progress and analyze astronomical data gathered during your journey.">Analytics & Progress</li>
            </ul>
            
            <div style="margin-top: 3.5rem;">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="planets.php" class="btn">Access Database</a>
                <?php else: ?>
                    <a href="register.php" class="btn">Join Mission</a>
                    <a href="login.php" class="btn" style="background: transparent; border-color: rgba(255,255,255,0.2); margin-top: 15px;">Login Account</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="explore-viewer">
            <div class="planet-sphere-container">
                <!-- 3D Canvas injects here -->
                <div class="planet-glow"></div>
            </div>
            
            <div class="planet-info-overlay" style="margin-top: 2rem; text-align: center; max-width: 600px; z-index: 20; position: relative;">
                <div class="subtitle" style="font-size: 0.9rem; letter-spacing: 10px; color: var(--primary); text-transform: uppercase; margin-bottom: 5px;">Initiate Sequence</div>
                <h1 id="planet-title" class="massive-title" style="font-family: 'Cinzel', serif; font-size: 5rem; line-height: 1; margin: 0; font-weight: 800; letter-spacing: 8px; background: linear-gradient(180deg, #ffffff 0%, #8b9bb4 70%, #2f405c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 10px 30px rgba(0,0,0,0.8);">Planets Database</h1>
                <p id="planet-desc" style="font-size: 1.2rem; color: var(--text-muted); line-height: 1.6;">Explore our interactive database of our solar system's planets. Discover details like temperatures, gravitational forces, and history.</p>
            </div>
        </div>
    </div>

    <!-- NASA APOD Section -->
    <?php if($apod && $apod['media_type'] === 'image'): ?>
    <section class="nasa-apod" style="position: relative; z-index: 10; padding: 4rem 10%; margin-top: 5rem;">
        <div class="glass-panel" style="background: linear-gradient(135deg, rgba(20,25,40,0.8), rgba(10,15,30,0.6)); backdrop-filter: blur(20px); border-radius: 30px; border: 1px solid rgba(0, 210, 255, 0.2); padding: 3rem; display: flex; flex-wrap: wrap; gap: 3rem; align-items: center; box-shadow: 0 20px 50px rgba(0,0,0,0.8);">
            <div style="flex: 1; min-width: 300px;">
                <span style="color: #ff3366; font-family: 'Orbitron', sans-serif; font-size: 0.9rem; letter-spacing: 2px; font-weight: bold;">LIVE NASA TELEMETRY</span>
                <h2 style="font-family: 'Cinzel', serif; font-size: 2.5rem; color: #fff; margin: 1rem 0;"><?php echo htmlspecialchars($apod['title']); ?></h2>
                <p style="color: #a0aec0; line-height: 1.8; font-size: 1rem; margin-bottom: 2rem; max-height: 200px; overflow-y: auto; padding-right: 15px; border-right: 2px solid rgba(0,210,255,0.2);">
                    <?php echo htmlspecialchars($apod['explanation']); ?>
                </p>
                <div style="color: var(--primary); font-family: 'Orbitron', sans-serif; font-size: 0.8rem; letter-spacing: 1px;">DATE: <?php echo htmlspecialchars($apod['date']); ?></div>
            </div>
            <div style="flex: 1.5; min-width: 300px; text-align: center;">
                <div style="border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,210,255,0.2);">
                    <img src="<?php echo htmlspecialchars($apod['url']); ?>" alt="<?php echo htmlspecialchars($apod['title']); ?>" style="width: 100%; max-height: 500px; object-fit: cover; display: block; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <style>
        .float-mars { position: fixed; left: 2%; top: 35%; width: 120px; border-radius: 50%; filter: drop-shadow(0 0 30px rgba(255, 60, 0, 0.2)); animation: float 14s ease-in-out infinite; z-index: -1; opacity: 0.4; }
        .float-venus { position: fixed; right: 2%; top: 20%; width: 90px; border-radius: 50%; filter: drop-shadow(0 0 30px rgba(255, 200, 0, 0.2)); animation: float 18s ease-in-out infinite reverse; z-index: -1; opacity: 0.4; }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-35px) rotate(8deg); } }
    </style>
    
    <img src="images/planets/mars.png" class="float-mars" id="mars" alt="Mars">
    <img src="images/planets/venus.png" class="float-venus" id="venus" alt="Venus">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="js/bg-stars.js?v=<?php echo time(); ?>"></script>
    <script src="js/planet3d.js?v=<?php echo time(); ?>"></script>
    <script src="script.js?v=<?php echo time(); ?>"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(typeof gsap !== 'undefined') {
                gsap.from(".navbar", { y: -50, opacity: 0, duration: 1.5, ease: "power4.out" });
                gsap.from(".explore-sidebar", { x: -100, opacity: 0, duration: 1.5, ease: "power3.out", delay: 0.2 });
                gsap.from(".planet-sphere-container", { scale: 0.8, opacity: 0, duration: 2, ease: "expo.out", delay: 0.4 });
                gsap.from(".planet-info-overlay", { y: 50, opacity: 0, duration: 1.5, ease: "power3.out", delay: 0.6 });
                
                // Parallax 
                document.addEventListener("mousemove", (e) => {
                    const x = (e.clientX / window.innerWidth - 0.5) * 40;
                    const y = (e.clientY / window.innerHeight - 0.5) * 40;
                    gsap.to("#mars", { x: -x, y: -y, duration: 2, ease: "power2.out" });
                    gsap.to("#venus", { x: x * 1.5, y: -y * 0.5, duration: 2, ease: "power2.out" });
                });
            }
        });
    </script>
    <!-- Product Scroll Injection -->
    <div style="background: var(--primary); color: #000; padding: 20px 0; overflow: hidden; margin: 4rem 0; transform: rotate(-2deg) scale(1.05); box-shadow: 0 0 40px rgba(0, 210, 255, 0.4); z-index: 20; position: relative;">
        <div style="display: flex; width: max-content; animation: marquee 30s linear infinite;">
            <div style="white-space: nowrap; font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.8rem; letter-spacing: 5px; padding-right: 20px;">
                NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • 
            </div>
            <div style="white-space: nowrap; font-family: 'Inter', sans-serif; font-weight: 800; font-size: 1.8rem; letter-spacing: 5px; padding-right: 20px;">
                NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • NEXT GENERATION TECH • ZERO GRAVITY EXPERIENCE • EXPLORE THE UNKNOWN • ADVANCED AEROSPACE ENGINEERING • 
            </div>
        </div>
    </div>

    <section id="products" style="padding: 0; min-height: 100vh; position: relative; z-index: 10;">
        <h2 class="section-title gs-reveal" style="padding-top: 5rem; margin-bottom: -2rem; font-family: 'Orbitron', serif; font-size: 4rem; text-align: center; color:var(--text-main);">Advanced Tech</h2>
        <div class="product-scroll-container" style="width: 100%; height: 100vh; display: flex; align-items: center; overflow: hidden; position: relative;">
            <div class="product-track" style="display: flex; gap: 4rem; padding: 0 10%; width: max-content;">
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" alt="Spacesuit" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Aero-Suit V4</h3>
                    <p style="color: #a0aec0;">Next-gen extravehicular activity suit with integrated HUD.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$12.5k</a>
                </div>
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/nasa-vhSz50AaFAs-unsplash.jpg" alt="Rover" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Terra-Rover</h3>
                    <p style="color: #a0aec0;">All-terrain personal mobility vehicle for rocky exoplanets.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$85k</a>
                </div>
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" alt="Drone" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Recon Drone</h3>
                    <p style="color: #a0aec0;">Atmospheric probe drone with quantum-link telemetry.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$4.2k</a>
                </div>
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/nasa-JHyiw_dpALk-unsplash.jpg" alt="Telescope" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Deep View</h3>
                    <p style="color: #a0aec0;">Personal orbital observatory module for private stations.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">$150k</a>
                </div>
            </div>
        </div>
        <style>
            .product-card:hover { transform: scale(1.05) !important; border-color: var(--primary) !important; box-shadow: 0 0 30px rgba(0, 210, 255, 0.3) !important; }
            .product-card:hover .product-image img { transform: scale(1.1) !important; }
            @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        </style>
        <script src="https://unpkg.com/@studio-freight/lenis@1.0.34/dist/lenis.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Lenis for Smooth Scrolling
                const lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
                function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
                requestAnimationFrame(raf);
                
                if(typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    gsap.registerPlugin(ScrollTrigger);
                    lenis.on('scroll', ScrollTrigger.update);
                    gsap.ticker.add((time) => { lenis.raf(time * 1000) });
                    gsap.ticker.lagSmoothing(0);
                    
                    const tracks = document.querySelectorAll('.product-track');
                    tracks.forEach(pt => {
                        let totalDist = pt.scrollWidth - window.innerWidth + 200;
                        if(totalDist > 0) {
                            gsap.fromTo(pt, { x: 0 }, {
                                x: -totalDist,
                                ease: "none",
                                scrollTrigger: {
                                    trigger: pt.closest('.product-scroll-container'),
                                    pin: true,
                                    scrub: 1,
                                    start: "center center",
                                    end: () => "+=" + totalDist,
                                    invalidateOnRefresh: true
                                }
                            });
                        }
                    });
                }
            });
        </script>
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
</body>
</html>
