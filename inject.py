import os
import glob

# Content to inject
product_scroll_html = """
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

    <!-- Product Scroll Section -->
    <section id="products" style="padding: 0; min-height: 100vh; position: relative; z-index: 10;">
        <h2 class="section-title gs-reveal" style="padding-top: 5rem; margin-bottom: -2rem; font-family: 'Orbitron', serif; font-size: 4rem; text-align: center; color:var(--text-main);">Advanced Tech</h2>
        <div class="product-scroll-container" style="width: 100%; height: 100vh; display: flex; align-items: center; overflow: hidden; position: relative;">
            <div class="product-track" style="display: flex; gap: 4rem; padding: 0 10%; width: max-content;">
                <!-- Product 1 -->
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/simon-lee-XnGxTBij48Q-unsplash.jpg" alt="Spacesuit" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Aero-Suit V4</h3>
                    <p style="color: #a0aec0;">Next-gen extravehicular activity suit with integrated HUD.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">.5k</a>
                </div>
                <!-- Product 2 -->
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/nasa-vhSz50AaFAs-unsplash.jpg" alt="Rover" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Terra-Rover</h3>
                    <p style="color: #a0aec0;">All-terrain personal mobility vehicle for rocky exoplanets.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;"></a>
                </div>
                <!-- Product 3 -->
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/planet-volumes-awYEQyYdHVE-unsplash.jpg" alt="Drone" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Recon Drone</h3>
                    <p style="color: #a0aec0;">Atmospheric probe drone with quantum-link telemetry.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;">.2k</a>
                </div>
                <!-- Product 4 -->
                <div class="product-card glass-panel" style="width: 350px; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; text-align: center; transform: scale(0.95); transition: transform 0.5s ease; background: linear-gradient(135deg, rgba(20,25,40,0.7), rgba(10,15,30,0.4)); backdrop-filter: blur(25px) saturate(200%); border-radius: 30px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 3rem; color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.5);">
                    <div class="product-image" style="width: 100%; height: 250px; border-radius: 15px; overflow: hidden; margin-bottom: 1.5rem;"><img src="images/images/nasa-JHyiw_dpALk-unsplash.jpg" alt="Telescope" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"></div>
                    <h3 style="font-size: 1.8rem; color: var(--primary); font-family: 'Orbitron', serif; margin: 0.5rem 0;">Deep View</h3>
                    <p style="color: #a0aec0;">Personal orbital observatory module for private stations.</p>
                    <a href="register.php" class="btn" style="padding: 0.5rem 1.5rem; display: inline-block; margin-top: 1rem;"></a>
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
                // Initialize Smooth Scrolling (Lenis)
                const lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
                function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
                requestAnimationFrame(raf);
                
                if(typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    gsap.registerPlugin(ScrollTrigger);
                    // Match GSAP and Lenis
                    lenis.on('scroll', ScrollTrigger.update);
                    gsap.ticker.add((time) => { lenis.raf(time * 1000) });
                    gsap.ticker.lagSmoothing(0);
                    
                    // Add smooth side scroll logic
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
"""

lenis_only = """
        <script src="https://unpkg.com/@studio-freight/lenis@1.0.34/dist/lenis.min.js"></script>
        <script>
            // Initialize Lenis smooth scroll for index.php too
            document.addEventListener('DOMContentLoaded', () => {
                if(typeof Lenis === 'undefined') return;
                const lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
                function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
                requestAnimationFrame(raf);
                if(typeof gsap !== 'undefined') {
                    lenis.on('scroll', ScrollTrigger.update);
                    gsap.ticker.add((time) => { lenis.raf(time * 1000) });
                    gsap.ticker.lagSmoothing(0);
                }
            });
        </script>
"""

import codecs

for f in glob.glob("C:/xampp/htdocs/vision 2/*.php"):
    if os.path.basename(f) in ['db.php', 'test_db.php', 'logout.php']:
        continue
    
    with codecs.open(f, 'r', 'utf-8') as file:
        content = file.read()
    
    # Check if already injected
    if '<!-- Product Scroll Injection -->' in content or 'Lenis' in content:
        continue
        
    print(f"Injecting into {f}")
    if os.path.basename(f) == "index.php":
        # Just inject Lenis for smooth scroll on the whole page since product scroll is already there
        if "</body>" in content:
            content = content.replace("</body>", lenis_only + "\n</body>")
    else:
        # Inject product scroll + lenis just before scripts if possible
        if "</body>" in content:
            # Insert just before <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js or just before </body>
            if "<script" in content.split("</div>")[-1]:
                content = content.replace("</body>", product_scroll_html + "\n</body>")
            else:
                content = content.replace("</body>", product_scroll_html + "\n</body>")
                
    with codecs.open(f, 'w', 'utf-8') as file:
        file.write(content)
print("Done")
