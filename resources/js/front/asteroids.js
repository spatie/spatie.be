export function startAsteroids(canvas, options = {}) {
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const asteroidSprites = Array.isArray(options.asteroidSprites) ? options.asteroidSprites : [];
    const spriteImgs = asteroidSprites.map(src => {
        const img = new Image();
        img.src = src;
        return img;
    });

    let W = (canvas.width = canvas.clientWidth || innerWidth);
    let H = (canvas.height = canvas.clientHeight || innerHeight);

    function resize() {
        W = canvas.width = canvas.clientWidth || innerWidth;
        H = canvas.height = canvas.clientHeight || innerHeight;
    }
    window.addEventListener('resize', resize);

    function rand(min, max) {
        return Math.random() * (max - min) + min;
    }
    function wrap(v, max) {
        if (v < 0) return v + max;
        if (v >= max) return v - max;
        return v;
    }
    function dist(a, b) {
        return Math.hypot(a.x - b.x, a.y - b.y);
    }

    const ship = {
        x: W / 2,
        y: H / 2,
        r: 14,
        angle: -Math.PI / 2,
        vel: { x: 0, y: 0 },
        thrusting: false,
        dead: false,
        respawnTimer: 0,
    };
    let asteroids = [];

    function makeAsteroid(x, y, r, verts) {
        verts = verts || Math.floor(rand(7, 12));
        const points = [];
        for (let i = 0; i < verts; i++) {
            const ang = (i / verts) * Math.PI * 2;
            const rad = r * rand(0.6, 1.1);
            points.push({ ang, rad });
        }
        const useSprite = spriteImgs.length ? Math.random() < 0.5 : false;
        const sprite = useSprite ? spriteImgs[Math.floor(Math.random() * spriteImgs.length)] : null;
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

    function spawnAsteroids(n) {
        for (let i = 0; i < n; i++) {
            let x = Math.random() * W;
            let y = Math.random() * H;
            if (Math.hypot(x - ship.x, y - ship.y) < 150) {
                x = (x + 200) % W;
                y = (y + 200) % H;
            }
            asteroids.push(makeAsteroid(x, y, rand(30, 80)));
        }
    }

    let bullets = [];
    function shoot(x, y, angle) {
        bullets.push({ x, y, angle, ttl: 60 });
    }

    let lastShot = 0;
    function aiControl(dt) {
        if (ship.dead) return;
        if (asteroids.length === 0) return;
        let nearest = asteroids[0];
        let nd = dist(ship, nearest);
        for (const a of asteroids) {
            const d = dist(ship, a);
            if (d < nd) {
                nd = d;
                nearest = a;
            }
        }
        const dx = nearest.x - ship.x;
        const dy = nearest.y - ship.y;
        const targetAngle = Math.atan2(dy, dx);
        const raw = ((targetAngle - ship.angle + Math.PI * 3) % (Math.PI * 2)) - Math.PI;
        const turn = 0.06;
        ship.angle += Math.max(-turn * dt, Math.min(turn * dt, raw));
        ship.thrusting = nd >= 120;
        if (Math.abs(raw) < 0.15 && nd < 600 && lastShot > 200) {
            const noseX = ship.x + Math.cos(ship.angle) * ship.r;
            const noseY = ship.y + Math.sin(ship.angle) * ship.r;
            shoot(noseX, noseY, ship.angle);
            lastShot = 0;
        }
    }

    let last = performance.now();

    function drawGlow() {
        ctx.shadowColor = 'white';
        ctx.shadowBlur = 12;
        ctx.save();
    }

    function loop(now) {
        const dt = Math.min(50, now - last);
        last = now;
        lastShot += dt;
        aiControl(dt);

        if (ship.thrusting) {
            const accel = 0.12;
            ship.vel.x += Math.cos(ship.angle) * accel * (dt / 16);
            ship.vel.y += Math.sin(ship.angle) * accel * (dt / 16);
        }
        ship.vel.x *= 0.995;
        ship.vel.y *= 0.995;
        ship.x = wrap(ship.x + ship.vel.x * (dt / 16), W);
        ship.y = wrap(ship.y + ship.vel.y * (dt / 16), H);

        for (let i = bullets.length - 1; i >= 0; i--) {
            const b = bullets[i];
            const speed = 8;
            b.x += Math.cos(b.angle) * speed * (dt / 16);
            b.y += Math.sin(b.angle) * speed * (dt / 16);
            b.ttl -= dt / 16;
            if (b.ttl <= 0) bullets.splice(i, 1);
            else {
                b.x = wrap(b.x, W);
                b.y = wrap(b.y, H);
            }
        }
        for (const a of asteroids) {
            a.x = wrap(a.x + a.vx * (dt / 16), W);
            a.y = wrap(a.y + a.vy * (dt / 16), H);
            a.rot += a.rotSpeed * (dt / 16);
        }

        for (let i = asteroids.length - 1; i >= 0; i--) {
            const a = asteroids[i];
            for (let j = bullets.length - 1; j >= 0; j--) {
                const b = bullets[j];
                if (Math.hypot(a.x - b.x, a.y - b.y) < a.r) {
                    bullets.splice(j, 1);
                    asteroids.splice(i, 1);
                    if (a.r > 22) {
                        const n = Math.min(3, Math.floor(a.r / 20));
                        for (let k = 0; k < n; k++) {
                            const frag = makeAsteroid(a.x + rand(-6, 6), a.y + rand(-6, 6), a.r * 0.55);
                            frag.sprite = a.sprite;
                            frag.useSprite = a.useSprite;
                            asteroids.push(frag);
                        }
                    }
                    break;
                }
            }
        }

        if (!ship.dead) {
            for (const a of asteroids)
                if (Math.hypot(a.x - ship.x, a.y - ship.y) < a.r + ship.r * 0.8) {
                    ship.dead = true;
                    ship.respawnTimer = 1200;
                    break;
                }
        } else {
            ship.respawnTimer -= dt;
            if (ship.respawnTimer <= 0) {
                ship.dead = false;
                ship.x = W / 2;
                ship.y = H / 2;
                ship.vel.x = 0;
                ship.vel.y = 0;
                ship.angle = -Math.PI / 2;
            }
        }

        ctx.clearRect(0, 0, W, H);
        ctx.save();
        ctx.strokeStyle = '#fff';
        ctx.lineWidth = 1.5;
        ctx.lineJoin = 'round';

        for (const a of asteroids) {
            if (a.useSprite && a.sprite && a.sprite.complete && a.sprite.naturalWidth) {
                ctx.save();
                ctx.translate(a.x, a.y);
                ctx.rotate(a.rot);
                const size = a.r * 1.1;
                ctx.drawImage(a.sprite, -a.r, -a.r, size, size);
                ctx.restore();
            } else {
                ctx.beginPath();
                for (let i = 0; i < a.points.length; i++) {
                    const p = a.points[i];
                    const ang = p.ang + a.rot;
                    const x = a.x + Math.cos(ang) * p.rad;
                    const y = a.y + Math.sin(ang) * p.rad;
                    if (i === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.closePath();
                ctx.stroke();
            }
        }

        if (!ship.dead) {
            drawGlow(ship.x, ship.y, ship.r * 1.9, 0.28);
            ctx.beginPath();
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
            ctx.moveTo(nose.x, nose.y);
            ctx.lineTo(left.x, left.y);
            ctx.lineTo(right.x, right.y);
            ctx.closePath();
            ctx.stroke();
            if (ship.thrusting) {
                ctx.beginPath();
                const back = {
                    x: ship.x + Math.cos(ship.angle + Math.PI) * ship.r * 0.6,
                    y: ship.y + Math.sin(ship.angle + Math.PI) * ship.r * 0.6,
                };
                ctx.moveTo(left.x, left.y);
                ctx.lineTo(back.x, back.y);
                ctx.lineTo(right.x, right.y);
                ctx.stroke();
            }
        } else {
            ctx.beginPath();
            ctx.moveTo(ship.x - 8, ship.y - 8);
            ctx.lineTo(ship.x + 8, ship.y + 8);
            ctx.moveTo(ship.x + 8, ship.y - 8);
            ctx.lineTo(ship.x - 8, ship.y + 8);
            ctx.stroke();
        }

        for (const b of bullets) {
            ctx.beginPath();
            ctx.arc(b.x, b.y, 1.8, 0, Math.PI * 2);
            ctx.stroke();
        }

        ctx.restore();
        if (asteroids.length === 0) spawnAsteroids(6);
        requestAnimationFrame(loop);
    }

    spawnAsteroids(6);
    requestAnimationFrame(loop);
}
