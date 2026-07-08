const existingGradientBoot = window.spatieGradientBoot;

existingGradientBoot?.destroy();

const intentEvents = ['scroll', 'wheel', 'pointermove', 'pointerdown', 'keydown', 'touchstart'];
const desktopMediaQuery = window.matchMedia('(min-width: 640px)');
const reducedMotionMediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

let fallbackTimeout = null;
let hasIntent = false;
let hasFallbackElapsed = false;
let isRendering = false;
let root = null;
let currentElement = null;

function addMediaQueryListener(mediaQuery, callback) {
    if (mediaQuery.addEventListener) {
        mediaQuery.addEventListener('change', callback);

        return () => mediaQuery.removeEventListener('change', callback);
    }

    mediaQuery.addListener(callback);

    return () => mediaQuery.removeListener(callback);
}

function findGradientElement() {
    return document.getElementById('gradient');
}

function connectionSavesData() {
    return Boolean(navigator.connection?.saveData);
}

function canRender(element) {
    if (! element) return false;
    if (! element.dataset.url) return false;
    if (! desktopMediaQuery.matches) return false;
    if (reducedMotionMediaQuery.matches) return false;
    if (connectionSavesData()) return false;
    if (document.visibilityState !== 'visible') return false;

    return true;
}

function unmountCurrentRoot() {
    if (! root) return;

    try {
        root.unmount();
    } finally {
        root = null;
    }
}

function resetElement(element) {
    if (! element) return;

    element.classList.remove('opacity-100');
    element.classList.add('opacity-0');
    delete element.dataset.gradientRendered;
}

function syncCurrentElement() {
    const element = findGradientElement();

    if (currentElement === element) return element;

    unmountCurrentRoot();

    resetElement(currentElement);

    currentElement = element;
    isRendering = false;

    return element;
}

function reveal(element) {
    window.requestAnimationFrame(() => {
        window.requestAnimationFrame(() => {
            if (currentElement !== element) return;

            element.classList.remove('opacity-0');
            element.classList.add('opacity-100');
            element.dataset.gradientRendered = 'true';
        });
    });
}

async function renderGradient(element) {
    if (isRendering) return;
    if (element.dataset.gradientRendered === 'true') return;

    isRendering = true;

    const [{ createRoot }, { ShaderGradient, ShaderGradientCanvas }, React] = await Promise.all([
        import('react-dom/client'),
        import('@shadergradient/react'),
        import('react'),
    ]);

    if (currentElement !== element) {
        isRendering = false;

        return;
    }

    if (! canRender(element)) {
        isRendering = false;

        return;
    }

    root = createRoot(element);
    root.render(
        React.createElement(
            ShaderGradientCanvas,
            null,
            React.createElement(ShaderGradient, {
                control: 'query',
                enableTransition: false,
                urlString: element.dataset.url,
            }),
        ),
    );

    reveal(element);
}

function attemptRender() {
    const element = syncCurrentElement();

    if (! canRender(element)) {
        unmountCurrentRoot();
        resetElement(element);
        isRendering = false;

        return;
    }

    if (! hasIntent && ! hasFallbackElapsed) return;

    renderGradient(element);
}

function markIntent() {
    hasIntent = true;
    intentEvents.forEach(eventName => window.removeEventListener(eventName, markIntent));
    attemptRender();
}

function scheduleFallback() {
    window.clearTimeout(fallbackTimeout);

    fallbackTimeout = window.setTimeout(() => {
        hasFallbackElapsed = true;
        attemptRender();
    }, 15000);
}

function scheduleFallbackAfterLoad() {
    if (document.readyState === 'complete') {
        scheduleFallback();

        return;
    }

    window.addEventListener('load', scheduleFallback, { once: true });
}

function destroy() {
    window.clearTimeout(fallbackTimeout);
    window.removeEventListener('load', scheduleFallback);
    document.removeEventListener('visibilitychange', attemptRender);
    document.removeEventListener('livewire:navigated', attemptRender);
    removeDesktopMediaQueryListener();
    removeReducedMotionMediaQueryListener();
    intentEvents.forEach(eventName => window.removeEventListener(eventName, markIntent));
    unmountCurrentRoot();
}

intentEvents.forEach(eventName => window.addEventListener(eventName, markIntent, { passive: true }));
document.addEventListener('visibilitychange', attemptRender);
document.addEventListener('livewire:navigated', attemptRender);

const removeDesktopMediaQueryListener = addMediaQueryListener(desktopMediaQuery, attemptRender);
const removeReducedMotionMediaQueryListener = addMediaQueryListener(reducedMotionMediaQuery, attemptRender);

scheduleFallbackAfterLoad();
attemptRender();

window.spatieGradientBoot = {
    destroy,
};
