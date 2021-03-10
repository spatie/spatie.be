<?php

namespace App\Http\Controllers;

use App\Actions\StartOrExtendNextPurchaseDiscountPeriodAction;
use App\Http\Requests\EventSourcingRequest;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class EventSourcingController
{
    public function show()
    {
        return view('front.pages.event-sourcing.index');
    }

    public function subscribe(EventSourcingRequest $request)
    {
        $emailList = EmailList::firstWhere('name', 'Spatie');

        $subscriber = Subscriber::createWithEmail($request->email)
            ->skipConfirmation()
            ->subscribeTo($emailList);

        $subscriber->addTag('event-sourcing-waiting-list');

        if (auth()->user()) {
            (new StartOrExtendNextPurchaseDiscountPeriodAction())->execute(auth()->user());
        }

        session()->flash('subscribed');

        return back();
    }
}
