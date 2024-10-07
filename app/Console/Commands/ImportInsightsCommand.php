<?php

namespace App\Console\Commands;

use App\Models\ExternalFeedItem;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laminas\Feed\Reader\Entry\AbstractEntry;
use Laminas\Feed\Reader\Reader;

class ImportInsightsCommand extends Command
{
    protected $signature = 'import:insights';

    protected $description = 'Import the blog posts of team members.';

    private const REGEX_ADD_SPACE_AFTER_PERIOD_WHEN_MISSING = '/(\.)([[:alpha:]]{2,})/';

    public function handle(): void
    {
        $this->info('Syncing insights from RSS feeds...');

        Member::query()->whereNotNull('website_rss')->pluck('website_rss')
            ->merge(config('services.rss'))
            ->unique()
            ->values()
            ->each(function (string $feedUrl): void {
                try {
                    $feed = Reader::import($feedUrl);

                    foreach ($feed as $entry) {
                        $insight = ExternalFeedItem::updateOrCreate([
                            'url' => $entry->getLink(),
                        ], [
                            'title' => $this->sanitizeTitle($entry->getTitle()),
                            'created_at' => new Carbon($entry->getDateModified()->format(DATE_ATOM)),
                            'url' => $entry->getLink(),
                            'website' => $this->getWebsite($entry),
                            'short_summary' => $this->getShortSummary($entry),
                        ]);

                        $this->info("Imported `{$insight->title}`");
                    }
                } catch (\Exception $e) {
                    $this->error("Could not load {$feedUrl}");
                }
            });
    }

    protected function sanitizeTitle(string $title): string
    {
        $title = ltrim($title, '★ ');

        $title = htmlspecialchars_decode($title, ENT_QUOTES);

        return $title;
    }

    protected function getWebsite(AbstractEntry $entry): string
    {
        $host = parse_url($entry->getLink(), PHP_URL_HOST);

        $host = ltrim($host, 'www.');

        return $host;
    }

    protected function getShortSummary(AbstractEntry $entry): string
    {
        $summary = Str::words($entry->getContent(), 30);

        $summary = html_entity_decode(strip_tags($summary));

        return preg_replace(
            self::REGEX_ADD_SPACE_AFTER_PERIOD_WHEN_MISSING,
            '$1 $2',
            $summary
        );
    }
}
