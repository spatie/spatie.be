<?php

namespace App\Jobs;

use App\Models\Issue;
use App\Services\Twitter\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TweetIssueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Issue $issue;

    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function handle(Twitter $twitter)
    {
        if (! app()->environment('production')) {
            return;
        }

        if ($this->issue->hasBeenTweeted()) {
            return;
        }

        $tweetText = $this->issue->toTweet();

        $twitter->tweet($tweetText);

        $this->issue->markAsTweeted();
    }
}
