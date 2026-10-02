<?php

namespace App\Jobs;

use App\Http\Controllers\PackageHeaderController;
use App\Jobs\Middleware\ThrottleScreenshots;
use App\Models\Repository;
use DateTimeInterface;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\LaravelScreenshot\Facades\Screenshot;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class GeneratePackageGithubHeaderJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public const array HEADER_ATTRIBUTES = ['name', 'banner_title', 'accent_color', 'logo_svg'];

    public const array MODES = ['dark', 'light'];

    public int $maxExceptions = 4;

    public int $uniqueFor = 60 * 60 * 24;

    public function __construct(
        public Repository $repository,
        public string $mode,
    ) {
    }

    /**
     * Each mode is a separate screenshot, and Cloudflare only allows one screenshot
     * every few seconds, so every mode gets its own job and its own rate limiter slot.
     */
    public static function dispatchForAllModes(Repository $repository): void
    {
        foreach (self::MODES as $mode) {
            dispatch(new self($repository, $mode));
        }
    }

    public function uniqueId(): string
    {
        return "{$this->repository->getKey()}-{$this->mode}";
    }

    /** @return array<int, object> */
    public function middleware(): array
    {
        return [new ThrottleScreenshots()];
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addDay();
    }

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 60 * 60, 60 * 60 * 6];
    }

    public function handle(): void
    {
        $temporaryDirectory = (new TemporaryDirectory())->create();

        /**
         * The header has always been a PNG stored as image.webp. GitHub READMEs
         * link to the .webp URL, so the format and file name stay as they were.
         */
        $path = $temporaryDirectory->path('image.png');

        $url = action([PackageHeaderController::class, 'html'], ['name' => $this->repository->name, 'mode' => $this->mode]);

        Screenshot::url($url)
            ->size(830, 190)
            ->deviceScaleFactor(2)
            ->omitBackground()
            ->save($path);

        $this->repository->addMedia($path)
            ->usingFileName('image.webp')
            ->toMediaCollection('github-header-' . $this->mode);

        $temporaryDirectory->delete();
    }
}
