<?php

namespace App\Http\Controllers;

use App\Models\ExternalFeedItem;

class ExternalFeedItemsController
{
    public function __invoke()
    {
        $externalFeedItems = ExternalFeedItem::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('front.pages.externalFeedItems.index', compact('externalFeedItems'));
    }
}
