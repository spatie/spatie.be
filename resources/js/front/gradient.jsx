import { createRoot } from 'react-dom/client';

let rendered = false;

function onIdle(callback) {
    if ('requestIdleCallback' in window) {
        window.requestIdleCallback(callback, { timeout: 2500 });

        return;
    }

    window.setTimeout(callback, 800);
}

function bootGradient() {
    if (rendered) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.matchMedia('(max-width: 639px)').matches) return;

    const element = document.getElementById('gradient');
    if (! element) return;

    const url = element.dataset.url;
    if (! url) return;

    rendered = true;

    onIdle(async () => {
        const { ShaderGradientCanvas, ShaderGradient } = await import('@shadergradient/react');

        const root = createRoot(element);
        root.render(
            <ShaderGradientCanvas>
                <ShaderGradient control="query" urlString={url} enableTransition={false} />
            </ShaderGradientCanvas>,
        );
    });
}

window.addEventListener('load', bootGradient, { once: true });
document.addEventListener('livewire:navigated', bootGradient);
