<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestingLaravel;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class ReadablePhpController
{
    public function show()
    {
        return view('front.pages.readable-php.index');
    }

    public function subscribe(TestingLaravel $request)
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        $subscriber = Subscriber::createWithEmail($request->email)
            ->skipConfirmation()
            ->subscribeTo($emailList);

        $subscriber->addTag('readable-php-waiting-list');

        session()->flash('subscribed');

        return back();
    }
}
