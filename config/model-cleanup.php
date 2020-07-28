<?php

return [

    /*
     * All models that use the GetsCleanedUp interface in these directories will be cleaned.
     */
    'directories' => [
        // app_path('models'),
    ],

    /*
     * All models in this array that use the GetsCleanedUp interface will be cleaned.
     */
    'models' => [
        // App\LogItem::class,
    ],

    /*
     * Specify whether to search the configured `directories` recursively.
     * Set to false to only search for models directly inside the specified paths.
     */
    'recursive' => true,
];
