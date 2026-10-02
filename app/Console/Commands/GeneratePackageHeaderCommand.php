<?php

namespace App\Console\Commands;

use App\Jobs\GeneratePackageGithubHeaderJob;
use App\Models\Repository;
use Illuminate\Console\Command;

class GeneratePackageHeaderCommand extends Command
{
    protected $signature = 'app:generate-package-header
        {names?* : The names of the repositories to generate headers for}
        {--missing : Generate headers for all repositories that don\'t have one yet}';

    protected $description = 'Generate the GitHub README header images of repositories';

    public function handle(): int
    {
        $names = $this->argument('names');

        if (! $names && ! $this->option('missing')) {
            $this->error('Pass one or more repository names, or use --missing.');

            return self::FAILURE;
        }

        $repositories = Repository::query()
            ->when($names, fn ($query) => $query->whereIn('name', $names))
            ->when($this->option('missing'), fn ($query) => $query->whereDoesntHave(
                'media',
                fn ($query) => $query->where('collection_name', 'github-header-dark'),
            ))
            ->get();

        $repositories->each(fn (Repository $repository) => dispatch(new GeneratePackageGithubHeaderJob($repository)));

        $this->info("Dispatched header generation for {$repositories->count()} repositories.");

        return self::SUCCESS;
    }
}
