const gravity = 9;
const damping = 0.55;
const breezeStrength = 0.6;
const pushStrength = 1.2;
const maxVelocity = 18;
const maxStep = 1 / 30;

const confettiCount = 120;
const confettiDuration = 2.5;
const confettiGravity = 900;
const confettiColors = ['#82D8AF', '#50E69B', '#E7C23D', '#FF354F', '#8A75FD', '#F9F8F7'];

export function startHangingSign(sign) {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let angle = 0;
    let velocity = 0.4;
    let turns = 0;
    let time = Math.random() * 100;
    let previousFrame = null;
    let frameRequest = null;
    let previousPointer = null;

    function pivot() {
        const container = sign.offsetParent.getBoundingClientRect();

        return {
            x: container.left + sign.offsetLeft + sign.offsetWidth / 2,
            y: container.top + sign.offsetTop,
        };
    }

    function breeze() {
        return breezeStrength * (
            0.6 * Math.sin(time * 0.6)
            + 0.3 * Math.sin(time * 1.7 + 1.3)
            + 0.5 * Math.sin(time * 0.23 + 2)
        );
    }

    function step(seconds) {
        time += seconds;

        const acceleration = -gravity * Math.sin(angle) - damping * velocity + breeze();

        velocity = clamp(velocity + acceleration * seconds, maxVelocity);
        angle += velocity * seconds;
    }

    function celebrateFullTurns() {
        const currentTurns = Math.round(angle / (2 * Math.PI));

        if (currentTurns !== turns) {
            turns = currentTurns;
            launchConfetti(pivot());
        }
    }

    function frame(now) {
        const seconds = previousFrame === null ? 0 : Math.min((now - previousFrame) / 1000, maxStep);

        previousFrame = now;
        step(seconds);
        celebrateFullTurns();
        sign.style.rotate = `${angle}rad`;
        frameRequest = requestAnimationFrame(frame);
    }

    function start() {
        if (frameRequest === null) {
            previousFrame = null;
            frameRequest = requestAnimationFrame(frame);
        }
    }

    function stop() {
        cancelAnimationFrame(frameRequest);
        frameRequest = null;
    }

    // Pointer movement acts as a gust: torque is the lever (pivot to pointer) crossed with the movement, scaled by speed.
    function push(event) {
        if (previousPointer === null) {
            previousPointer = event;

            return;
        }

        const movementX = event.clientX - previousPointer.clientX;
        const movementY = event.clientY - previousPointer.clientY;
        const milliseconds = Math.max(event.timeStamp - previousPointer.timeStamp, 8);
        const speed = Math.hypot(movementX, movementY) / milliseconds;

        previousPointer = event;

        const { x: pivotX, y: pivotY } = pivot();
        const leverX = event.clientX - pivotX;
        const leverY = event.clientY - pivotY;
        const pendulumLength = sign.offsetHeight;
        const torque = (leverX * movementY - leverY * movementX) / (pendulumLength * pendulumLength);

        velocity = clamp(velocity + torque * (0.3 + speed) * pushStrength, maxVelocity);
    }

    sign.addEventListener('pointermove', push);
    sign.addEventListener('pointerleave', () => {
        previousPointer = null;
    });

    new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            start();
        } else {
            stop();
        }
    }).observe(sign);
}

function launchConfetti(origin) {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const pixelRatio = window.devicePixelRatio;

    canvas.width = window.innerWidth * pixelRatio;
    canvas.height = window.innerHeight * pixelRatio;
    canvas.style.cssText = 'position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; z-index: 50;';
    context.scale(pixelRatio, pixelRatio);
    document.body.append(canvas);

    const pieces = Array.from({ length: confettiCount }, () => createConfettiPiece(origin));
    let previousFrame = performance.now();
    let elapsed = 0;

    function draw(now) {
        const seconds = Math.min((now - previousFrame) / 1000, maxStep);

        previousFrame = now;
        elapsed += seconds;
        context.clearRect(0, 0, window.innerWidth, window.innerHeight);
        context.globalAlpha = Math.max(0, 1 - elapsed / confettiDuration);
        pieces.forEach((piece) => {
            moveConfettiPiece(piece, seconds);
            drawConfettiPiece(context, piece);
        });

        if (elapsed < confettiDuration) {
            requestAnimationFrame(draw);
        } else {
            canvas.remove();
        }
    }

    requestAnimationFrame(draw);
}

function createConfettiPiece(origin) {
    const direction = Math.random() * Math.PI * 2;
    const speed = 150 + Math.random() * 450;

    return {
        x: origin.x,
        y: origin.y,
        velocityX: Math.cos(direction) * speed,
        velocityY: Math.sin(direction) * speed - 300,
        rotation: Math.random() * Math.PI,
        spin: (Math.random() - 0.5) * 12,
        width: 6 + Math.random() * 6,
        height: 3 + Math.random() * 4,
        color: confettiColors[Math.floor(Math.random() * confettiColors.length)],
    };
}

function moveConfettiPiece(piece, seconds) {
    piece.velocityY += confettiGravity * seconds;
    piece.x += piece.velocityX * seconds;
    piece.y += piece.velocityY * seconds;
    piece.rotation += piece.spin * seconds;
}

function drawConfettiPiece(context, piece) {
    context.save();
    context.translate(piece.x, piece.y);
    context.rotate(piece.rotation);
    context.fillStyle = piece.color;
    context.fillRect(-piece.width / 2, -piece.height / 2, piece.width, piece.height);
    context.restore();
}

function clamp(value, limit) {
    return Math.max(-limit, Math.min(limit, value));
}
