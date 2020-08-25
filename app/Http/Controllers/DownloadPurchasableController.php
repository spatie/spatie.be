<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchasable;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadPurchasableController
{
    public function __invoke(Request $request, Product $product, Purchase $purchase, Media $file)
    {
        $userHasPurchase = Purchase::query()->whereUser($request->user())->whereKey($purchase->id)->exists();

        abort_unless($userHasPurchase, 403, 'Purchase missing');

        abort_unless($file->model->is($purchase->purchasable), 403, 'File does not belong to purchasable');

        return response()->download($file->getPath(), $file->file_name);
    }
}
