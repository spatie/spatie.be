<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    protected TwitterOAuth $twitter;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    public function tweet(string $status)
    {
        if (! app()->environment('production')) {
            info("Tweeting {$status}");

            return;
        }

        return $this->twitter->post('statuses/update', compact('status'));
    }
}
