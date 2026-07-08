import baseConfig from './tailwind.config.js';

export default {
    ...baseConfig,
    content: [
        './resources/views/front/pages/home/**/*.blade.php',
        './resources/views/front/pages/open-source/components/content.blade.php',
        './resources/views/front/pages/open-source/components/staggered-title.blade.php',
        './resources/views/front/pages/open-source/components/statistic.blade.php',
        './resources/views/layout/default.blade.php',
        './resources/views/layout/partials/analytics.blade.php',
        './resources/views/layout/partials/favicons.blade.php',
        './resources/views/layout/partials/footer.blade.php',
        './resources/views/layout/partials/gradient-background.blade.php',
        './resources/views/layout/partials/header.blade.php',
        './resources/views/layout/partials/hreflang.blade.php',
        './resources/views/layout/partials/meta.blade.php',
        './resources/views/layout/partials/modal-match.blade.php',
        './resources/views/layout/partials/modal-telephone.blade.php',
        './resources/views/layout/partials/navigation/*.blade.php',
        './resources/views/layout/partials/wallpaper.blade.php',
        './resources/views/components/countdown.blade.php',
        './resources/views/components/ld-json.blade.php',
    ],
};
