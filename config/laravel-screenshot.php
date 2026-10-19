<?php

return [
    /*
     * The default driver to use for screenshot generation.
     * Supported: "browsershot", "cloudflare"
     */
    'driver' => env('LARAVEL_SCREENSHOT_DRIVER', 'browsershot'),

    /*
     * The job class used for queued screenshot generation.
     * You can replace this with your own class that extends GenerateScreenshotJob
     * to customize things like $tries, $timeout, $backoff, or default queue.
     */
    'job' => Spatie\LaravelScreenshot\Jobs\GenerateScreenshotJob::class,

    /*
     * The action class used to determine the image type from a file path.
     * The default implementation maps file extensions to ImageType enum values,
     * falling back to PNG for unknown extensions.
     */
    'determine_image_type' => Spatie\LaravelScreenshot\Actions\DetermineImageType::class,

    /*
     * Default screenshot options.
     * These are applied when a value isn't explicitly set on the builder.
     */
    'defaults' => [
        'width' => 1280,
        'height' => 800,
        'device_scale_factor' => 2,
        'wait_until' => 'networkidle2',

        /*
         * The image type used when the file extension cannot be mapped to a
         * supported format. Supported: "png", "jpeg", "webp"
         */
        'type' => 'png',
    ],

    /*
     * Browsershot driver configuration.
     *
     * Requires the spatie/browsershot package:
     * composer require spatie/browsershot
     */
    'browsershot' => [
        /*
         * Configure the paths to Node.js, npm, Chrome, and other binaries.
         * Leave null to use system defaults or Browsershot's auto-detection.
         */
        'node_binary' => env('LARAVEL_SCREENSHOT_NODE_BINARY'),
        'npm_binary' => env('LARAVEL_SCREENSHOT_NPM_BINARY'),
        'include_path' => env('LARAVEL_SCREENSHOT_INCLUDE_PATH'),
        'chrome_path' => env('LARAVEL_SCREENSHOT_CHROME_PATH'),
        'node_modules_path' => env('LARAVEL_SCREENSHOT_NODE_MODULES_PATH'),
        'bin_path' => env('LARAVEL_SCREENSHOT_BIN_PATH'),
        'temp_path' => env('LARAVEL_SCREENSHOT_TEMP_PATH'),

        /*
         * Other Browsershot configuration options.
         */
        'write_options_to_file' => env('LARAVEL_SCREENSHOT_WRITE_OPTIONS_TO_FILE', false),
        'no_sandbox' => env('LARAVEL_SCREENSHOT_NO_SANDBOX', false),
    ],

    /*
     * Cloudflare Browser Rendering driver configuration.
     *
     * Requires a Cloudflare account with the Browser Rendering API enabled.
     * https://developers.cloudflare.com/browser-rendering/
     */
    'cloudflare' => [
        'api_token' => env('CLOUDFLARE_API_TOKEN'),
        'account_id' => env('CLOUDFLARE_ACCOUNT_ID'),
    ],
];
