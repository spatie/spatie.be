<?php

namespace App\Console\Commands;

use App\Jobs\TweetIssueJob;
use App\Models\Issue;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportGitHubIssues extends Command
{
    protected $signature = 'import:github-issues';

    protected $description = 'Import issues.';

    public function handle(GitHubApi $api)
    {
        $this->info('Importing good first issues from GitHub...');

        Repository::get()->each(function (Repository $repository) use ($api) {
            $this->comment("Searching for good issues in {$repository->name}");

            $issues = $api->fetchOpenIssues('spatie', $repository->name, ['good first issue']);

            $this->cleanupIssuesForPackage($repository, $issues);

            $issues
                ->map(function (array $issueData) use ($repository) {
                    $issue = Issue::updateOrCreate([
                        'repository_id' => $repository->id,
                        'number' => $issueData['number'],
                    ], [
                        'repository_id' => $repository->id,
                        'url' => $issueData['html_url'],
                        'title' => $issueData['title'],
                        'number' => $issueData['number'],
                        'created_at' => Carbon::createFromTimeString($issueData['created_at']),
                    ]);

                    $this->info("Imported {$repository->name}#{$issue->number}: `{$issue->title}`");

                    return $issue;
                })
                ->values()
                ->each(function (Issue $issue, int $delayInHours) {
                    $this->tweetIssue($issue, $delayInHours);
                });
        });

        $this->info('All done!');
    }

    protected function cleanupIssuesForPackage(Repository $repository, Collection $currentIssues)
    {
        $closedIssues = Issue::query()
            ->where('repository_id', $repository->id)
            ->whereNotIn('number', $currentIssues->pluck('number'))
            ->get();

        if ($closedIssues->isEmpty()) {
            return;
        }

        $closedIssues->each->delete();

        $this->warn("Deleted {$closedIssues->count()} closed issues.");
    }

    protected function tweetIssue(Issue $issue, int $delayInHours)
    {
        if ($issue->hasBeenTweeted()) {
            return;
        }

        $this->info("Scheduling tweeting issue id `$issue->id`");

        dispatch(new TweetIssueJob($issue))->delay(now()->addHours($delayInHours));
    }
}
