<?php

namespace App\Http\Api\Controllers;

use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Http\Requests\HelpSpaceRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class HelpSpaceController
{
    public function __invoke(HelpSpaceRequest $request)
    {
        $html = $this->getSpatieContent($request) . $this->getMailCoachContent($request);

        return response()->json(['html' => $html]);
    }

    public function getSpatieContent(HelpSpaceRequest $request): string
    {
        $user = User::firstWhere('email', $request->email());

        if (! $user) {
            return 'No user found at spatie.be';
        }

        $purchases = $user->purchases
            ->flatMap(fn (Purchase $purchase) => $purchase->getPurchasables())
            ->map(fn (Purchasable $purchasable) => $purchasable->title)
            ->unique()
            ->implode(', ');

        return view('api.helpSpace', compact('user', 'purchases'))->render();
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
