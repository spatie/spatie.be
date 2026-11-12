<?php

namespace App\Console\Commands;

use App\Domain\Blog\Actions\ImportBlogAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ImportBlogCommand extends Command
{
    protected $signature = 'blog:import {snapshot : Private snapshot directory} {--dry-run : Validate without writing posts or media}';

    protected $description = 'Import Spatie blog posts and media from a verified private CMS snapshot.';

    public function handle(ImportBlogAction $import): int
    {
        $result = Cache::lock('blog:import', 86400)->get(fn () => $import->execute($this->argument('snapshot'), $this->option('dry-run')));

        if ($result === false) {
            $this->error('Another blog import is running.');

            return self::FAILURE;
        }

        $this->line(json_encode($result, JSON_THROW_ON_ERROR));

        return self::SUCCESS;
    }
}
