import { createRoot } from "react-dom/client";

document.addEventListener('livewire:navigated', async () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (window.matchMedia('(max-width: 639px)').matches) return;

    const element = document.getElementById("gradient");
    if (! element) return;

    const url = element.dataset.url;
    if (! url) return;

    const { ShaderGradientCanvas, ShaderGradient } = await import('@shadergradient/react');

    const root = createRoot(element);
    root.render(
        <ShaderGradientCanvas>
            <ShaderGradient
                control='query'
                urlString={url}
                enableTransition={false}
            />
        </ShaderGradientCanvas>
    );
});
