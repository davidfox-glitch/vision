<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missions - SPACEEDU</title>
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
            <li><a href="missions.php" class="active">Missions</a></li>
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
            <h1 style="margin-bottom: 2rem; color: var(--primary); font-family: 'Orbitron', sans-serif; font-size: 3rem;" class="glitch-effect">MISSIONS</h1>
            
            <ul class="planet-list">
                <li data-image="https://images.unsplash.com/photo-1541873676-a18131494184?auto=format&fit=crop&w=800&q=80" data-title="Apollo 11" data-desc="The American spaceflight that first landed humans on the Moon on July 20, 1969." data-temp="N/A" data-gravity="N/A" data-history="Landed July 20, 1969" data-id="missions-apollo11">Apollo 11 Landing</li>
                <li data-image="https://images.unsplash.com/photo-1614729939124-03290b56c9ce?auto=format&fit=crop&w=800&q=80" data-title="Voyager 1" data-desc="A space probe launched by NASA on September 5, 1977. It is currently the most distant human-made object from Earth." data-temp="Deep Space" data-gravity="0" data-history="Launched Sept 5, 1977" data-id="missions-voyager1">Voyager 1 Probe</li>
                <li data-image="images/images/nasa-vhSz50AaFAs-unsplash.jpg" data-title="Perseverance Rover" data-desc="A car-sized Mars rover designed to explore the crater Jezero on Mars as part of NASA's Mars 2020 mission." data-temp="Martian Temps" data-gravity="0.38g" data-history="Landed Feb 18, 2021" data-id="missions-perseverance" class="active">Perseverance Rover</li>
                <li data-image="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" data-title="Hubble Telescope" data-desc="One of the most valuable and versatile space telescopes ever built, orbiting Earth since 1990." data-temp="Space Vacuum" data-gravity="0" data-history="Launched April 24, 1990" data-id="missions-hubble">Hubble Space Telescope</li>
                <li data-image="images/images/nasa-JHyiw_dpALk-unsplash.jpg" data-title="James Webb Telescope" data-desc="A space telescope designed primarily to conduct infrared astronomy. It is the most powerful telescope ever launched." data-temp="< 50 Kelvin" data-gravity="0" data-history="Launched December 25, 2021" data-id="missions-jwst">James Webb Telescope</li>
                <li data-image="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80" data-title="Artemis I" data-desc="The first uncrewed flight of the Artemis program, designed to orbit the Moon and return to Earth." data-temp="Space Vacuum" data-gravity="0" data-history="Launched Nov 16, 2022" data-id="missions-artemis1">Artemis I</li>
                <li data-image="https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=800&q=80" data-title="Cassini-Huygens" data-desc="A joint NASA-ESA-ASI mission that studied the planet Saturn and its system, including its rings and moons." data-temp="Deep Space" data-gravity="0" data-history="Launched Oct 15, 1997" data-id="missions-cassini">Cassini-Huygens</li>
                <li data-image="https://images.unsplash.com/photo-1618141973059-86c2aa2d59ae?auto=format&fit=crop&w=800&q=80" data-title="Curiosity Rover" data-desc="A car-sized rover exploring Gale Crater on Mars to determine if it could ever have supported microbial life." data-temp="Martian Temps" data-gravity="0.38g" data-history="Landed Aug 6, 2012" data-id="missions-curiosity">Curiosity Rover</li>
                <li data-image="https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=800&q=80" data-title="New Horizons" data-desc="The first spacecraft to explore Pluto and its moons, providing unprecedented views of the dwarf planet." data-temp="< 50 Kelvin" data-gravity="0" data-history="Launched Jan 19, 2006" data-id="missions-newhorizons">New Horizons</li>
                <li data-image="https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?auto=format&fit=crop&w=800&q=80" data-title="Chandra X-ray" data-desc="A Flagship-class space telescope designed to detect X-ray emission from very hot regions of the Universe." data-temp="Space Vacuum" data-gravity="0" data-history="Launched July 23, 1999" data-id="missions-chandra">Chandra Observatory</li>
            </ul>
        </div>
        
        <div class="explore-viewer">
            <div class="planet-sphere-container">
                <!-- 3D Canvas injects here -->
                <div class="planet-glow"></div>
            </div>
            
            <div class="planet-info-overlay">
                <h1 id="planet-title" class="glitch-effect">Perseverance Rover</h1>
                <p id="planet-desc">A car-sized Mars rover designed to explore the crater Jezero on Mars as part of NASA's Mars 2020 mission.</p>
                <div class="planet-stats" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.8rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">TEMP:</span> <span id="planet-temp">N/A</span></div>
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">GRAVITY:</span> <span id="planet-gravity">N/A</span></div>
                    <div><span style="color: var(--primary); font-weight: bold; font-family: 'Orbitron', sans-serif;">HISTORY:</span> <span id="planet-history">Launched July 30, 2020</span></div>
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
</body>
</html>
