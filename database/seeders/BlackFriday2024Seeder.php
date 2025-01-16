<?php

namespace Database\Seeders;

use App\Enums\BlackFridayRewardType;
use Carbon\CarbonImmutable;
use DateTimeZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BlackFriday2024Seeder extends Seeder
{
    public function run()
    {
        DB::table('bf24_questions')->insert([
            'day' => 1,
            'question' => 'In which city is Spatie based?',
            'answer' => 'Antwerp',
            'hint' => 'There are a lot of diamonds in this city',
        ]);
        DB::table('bf24_questions')->insert([
            'day' => 2,
            'question' => 'Who owns Spatie?',
            'answer' => 'Freek and Jef',
            'hint' => 'One is famous in the Laravel community, the other hasn\'t merged a single PR',
        ]);
        DB::table('bf24_questions')->insert([
            'day' => 3,
            'question' => 'What the best dish in the Fontanella',
            'answer' => 'Scaloppa Fontanella',
            'hint' => 'Think about milanese',
        ]);
        DB::table('bf24_questions')->insert([
            'day' => 4,
            'question' => 'How many employees does Spatie have?',
            'answer' => '11',
            'hint' => 'It\'s a prime number',
        ]);
        DB::table('bf24_questions')->insert([
            'day' => 5,
            'question' => 'What sits between everything?',
            'answer' => 'Spatie',
            'hint' => 'It\'s a company',
        ]);

        foreach ([BlackFridayRewardType::Flare50Off, BlackFridayRewardType::Mailcoach50Off] as $rewardType) {
            foreach (range(1, 500) as $i) {
                DB::table('bf24_codes_pool')->insert([
                    'code' => faker()->unique()->bothify('??????????'),
                    'type' => $rewardType,
                ]);
            }
        }

        foreach (range(1, 5) as $day) {
            foreach ([BlackFridayRewardType::FreeMerch, BlackFridayRewardType::FreeRay] as $rewardType) {
                $timestamps = Collection::times(10, fn () => faker()->numberBetween(
                    CarbonImmutable::parse(config('black-friday.start_date'), new DateTimeZone('UTC'))
                        ->startOfDay()
                        ->addDays($day - 1)
                        ->unix(),
                    CarbonImmutable::parse(config('black-friday.start_date'), new DateTimeZone('UTC'))
                        ->endOfDay()
                        ->addDays($day - 1)
                        ->unix(),
                ))->sort()->all();

                foreach ($timestamps as $timestamp) {
                    DB::table('bf24_rewards')->insert([
                        'day' => $day,
                        'type' => $rewardType,
                        'available_at' => CarbonImmutable::createFromTimestamp($timestamp, 'UTC'),
                    ]);
                }
            }
        }
    }
}
