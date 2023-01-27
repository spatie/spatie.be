<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Spatie\HelpSpace\Facades\HelpSpace;
use Spatie\HelpSpace\Http\Requests\HelpSpaceRequest;

class HelpSpaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        HelpSpace::sidebar(function (HelpSpaceRequest $request) {
            [$mailcoachContent, $flareContent] = $this->getExternalContent($request);

            $html = $mailcoachContent
                . $flareContent
                . $this->getSpatieContent($request);

            return $html ?? '<p>No information found</p>';
        });
    }

    public function getSpatieContent(HelpSpaceRequest $request): string
    {
        $user = User::firstWhere('email', $request->email());

        if (! $user) {
            return '';
        }

        return view('api.helpSpace', compact('user'))->render();
    }

    protected function getExternalContent(HelpSpaceRequest $request): array
    {
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->withHeaders(['signature' => $request->header('signature')])
                ->withBody($request->getContent(), $request->getContentType())
                ->post('https://mailcoach.app/api/help-space'),
            $pool->withHeaders(['signature' => $request->header('signature')])
                ->withBody($request->getContent(), $request->getContentType())
                ->post('https://flareapp.io/api/help-space'),
        ]);

        return [
            $responses[0]->ok() ? $responses[0]->json('html', '') : '',
            $responses[1]->ok() ? $responses[1]->json('html', '') : '',
        ];
    }
}
