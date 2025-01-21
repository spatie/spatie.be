<?php

return [
    'feeds' => [
        'main' => [
            'items' => [\App\Models\ExternalFeedItem::class, 'getFeedItems'],
            'url' => '/feeds/team-members-products',
            'title' => 'Spatie: Team members & products',
            'description' => 'Blog posts from Spatie team members & product sites.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
        'insights' => [
            'items' => [\App\Http\Controllers\BlogController::class, 'getFeedItems'],
            'url' => '/feeds/blog',
            'title' => 'Spatie: Blog',
            'description' => 'News & insights from the Spatie team.',
            'language' => 'en-US',
            'image' => '',
            'format' => 'atom',
            'view' => 'feed::atom',
            'type' => '',
            'contentType' => '',
        ],
    ],
];
