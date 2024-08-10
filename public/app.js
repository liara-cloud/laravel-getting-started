// Constants for calculations
const TWO_PI = Math.PI * 2;
const HALF_PI = Math.PI * 0.5;
const TIME_STEP = 1 / 60;
const PARTICLE_COUNT = 128;
const CANVAS_WIDTH = 512;
const CANVAS_HEIGHT = 350;

// Utility Functions
class Point {
    constructor(x = 0, y = 0) {
        this.x = x;
        this.y = y;
    }
}

const cubeBezier = (p0, c0, c1, p1, t) => {
    const nt = 1 - t;
    return new Point(
        nt ** 3 * p0.x + 3 * nt ** 2 * t * c0.x + 3 * nt * t ** 2 * c1.x + t ** 3 * p1.x,
        nt ** 3 * p0.y + 3 * nt ** 2 * t * c0.y + 3 * nt * t ** 2 * c1.y + t ** 3 * p1.y
    );
};

// Ease functions
const Ease = {
    inCubic: (t, b, c, d) => (c * ((t /= d) * t * t) + b),
    outCubic: (t, b, c, d) => (c * ((t = (t / d) - 1) * t * t + 1) + b),
    inOutCubic: (t, b, c, d) => {
        if ((t /= d / 2) < 1) return (c / 2 * t ** 3 + b);
        return (c / 2 * ((t -= 2) ** 3 + 2) + b);
    },
    inBack: (t, b, c, d, s = 1.70158) => (c * ((t /= d) * t * ((s + 1) * t - s)) + b),
};

// Particle Class
class Particle {
    constructor(p0, p1, p2, p3) {
        this.p0 = p0;
        this.p1 = p1;
        this.p2 = p2;
        this.p3 = p3;
        this.time = 0;
        this.duration = 3 + Math.random() * 2;
        this.color = `#${Math.floor(Math.random() * 0xffffff).toString(16)}`;
        this.width = 8;
        this.height = 6;
        this.complete = false;
    }

    update() {
        this.time = Math.min(this.duration, this.time + TIME_STEP);
        const f = Ease.outCubic(this.time, 0, 1, this.duration);
        const p = cubeBezier(this.p0, this.p1, this.p2, this.p3, f);
        const dx = p.x - this.x;
        const dy = p.y - this.y;
        this.rotation = Math.atan2(dy, dx) + HALF_PI;
        this.scaleY = Math.sin(Math.PI * f * 10);
        this.x = p.x;
        this.y = p.y;
        this.complete = this.time === this.duration;
    }

    draw(ctx) {
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation);
        ctx.scale(1, this.scaleY);
        ctx.fillStyle = this.color;
        ctx.fillRect(-this.width / 2, -this.height / 2, this.width, this.height);
        ctx.restore();
    }
}

// Loader Class
class Loader {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.radius = 24;
        this._progress = 0;
        this.complete = false;
    }

    set progress(value) {
        this._progress = Math.min(Math.max(value, 0), 1);
        this.complete = this._progress === 1;
    }

    get progress() {
        return this._progress;
    }

    draw(ctx) {
        ctx.fillStyle = '#fff';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, -HALF_PI, TWO_PI * this._progress - HALF_PI);
        ctx.lineTo(this.x, this.y);
        ctx.closePath();
        ctx.fill();
    }
}

// Exploder Class
class Exploder {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.startRadius = 24;
        this.time = 0;
        this.duration = 0.4;
        this.progress = 0;
        this.complete = false;
    }

    reset() {
        this.time = 0;
        this.progress = 0;
        this.complete = false;
    }

    update() {
        this.time = Math.min(this.duration, this.time + TIME_STEP);
        this.progress = Ease.inBack(this.time, 0, 1, this.duration);
        this.complete = this.time === this.duration;
    }

    draw(ctx) {
        ctx.fillStyle = '#fff';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.startRadius * (1 - this.progress), 0, TWO_PI);
        ctx.fill();
    }
}

// Main Application Logic
const particles = [];
let loader;
let exploder;
let phase = 0;

const initDrawingCanvas = () => {
    const canvas = document.getElementById('drawing_canvas');
    canvas.width = CANVAS_WIDTH;
    canvas.height = CANVAS_HEIGHT;
    const ctx = canvas.getContext('2d');

    loader = new Loader(CANVAS_WIDTH * 0.5, CANVAS_HEIGHT * 0.5);
    exploder = new Exploder(CANVAS_WIDTH * 0.5, CANVAS_HEIGHT * 0.5);
    createParticles(ctx);
};

const createParticles = (ctx) => {
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        const p0 = new Point(CANVAS_WIDTH * 0.5, CANVAS_HEIGHT * 0.5);
        const p1 = new Point(Math.random() * CANVAS_WIDTH, Math.random() * CANVAS_HEIGHT);
        const p2 = new Point(Math.random() * CANVAS_WIDTH, Math.random() * CANVAS_HEIGHT);
        const p3 = new Point(Math.random() * CANVAS_WIDTH, CANVAS_HEIGHT + 64);
        particles.push(new Particle(p0, p1, p2, p3));
    }
};

const update = () => {
    switch (phase) {
        case 0:
            loader.progress += 1 / 45;
            break;
        case 1:
            exploder.update();
            break;
        case 2:
            particles.forEach(p => p.update());
            break;
    }
};

const draw = (ctx) => {
    ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
    switch (phase) {
        case 0:
            loader.draw(ctx);
            break;
        case 1:
            exploder.draw(ctx);
            break;
        case 2:
            particles.forEach(p => p.draw(ctx));
            break;
    }
};

const loop = (ctx) => {
    update();
    draw(ctx);

    if (phase === 0 && loader.complete) {
        phase = 1;
    } else if (phase === 1 && exploder.complete) {
        phase = 2;
    } else if (phase === 2 && particles.every(p => p.complete)) {
        phase = 2;
        exploder.reset();
        particles.length = 0;
        createParticles(ctx);
    }

    requestAnimationFrame(() => loop(ctx));
};

window.onload = () => {
    const canvas = document.getElementById('drawing_canvas');
    const ctx = canvas.getContext('2d');
    initDrawingCanvas();
    requestAnimationFrame(() => loop(ctx));
};
