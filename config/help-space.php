<?php

return [
    /*
     * The secret used to verify if the incoming HelpSpace secret is valid
     */
    'secret' => env('HELP_SPACE_SECRET'),

    /*
     * The package will automatically register this route to handle incoming
     * requests from HelpSpace.
     *
     * You can set this to `null` if you prefer to register your route manually.
     */
    'url' => '/help-space',

    /*
     * These middleware will be applied on the automatically registered route.
     */
    'middleware' => [
        Spatie\HelpSpace\Http\Middleware\IsValidHelpSpaceRequest::class,
        'api',
    ],
];
