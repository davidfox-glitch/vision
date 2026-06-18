<?php
session_start();

// Fetch Real-Time Space News from Spaceflight News API
function getSpaceNews() {
    $url = "https://api.spaceflightnewsapi.net/v4/articles/?limit=6";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 second timeout
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if($response) {
        $data = json_decode($response, true);
        if(isset($data['results']) && is_array($data['results'])) {
            return $data['results'];
        }
    }
    return false;
}

$liveArticles = getSpaceNews();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Space News - SPACEEDU</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&display=swap" rel="stylesheet">
    <style>
        .news-wrapper {
            padding: 120px 5% 50px 5%;
            color: white;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 4rem;
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

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            margin-bottom: 4rem;
        }

        .news-card {
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 210, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transition: all 0.4s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            border-color: rgba(0, 210, 255, 0.5);
            box-shadow: 0 15px 40px rgba(0,210,255,0.2);
        }

        .news-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.5s ease;
        }
        
        .news-card:hover .news-image {
            transform: scale(1.05);
        }

        .news-content {
            padding: 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-tag {
            background: rgba(0, 210, 255, 0.1);
            color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 1rem;
            align-self: flex-start;
            border: 1px solid rgba(0, 210, 255, 0.3);
        }

        .news-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.4rem;
            margin: 0 0 1rem 0;
            color: #fff;
            line-height: 1.4;
        }

        .news-desc {
            color: #a0aec0;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            font-size: 0.95rem;
        }

        .read-more {
            color: var(--primary);
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
            transition: color 0.3s;
            font-size: 0.9rem;
        }
        
        .read-more:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 210, 255, 0.8);
        }

        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ff3366;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Orbitron', sans-serif;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #ff3366;
            border-radius: 50%;
            box-shadow: 0 0 10px #ff3366;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 51, 102, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(255, 51, 102, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 51, 102, 0); }
        }

        /* Hero Video Launch */
        .live-launch-container {
            width: 100%;
            height: 500px;
            background: url('https://images.unsplash.com/photo-1541873676-a18131494184?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            border-radius: 20px;
            margin-bottom: 4rem;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            border: 1px solid rgba(0, 210, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            overflow: hidden;
        }
        
        .live-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to top, rgba(2, 5, 10, 0.9) 0%, rgba(2, 5, 10, 0.3) 100%);
            z-index: 1;
        }

        .live-launch-content {
            position: relative;
            z-index: 2;
        }

        .live-tag {
            background: #ff3366;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            font-family: 'Orbitron', sans-serif;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 1rem;
            letter-spacing: 2px;
            box-shadow: 0 0 15px rgba(255, 51, 102, 0.6);
            animation: pulse-border 2s infinite;
        }
        
        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0 rgba(255, 51, 102, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(255, 51, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 51, 102, 0); }
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
            <li><a href="news.php" class="active">News & Live</a></li>
            <li><a href="analysis.php">Analysis</a></li>
        </ul>
    </nav>

    <!-- Deep Space Background via Three.js -->
    <div id="star-canvas"></div>
    <div class="clouds"></div>

    <div class="news-wrapper">
        <div class="dashboard-header gs-reveal">
            <h1>COMMUNICATIONS LINK</h1>
            <p>REAL-TIME SPACE NEWS & LAUNCH EVENTS</p>
        </div>

        <div class="live-indicator gs-reveal">
            <div class="pulse-dot"></div> LIVE BROADCAST FEED
        </div>

        <!-- Featured Live Launch -->
        <div class="live-launch-container gs-reveal">
            <div class="live-overlay"></div>
            <div class="live-launch-content">
                <div class="live-tag">LIVE NOW</div>
                <h2 style="font-family: 'Cinzel', serif; font-size: 3rem; margin: 0 0 1rem 0; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">SpaceX Starship Orbital Test Flight</h2>
                <p style="font-size: 1.1rem; color: #cbd5e1; max-width: 600px; margin-bottom: 2rem; line-height: 1.5;">Watch live as SpaceX attempts to launch the most powerful rocket ever built into orbit. Integrated flight test operations are currently underway.</p>
                <a href="#" id="live-stream-btn" class="btn" style="padding: 1rem 2.5rem; letter-spacing: 2px;">Join Live Stream</a>
            </div>
        </div>

        <div class="news-grid">
            <?php if($liveArticles && count($liveArticles) > 0): ?>
                <?php foreach($liveArticles as $article): ?>
                    <div class="news-card gs-reveal">
                        <div style="overflow: hidden;">
                            <img src="<?php echo htmlspecialchars($article['image_url'] ?? 'images/images/nasa-JHyiw_dpALk-unsplash.jpg'); ?>" alt="News Image" class="news-image" onerror="this.src='images/images/nasa-JHyiw_dpALk-unsplash.jpg'">
                        </div>
                        <div class="news-content">
                            <span class="news-tag"><?php echo htmlspecialchars($article['news_site'] ?? 'Space News'); ?></span>
                            <h3 class="news-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                            <p class="news-desc">
                                <?php 
                                    $summary = $article['summary'] ?? '';
                                    if(strlen($summary) > 120) {
                                        echo htmlspecialchars(substr($summary, 0, 120)) . '...';
                                    } else {
                                        echo htmlspecialchars($summary);
                                    }
                                ?>
                            </p>
                            <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank" class="read-more">Decrypt Transmission &rarr;</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Static Content if API is down -->
                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1614728894747-a83421e2b9c9?auto=format&fit=crop&w=800&q=80" alt="Black Hole" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">Black Hole Research</span>
                        <h3 class="news-title">Event Horizon Telescope Captures New Black Hole Image</h3>
                        <p class="news-desc">Astronomers have unveiled the first image of the supermassive black hole at the center of our own Milky Way galaxy, Sagittarius A*.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>

                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80" alt="NASA" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">NASA Updates</span>
                        <h3 class="news-title">Artemis II Crew Announced for Lunar Mission</h3>
                        <p class="news-desc">NASA has revealed the four astronauts who will orbit the Moon, returning humanity to the lunar vicinity for the first time in over 50 years.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>

                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=800&q=80" alt="Exoplanet" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">New Planet Discoveries</span>
                        <h3 class="news-title">James Webb Detects Water on Distant Exoplanet</h3>
                        <p class="news-desc">The JWST has confirmed the presence of water vapor in the atmosphere of a gas giant orbiting a star 1,150 light-years away.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>

                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" alt="Rover" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">Mars Exploration</span>
                        <h3 class="news-title">Perseverance Rover Collects Crucial Rock Sample</h3>
                        <p class="news-desc">The Mars rover has successfully cored and stored its 14th rock sample, providing vital clues about the planet's ancient hydrological history.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>
                
                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=800&q=80" alt="ISS" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">Space Stations</span>
                        <h3 class="news-title">Commercial Axiom Module Successfully Docks</h3>
                        <p class="news-desc">The first commercial laboratory module has successfully attached to the International Space Station, marking a new era of orbital research.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>

                <div class="news-card gs-reveal">
                    <div style="overflow: hidden;"><img src="https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3?auto=format&fit=crop&w=800&q=80" alt="Nebula" class="news-image"></div>
                    <div class="news-content">
                        <span class="news-tag">Deep Space</span>
                        <h3 class="news-title">Unprecedented View of the Tarantula Nebula</h3>
                        <p class="news-desc">New composite imagery from multiple observatories provides the most detailed look ever at star formation within the massive Tarantula Nebula.</p>
                        <a href="#" class="read-more">Decrypt Transmission →</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Required 3D Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="js/bg-stars.js?v=<?php echo time(); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // GSAP Entrances
            if (typeof gsap !== 'undefined') {
                gsap.from(".gs-reveal", {
                    y: 40, opacity: 0, duration: 1, stagger: 0.15, ease: "back.out(1.5)"
                });
            }
            
            // Watch Live Launch Track for Achievement
            const liveBtn = document.getElementById('live-stream-btn');
            if (liveBtn) {
                liveBtn.addEventListener('click', () => {
                    if(!localStorage.getItem('watchedLiveLaunch')) {
                        localStorage.setItem('watchedLiveLaunch', 'true');
                        alert("ACHIEVEMENT UNLOCKED: Space Enthusiast! You tuned into a live broadcast.");
                    }
                });
            }
        });
    </script>

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
