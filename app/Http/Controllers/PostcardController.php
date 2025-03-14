<?php

namespace App\Http\Controllers;

use App\Models\Postcard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PostcardController
{
    public function index(): View|JsonResponse
    {
        $postcards = Postcard::orderByDesc('created_at')->get();

        $countries = Postcard::getTopCountries();

        if (request()->wantsJson()) {
            return $this->respondWithJson($postcards, $countries);
        }

        return view('front.pages.open-source.postcards', compact('postcards', 'countries'));
    }

    public function respondWithJson($postcards, Collection $countries): JsonResponse
    {
        return cache()->remember('postcards-json', now()->addHour(), function () use ($postcards, $countries) {
            return response()->json([
                'postcards' => $postcards->map(function ($postcard) {
                    return [
                        'id' => $postcard->id,
                        'sender' => $postcard->sender,
                        'location' => $postcard->location,
                        'image' => $postcard->getFirstMedia() ? $postcard->getFirstMedia()->getUrl() : null,
                        'created_at' => $postcard->created_at,
                    ];
                }),
                'countries' => $countries,
            ]);
        });
    }
}
