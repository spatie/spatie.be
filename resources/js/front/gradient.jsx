import React from 'react';
import { createRoot } from "react-dom/client";
import { ShaderGradientCanvas, ShaderGradient } from 'shadergradient';

document.addEventListener('livewire:navigated', () => {
    const element = document.getElementById("gradient");

    if (! element) {
        return;
    }

    const root = createRoot(document.getElementById("gradient"));
    const url = document.getElementById("gradient").dataset.url;

    if (! url) {
        return;
    }

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
