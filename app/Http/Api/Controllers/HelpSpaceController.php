<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
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

        $purchases = $user->purchases
            ->map(fn (Purchase $purchase) => $purchase->getPurchasables())
            ->map(fn (Purchasable $purchasable) => $purchasable->title)
            ->unique()
            ->implode(', ');



        // $userInfo = view('add-view');
        $spatieHtml = <<<html
            <div>
                <h2 class="flex-grow spm-ticket-sidebar-head mb-px">Spatie</h2>
                <div class="relative flex-wrap w-full mt-2 bg-gray-200 rounded-lg px-4 py-4 3xl:mr-2">
                    <h3 class="flex-grow spm-ticket-sidebar-head mb-px">Purchases</h3>
                    <div class="text-sm mb-4">{$purchases}</div>
                </div>
            </div>
        html;

        $spatieHtml .= $mailcoachHtml;

        return response()->json(['html' => $spatieHtml]);
    }
}
