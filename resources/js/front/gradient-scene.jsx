import React, { useLayoutEffect } from 'react';
import { useThree } from '@react-three/fiber';
import { ShaderGradient, ShaderGradientCanvas } from '@shadergradient/react';

function PauseWhenHidden() {
    const clock = useThree(state => state.clock);

    useLayoutEffect(() => {
        let paused = false;

        function syncVisibility() {
            const hidden = document.visibilityState !== 'visible';

            if (hidden === paused) return;

            // ShaderGradient reads this clock's elapsed time. Keep its phase,
            // excluding time in hidden tabs (Clock.start() resets elapsedTime).
            const elapsedTime = clock.elapsedTime;

            if (hidden) {
                clock.stop();
            } else {
                clock.start();
            }

            clock.elapsedTime = elapsedTime;
            paused = hidden;
        }

        document.addEventListener('visibilitychange', syncVisibility);
        syncVisibility();

        return () => document.removeEventListener('visibilitychange', syncVisibility);
    }, [clock]);

    return null;
}

export default function GradientScene({ url }) {
    return (
        <ShaderGradientCanvas>
            <PauseWhenHidden />
            <ShaderGradient control="query" enableTransition={false} urlString={url} />
        </ShaderGradientCanvas>
    );
}
