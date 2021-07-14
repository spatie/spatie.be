<?php

namespace App\Http\Controllers;

use App\Actions\StartOrExtendNextPurchaseDiscountPeriodAction;
use App\Http\Requests\TestingLaravel;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class TestingLaravelController
{
    public function show()
    {
        return view('front.pages.testing-laravel.index');
    }

    public function subscribe(TestingLaravel $request)
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        $subscriber = Subscriber::createWithEmail($request->email)
            ->skipConfirmation()
            ->subscribeTo($emailList);

        $subscriber->addTag('testing-laravel-waiting-list');

        session()->flash('subscribed');

        return back();
    }
}
