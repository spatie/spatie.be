<?php

return [
    'feeds' => [
        'main' => [
            'items' => \App\Models\Insight::class . '@getFeedItems',
            'url' => '/feed',
            'title' => 'All blogposts of the Spatie team',
            //'view' => 'feeds.insights',
        ],
    ],
];
