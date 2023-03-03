<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InvoicesController
{
    public function __invoke(): View
    {
        $transactions = auth()->user()->receipts;
        $purchases = auth()->user()->purchases;

        foreach ($transactions as $transaction) {
            $transaction->setRelation('purchase', $purchases->where('receipt_id', $transaction->id)->first());
        }

        return view('front.profile.invoices', compact('transactions'));
    }
}
