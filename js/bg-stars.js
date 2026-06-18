const canvas = document.createElement('canvas');
canvas.id = 'star-canvas';
document.body.insertBefore(canvas, document.body.firstChild);
const ctx = canvas.getContext('2d');

let stars = [];
const numStars = 300; // Reduced from 800 for massive performance boost

function resize() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

window.addEventListener('resize', resize);
resize();

class Star {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.z = Math.random() * canvas.width;
        this.size = Math.random() * 1.5;
        this.baseX = this.x;
        this.baseY = this.y;
    }
    
    update(mouseX, mouseY) {
        this.z -= 0.5; // moving towards camera
        if (this.z <= 0) {
            this.z = canvas.width;
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
        }

        // Mouse Parallax effect
        let dx = (mouseX - canvas.width / 2) * (canvas.width / this.z) * 0.05;
        let dy = (mouseY - canvas.height / 2) * (canvas.width / this.z) * 0.05;

        let screenX = (this.x - canvas.width / 2) * (canvas.width / this.z) + canvas.width / 2 - dx;
        let screenY = (this.y - canvas.height / 2) * (canvas.width / this.z) + canvas.height / 2 - dy;
        let radius = Math.max(1, this.size * (canvas.width / this.z));

        // draw
        if (screenX > 0 && screenX < canvas.width && screenY > 0 && screenY < canvas.height) {
            let colorVal = Math.floor(255 - (this.z / canvas.width) * 255);
            ctx.fillStyle = `rgba(${colorVal}, ${colorVal}, ${colorVal + 50}, ${(1 - this.z / canvas.width)})`;
            // Using fillRect instead of arc is thousands of times faster on Canvas 2D
            ctx.fillRect(screenX, screenY, radius, radius);
        }
    }
}

for (let i = 0; i < numStars; i++) {
    stars.push(new Star());
}

let mouseX = canvas.width / 2;
let mouseY = canvas.height / 2;

document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
});

function animateStars() {
    // slight trailing effect
    ctx.fillStyle = 'rgba(3, 5, 10, 0.3)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    for (let i = 0; i < numStars; i++) {
        stars[i].update(mouseX, mouseY);
    }
    requestAnimationFrame(animateStars);
}

animateStars();
