<?php

namespace App\Jobs;

use App\Http\Controllers\PackageHeaderController;
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
        $url = action([PackageHeaderController::class, 'html'], ['name' => $this->repository->name, 'mode' => $mode]);

        $browsershot = Browsershot::url($url);

        if (app()->isProduction()) {
            $browsershot->setNodeBinary('/usr/bin/node')
                ->setNpmBinary('/usr/bin/npm')
                ->setChromePath("/home/forge/.cache/puppeteer/chrome/linux-134.0.6998.35/chrome-linux64/chrome");
        }

        $browsershot->hideBackground()
            ->windowSize(830, 190)
            ->deviceScaleFactor(2)
            ->save($fileName);

        $this->repository->addMedia($fileName)
            ->toMediaCollection('github-header-' . $mode);

        $temporaryDirectory->delete();
    }
}
