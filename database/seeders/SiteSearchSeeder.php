<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\SiteSearch\Models\SiteSearchConfig;

class SiteSearchSeeder extends Seeder
{
    public function run(): void
    {
        SiteSearchConfig::create([
            'name' => 'docs',
            'index_base_name' => 'docs',
            'crawl_url' => 'https://spatie.be.test/docs',
            'enabled' => 1,
            'extra' => [
                'meilisearch' => [
                    // apiKey => '', // for production
                    'indexSettings' => [
                        'filterableAttributes' => ['version', 'repo'],
                        'searchableAttributes' => ['pageTitle', 'description', 'entry'],
                    ],
                ],
            ],
        ]);
    }
}
