<?php

return [
    'default_collection' => null,

    'collections' => [

        'docs' => [
            'disk' => 'docs',
            'sheet_class' => \App\Docs\DocumentationPage::class,
            'path_parser' => \App\Docs\DocumationPathParser::class,
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
