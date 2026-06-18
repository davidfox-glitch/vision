// 1. IMMERSIVE EXPLORE INTERACTION
const planetListItems = document.querySelectorAll('.planet-list li');
const planetTitle = document.getElementById('planet-title');
const planetDesc = document.getElementById('planet-desc');
const planetTemp = document.getElementById('planet-temp');
const planetGravity = document.getElementById('planet-gravity');
const planetHistory = document.getElementById('planet-history');

// Removed old flat image references
let currentPlanetSrc = '';

// Track progress
function updateProgress(id) {
    try {
        let progress = JSON.parse(localStorage.getItem('spaceProgress')) || [];
        if(!progress.includes(id)) {
            progress.push(id);
            localStorage.setItem('spaceProgress', JSON.stringify(progress));
        }
    } catch(e) {
        console.warn('Progress tracking disabled/failed', e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Initialize True 3D Engine if container exists
    if(typeof init3DPlanet === 'function') {
        init3DPlanet();
    }

    // Set initial 3D globe texture from the active list item
    const initialActive = document.querySelector('.planet-list li.active');
    if (initialActive && typeof updatePlanetTexture3D === 'function') {
        currentPlanetSrc = initialActive.getAttribute('data-image');
        updatePlanetTexture3D(currentPlanetSrc);
    }

    if(planetListItems.length > 0) {
        planetListItems.forEach(item => {
            item.addEventListener('click', () => {
            const trackingId = item.getAttribute('data-id');
            if(trackingId) {
                window.location.href = 'details.php?id=' + trackingId;
            }
        });

        item.addEventListener('mouseenter', () => {
                // Remove active from all
                planetListItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                
                const imageSrc = item.getAttribute('data-image');
                const trackingId = item.getAttribute('data-id') || item.innerText;
                const newTitle = item.getAttribute('data-title');
                const newDesc = item.getAttribute('data-desc');
                
                const newTemp = item.getAttribute('data-temp');
                const newGravity = item.getAttribute('data-gravity');
                const newHistory = item.getAttribute('data-history');
                
                updateProgress(trackingId); // Record progress
                
                // If title exists and it's changed, update it
                if(planetTitle && newTitle && planetTitle.innerText.trim() !== newTitle.trim()) {
                    planetTitle.classList.add('fading');
                    if(planetDesc) planetDesc.classList.add('fading');
                    
                    if(planetTemp) {
                        planetTemp.parentNode.parentNode.classList.add('fading');
                    }
                    
                    setTimeout(() => {
                        planetTitle.innerText = newTitle;
                        if(planetDesc) planetDesc.innerText = newDesc;
                        
                        if(planetTemp) {
                            planetTemp.innerText = newTemp || 'N/A';
                            if(planetGravity) planetGravity.innerText = newGravity || 'N/A';
                            if(planetHistory) planetHistory.innerText = newHistory || 'N/A';
                            planetTemp.parentNode.parentNode.classList.remove('fading');
                        }
                        
                        planetTitle.classList.remove('fading');
                        if(planetDesc) planetDesc.classList.remove('fading');
                    }, 400);
                }
                
                // Send texture update to 3D Renderer if it has changed
                if(imageSrc !== currentPlanetSrc && typeof updatePlanetTexture3D === 'function') {
                    currentPlanetSrc = imageSrc;
                    updatePlanetTexture3D(imageSrc);
                }
            });
            
            // Add click listener to navigate to details page
            item.addEventListener('click', () => {
                const targetUrl = item.getAttribute('data-target');
                if (targetUrl) {
                    window.location.href = targetUrl;
                } else {
                    const trackingId = item.getAttribute('data-id') || item.innerText;
                    window.location.href = 'details.php?id=' + trackingId;
                }
            });
        });
    }
});
