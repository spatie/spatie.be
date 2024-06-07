<?php

return [
    'feeds' => [
        'main' => [
            'items' => [\App\Http\Controllers\InsightsController::class, 'getFeedItems'],
            'url' => '/feed',
            'title' => 'All insights of the Spatie team',
            'description' => 'All insights of the Spatie team.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
        'insights' => [
            'items' => [\App\Models\Insight::class, 'getFeedItems'],
            'url' => '/feed-insights',
            'title' => 'All personal blogposts of the Spatie team',
            'description' => 'All personal blogposts of the Spatie team.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
    ],
];
