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
            [
                'name' => 'Tailwind CSS',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://tailwindcss.com/',
                'image_url' => 'https://pbs.twimg.com/profile_images/1278691829135876097/I4HKOLJw_400x400.png',
                'recommended_by' => ['Willem'],
                'description' => 'A description why we use Tailwind',
            ],
            [
                'name' => 'Vite',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://vitejs.dev/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['Sebastian', 'Adriaan'],
                'description' => 'A description why we use Vite.js',
            ],
            [
                'name' => 'React',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://reactjs.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['Sebastian', 'Adriaan', 'Rias'],
                'description' => 'A description why we use React.js',
            ],
            [
                'name' => 'Typescript',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://www.typescriptlang.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['Sebastian', 'Adriaan'],
                'description' => 'A description why we use Typescript',
            ],
            [
                'name' => 'Yarn',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://www.typescriptlang.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['Sebastian', 'Adriaan'],
                'description' => 'A description why we use Yarn',
            ],

            // Backend
            [
                'name' => 'Laravel',
                'type' => TechnologyType::backend(),
                'website_url' => 'https://laravel.com/',
                'image_url' => 'https://laravel.com/img/logomark.min.svg',
                'recommended_by' => ['Freek', 'Sebastian', 'Alex', 'Brent', 'Ruben', 'Rias', 'Niels'],
                'description' => 'A description why we use Laravel',
            ],

            // Devops
            [
                'name' => 'Oh dear',
                'type' => TechnologyType::devops(),
                'website_url' => 'https://ohdear.app/',
                'image_url' => 'https://ohdear.app/img/logo/ohdear-logo-white-transparant.svg',
                'recommended_by' => ['Freek'],
                'description' => 'A description why we use Oh dear',
            ],

            // Integrations
            [
                'name' => 'Mailcoach',
                'type' => TechnologyType::integrations(),
                'website_url' => 'https://mailcoach.app/',
                'image_url' => 'https://i.ytimg.com/vi/b3ZDyewAJYc/maxresdefault.jpg',
                'recommended_by' => ['Freek', 'Wouter', 'Brent', 'Jef'],
                'description' => 'We would be crazy to use Mailchimp for our mailings.
                That’s why we built Mailcoach.
                It’s our answer to self-host your email marketing while cutting the cost.',
            ],
            // Tools
            [
                'name' => 'Streamyard',
                'type' => TechnologyType::tools(),
                'website_url' => 'https://streamyard.com/',
                'image_url' => 'https://streamyard.com/static/img/7b107537a14784d40bde2496b4b284d9.svg',
                'recommended_by' => ['Freek', 'Brent'],
                'description' => 'Most of our live streams are hosted on Streamyard.
                It’s a quick and easy way to create professional livestreams instantly. We also host livestreams on YouTube.',
            ]

        ];
    }

    public function run(): void
    {
        foreach ($this->technologies() as $data) {
            $imageUrl = $data['image_url'];

            unset($data['image_url']);

             $technology = Technology::firstOrNew(['name' => $data['name']])
                ->fill($data);

             $technology->save();

             $technology
                 ->addMediaFromUrl($imageUrl)
                ->toMediaCollection('avatar');
        }

        Technology::whereNotIn('name', array_column($this->technologies(), 'name'))
            ->delete();
    }
}
