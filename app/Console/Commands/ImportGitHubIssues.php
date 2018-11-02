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

    /** @var \App\Services\GitHub\GitHubApi */
    protected $api;

    public function __construct(GitHubApi $api)
    {
        $this->api = $api;

        parent::__construct();
    }

    public function handle()
    {
        $this->info('Importing good first issues from GitHub...');

        Repository::get()->each(function (Repository $repository) {
            $this->comment("Searching for good issues in {$repository->name}");

            $issues = $this->api->fetchOpenIssues('spatie', $repository->name, ['good first issue']);

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
                ->each(function (Issue $issue) {
                    if ($issue->hasBeenTweeted()) {
                        return;
                    }

                    $this->info("Tweeting issue id `$issue->id`");

                    dispatch(new TweetIssueJob($issue));
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
}
