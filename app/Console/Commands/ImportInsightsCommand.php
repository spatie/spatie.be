<?php

namespace App\Console\Commands;

use App\Models\Insight;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Zend\Feed\Exception\ExceptionInterface;
use Zend\Feed\Reader\Entry\AbstractEntry;
use Zend\Feed\Reader\Reader;

class ImportInsightsCommand extends Command
{
    protected $signature = 'import:insights';

    protected $description = 'Import the blog posts of team members.';

    public function handle()
    {
        $this->info('Syncing insights from RSS feeds...');

        collect(config('services.rss'))
            ->each(function (string $feedUrl) {
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
                        ]);

                        $this->info("Imported `{$insight->title}`");
                    }
                } catch (ExceptionInterface $exception) {
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
}
