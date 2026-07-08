import Alpine from 'alpinejs';
window.Alpine = Alpine;

async function startAlpine() {
    if (window.spatieUsesAlpineFocus) {
        const { default: focus } = await import('@alpinejs/focus');

        Alpine.plugin(focus);
    }

    Alpine.start();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startAlpine);
} else {
    startAlpine();
}

window.addEventListener('load', () => {
    if (document.querySelector('[srcset][sizes="1px"]')) {
        import('./images').then(({ default: images }) => images());
    }

    if (document.querySelector('.docs-submenu-item')) {
        import('./docs').then(({ default: docs }) => docs());
    }
});

let cleanupAsteroids = null;
let asteroidsCanvas = null;
let asteroidsImportId = 0;

function bootAsteroids() {
    cleanupAsteroids?.();
    cleanupAsteroids = null;

    const canvas = document.querySelector('.js-asteroids');
    asteroidsCanvas = canvas;

    if (! canvas) return;

    const importId = ++asteroidsImportId;

    import('./asteroids').then(({ startAsteroids }) => {
        if (importId !== asteroidsImportId) return;
        if (asteroidsCanvas !== canvas) return;
        if (! document.contains(canvas)) return;

        cleanupAsteroids = startAsteroids(canvas);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootAsteroids, { once: true });
} else {
    bootAsteroids();
}

document.addEventListener('livewire:navigated', bootAsteroids);
