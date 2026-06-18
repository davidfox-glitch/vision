<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis - SPACEEDU</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700;600&display=swap" rel="stylesheet">
    <style>
        .analysis-wrapper {
            padding: 120px 5% 50px 5%;
            color: white;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .dashboard-header h1 {
            font-family: 'Cinzel', serif;
            font-size: 4rem;
            margin: 0;
            background: linear-gradient(180deg, #ffffff 0%, #00d2ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 5px;
        }
        .dashboard-header p {
            color: var(--text-muted);
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 3px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 210, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px;
            background: var(--primary);
        }
        .stat-value {
            font-size: 3.5rem;
            font-weight: 900;
            font-family: 'Orbitron', sans-serif;
            color: #fff;
            margin: 1rem 0;
            text-shadow: 0 0 20px rgba(0, 210, 255, 0.5);
        }
        .stat-label {
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
        }

        .metrics-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .detailed-progress {
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
        }
        .detailed-progress h2 {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary);
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }

        .progress-row { margin-bottom: 1.5rem; }
        .row-header { display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 600; letter-spacing: 1px; }
        .progress-track {
            width: 100%; height: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px; overflow: hidden;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);
        }
        .progress-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, #005c99, #00d2ff);
            border-radius: 6px;
            transition: width 1.5s cubic-bezier(0.1, 0.9, 0.2, 1);
            position: relative;
        }
        .progress-fill::after {
            content: ''; position: absolute; top:0; right: 0; bottom: 0; width: 20px;
            background: rgba(255,255,255,0.5); filter: blur(5px);
        }

        .achievements-panel {
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
        }
        
        .badge {
            display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;
            padding: 1rem; border-radius: 12px; background: rgba(0,0,0,0.3);
            border-left: 4px solid #444; opacity: 0.5; transition: all 0.3s ease;
        }
        .badge.unlocked {
            border-left-color: #ffd700; opacity: 1; background: rgba(255, 215, 0, 0.05);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.1);
        }
        .badge-icon {
            width: 40px; height: 40px; border-radius: 50%;
            background: #333; display: flex; justify-content: center; align-items: center;
            font-weight: bold; font-family: 'Orbitron', sans-serif;
        }
        .badge.unlocked .badge-icon { background: #ffd700; color: #000; box-shadow: 0 0 10px #ffd700; }
        .badge-info h4 { margin: 0 0 5px 0; color: #fff; }
        .badge-info p { margin: 0; font-size: 0.8rem; color: #aaa; }

        @media (max-width: 900px) {
            .metrics-container { grid-template-columns: 1fr; }
            .dashboard-header h1 { font-size: 2.5rem; }
        }
    </style>
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
            <li><a href="analysis.php" class="active">Analysis</a></li>
        </ul>
    </nav>

    <!-- Deep Space Background via Three.js (Imported Below) -->
    <div id="star-canvas"></div>
    <div class="clouds"></div>

    <div class="analysis-wrapper">
        <div class="dashboard-header gs-reveal">
            <h1>COMMAND CENTER</h1>
            <p>USER TELEMETRY & PROGRESS ANALYSIS</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card gs-reveal">
                <div class="stat-label">EXPLORER RANK</div>
                <div class="stat-value" id="user-rank" style="font-size: 2.5rem;">NOVICE</div>
            </div>
            <div class="stat-card gs-reveal">
                <div class="stat-label">TOTAL DISCOVERIES</div>
                <div class="stat-value" id="total-discoveries">0</div>
            </div>
            <div class="stat-card gs-reveal">
                <div class="stat-label">COMPLETION STATUS</div>
                <div class="stat-value"><span id="completion-rate">0</span>%</div>
            </div>
        </div>

        <div class="metrics-container">
            <div class="detailed-progress gs-reveal">
                <h2>DATABANK UPLINK STATUS</h2>
                
                <div class="progress-row">
                    <div class="row-header">
                        <span>Solar System Planets</span>
                        <span id="planets-stat">0/8</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="planets-bar"></div>
                    </div>
                </div>

                <div class="progress-row">
                    <div class="row-header">
                        <span>Deep Space Galaxies</span>
                        <span id="galaxies-stat">0/5</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="galaxies-bar"></div>
                    </div>
                </div>

                <div class="progress-row">
                    <div class="row-header">
                        <span>Historical NASA Missions</span>
                        <span id="missions-stat">0/5</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" id="missions-bar"></div>
                    </div>
                </div>
            </div>

            <div class="achievements-panel gs-reveal">
                <h2 style="font-family: 'Orbitron'; color: #ffd700; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">ACHIEVEMENTS</h2>
                
                <div class="badge" id="badge-1">
                    <div class="badge-icon">I</div>
                    <div class="badge-info">
                        <h4>First Steps</h4>
                        <p>Access your first planetary details page.</p>
                    </div>
                </div>
                
                <div class="badge" id="badge-2">
                    <div class="badge-icon">II</div>
                    <div class="badge-info">
                        <h4>Interstellar</h4>
                        <p>Discover 3 or more deep space galaxies.</p>
                    </div>
                </div>

                <div class="badge" id="badge-3">
                    <div class="badge-icon">III</div>
                    <div class="badge-info">
                        <h4>NASA Historian</h4>
                        <p>Analyze all 5 historical NASA missions.</p>
                    </div>
                </div>
                
                <div class="badge" id="badge-4">
                    <div class="badge-icon">★</div>
                    <div class="badge-info">
                        <h4>Cosmic Master</h4>
                        <p>Achieve 100% exploration completion.</p>
                    </div>
                </div>

                <div class="badge" id="badge-5">
                    <div class="badge-icon">🌍</div>
                    <div class="badge-info">
                        <h4>Earth Explorer</h4>
                        <p>Explored the home planet Earth.</p>
                    </div>
                </div>

                <div class="badge" id="badge-6">
                    <div class="badge-icon">🪐</div>
                    <div class="badge-info">
                        <h4>Galaxy Explorer</h4>
                        <p>Explored all planets in the solar system.</p>
                    </div>
                </div>

                <div class="badge" id="badge-7">
                    <div class="badge-icon">🚀</div>
                    <div class="badge-info">
                        <h4>Space Enthusiast</h4>
                        <p>Tuned into a live space launch broadcast.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="js/bg-stars.js?v=<?php echo time(); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // GSAP Entrances
            if (typeof gsap !== 'undefined') {
                gsap.from(".gs-reveal", {
                    y: 40, opacity: 0, duration: 1, stagger: 0.2, ease: "back.out(1.5)"
                });
            }

            // Calculation Logic
            const progress = JSON.parse(localStorage.getItem('spaceProgress')) || [];
            
            const totalPlanets = 8;
            const totalGalaxies = 5;
            const totalMissions = 5;
            const overallTotal = totalPlanets + totalGalaxies + totalMissions;
            
            // Clean up old incorrect IDs just in case, only count valid ones
            const validPlanetIds = ['planets-mercury','planets-venus','planets-earth','planets-mars','planets-jupiter','planets-saturn','planets-uranus','planets-neptune'];
            const validGalaxyIds = ['galaxies-andromeda','galaxies-orion','galaxies-milkyway','galaxies-whirlpool','galaxies-sombrero'];
            const validMissionIds = ['missions-apollo11','missions-voyager1','missions-perseverance','missions-jwst','missions-hubble'];

            let planetsSeen = progress.filter(id => validPlanetIds.includes(id)).length;
            let galaxiesSeen = progress.filter(id => validGalaxyIds.includes(id)).length;
            let missionsSeen = progress.filter(id => validMissionIds.includes(id)).length;
            
            let totalSeen = planetsSeen + galaxiesSeen + missionsSeen;
            let completionRate = Math.round((totalSeen / overallTotal) * 100);

            // Update UI Counters
            // We use GSAP to animate the numbers rolling up for premium effect
            gsap.to(document.getElementById("total-discoveries"), {
                innerText: totalSeen, duration: 2, snap: { innerText: 1 }, ease: "power2.out"
            });
            gsap.to(document.getElementById("completion-rate"), {
                innerText: completionRate, duration: 2, snap: { innerText: 1 }, ease: "power2.out"
            });
            
            // Text values
            document.getElementById('planets-stat').innerText = planetsSeen + '/' + totalPlanets;
            document.getElementById('galaxies-stat').innerText = galaxiesSeen + '/' + totalGalaxies;
            document.getElementById('missions-stat').innerText = missionsSeen + '/' + totalMissions;
            
            // Determine Rank
            let rank = "NOVICE";
            if (completionRate >= 25) rank = "ASTRONAUT";
            if (completionRate >= 50) rank = "COMMANDER";
            if (completionRate >= 85) rank = "VISIONARY";
            if (completionRate === 100) rank = "COSMIC MASTER";
            document.getElementById('user-rank').innerText = rank;

            // Delayed Progress Bar Fills
            setTimeout(() => {
                document.getElementById('planets-bar').style.width = (planetsSeen / totalPlanets * 100) + '%';
                document.getElementById('galaxies-bar').style.width = (galaxiesSeen / totalGalaxies * 100) + '%';
                document.getElementById('missions-bar').style.width = (missionsSeen / totalMissions * 100) + '%';
            }, 600);

            // Unlock Badges
            if (totalSeen >= 1) document.getElementById('badge-1').classList.add('unlocked');
            if (galaxiesSeen >= 3) document.getElementById('badge-2').classList.add('unlocked');
            if (missionsSeen === totalMissions) document.getElementById('badge-3').classList.add('unlocked');
            if (completionRate === 100) document.getElementById('badge-4').classList.add('unlocked');
            
            // New SPACEEDU Badges
            if (progress.includes('planets-earth')) document.getElementById('badge-5').classList.add('unlocked');
            if (planetsSeen === totalPlanets) document.getElementById('badge-6').classList.add('unlocked');
            if (localStorage.getItem('watchedLiveLaunch')) document.getElementById('badge-7').classList.add('unlocked');
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
