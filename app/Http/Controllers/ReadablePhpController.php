<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestingLaravel;
use App\Services\Mailcoach\MailcoachApi;
use Illuminate\View\View;

class ReadablePhpController
{
    public function show(): View
    {
        return view('front.pages.readable-php.index');
    }

    public function subscribe(TestingLaravel $request, MailcoachApi $mailcoachApi)
    {
        $subscriber = $mailcoachApi->getSubscriber($request->email);

        if (! $subscriber) {
            $subscriber = $mailcoachApi->subscribe($request->email, skipConfirmation: true);
        }

        $mailcoachApi->addTags($subscriber, ['readable-php-waiting-list']);

        session()->flash('subscribed');

        return back();
    }
}
