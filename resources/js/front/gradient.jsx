import React from 'react';
import { createRoot } from "react-dom/client";
import { ShaderGradientCanvas, ShaderGradient } from 'shadergradient';

const root = createRoot(document.getElementById("gradient"));
const url = document.getElementById("gradient").dataset.url;

root.render(
    <ShaderGradientCanvas>
        <ShaderGradient
            control='query'
            urlString={url}
        />
    </ShaderGradientCanvas>
);
