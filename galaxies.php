<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galaxies - SPACEEDU</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo">SPACEEDU</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="planets.php">Planets</a></li>
            <li><a href="galaxies.php">Galaxies</a></li>
            <li><a href="missions.php">Missions</a></li>
            <li><a href="news.php">News & Live</a></li>
            <li><a href="analysis.php">Analysis</a></li>
        </ul>
    </nav>

    <!-- Background animations -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>

    <div class="immersive-explore">
        <div class="explore-sidebar glassmorphism">
            <h1 style="margin-bottom: 2rem; color: var(--primary); font-family: 'Orbitron', sans-serif; font-size: 3rem;" class="glitch-effect">GALAXIES</h1>
            
            <ul class="planet-list">
                <li data-image="images/images/nasa-JHyiw_dpALk-unsplash.jpg" data-title="Andromeda Galaxy" data-desc="The Andromeda Galaxy (M31) is the nearest major galaxy to the Milky Way, located about 2.5 million light-years away." data-temp="Absolute Zero" data-gravity="1.5 Trillion M☉" data-history="Identified by Edwin Hubble, 1920s" data-id="galaxies-andromeda" class="active"><img src="images/images/nasa-JHyiw_dpALk-unsplash.jpg" class="list-thumb"> Andromeda Galaxy</li>
                
                <li data-image="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" data-title="Orion Nebula" data-desc="The Orion Nebula is a breathtaking active stellar nursery situated incredibly close to Earth—just 1,344 light-years away." data-temp="10k Kelvin Plasma" data-gravity="Nebular Collapse" data-history="Discovered by Nicolas-Claude, 1610" data-id="galaxies-orion"><img src="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" class="list-thumb"> Orion Nebula</li>
                
                <li data-image="images/planets/milkyway.png" data-title="Milky Way" data-desc="The Milky Way is the barred spiral galaxy that contains our entire Solar System and an estimated 400 billion stars." data-temp="Extreme Variance" data-gravity="Sgr A* Supermassive Black Hole" data-history="Understood conceptually by Democritus" data-id="galaxies-milkyway"><img src="images/planets/milkyway.png" class="list-thumb"> Milky Way Galaxy</li>
                
                <li data-image="images/planets/whirlpool.png" data-title="Whirlpool Galaxy" data-desc="An interacting grand-design spiral galaxy with a Seyfert 2 active galactic nucleus, deeply studied for its structure." data-temp="Unknown" data-gravity="Interacting System" data-history="Discovered by Charles Messier, 1773" data-id="galaxies-whirlpool"><img src="images/planets/whirlpool.png" class="list-thumb"> Whirlpool Galaxy</li>
                
                <li data-image="images/planets/sombrero.png" data-title="Sombrero Galaxy" data-desc="A peculiar unbarred spiral galaxy with a prominent dust lane and an incredibly large central bulge." data-temp="Unknown" data-gravity="800 Billion M☉" data-history="Discovered by Pierre Méchain, 1781" data-id="galaxies-sombrero"><img src="images/planets/sombrero.png" class="list-thumb"> Sombrero Galaxy</li>
            </ul>
        </div>
        
        <div class="explore-viewer">
            <div class="planet-sphere-container">
                <!-- 3D Canvas injects here -->
                <div class="planet-glow"></div>
            </div>
            
            <div class="planet-info-overlay">
                <h1 id="planet-title" class="glitch-effect">Andromeda Galaxy</h1>
                <p id="planet-desc">The closest large galaxy to the Milky Way and is one of a few galaxies that can be seen unaided from the Earth.</p>
                <div class="planet-stats" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.8rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">TEMP:</span> <span id="planet-temp">N/A</span></div>
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">GRAVITY:</span> <span id="planet-gravity">N/A</span></div>
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">HISTORY:</span> <span id="planet-history">Discovered by Al-Sufi in 964 AD</span></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="js/bg-stars.js?v=<?php echo time(); ?>"></script>
    <script src="js/planet3d.js?v=<?php echo time(); ?>"></script>
    <script src="script.js?v=<?php echo time(); ?>"></script>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
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
