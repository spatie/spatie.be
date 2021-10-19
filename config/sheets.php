<?php

return [
    'default_collection' => null,

    'collections' => [
        'guidelines' => [
            'disk' => 'guidelines',
            'sheet_class' => \App\Guidelines\GuidelinesPage::class,
            'path_parser' => \Spatie\Sheets\PathParsers\SlugParser::class,
            'content_parser' => \App\Guidelines\GuidelinesContentParser::class,
        ],
    ],
];
