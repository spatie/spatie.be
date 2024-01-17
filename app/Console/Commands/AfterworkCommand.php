<?php

namespace App\Console\Commands;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Spatie\Holidays\Holidays;
use Spatie\SlackAlerts\Facades\SlackAlert;

class AfterworkCommand extends Command
{
    protected $signature = 'spatie:after-work';

    protected array $targetWeekdays = ['Friday'];

    public function handle(): void
    {
        $options = collect($this->generatePollOptions())
            ->map(fn (string $option, int $index) => $this->addEmoji($option, $index))
            ->implode("\n");

        $this->info("Poll options:\n{$options}");

        SlackAlert::message("Who is in for an afterwork drink? :beer:\n{$options}");

        $this->info('Poll posted to Slack');
    }

    protected function generatePollOptions(): array
    {
        $options = [];

        foreach ($this->targetWeekdays as $weekday) {
            $datesInMonth = $this->getDatesForWeekdayInMonth($weekday);

            foreach ($datesInMonth as $date) {
                if (Holidays::new()->isHoliday($date, 'be')) {
                    continue;
                }

                $options[$date->day] = "{$date->shortDayName} {$date->day}/{$date->month}";
            }
        }

        ksort($options);

        return array_values($options);
    }

    protected function addEmoji(string $option, int $index): string
    {
        $index++;

        $emoji = $this->numberWords()[$index];

        return ":{$emoji}: {$option}";
    }

    protected function getDatesForWeekdayInMonth(string $dayName): CarbonPeriod
    {
        return new CarbonPeriod(
            CarbonImmutable::parse("first {$dayName} of this month"),
            CarbonInterval::week(),
            CarbonImmutable::parse("first {$dayName} of next month")->subDay(),
        );
    }

    protected function numberWords(): array
    {
        return [
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'beer', // no 10 emoji in Slack
        ];
    }
}
