// planet3d.js
// A true 3D WebGL renderer for the extreme immersive space UI

let scene, camera, renderer, globe, clouds;

function init3DPlanet() {
    const container = document.querySelector('.planet-sphere-container');
    if (!container) return;

    // Create Canvas
    const canvas = document.createElement('canvas');
    canvas.id = 'canvas-3d-planet';
    container.appendChild(canvas);

    // Initialize Three.js Scene
    scene = new THREE.Scene();
    
    // Camera
    camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
    camera.position.z = 18;

    renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1.2);
    directionalLight.position.set(5, 3, 5);
    scene.add(directionalLight);

    // Deep space rim lighting
    const backLight = new THREE.DirectionalLight(0x00d2ff, 1);
    backLight.position.set(-5, 3, -5);
    scene.add(backLight);

    // Sphere Geometry
    const geometry = new THREE.SphereGeometry(6, 64, 64);
    
    // Initial Material
    const material = new THREE.MeshStandardMaterial({
        color: 0xffffff,
        roughness: 0.6,
        metalness: 0.1,
    });
    
    globe = new THREE.Mesh(geometry, material);
    scene.add(globe);

    // Optional Clouds Layer
    const cloudGeo = new THREE.SphereGeometry(6.1, 64, 64);
    const cloudMat = new THREE.MeshPhongMaterial({
        color: 0xffffff,
        transparent: true,
        opacity: 0.2,
        blending: THREE.AdditiveBlending,
        side: THREE.DoubleSide
    });
    clouds = new THREE.Mesh(cloudGeo, cloudMat);
    scene.add(clouds);

    // Mouse Interaction
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    
    canvas.addEventListener('mousedown', (e) => { isDragging = true; });
    window.addEventListener('mouseup', () => { isDragging = false; });
    window.addEventListener('mousemove', (e) => {
        if (isDragging) {
            const deltaMove = {
                x: e.offsetX - previousMousePosition.x,
                y: e.offsetY - previousMousePosition.y
            };
            globe.rotation.y += deltaMove.x * 0.01;
            globe.rotation.x += deltaMove.y * 0.01;
            clouds.rotation.y += deltaMove.x * 0.012;
            clouds.rotation.x += deltaMove.y * 0.012;
        }
        previousMousePosition = { x: e.offsetX, y: e.offsetY };
    });

    // Resize handler
    window.addEventListener('resize', () => {
        if (!container) return;
        renderer.setSize(container.clientWidth, container.clientHeight);
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
    });

    function animate() {
        requestAnimationFrame(animate);
        if (!isDragging) {
            globe.rotation.y += 0.003;
            if(clouds) {
                clouds.rotation.y += 0.004;
                clouds.rotation.z += 0.0005;
            }
        }
        renderer.render(scene, camera);
    }
    animate();
}

function updatePlanetTexture3D(imgSrc) {
    if (!globe) return;
    const loader = new THREE.TextureLoader();
    loader.load(imgSrc, (texture) => {
        texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
        globe.material.map = texture;
        globe.material.needsUpdate = true;
        
        // Add subtle displacement based on the image itself
        globe.material.displacementMap = texture;
        globe.material.displacementScale = 0.2;
    });
}
