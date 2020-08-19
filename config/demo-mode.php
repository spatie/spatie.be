<?php

return [

    /*
     * This is the master switch to enable demo mode.
     */
    'enabled' => env('DEMO_MODE_ENABLED', true),

    /*
     * Guard to be used in order to grant or deny access.
     */
    'guard' => \Spatie\DemoMode\DefaultDemoGuard::class,

    /*
     * Visitors browsing a protected url will be redirected to this path.
     */
    'redirect_unauthorized_users_to_url' => '/under-construction',

    /*
     * After having gained access, visitors will be redirected to this path.
     */
    'redirect_authorized_users_to_url' => '/',

    /*
     * The following IP's will automatically gain access to the
     * app without having to visit the `demoAccess` route.
     */
    'authorized_ips' => [
        //
    ],

    /*
     * When strict mode is enabled, only IP's listed in `authorized_ips` will gain access.
     * Visitors won't be able to gain access by visiting the `demoAccess` route anymore.
     */
    'strict_mode' => false,

];
