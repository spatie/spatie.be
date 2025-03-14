<?php

namespace App\Jobs;

use App\Models\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Browsershot\Browsershot;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class GeneratePackageGithubHeaderJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Repository $repository,
    ) {
    }

    public function handle(): void
    {
        $this->generateImage('dark');
        $this->generateImage('light');
    }

    protected function generateImage($mode): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $temporaryDirectory = (new TemporaryDirectory())->create();
        $fileName = $temporaryDirectory->path('image.webp');

        Browsershot::url('https://spatie.be.test/packages/header/browsershot/html/' . $mode)
            ->setNodeBinary('/usr/bin/node')
            ->setNpmBinary('/usr/bin/npm')
            ->hideBackground()
            ->windowSize(830, 190)
            ->deviceScaleFactor(2)
            ->quality(100)
            ->save($fileName);

        $this->repository->addMedia($fileName)
            ->toMediaCollection('github-header-' . $mode);

        $temporaryDirectory->delete();
    }
}
