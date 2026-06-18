const planetListItems = document.querySelectorAll('.planet-list li');
const planetTitle = document.getElementById('planet-title');
const planetDesc = document.getElementById('planet-desc');
const planetTemp = document.getElementById('planet-temp');
const planetGravity = document.getElementById('planet-gravity');
const planetHistory = document.getElementById('planet-history');

let currentPlanetSrc = '';
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function updateProgress(id) {
    try {
        const progress = JSON.parse(localStorage.getItem('spaceProgress') || '[]');
        if (!progress.includes(id)) {
            progress.push(id);
            localStorage.setItem('spaceProgress', JSON.stringify(progress));
        }
    } catch (e) {
        console.warn('Progress tracking disabled/failed', e);
    }
}

function setNavState() {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelector('.nav-links');
    const toggle = document.querySelector('.nav-toggle');

    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    }

    if (navLinks && toggle && window.innerWidth <= 900) {
        navLinks.classList.remove('open');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelector('.nav-links');

    if (navbar && navLinks && !document.querySelector('.nav-toggle')) {
        const toggle = document.createElement('button');
        toggle.className = 'nav-toggle';
        toggle.type = 'button';
        toggle.setAttribute('aria-label', 'Toggle navigation');
        toggle.innerHTML = '<span></span><span></span><span></span>';
        navbar.appendChild(toggle);

        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('open');
        });

        document.addEventListener('click', (event) => {
            if (!navbar.contains(event.target)) {
                navLinks.classList.remove('open');
            }
        });

        navLinks.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
            });
        });
    }

    if (typeof init3DPlanet === 'function') {
        init3DPlanet();
    }

    const initialActive = document.querySelector('.planet-list li.active');
    if (initialActive && typeof updatePlanetTexture3D === 'function') {
        currentPlanetSrc = initialActive.getAttribute('data-image');
        updatePlanetTexture3D(currentPlanetSrc);
    }

    if (planetListItems.length > 0) {
        planetListItems.forEach((item) => {
            item.addEventListener('mouseenter', () => {
                planetListItems.forEach((i) => i.classList.remove('active'));
                item.classList.add('active');

                const imageSrc = item.getAttribute('data-image');
                const trackingId = item.getAttribute('data-id') || item.innerText.trim();
                const newTitle = item.getAttribute('data-title');
                const newDesc = item.getAttribute('data-desc');
                const newTemp = item.getAttribute('data-temp');
                const newGravity = item.getAttribute('data-gravity');
                const newHistory = item.getAttribute('data-history');

                updateProgress(trackingId);

                if (planetTitle && newTitle && planetTitle.textContent.trim() !== newTitle.trim()) {
                    const fadeDuration = reducedMotion ? 0 : 300;
                    planetTitle.classList.add('fading');
                    if (planetDesc) planetDesc.classList.add('fading');
                    if (planetTemp && planetTemp.parentNode && planetTemp.parentNode.parentNode) {
                        planetTemp.parentNode.parentNode.classList.add('fading');
                    }

                    setTimeout(() => {
                        planetTitle.textContent = newTitle;
                        if (planetDesc) planetDesc.textContent = newDesc || '';

                        if (planetTemp) {
                            planetTemp.textContent = newTemp || 'N/A';
                            if (planetGravity) planetGravity.textContent = newGravity || 'N/A';
                            if (planetHistory) planetHistory.textContent = newHistory || 'N/A';
                        }

                        planetTitle.classList.remove('fading');
                        if (planetDesc) planetDesc.classList.remove('fading');
                        if (planetTemp && planetTemp.parentNode && planetTemp.parentNode.parentNode) {
                            planetTemp.parentNode.parentNode.classList.remove('fading');
                        }
                    }, fadeDuration);
                }

                if (imageSrc && imageSrc !== currentPlanetSrc && typeof updatePlanetTexture3D === 'function') {
                    currentPlanetSrc = imageSrc;
                    updatePlanetTexture3D(imageSrc);
                }
            });

            item.addEventListener('click', () => {
                const targetUrl = item.getAttribute('data-target');
                const detailsUrl = item.getAttribute('data-id')
                    ? 'details.php?id=' + item.getAttribute('data-id')
                    : 'details.php';

                window.location.href = targetUrl || detailsUrl;
            });
        });
    }

    setNavState();
});

window.addEventListener('scroll', setNavState, { passive: true });
window.addEventListener('resize', setNavState);
