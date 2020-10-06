<?php

return [
    'default_collection' => null,

    'collections' => [

        'docs' => [
            'disk' => 'docs',
            'sheet_class' => \App\Docs\DocumentationPage::class,
            'path_parser' => \App\Docs\DocumentationPathParser::class,
            'content_parser' => \App\Docs\DocumentationContentParser::class,
        ],

        'guidelines' => [
            'disk' => 'guidelines',
            'sheet_class' => \App\Guidelines\GuidelinesPage::class,
            'path_parser' => \Spatie\Sheets\PathParsers\SlugParser::class,
            'content_parser' => \App\Guidelines\GuidelinesContentParser::class,
        ],

        /*
        'posts' => [
            'disk' => 'posts',
            'sheet_class' => App\Post::class,
            'path_parser' => Spatie\Sheets\PathParsers\SlugWithDateParser::class,
            'content_parser' => Spatie\Sheets\ContentParsers\MarkdownParser::class,
            'extension' => 'txt',
        ], */
    ],
];
