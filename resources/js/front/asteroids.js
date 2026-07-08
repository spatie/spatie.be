function createSpriteDataUrl(svg) {
    return `data:image/svg+xml,${encodeURIComponent(svg)}`;
}

const defaultAsteroidSprites = [
    createSpriteDataUrl(`
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 30 12 15h14c6 0 10 3 10 8 0 6-4 9-11 9h-4l-1 6h-7l1-6H9Z" stroke="white" stroke-width="1.5"/>
            <path d="M22 20h4c2 0 3 1 3 2.5S28 25 25 25h-4l1-5Z" stroke="white" stroke-width="1.5"/>
        </svg>
    `),
    createSpriteDataUrl(`
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="24" cy="24" rx="18" ry="7" stroke="white" stroke-width="1.5"/>
            <ellipse cx="24" cy="24" rx="18" ry="7" stroke="white" stroke-width="1.5" transform="rotate(60 24 24)"/>
            <ellipse cx="24" cy="24" rx="18" ry="7" stroke="white" stroke-width="1.5" transform="rotate(120 24 24)"/>
            <circle cx="24" cy="24" r="3" fill="white"/>
        </svg>
    `),
    createSpriteDataUrl(`
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="m24 6 15 8v20l-15 8-15-8V14L24 6Z" stroke="white" stroke-width="1.5"/>
            <path d="M9 14 24 23l15-9M24 23v19" stroke="white" stroke-width="1.5"/>
        </svg>
    `),
    createSpriteDataUrl(`
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 29c2 2 5 3 8 3 4 0 7-2 7-5 0-8-14-3-14-11 0-3 3-6 8-6 3 0 6 1 8 3" stroke="white" stroke-width="1.5"/>
            <path d="M28 12h12M34 12v24M27 36h14" stroke="white" stroke-width="1.5"/>
        </svg>
    `),
];

function addMediaQueryListener(mediaQuery, callback) {
    if (mediaQuery.addEventListener) {
        mediaQuery.addEventListener('change', callback);

        return () => mediaQuery.removeEventListener('change', callback);
    }

    mediaQuery.addListener(callback);

    return () => mediaQuery.removeListener(callback);
}

