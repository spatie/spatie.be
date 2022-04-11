<?php

namespace Database\Seeders;

use App\Models\Enums\TechnologyType;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Throwable;

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
                //'image_url' => 'https://pbs.twimg.com/profile_images/1278691829135876097/I4HKOLJw_400x400.png',
                'recommended_by' => ['willem'],
                'description' => 'A description why we use Tailwind',
            ],
            [
                'name' => 'Vite',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://vitejs.dev/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['sebastian', 'adriaan'],
                'description' => 'A description why we use Vite.js',
            ],
            [
                'name' => 'React',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://reactjs.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['sebastian', 'adriaan', 'rias'],
                'description' => 'A description why we use React.js',
            ],
            [
                'name' => 'Typescript',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://www.typescriptlang.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['sebastian', 'adriaan'],
                'description' => 'A description why we use Typescript',
            ],
            [
                'name' => 'Yarn',
                'type' => TechnologyType::frontend(),
                'website_url' => 'https://www.typescriptlang.org/',
                'image_url' => 'https://vitejs.dev/logo.svg',
                'recommended_by' => ['sebastian', 'adriaan'],
                'description' => 'A description why we use Yarn',
            ],

            // Backend
            [
                'name' => 'Laravel',
                'type' => TechnologyType::backend(),
                'website_url' => 'https://laravel.com/',
                'image_url' => 'https://laravel.com/img/logomark.min.svg',
                'recommended_by' => ['freek', 'sebastian', 'alex', 'brent', 'ruben', 'rias', 'niels'],
                'description' => 'A description why we use Laravel',
            ],

            // Desktop apps
            [
                'name' => 'Oh dear',
                'type' => TechnologyType::apps(),
                'website_url' => 'https://ohdear.app/',
                'image_url' => 'https://ohdear.app/img/logo/ohdear-logo-white-transparant.svg',
                'recommended_by' => ['freek'],
                'description' => 'A description why we use Oh dear',
            ],
            // services
            [
                'name' => 'Streamyard',
                'type' => TechnologyType::services(),
                'website_url' => 'https://streamyard.com/',
                'image_url' => 'https://streamyard.com/static/img/7b107537a14784d40bde2496b4b284d9.svg',
                'recommended_by' => ['freek', 'brent'],
                'description' => 'Most of our live streams are hosted on Streamyard.
                It’s a quick and easy way to create professional livestreams instantly. We also host livestreams on YouTube.',
            ],
            [
                'name' => 'Mailcoach',
                'type' => TechnologyType::services(),
                'website_url' => 'https://mailcoach.app/',
                'image_url' => 'https://i.ytimg.com/vi/b3ZDyewAJYc/maxresdefault.jpg',
                'recommended_by' => ['freek', 'wouter', 'brent', 'jef'],
                'description' => 'We would be crazy to use Mailchimp for our mailings.
                That’s why we built Mailcoach.
                It’s our answer to self-host your email marketing while cutting the cost.',
            ],

        ];
    }

    public function run(): void
    {
        foreach ($this->technologies() as $data) {
            $imageUrl = $data['image_url'] ?? null;

            unset($data['image_url']);

            $technology = Technology::firstOrNew(['name' => $data['name']])
                ->fill($data);

            $technology->save();

            try {
                $technology
                    ->addMediaFromUrl($imageUrl)
                    ->toMediaCollection('avatar');
            } catch (Throwable $exception) {
            }
        }

        Technology::whereNotIn('name', array_column($this->technologies(), 'name'))
            ->delete();
    }
}
