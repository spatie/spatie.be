<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Purchase;
use App\Http\Requests\HelpSpaceRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class HelpSpaceController
{
    public function __invoke(HelpSpaceRequest $request)
    {
        $html = $this->getMailCoachContent($request) . $this->getSpatieContent($request);

        return response()->json(['html' => $html]);
    }

    public function getSpatieContent(HelpSpaceRequest $request): string
    {
        $user = User::firstWhere('email', $request->email());

        if (! $user) {
            return '<div>No user found at spatie.be</div>';
        }

        return view('api.helpSpace', compact('user'))->render();
    }

    protected function getMailCoachContent(HelpSpaceRequest $request): string
    {
        try {
            return Http::withHeaders(['signature' => $request->header('signature')])
                ->withBody($request->getContent(), $request->getContentType())
                ->post('https://mailcoach.app/api/help-space')
                ->json('html', '');
        } catch (Exception) {
            return '';
        }
    }
}
