<?php

namespace App\Console\Commands;

use App\Models\Insight;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laminas\Feed\Exception\ExceptionInterface;
use Laminas\Feed\Reader\Entry\AbstractEntry;
use Laminas\Feed\Reader\Reader;
use Laminas\Http\Client\Adapter\Exception\TimeoutException;

class ImportInsightsCommand extends Command
{
    protected $signature = 'import:insights';

    protected $description = 'Import the blog posts of team members.';

    public function handle()
    {
        $this->info('Syncing insights from RSS feeds...');

        collect(config('services.rss'))
            ->each(function (string $feedUrl): void {
                try {
                    $feed = Reader::import($feedUrl);

                    foreach ($feed as $entry) {
                        $insight = Insight::updateOrCreate([
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
                } catch (ExceptionInterface | TimeoutException $exception) {
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
        return Str::words(
            strip_tags($entry->getContent()),
            30
        );
    }
}
