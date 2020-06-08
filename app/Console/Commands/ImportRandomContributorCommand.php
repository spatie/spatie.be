<?php

namespace App\Console\Commands;

use App\Models\Contributor;
use App\Models\Repository;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;

class ImportRandomContributorCommand extends Command
{
    protected $signature = 'import:random-contributor';

    protected $description = 'Import random contributor.';

    public function handle(GitHubApi $api)
    {
        $this->info('Importing random contributor from GitHub...');

        [$contributorAttributes, $repository] = $this->getRandomContributor($api);

        $user = $api->getUser($contributorAttributes['login']);

        $contributor = Contributor::create([
            'username' => $contributorAttributes['login'],
            'avatar_url' => $contributorAttributes['avatar_url'],
            'name' => $user['name'] ?? 'John Doe',
            'repository_url' => $repository->url,
            'repository_name' => $repository->name,
        ]);

        Contributor::where('id', '<>', $contributor->id)->get()->each->delete();

        $this->comment("Imported user `{$contributor->username}`");
        $this->info('All done');
    }

    public function getRandomContributor(GitHubApi $api): array
    {
        $contributors = collect();

        while ($contributors->isEmpty()) {
            $repository = Repository::get()->random();

            $contributors = $api
                ->fetchRepositoryContributors('spatie', $repository->name)
                ->reject(fn (array $contributorAttributes) => $this->worksForSpatie($contributorAttributes['login']));
        }

        return [$contributors->random(), $repository];
    }

    public function worksForSpatie(string $username): bool
    {
        $spatieUsernames = [
            'spatie',
            'spatie-bot',
            'freekmurze',
            'sebastiandedeyne',
            'willemvb',
            'AlexVanderbist',
            'brendt',
            'JolitaGrazyte',
            'TVke',
            'MatthiasDeWinter',
            'laravel-shift',
            'Unknown',
            'invalid-email-address',
        ];

        return in_array($username, $spatieUsernames);
    }
}
