<?php

namespace Database\Seeders;

use App\Models\Enums\TechnologyType;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologiesSeeder extends Seeder
{
    protected function technologies(): array
    {
        return [
            // Frontend

            // Backend

            // Devops

            // Integrations
            [
                'name' => 'Mailcoach',
                'type' => TechnologyType::INTEGRATIONS(),
                'website_url' => 'https://mailcoach.app/',
                'image_url' => 'https://i.ytimg.com/vi/b3ZDyewAJYc/maxresdefault.jpg',
                'recommended_by' => ['Freek', 'Wouter'],
                'description' => 'We would be crazy to use Mailchimp for our mailings.
                That’s why we built Mailcoach.
                It’s our answer to self-host your email marketing while cutting the cost.'
            ]
        ];
    }

    public function run(): void
    {
        $technologies = $this->technologies();

        foreach ($technologies as $technology) {
            Technology::firstOrNew(['name' => $technology['name']])
                ->fill($technology)
                ->save();
        }

        Technology::whereNotIn('name', array_column($technologies, 'name'))
            ->delete();
    }
}
