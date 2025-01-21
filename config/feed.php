<?php

return [
    'feeds' => [
        'main' => [
            'items' => [\App\Models\ExternalFeedItem::class, 'getFeedItems'],
            'url' => '/feed',
            'title' => 'Spatie: From our team & products',
            'description' => 'Blog posts from Spatie team members & products.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
        'insights' => [
            'items' => [\App\Http\Controllers\InsightsController::class, 'getFeedItems'],
            'url' => '/feed-insights',
            'title' => 'Spatie: Insights',
            'description' => 'Insights from the Spatie team.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
    ],
];
