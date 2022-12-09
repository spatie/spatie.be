<?php

namespace App\Http\Api\Controllers;

use App\Http\Requests\HelpSpaceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class HelpSpaceController
{
    public function __invoke(HelpSpaceRequest $request)
    {
        $mailcoachHtml = Http::withHeaders(['signature' => $request->header('signature')])
            ->withBody($request->getContent(), $request->getContentType())
            ->post('https://mailcoach.app/api/help-space')
            ->json('html', '');

        $user = User::firstWhere('email', $request->email());

        if (! $user) {
            return 'No user found at spatie.be';
        }

        // $userInfo = view('add-view');

        return response()->json(['html' => $mailcoachHtml]);
    }
}
