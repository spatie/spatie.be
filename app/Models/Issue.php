<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issue extends Model
{
    use HasFactory;

    public $dates = ['tweeted_at'];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }

    public function markAsTweeted()
    {
        $this->tweeted_at = now();

        $this->save();
    }

    public function hasBeenTweeted(): bool
    {
        return ! is_null($this->tweeted_at);
    }

    public function toTweet(): string
    {
        $repositoryName = $this->repository->name;

        $tweetTexts = collect([
            "Here's an easy issue on our {$repositoryName} repo. Perfect for awesome people that want to start contributing to open source!",
            "Want to start contributing to open source? Here's a good first issue for you!",
            "Looking for a good first issue to start contributing to open source? Here you go!",
            "Who has a little of spare time and motivation to take care of this issue on {$repositoryName}?",
            "You can help us out by fixing this easy issue on the {$repositoryName} repo.",
            "Have you always wanted to contribute to open source but never knew where to begin? Here's a good first issue you could take care of",
        ]);

        return $tweetTexts->random() . PHP_EOL . $this->url;
    }
}