export function startAsteroids(canvas, options = {}) {
    if (! canvas) return () => {};

    const context = canvas.getContext('2d');

    if (! context) return () => {};

    const asteroidSprites = Array.isArray(options.asteroidSprites) ? options.asteroidSprites : defaultAsteroidSprites;
    const spriteImages = asteroidSprites.map(src => {
        const image = new Image();
        image.src = src;

        return image;
    });

    const maxDevicePixelRatio = options.maxDevicePixelRatio ?? 1.5;
    const targetFrameRate = options.frameRate ?? 30;
    const frameInterval = 1000 / targetFrameRate;
    const reducedMotionMediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    let width = 1;
    let height = 1;
    let animationFrame = null;
    let isCanvasVisible = ! ('IntersectionObserver' in window);
    let isDestroyed = false;
    let last = performance.now();
    let lastFrame = 0;
    let lastShot = 0;
    let asteroids = [];
    let bullets = [];

    function resize() {
        width = canvas.clientWidth || window.innerWidth || 1;
        height = canvas.clientHeight || window.innerHeight || 1;

        const devicePixelRatio = Math.min(window.devicePixelRatio || 1, maxDevicePixelRatio);

        canvas.width = Math.max(1, Math.round(width * devicePixelRatio));
        canvas.height = Math.max(1, Math.round(height * devicePixelRatio));
        context.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0);
    }

    function rand(min, max) {
        return Math.random() * (max - min) + min;
    }

    function wrap(value, max) {
        if (value < 0) return value + max;
        if (value >= max) return value - max;

        return value;
    }

    function dist(a, b) {
        return Math.hypot(a.x - b.x, a.y - b.y);
    }

    resize();

    const ship = {
        x: width / 2,
        y: height / 2,
        r: 14,
        angle: -Math.PI / 2,
        vel: { x: 0, y: 0 },
        thrusting: false,
        dead: false,
        respawnTimer: 0,
    };

    function makeAsteroid(x, y, r, verts = Math.floor(rand(7, 12))) {
        const points = [];

        for (let i = 0; i < verts; i++) {
            const angle = (i / verts) * Math.PI * 2;
            const radius = r * rand(0.6, 1.1);

            points.push({ angle, radius });
        }

        const useSprite = spriteImages.length ? Math.random() < 0.5 : false;
        const sprite = useSprite ? spriteImages[Math.floor(Math.random() * spriteImages.length)] : null;

        return {
            x,
            y,
            r,
            points,
            rot: 0,
            rotSpeed: rand(-0.02, 0.02),
            vx: rand(-0.5, 0.5),
            vy: rand(-0.5, 0.5),
            sprite,
            useSprite,
        };
    }

    function spawnAsteroids(amount) {
        for (let i = 0; i < amount; i++) {
            let x = Math.random() * width;
            let y = Math.random() * height;

            if (Math.hypot(x - ship.x, y - ship.y) < 150) {
                x = (x + 200) % width;
                y = (y + 200) % height;
            }

            asteroids.push(makeAsteroid(x, y, rand(30, 80)));
        }
    }

    function shoot(x, y, angle) {
        bullets.push({ x, y, angle, ttl: 60 });
    }

    function aiControl(deltaTime) {
        if (ship.dead) return;
        if (asteroids.length === 0) return;

        let nearest = asteroids[0];
        let nearestDistance = dist(ship, nearest);

        for (const asteroid of asteroids) {
            const distance = dist(ship, asteroid);

            if (distance < nearestDistance) {
                nearestDistance = distance;
                nearest = asteroid;
            }
        }

        const dx = nearest.x - ship.x;
        const dy = nearest.y - ship.y;
        const targetAngle = Math.atan2(dy, dx);
        const raw = ((targetAngle - ship.angle + Math.PI * 3) % (Math.PI * 2)) - Math.PI;
        const turn = 0.06;

        ship.angle += Math.max(-turn * deltaTime, Math.min(turn * deltaTime, raw));
        ship.thrusting = nearestDistance >= 120;

        if (Math.abs(raw) < 0.15 && nearestDistance < 600 && lastShot > 200) {
            const noseX = ship.x + Math.cos(ship.angle) * ship.r;
            const noseY = ship.y + Math.sin(ship.angle) * ship.r;

            shoot(noseX, noseY, ship.angle);
            lastShot = 0;
        }
    }

    function updateShip(deltaTime) {
        if (ship.thrusting) {
            const accel = 0.12;

            ship.vel.x += Math.cos(ship.angle) * accel * (deltaTime / 16);
            ship.vel.y += Math.sin(ship.angle) * accel * (deltaTime / 16);
        }

        ship.vel.x *= 0.995;
        ship.vel.y *= 0.995;
        ship.x = wrap(ship.x + ship.vel.x * (deltaTime / 16), width);
        ship.y = wrap(ship.y + ship.vel.y * (deltaTime / 16), height);
    }

    function updateBullets(deltaTime) {
        for (let i = bullets.length - 1; i >= 0; i--) {
            const bullet = bullets[i];
            const speed = 8;

            bullet.x += Math.cos(bullet.angle) * speed * (deltaTime / 16);
            bullet.y += Math.sin(bullet.angle) * speed * (deltaTime / 16);
            bullet.ttl -= deltaTime / 16;

            if (bullet.ttl <= 0) {
                bullets.splice(i, 1);

                continue;
            }

            bullet.x = wrap(bullet.x, width);
            bullet.y = wrap(bullet.y, height);
        }
    }

    function updateAsteroids(deltaTime) {
        for (const asteroid of asteroids) {
            asteroid.x = wrap(asteroid.x + asteroid.vx * (deltaTime / 16), width);
            asteroid.y = wrap(asteroid.y + asteroid.vy * (deltaTime / 16), height);
            asteroid.rot += asteroid.rotSpeed * (deltaTime / 16);
        }
    }

    function resolveCollisions(deltaTime) {
        for (let i = asteroids.length - 1; i >= 0; i--) {
            const asteroid = asteroids[i];

            for (let j = bullets.length - 1; j >= 0; j--) {
                const bullet = bullets[j];

                if (Math.hypot(asteroid.x - bullet.x, asteroid.y - bullet.y) >= asteroid.r) continue;

                bullets.splice(j, 1);
                asteroids.splice(i, 1);

                if (asteroid.r > 22) {
                    const fragments = Math.min(3, Math.floor(asteroid.r / 20));

                    for (let k = 0; k < fragments; k++) {
                        const fragment = makeAsteroid(
                            asteroid.x + rand(-6, 6),
                            asteroid.y + rand(-6, 6),
                            asteroid.r * 0.55,
                        );

                        fragment.sprite = asteroid.sprite;
                        fragment.useSprite = asteroid.useSprite;
                        asteroids.push(fragment);
                    }
                }

                break;
            }
        }

        if (! ship.dead) {
            for (const asteroid of asteroids) {
                if (Math.hypot(asteroid.x - ship.x, asteroid.y - ship.y) >= asteroid.r + ship.r * 0.8) continue;

                ship.dead = true;
                ship.respawnTimer = 1200;

                break;
            }

            return;
        }

        ship.respawnTimer -= deltaTime;

        if (ship.respawnTimer > 0) return;

        ship.dead = false;
        ship.x = width / 2;
        ship.y = height / 2;
        ship.vel.x = 0;
        ship.vel.y = 0;
        ship.angle = -Math.PI / 2;
    }

    function drawAsteroid(asteroid) {
        if (asteroid.useSprite && asteroid.sprite?.complete && asteroid.sprite.naturalWidth) {
            context.save();
            context.translate(asteroid.x, asteroid.y);
            context.rotate(asteroid.rot);

            const size = asteroid.r * 1.1;

            context.drawImage(asteroid.sprite, -asteroid.r, -asteroid.r, size, size);
            context.restore();

            return;
        }

        context.beginPath();

        for (let i = 0; i < asteroid.points.length; i++) {
            const point = asteroid.points[i];
            const angle = point.angle + asteroid.rot;
            const x = asteroid.x + Math.cos(angle) * point.radius;
            const y = asteroid.y + Math.sin(angle) * point.radius;

            if (i === 0) {
                context.moveTo(x, y);
            } else {
                context.lineTo(x, y);
            }
        }

        context.closePath();
        context.stroke();
    }

    function drawShip() {
        if (ship.dead) {
            context.beginPath();
            context.moveTo(ship.x - 8, ship.y - 8);
            context.lineTo(ship.x + 8, ship.y + 8);
            context.moveTo(ship.x + 8, ship.y - 8);
            context.lineTo(ship.x - 8, ship.y + 8);
            context.stroke();

            return;
        }

        context.save();
        context.shadowColor = 'white';
        context.shadowBlur = 12;
        context.beginPath();

        const nose = {
            x: ship.x + Math.cos(ship.angle) * ship.r,
            y: ship.y + Math.sin(ship.angle) * ship.r,
        };
        const left = {
            x: ship.x + Math.cos(ship.angle + 2.8) * ship.r * 0.8,
            y: ship.y + Math.sin(ship.angle + 2.8) * ship.r * 0.8,
        };
        const right = {
            x: ship.x + Math.cos(ship.angle - 2.8) * ship.r * 0.8,
            y: ship.y + Math.sin(ship.angle - 2.8) * ship.r * 0.8,
        };

        context.moveTo(nose.x, nose.y);
        context.lineTo(left.x, left.y);
        context.lineTo(right.x, right.y);
        context.closePath();
        context.stroke();

        if (ship.thrusting) {
            context.beginPath();

            const back = {
                x: ship.x + Math.cos(ship.angle + Math.PI) * ship.r * 0.6,
                y: ship.y + Math.sin(ship.angle + Math.PI) * ship.r * 0.6,
            };

            context.moveTo(left.x, left.y);
            context.lineTo(back.x, back.y);
            context.lineTo(right.x, right.y);
            context.stroke();
        }

        context.restore();
    }

    function drawBullets() {
        for (const bullet of bullets) {
            context.beginPath();
            context.arc(bullet.x, bullet.y, 1.8, 0, Math.PI * 2);
            context.stroke();
        }
    }

    function draw() {
        context.clearRect(0, 0, width, height);
        context.save();
        context.strokeStyle = '#fff';
        context.lineWidth = 1.5;
        context.lineJoin = 'round';

        for (const asteroid of asteroids) {
            drawAsteroid(asteroid);
        }

        drawShip();
        drawBullets();
        context.restore();
    }

    function shouldAnimate() {
        if (isDestroyed) return false;
        if (! isCanvasVisible) return false;
        if (document.visibilityState !== 'visible') return false;
        if (reducedMotionMediaQuery.matches) return false;

        return true;
    }

    function scheduleLoop() {
        if (animationFrame) return;
        if (! shouldAnimate()) return;

        animationFrame = window.requestAnimationFrame(loop);
    }

    function stopLoop() {
        if (! animationFrame) return;

        window.cancelAnimationFrame(animationFrame);
        animationFrame = null;
    }

    function updateAnimationState() {
        if (shouldAnimate()) {
            last = performance.now();
            lastFrame = 0;
            scheduleLoop();

            return;
        }

        stopLoop();
        context.clearRect(0, 0, width, height);
    }

    function loop(now) {
        animationFrame = null;

        if (! shouldAnimate()) return;

        if (now - lastFrame < frameInterval) {
            scheduleLoop();

            return;
        }

        const deltaTime = Math.min(50, now - last);

        last = now;
        lastFrame = now;
        lastShot += deltaTime;

        aiControl(deltaTime);
        updateShip(deltaTime);
        updateBullets(deltaTime);
        updateAsteroids(deltaTime);
        resolveCollisions(deltaTime);

        if (asteroids.length === 0) {
            spawnAsteroids(6);
        }

        draw();
        scheduleLoop();
    }

    function onResize() {
        resize();
        updateAnimationState();
    }

    function onVisibilityChange() {
        updateAnimationState();
    }

    spawnAsteroids(6);

    window.addEventListener('resize', onResize);
    document.addEventListener('visibilitychange', onVisibilityChange);

    const removeReducedMotionListener = addMediaQueryListener(reducedMotionMediaQuery, updateAnimationState);
    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver(entries => {
            isCanvasVisible = entries.some(entry => entry.isIntersecting);
            updateAnimationState();
        }, { rootMargin: '250px' })
        : null;

    observer?.observe(canvas);
    updateAnimationState();

    return () => {
        isDestroyed = true;
        stopLoop();
        observer?.disconnect();
        removeReducedMotionListener();
        window.removeEventListener('resize', onResize);
        document.removeEventListener('visibilitychange', onVisibilityChange);
        context.clearRect(0, 0, width, height);
    };
}
