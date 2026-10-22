<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GitHubAdImageController
{
    public function __invoke(string $name): StreamedResponse
    {
        $repository = Repository::where('name', $name)->first();

        abort_unless($repository, 404, headers: ['Cache-Control' => 'no-store']);

        $disk = Storage::disk('github_ads');
        $path = $repository->gitHubAdImagePath();

        abort_unless($disk->exists($path), 404, headers: ['Cache-Control' => 'no-store']);

        return $disk->response($path, headers: [
            'Cache-Control' => 'public, max-age=120',
            'Cloudflare-CDN-Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
