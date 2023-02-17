<?php

namespace App\Http\Controllers;

use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadPurchasableController
{
    public function __invoke(Request $request, Product $product, Purchase $purchase, Media $file): Response
    {
        $userHasPurchase = PurchaseAssignment::query()
            ->whereUser($request->user())
            ->wherePurchase($purchase)
            ->exists();

        abort_unless($userHasPurchase, 403, 'Purchase missing');

        abort_unless($purchase->getPurchasables()->contains($file->model), 403, 'File does not belong to purchasable');

        return response()->download($file->getPath(), $file->file_name);
    }
}
